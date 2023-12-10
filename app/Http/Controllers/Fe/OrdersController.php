<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Admin\Controller;
use App\Models\Orders;
use App\Models\User;
use App\Services\Order\OrderSevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function __construct(protected OrderSevice $orderSevice)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $order = $this->orderSevice->list($request);

        return view('pages.order.list', $order);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $order = $this->orderSevice->orderStore($request);
        if ($order) {
            return redirect()->route('order.complete');
        }
        return redirect()->back()->with('notify', 'Đặt hàng không thành công')->with('notify_type', 'error');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = $this->orderSevice->destroy($id);
        return response()->json($order);
    }

    public function updateSimple(Request $request, $id)
    {
        $params = $request->all();
        $res = $order = Orders::where('id', $id)->update(['status' => $params['status']]);

        if ($res) {
            $order = Orders::where('id', $id)->first();
        }

        return response()->json(['status' => $res, 'result' => $order]);
    }

    public function completeOrder()
    {
        $product = User::with('orders')->find(Auth::user()->id);

        return view('pages.order.thank_you', ['objs' => $product]);
    }
}
