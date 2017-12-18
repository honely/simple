<?php
namespace Admin\Model;
use Think\Model;

class PayinfoModel extends Model {
    
    public function paytype(){
    
        return array(
            '1' => '微信',
            '2' => '手动',
            '3' => '其他'
        );
    }
    
    public function payflag(){
    
        return array(
            '1' => '未支付',
            '2' => '已支付'
        );
    }
    
}