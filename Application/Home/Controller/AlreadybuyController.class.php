<?php
namespace Home\Controller;
use Think\Controller;

/*
 *前端主架构控制器0902
 * controller 控制器
 * action 方法
 * return true/false
 */
class AlreadybuyController extends Controller {
        function __construct() {
		//继承父类
		parent::__construct();
		//判断是否在微信中打开
		/*if(!is_weixin()){
			header("Content-Type: text/html; charset=utf-8");
			echo "<center style='font-size:5rem;padding-top:3rem;'>系统提示：<br>请在微信中打开。。。</center>";
			exit();
		}*/
		//判断登录状态
		$user_id=session("user_id");
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
	
	//默认首页(已购)
    public function index(){
		$user_id=session("user_id");
		//$user_id=5;
		//查询满足要求的总记录数
		$count      =M("Buyinfo")
					->join("left join  ec_course on ec_course.course_id=ec_buyinfo.course_id")
					->join("left join  ec_user on ec_user.user_id=ec_buyinfo.user_id")
					->where('ec_buyinfo.user_id='.$user_id." and ec_buyinfo.course_id>0 and ec_buyinfo.buy_flag=2 and ec_buyinfo.buy_endtime>= ".SYS_TIME)
					->count();
		$Page       = new \Think\Page($count,5);
		$listinfo=M("Buyinfo")
					->join("left join  ec_course on ec_course.course_id=ec_buyinfo.course_id")
					->join("left join  ec_user on ec_user.user_id=ec_buyinfo.user_id")
					->where('ec_buyinfo.user_id='.$user_id." and ec_buyinfo.course_id>0 and ec_buyinfo.buy_flag=2 and ec_buyinfo.buy_endtime>= ".SYS_TIME)
					->order('ec_buyinfo.buy_id desc ')
					->fetchSQL(false)
					->limit($Page->firstRow.','.$Page->listRows)
					->select();
					
		//dd($listinfo);die;
		//加载更多
		if(IS_AJAX){
			  if($Page->totalPages>=$p){
				  $this->ajaxReturn(array('listinfo'=>$listinfo));
			  }else{
				  $this->ajaxReturn(array('listinfo'=>array()));
			  }
        } else{
              $this->assign("listinfo",$listinfo);
              $this->assign("count",$count);
			  $this->display();
        }
    }
	
	

}