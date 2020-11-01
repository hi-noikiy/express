<?php
namespace App\Services\Logistics;


class AliClient {

    public function __construct() {

    }

    public function wuliu($order)
    {
        $host = config('aliwuliu.host');//api访问链接
        $path = "/kdi";//API访问后缀
        $method = "GET";
        $appcode = config('aliwuliu.app_code');//开通服务后 买家中心-查看AppCode
        $headers = [];
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $querys = "no=$order&type=zto";  //参数写在这里
        $bodys = "";
        $url = $host . $path . "?" . $querys;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        if (1 == strpos("$" . $host, "https://")) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        $out_put = curl_exec($curl);

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        list($header, $body) = explode("\r\n\r\n", $out_put, 2);
        if ($httpCode == 200) {
            return json_decode($body);
        } else {
            if ($httpCode == 400 && strpos($header, "Invalid Param Location") !== false) {
                $message = '参数错误';
            } elseif ($httpCode == 400 && strpos($header, "Invalid AppCode") !== false) {
                $message = 'AppCode错误';
            } elseif ($httpCode == 400 && strpos($header, "Invalid Url") !== false) {
                $message = '请求的 Method、Path 或者环境错误';
            } elseif ($httpCode == 403 && strpos($header, "Unauthorized") !== false) {
                $message = '服务未被授权（或URL和Path不正确）';
            } elseif ($httpCode == 403 && strpos($header, "Quota Exhausted") !== false) {
                $message = "套餐包次数用完";
            } elseif ($httpCode == 500) {
                $message = "API网关错误";
            } elseif ($httpCode == 0) {
                $message = "URL错误";
            } else {
                $message = "参数名错误 或 其他错误";
//                $headers = explode("\r\n", $header);
//                $headList = array();
//                foreach ($headers as $head) {
//                    $value = explode(':', $head);
//                    $headList[$value[0]] = $value[1];
//                }
//                $message = $headList['x-ca-error-message'];
            }

            return ['status' => $httpCode, 'msg' => $message];
        }
    }
}

?>