<?php
/**
 * Created by PhpStorm.
 * Useroop: Administrator
 * Date: 2011/1/21
 * Time: 5:55
 */
namespace Admin\Model;
use Think\Model;

class ApplyinfoModel extends Model{

    public function applyflag(){
      return  array(
            '1' => '申请',
            '2' => '通过',
            '3' => '驳回'
        );
    }
	
	//分社级别 1城市分社，2分社代言人
	public function get_applytype(){
		return array(
		    '1' => '城市分社',
            '2' => '分社代言人'
		);
		
	}
	
}


