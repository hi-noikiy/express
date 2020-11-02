<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrdersExport implements FromCollection
{

    private $type;

    private $model;

    public function __construct($type, $model)
    {
        $this->type = $type;
        $this->model = $model;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        $orders = Order::where('type', $this->type);
        if ($this->model == 2)
        {
            $orders = $orders->where(function ($query) {
                $query->where('status', '揽件')
                    ->orWhere('status', '');
            });
        }
        $orders = $orders->select('company', 'number', 'platform', 'status', 'detail', 'remark')->get();
        $orderArr = [
            ['快递公司', '单号', '平台', '状态', '物流信息', '备注']
        ];
        foreach ($orders as $order)
        {
            $detail = json_decode($order->detail);
            $content = '';
            if ($detail)
            {
                foreach ($detail as $item)
                {
                    $content .= $item->time.' '.$item->status.' ';
                }
            }
            $item = [
                $order->company,
                $order->number,
                $order->platform,
                $order->status,
                $content,
                $order->remark
            ];
            array_push($orderArr, $item);
        }

        return new Collection($orderArr);
    }
}
