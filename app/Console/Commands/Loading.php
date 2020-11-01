<?php

namespace App\Console\Commands;

use App\Jobs\Order\Import;
use App\Models\Order;
use App\Services\Logistics\Config;
use App\Services\Logistics\Service;
use Illuminate\Console\Command;

class Loading extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wuliu:loading';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $orders = Order::where('type', 2)->get();
        $ids = [];
        foreach ($orders as $order)
        {
            array_push($ids, $order->id);
        }
        Order::destroy($ids);
        $this->loading(1);
    }

    public function loading($page = 1)
    {
        $env =array(
            'sandbox' => false, //测试环境还是正式环境
            'debug_mode'=>false, //是否输出日志
            'partner_id' => '0b55fd61441dc30e93d6913d2a821499',
            'partner_key' => 'f8d8246a4e176f344b8c0d8de9257b2a',
            'token' => '51e5dcfeb9e213368199c44ff85dce7d'
        );

        $config = new Config($env['sandbox'],$env['partner_id'],$env['partner_key'],$env['token'],'',
            '',$env['debug_mode']);
        $service = new Service($config);
        $params = [
            'modified_begin' => date('Y-m-d H:i:s', strtotime('-1 days')),
            'modified_end' => date('Y-m-d H:i:s', time()),
            'page_size' => 50,
            'page_index' => $page
        ];

        $response = $service->orderSingle($params);
        dump($response);
        if ($response['page_size'])
        {
            $orders = $response['orders'];
            foreach ($orders as $order)
            {
                if ($order['l_id'])
                {
                    if (!in_array($order['status'], ["WaitPay", "Cancelled"]))
                    {
                        $orderId = str_replace('@', '', $order['l_id']);
                        $item = [$order['logistics_company'], $orderId, $order['shop_name']];
                        dump($item);
                        Import::dispatch($item);
                    }
                }
            }
            if ($response['page_count'] > 1)
            {
                for ($i=$page+1;$i<=$response['page_count'];$i++)
                {
                    $this->loading($i);
                }
            }
        }

    }
}