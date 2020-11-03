<?php

namespace App\Http\Controllers;

use App\Jobs\Order\Import;
use App\Services\Logistics\AliClient;
use App\Services\Logistics\Config;
use App\Services\Logistics\Service;
use App\Services\User\UserService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['demo']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function demo()
    {
//        $env =array(
//            'sandbox' => false, //测试环境还是正式环境
//            'debug_mode'=>false, //是否输出日志
//            'partner_id' => '0b55fd61441dc30e93d6913d2a821499',
//            'partner_key' => 'f8d8246a4e176f344b8c0d8de9257b2a',
//            'token' => '51e5dcfeb9e213368199c44ff85dce7d'
//        );
//
//        $config = new Config($env['sandbox'],$env['partner_id'],$env['partner_key'],$env['token'],'','',$env['debug_mode']);
//
//        $service = new Service($config);
//        $shipId = 10236807;
//        $params = [
//            'shop_id' => $shipId,
//            'modified_begin' => date('Y-m-d H:i:s', strtotime('-1 days')),
//            'modified_end' => date('Y-m-d H:i:s', time()),
//        ];
//
//        //普通接口调用方式,查询全部店铺信息
//        $response = $service->orderSingle($params);
//        dump($response);

//        $item = ["中通", "78153135291576"];
//        Import::dispatch($item);
//        $aliclient = app(AliClient::class);
//        $res = $aliclient->wuliu(78153135291576);
//        dump($res);
//        $host = "https://wuliu.market.alicloudapi.com";//api访问链接
//        $path = "/kdi";//API访问后缀
//        $method = "GET";
//        $appcode = "f4d3c085f5e84b2d8b4a679d68f6b7f9";//开通服务后 买家中心-查看AppCode
//        $headers = array();
//        array_push($headers, "Authorization:APPCODE " . $appcode);
//        $querys = "no=9863358947551";  //参数写在这里
//        $bodys = "";
//        $url = $host . $path . "?" . $querys;
//
//        $curl = curl_init();
//        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
//        curl_setopt($curl, CURLOPT_URL, $url);
//        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//        curl_setopt($curl, CURLOPT_FAILONERROR, false);
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($curl, CURLOPT_HEADER, true);
//        if (1 == strpos("$" . $host, "https://")) {
//            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
//            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
//        }
//        $out_put = curl_exec($curl);
//
//        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
//
//        list($header, $body) = explode("\r\n\r\n", $out_put, 2);
//        if ($httpCode == 200) {
//            print("正常请求计费(其他均不计费)<br>");
//            print($body);
//        } else {
//            if ($httpCode == 400 && strpos($header, "Invalid Param Location") !== false) {
//                print("参数错误");
//            } elseif ($httpCode == 400 && strpos($header, "Invalid AppCode") !== false) {
//                print("AppCode错误");
//            } elseif ($httpCode == 400 && strpos($header, "Invalid Url") !== false) {
//                print("请求的 Method、Path 或者环境错误");
//            } elseif ($httpCode == 403 && strpos($header, "Unauthorized") !== false) {
//                print("服务未被授权（或URL和Path不正确）");
//            } elseif ($httpCode == 403 && strpos($header, "Quota Exhausted") !== false) {
//                print("套餐包次数用完");
//            } elseif ($httpCode == 500) {
//                print("API网关错误");
//            } elseif ($httpCode == 0) {
//                print("URL错误");
//            } else {
//                print("参数名错误 或 其他错误");
//                print($httpCode);
//                dd($header);
//                $headers = explode("\r\n", $header);
//                $headList = array();
//                foreach ($headers as $head) {
//                    $value = explode(':', $head);
//                    $headList[$value[0]] = $value[1];
//                }
//                print($headList['x-ca-error-message']);
//            }
//        }
        $item = ["邮政快递包裹", "9863356919550", "拼多多-全护润滑油旗舰店"];
        Import::dispatch($item);
    }
}
