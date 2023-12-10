<?php

namespace App\Services\Order;

use App\Models\Category;
use App\Models\Order;
use App\Models\Orders;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderSevice
{
    /**
     * Display a listing of the resource.
     */
    public function store($request)
    {
        $product = Product::getOne($request->product_code);
        if ($product) {
            $userid = Auth::user()->id;
            $request->merge([
                'author_id' => $userid,
                'product_id' => $product->id,
                'seller_id' => $product->author_id,
                'code' => Auth::user()->username . '-' . time(),
                'price' => $product->price,
            ]);

            return Orders::query()->create($request->all());
        }

        return false;;
    }

    public function list($request)
    {


        $currentPage = $request->input('current');
        $pageSize = $request->input('page_size') ?? 24;
        $res['categories'] = Category::with('avatar')->get();
        $res['objs'] = Orders::with('author', 'product')
            ->paginate($pageSize, ['*'], 'page', $currentPage);
        $res['totalPrice'] = Product::whereIn('id', Orders::all()->pluck('product_id')->toArray())
            ->get()->sum('price');

        return $res;
    }

    public function destroy($id)
    {
        $order = Orders::find($id);

        if (!Auth::user() || Auth::user()->role > ROLE_ADMIN || $order->seller_id != Auth::user()->id) {
            return ['status' => false, 'result' => null];
        }
        if ($order) {
            $order->delete();
        }

        return ['status' => true, 'message' => 'Xóa thành công'];
    }
}
