<?php

namespace App\Http\Controllers\Order;

use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;
use App\Imports\OrderImport;
use App\Models\Order;
use Illuminate\Http\Request;
use Excel;
use Illuminate\Support\Facades\Cache;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param int $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index($type = 0)
    {
        $type = $type ? $type : 1;
        $orders = Order::where('type', $type)->get();

        return view('order.index')->with('orders', $orders)->with('type', $type);
    }

    public function import(Request $request)
    {
        $file = $request->file('file');
        $extension = $file->extension();
        $path = $file->storeAs('file', 'order.'.$extension);
        Excel::import(new OrderImport, $path);

        return redirect()->route('order', [1]);
    }

    public function loading()
    {
        Cache::put('loading', 1, 70);

        return redirect()->route('order', [2]);
    }

    public function export($type, $model)
    {
        return Excel::download(new OrdersExport($type, $model), 'orders.xlsx');
    }


}
