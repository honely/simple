<?php
namespace Admin\Model;
use Think\Model;

class BuyinfoModel extends Model {
    
    public function buytype(){
        return array(
            '1' => '微信',
            '2' => '奖学金',
        );
    }
    
    public function buyflag(){
        return array(
            '1' => '未支付',
            '2' => '已支付'
        );
    }
    public function isself(){
        return array(
            '1' => '是',
            '2' => '否'
        );
    }
	//研习班报名表支付状态，1未支付，2已支付
	  public function pay_flag(){
        return array(
			'1' => '未支付',
            '2' => '已支付'
        );
    }
	//研习班报名表支付方式，1微信，2余额
	  public function pay_type(){
        return array(
            '1' => '微信',
            '2' => '奖学金',
        );
    }
	
	//工具类型：1管理工具；2落地方案；3行业资料
	
	  public function down_type(){
        return array(
            '1' => '管理工具',
            '2' => '落地方案',
			'3' => '行业资料'
        );
    }
	
    
}