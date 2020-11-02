<?php

namespace App\Jobs\Order;

use App\Models\Order;
use App\Services\Logistics\AliClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class Import implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $item;

    /**
     * Import constructor.
     * @param $item
     */
    public function __construct($item)
    {
        $this->item = $item;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $aliwuliu = app(AliClient::class);
//        $order = $aliwuliu->wuliu($this->item[1]);
        $order = [];
        $orderCreateData = [
            'type' => isset($this->item[2]) ? 2 : 1,
            'company' => $this->item[0],
            'number' => $this->item[1],
            'platform' => $this->item[2] ?? '',
        ];
        if (isset($order->status) && $order->status == 0)
        {
            $result = $order->result;
            // 投递状态 0快递收件(揽件)1.在途中 2.正在派件 3.已签收 4.派送失败 5.疑难件 6.退件签收
            switch ($result->deliverystatus)
            {
                case 0:
                    $status = '揽件';
                    break;
                case 1:
                    $status = '在途中';
                    break;
                case 2:
                    $status = '正在派件';
                    break;
                case 3:
                    $status = '已签收';
                    break;
                case 4:
                    $status = '派送失败';
                    break;
                case 5:
                    $status = '疑难件';
                    break;
                case 6:
                    $status = '退件签收';
                    break;
            }
            $orderCreateData['status'] = $status;
            $orderCreateData['detail'] = json_encode($result->list);
        }
        else
        {
            Log::info('order:', (array) $order);
            $orderCreateData['remark'] = '没有信息';
        }
        Order::create($orderCreateData);
    }
}
