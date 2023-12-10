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
    public function orderStore($request)
    {
        if (!Auth::check()) {
            return view('pages/auth/login');
        }
        $obj = [];
        $product = Product::find($request->product_id);
        $order = Orders::where('code', $product->code)->exists();
        if (!$order) {
            $request->merge([
                'author_id' => Auth::user()->id,
                'product_id' => $product->id,
                'seller_id' => $product->author_id,
                'code' => $product->code,
            ]);

            $obj = Orders::create($request->all());
        }

        return $obj;;
    }

    public function list($request)
    {

        if (!Auth::user()) {
            return view('pages/auth/login');
        }

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
