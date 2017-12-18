<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/08/28 0028
 * Time: 17:31:57
 */

namespace Home\Model;
use Think\Model;

class ApplyinfoModel extends Model
{
    //vip等级
    public function ger_viplevel(){
    $result=array();
    $vip_level=M("Viplevel")->select();
    foreach ($vip_level as $key=>$value){
        $result[$key+1]=$value['vip_name'];
    }
    $result[0]="非vip会员";
    return $result;

}
    //用户等级
    public function ger_userlevel(){
        $result=array();
        $user_level=M("Userlevel")->select();
        foreach ($user_level as $key=>$value){
            $result[$key+1]=$value['level_name'];
        }
        return $result;
    }
	
	 
	
}