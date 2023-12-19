<?php

namespace App\Services\Post;

use App\Models\Category;
use App\Models\Files;
use App\Models\Pdw\District;
use App\Models\Pdw\Province;
use App\Models\Pdw\Ward;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PostService
{
    private array $res = [];

    public function store($request)
    {
        if (!isLoged()) {
            return redirect()->route('login');
        }

        $userid = Auth::id();

        $request->merge([
            'code' => time() . '-' . $userid,
            'author_id' => $userid,
            'attr' => str_replace(['\"', '%22'], '', json_encode($request->input('attr'))),
        ]);
        $files = $request->input('file_ids');
        if ($files) {
            $request->merge(['avatar_id' => $files[0]]);
        }

        $obj = Post::query()->create($request->all());
        if ($obj && $files) {
            $obj->files()->sync($files);
        }

        $author = User::find($userid)
            ->whereNull('address')
            ->orWhereNull('province_id')
            ->orWhereNull('district_id')
            ->orWhereNull('ward_id')
            ->first();

        if ($author) {
            $address = [
                'province_id' => $request->input('province_id'),
                'district_id' => $request->input('district_id'),
                'ward_id' => $request->input('ward_id'),
                'address' => $request->input('address')
            ];
            $author->update($address);
        }

        return ['status' => true, 'result' => $obj];
    }

    public function update($request, $code)
    {
        $obj = Post::where('code', $code)->first();
        if (!isAdmin() && !isAuthor($obj)) {
            return RETURN_REQUIRED_AUTHOR;
        }
        $files = $request->input('file_ids');

        if ($files) {
            $obj->files()->sync($files);
        }

        $params = $request->all();

        if (isset($params['attr'])) {
            $params['attr'] = str_replace(['\"', '%22'], '', json_encode($params['attr']));
        }

        $res = $obj->update($params);
        Cache::forget(Post::CACHE_KEY . $code);
        return ['status' => true, 'result' => $res];
    }

    public function getAttrOptions($post = null)
    {
        $categories = Category::with('avatar')->get();
        $provinces = Province::get()->keyBy('id');
        $districts = $post ? District::whereProvinceId($post->province_id)->get()->keyBy('id') : [];
        $wards = $post ? Ward::whereDistrictId($post->district_id)->get()->keyBy('id') : [];

        $categoryFields = Post::$categoryFields;
        $catCode = getCategoryCode($post->category_id);

        $fields = $categoryFields[$catCode] ?? [];
        $attrs = Post::$attr;

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
        $routeParams = request()->route()->parameters();
        $request->merge($routeParams);

        $catCode = $request->input('catCode')?? 'tat-ca';
        $this->res['categories'] = Category::getAll();
        $this->res['category'] = $this->res['categories']->firstWhere('code', $catCode);

        $provinceCode = $request->input('provinceCode');

        $this->res['provinces'] = Province::getAll();

        $province = $this->res['provinces']->firstWhere('code', $provinceCode);
//        dd($provinceCode, $province);
        if ($provinceCode && $province) {
            $this->res['province'] = $province;
            $this->res['districts'] = District::getAll()->where('province_id', $province->id);
            $district = $this->res['districts']->firstWhere('code', $request->input('districtCode'));
            if ($district) {
                $this->res['district'] = $district;
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

    public function incrementViewNumber($code)
    {
        $postKey = 'posts_' . $code;
// Kiểm tra Session của bài viết có tồn tại hay không.
        // Nếu không tồn tại, sẽ tự động tăng trường viewed_quantity lên 1 đồng thời tạo session lưu trữ key bài viết.
        if (!Session::has($postKey)) {
            Post::where('code', $code)->increment('viewed_quantity');
            Session::put($postKey, 1);
        }
    }

    public function populateSellerAddress($user, $obj = [])
    {
        $province = Province::getAll()->get($user->province_id);
        $district = District::getAll()->get($user->district_id);
        $ward = Ward::getAll()->get($user->ward_id);
        return array_merge([
            'province_name' => $province->name ?? '',
            'province_id' => $province->id ?? '',
            'district_name' => $district->name ?? '',
            'district_id' => $district->id ?? '',
            'ward_name' => $ward->name ?? '',
            'ward_id' => $ward->id ?? '',
            'address' => $user->address ?? '',
        ], $obj);
    }
}
