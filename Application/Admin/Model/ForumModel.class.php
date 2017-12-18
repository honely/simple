<?php
namespace Admin\Model;
use Think\Model;

class ForumModel extends Model {
	
	//获取置顶状态
	/*
	 * return array
	 */
	public function get_forum_top(){
		return array(
			'1'=>'非置顶',
			'2'=>'置顶', 	 
		);
	}
	
	public function get_forum_flag(){
		return array(
			'1'=>"未审核",
			'2'=>'已审核',  
		);
	}
}