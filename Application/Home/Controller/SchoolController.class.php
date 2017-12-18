<?php
namespace Home\Controller;
use Think\Controller;

/*
 *前端主架构控制器0916
 * controller 控制器
 * action 方法
 * return true/false
 */
class SchoolController extends Controller {

	function __construct() {
		//继承父类
		parent::__construct();
		
	
		$user_id=session("user_id");
		//判断登录状态
		if($user_id==""){//未登录
			 	header("Location:".U('index/index'));
				exit();
		}
	
    }

	//空方法，防止报错
	public function _empty(){
        echo "非法操作！！！";
		exit();
    }
	
	//默认我要入学
    public function index(){
		header("Content-Type: text/html; charset=utf-8");
		$user_id=session("user_id"); //会员登录user_id
		$user_info = M("user")
				->where("ec_user.user_id='".$user_id."' and vip!=0")
				->join('left join ec_userlevel on ec_userlevel.level_id = ec_user.level')
				->join('left join ec_viplevel on ec_viplevel.vip_id = ec_user.vip')
				->field('ec_user.*,ec_userlevel.level_name,ec_viplevel.vip_image,ec_viplevel.vip_name')
				->find();			
		$content_id=5;
		$content_info_= M("content")->where('id='.$content_id)->fetchsql(false)->find();
		$this->assign('content_info_',$content_info_); //我要入学信息	
		$this->assign('user_info',$user_info);		 	//用户信息	
		if (!$user_info) {
            jump("您已入学", U("index/index"));
        }
		$this->display();
    }

}