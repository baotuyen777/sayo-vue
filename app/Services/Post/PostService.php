<?php

namespace App\Services\Post;

use App\Models\Category;
use App\Models\Files;
use App\Models\Pdw\District;
use App\Models\Pdw\Province;
use App\Models\Pdw\Ward;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PostService
{
    private array $res = [];

    function getAttrField($post = false, $filterNull = false)
    {
        $config = Post::$attr;

        $attrs = json_decode(str_replace('%22', '', $post->attr));
        $res = [];
        foreach ($config as $k => $item) {
            if (isset($attrs->$k)) {
                $rawValue = $attrs->$k;
                $item['value'] = $rawValue;
                $item['valueLabel'] = $item['options'][$rawValue] ?? $rawValue;
                if (isset($item['type'])) {
                    if ($item['type'] == 'boolean') {
                        $item['valueLabel'] = $rawValue ? 'Có' : 'Không';
                    }
                    if ($item['type'] == 'money') {
                        $item['valueLabel'] = moneyFormat($rawValue);
                    }
                    if ($item['type'] == 's') {
                        $item['valueLabel'] = $rawValue . 'm2';
                    }
                }
            } else if ($filterNull) {
                continue;
            }

            $res[$k] = $item;
        }

        return $res;
    }

    public function getAttrOptions($post = null)
    {
        $categories = Category::with('avatar')->get();
        $provinces = Province::get()->keyBy('id');
        $districts = $post ? District::whereProvinceId($post->province_id)->get()->keyBy('id') : [];
        $wards = $post ? Ward::whereDistrictId($post->district_id)->get()->keyBy('id') : [];

        return get_defined_vars();
    }

    public function getAll($request)
    {
        $this->res = [
            'provinces' => [],
            'province' => null,
            'districts' => [],
            'district' => null,
            'wards' => [],
            'ward' => null,
            'objs' => [],
            'categories' => [],
            'category' => null
        ];
        $catCode = $request->input('catCode');
        $this->res['categories'] = Category::getAll();
        $this->res['category'] = $this->res['categories']->firstWhere('code', $catCode);

        $provinceCode = $request->input('provinceCode');

        $this->res['provinces'] = Province::getAll();
        $province = $this->res['provinces']->firstWhere('code', $provinceCode);
        if ($province) {
            $this->res['districts'] = District::getAll()->where('province_id', $province->id);
            $district = $this->res['districts']->firstWhere('code', $request->input('districtCode'));
            if ($district) {
                $this->res['wards'] = Ward::getAll()->where('district_id', $district->id);
                $this->res['ward'] = $this->res['wards']->firstWhere('code', $request->input('wardCode'));
            }
        }

        $this->res['objs'] = Post::getAll($request);

        return $this->res;
    }

    function getAllSimple($request, $where = [])
    {
        $s = $request->input('s');
        $currentPage = $request->input('current') ?? $request->input('page');
        $pageSize = $request->input('page_size') ?? 10;

        $posts = Post::with('avatar');
        if ($s) {
            $posts->where('name', 'like', "%{$s}%");
        }

        foreach ($where as $k => $v) {
            $posts->where($k, $v);
        }

        return $posts->orderBy('created_at', 'desc')
            ->paginate($pageSize, ['*'], 'page', $currentPage);
    }

    public function destroy($code)
    {
        $obj = Post::getOne($code);
        if (!$obj) {
            return RETURN404;
        }

        if (!isAuthor($obj) && !isAdmin()) {
            return RETURN_REQUIRED_ADMIN;
        }

        try {
            $urlFiles = $obj->files->pluck('url')->toArray();
            $urlStorages = array_map(function ($val) {
                return str_replace(asset('storage'), 'public', $val);
            }, $urlFiles);

            foreach ($urlStorages as $urlStorage) {
                if (Storage::exists($urlStorage)) {
                    Storage::delete($urlStorage);
                }
            }

            $fileIds = $obj->files->pluck('id')->toArray();
            Post::whereIn('avatar_id', $fileIds)->update(['avatar_id' => null]);
            $obj->files()->detach();
            Files::whereIn('id', $fileIds)->delete();
            $obj->delete();
            Cache::flush();
        } catch (\Exception $e) {
            return RETURN_SOMETHING_WENT_WRONG;
        }

        return returnSuccess();
    }
}
