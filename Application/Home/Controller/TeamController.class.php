<?php
namespace Home\Controller;
use Think\Controller;

/*
 *前端主架构控制器0916
 * controller 控制器
 * action 方法
 * return true/false
 */
class TeamController extends Controller {

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
	
	//默认我合伙人招募
    public function index(){
		$user_id=session("user_id"); //会员登录user_id
		$user_info = M("user")
				->where('ec_user.user_id='.intval($user_id))
				->join('left join ec_userlevel on ec_userlevel.level_id = ec_user.level')
				->field('ec_user.*,ec_userlevel.level_name,ec_userlevel.level_image')
				->find();
		$content_id=4;
		$content_info_= M("content")->where('id='.$content_id)->fetchsql(false)->find();
		$this->assign('content_info_',$content_info_); //我合伙人招募信息	
		$this->assign('user_info',$user_info);		 	//用户信息	
		$this->display();
    }

}