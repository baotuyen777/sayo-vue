<?php

namespace App\Services\Product;

use App\Models\Category;
use App\Models\Files;
use App\Models\Pdw\District;
use App\Models\Pdw\Province;
use App\Models\Pdw\Ward;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    private array $res = [];

    function __construct()
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
    }

    public function store($request)
    {
        if (!isLoged()) {
            return redirect()->route('login');
        }

        $userid = Auth::id();

        $request->merge([
            'code' => time() . '-' . $userid,
            'author_id' => $userid,
            'attr' => str_replace(['\"', '%22'], '', json_encode($request['attr'])),
        ]);
        $files = $request['file_ids'];
        if ($files) {
            $request->merge(['avatar_id' => $files[0]]);
        }

        $obj = Product::query()->create($request->all());
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
                'province_id' => $request['province_id'],
                'district_id' => $request['district_id'],
                'ward_id' => $request['ward_id'],
                'address' => $request['address']
            ];
            $author->update($address);
        }

        return ['status' => true, 'result' => $obj];
    }

    public function update($request, $code)
    {
        $obj = Product::getOne($code);
        if (!$obj) {
            return RETURN404;
        }

        if (!isAdmin() && !isAuthor($obj)) {
            return RETURN_REQUIRED_ADMIN;
        }
        $files = $request['file_ids'];

        if ($files) {
            $obj->files()->sync($files);
        }

        $params = $request->all();

        if (isset($params['attr'])) {
            $params['attr'] = str_replace(['\"', '%22'], '', json_encode($params['attr']));
        }

        $res = $obj->update($params);
        Cache::forget(Product::CACHE_KEY . $code);
        return ['status' => true, 'result' => $res];
    }

    function getAttrField($product = false, $filterNull = false)
    {
        $config = Product::$attr;

        $attrs = json_decode(str_replace('%22', '', $product->attr));
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

    public function getAttrOptions($product = null)
    {
        $categories = Category::with('avatar')->get();
        $provinces = Province::get()->keyBy('id');
        $districts = $product ? District::whereProvinceId($product->province_id)->get()->keyBy('id') : [];
        $wards = $product ? Ward::whereDistrictId($product->district_id)->get()->keyBy('id') : [];

        return get_defined_vars();
    }

    public function getAll($request)
    {
        $where = is_array($request) ? $request : $request->all();
        $s = $where['s'] ?? '';
        $currentPage = $where['current'] ?? $where['page'] ?? 1;
        $pageSize = $where['page_size'] ?? 24;

        $catCode = $where['catCode'] ?? '';
        $category = Category::where('code', $catCode)->first();
        
        return Product::getAll($where);
    }

    function getRelationOptions($where): array
    {
        $res = [
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
        $catCode = $where['catCode'] ?? 'tat-ca';
        $res['categories'] = Category::getAll();

        $res['category'] = $res['categories']->firstWhere('code', $catCode);
        $provinceCode = $where['provinceCode'] ?? '';
        $res['provinces'] = Province::getAll();

        $province = $res['provinces']->firstWhere('code', $provinceCode);
        $districtCode = $where['districtCode'] ?? '';
        $wardCode = $where['wardCode'] ?? '';
        if ($provinceCode && $province) {
            $res['province'] = $province;
            $res['districts'] = District::getAll()->where('province_id', $province->id);
            $district = $res['districts']->firstWhere('code', $districtCode);
            if ($district) {
                $res['district'] = $district;
                $res['wards'] = Ward::getAll()->where('district_id', $district->id);
                $res['ward'] = $res['wards']->firstWhere('code', $wardCode);
            }
        }

        return $res;
    }

    function getAllSimple($request, $where = [])
    {
        $s = is_array($request) ? $request['s'] : $request->input('s');
        $currentPage = is_array($request) ? ($request['current'] ?? $request['page']) : ($request->input('current') ?? $request->input('page'));
        $pageSize = is_array($request) ? ($request['page_size'] ?? 10) : ($request->input('page_size') ?? 10);

        $products = Product::with('avatar');
        if ($s) {
            $products->where('name', 'like', "%{$s}%");
        }

        foreach ($where as $k => $v) {
            $products->where($k, $v);
        }

        return $products->orderBy('created_at', 'desc')
            ->paginate($pageSize, ['*'], 'page', $currentPage);
    }

    public function destroy($code)
    {
        $obj = Product::getOne($code);
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
            Product::whereIn('avatar_id', $fileIds)->update(['avatar_id' => null]);
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
        $productKey = 'products_' . $code;
        if (!Session::has($productKey)) {
            Product::where('code', $code)->increment('viewed_quantity');
            Session::put($productKey, 1);
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
