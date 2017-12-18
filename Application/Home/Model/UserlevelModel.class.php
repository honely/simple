<?php 
namespace Home\Model;

use Think\Model;

class UserlevelModel extends Model {
    //获取用户等级
    public function get_userlevel(){
        $userlevel = M('userlevel')->select(); 
		$return=array();
		foreach($userlevel as $k=>$v){
		   $return[$v['level_id']]=$v['level_name'];
		}
        return $return;
    }
}
