<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Admin\Controller;
use App\Models\Orders;
use App\Services\Order\OrderSevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if (!isLoged()) {
            return view('pages/auth/login');
        }

        if (!isAdmin()) {
            $request->merge(['seller_id' => Auth::user()->id]);
        }

        $order = $this->orderSevice->list($request);

        return view('pages/order/list', $order);
    }

    public function me(Request $request)
    {
        if (!isLoged()) {
            return view('pages/auth/login');
        }

        $request->merge(['author_id' => Auth::user()->id]);

        $order = $this->orderSevice->list($request);

        return view('pages/order/list', $order);
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
        if (!isLoged()) {
            return view('pages/auth/login');
        }

        $obj = $this->orderSevice->store($request);
        if ($obj) {
            return returnSuccess($obj, route('order.show', ['order' => $obj->code]));
        }

        return RETURN_SOMETHING_WENT_WRONG;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $code)
    {
        $obj = Orders::query()->where('code', $code)->first();
        if (!$obj) {
            return view('pages/404');
        }
        return view('pages/order/show', ['obj' => $obj]);
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
}
