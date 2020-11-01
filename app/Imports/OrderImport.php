<?php

namespace App\Imports;

use App\Jobs\Order\Import;
use App\Models\Order;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class OrderImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $orders = Order::where('type', 1)->get();
        $ids = [];
        foreach ($orders as $order)
        {
            array_push($ids, $order->id);
        }
        Order::destroy($ids);
        foreach ($collection as $i => $item)
        {
            if ($i > 0)
            {
                if ($item[0] && $item[1])
                {
                    Import::dispatch($item);
                }
            }
        }
    }
}
