<?php
namespace App\Services\Logistics;


class Service {
    private $__client = null;
    public function __construct($cfg,$ts=null) {
        $this->__client = new Client($cfg);
        
    }

    //店铺查询  普通接口
    public function shops($params=null) {
        if($params == null) $params = (object)array();
        return $this->__client->call('shops.query',$params);
    }

    public function orderSingle($params=null) {
        if($params == null) $params = (object)array();
        return $this->__client->call('orders.single.query',$params);
    }

    public function logistic($params=null) {
        if($params == null) $params = (object)array();
        return $this->__client->call('logistic.query',$params);
    }

}

?>