<?php
namespace Home\Controller;
use Think\Controller;

/*
 *前端主架构控制器0902
 * controller 控制器
 * action 方法
 * return true/false
 */
class CollectController extends Controller {

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
	
	//默认首页
    public function index(){
		$this->display();
    }
    //我的收藏
	public function mycollect(){
		$user_id=session("user_id");
		//$user_id=1;
		// 查询满足要求的总记录数
		$count      =M("Collect")
					->join("left join  ec_course on ec_course.course_id=ec_collect.course_id")
					->join("left join  ec_user on ec_user.user_id=ec_collect.user_id")
					->join("left join  ec_lesson on ec_lesson.lesson_id=ec_collect.lesson_id")
					->field("ec_collect.collect_id,ec_collect.user_id,ec_collect.course_id,ec_user.nickname,
					ec_course.course_name,ec_lesson.lesson_id,ec_lesson.lesson_name,ec_lesson.lesson_remarks,ec_lesson.lesson_image,
					ec_lesson.lesson_ishot ")
					->where('ec_collect.user_id='.$user_id)
					->count();
					
		$Page       = new \Think\Page($count,5);
		$collect=M("Collect")
				->join("left join  ec_course on ec_course.course_id=ec_collect.course_id")
				->join("left join  ec_user on ec_user.user_id=ec_collect.user_id")
				->join("right join  ec_lesson on ec_lesson.lesson_id=ec_collect.lesson_id")
				->field("ec_collect.collect_id,ec_collect.user_id,ec_collect.course_id,ec_user.nickname,
						ec_course.course_name,ec_lesson.lesson_id,ec_lesson.lesson_name,ec_lesson.lesson_remarks,ec_lesson.lesson_image,
						ec_lesson.lesson_ishot ")
				->where("ec_collect.user_id='".$user_id."'  ")
				->order('ec_collect.collect_id desc ')
				->limit($Page->firstRow.','.$Page->listRows)
				->select();
		//dump($collect);
		//加载更多
		if(IS_AJAX){
			  if($Page->totalPages>=$p){
				  $this->ajaxReturn(array('collect'=>$collect));
			  }else{
				  $this->ajaxReturn(array('collect'=>array()));
			  }
        } else{
              $this->assign("collect",$collect);
              $this->assign("count",$count);
			  $this->display();
        }
    }
	
	//删除收藏
	public function delcollect(){
        $collect_id = I("get.collect_id");
        M("collect")->where("collect_id=".$collect_id)->delete();
        jump("删除成功",U("collect/mycollect"));
    }
	//删除收藏(ajax)
	public function del(){
		if(IS_AJAX){
			$collect_id = $_POST['collect_id'];
			$info=M("collect")->where("collect_id=".$collect_id)->delete();
			if($info){
				   $this->ajaxReturn("删除成功");
				}else{
				   $this->ajaxReturn("删除失败");
				}
		}
    }

	
	//申请分社
	public function applyforbranch(){
		header("Expires:-1");
        header("Cache-Control:no_cache");
        header("Pragma:no-cache");
		$user_id=session("user_id");
		//$user_id=1;
		$state=1;
		if(IS_POST){
			$info=I('info');
			$info['user_id']=$user_id;		
			$info['apply_addtime']=time();		
			$info['apply_flag']=1;	
			$flag=M("Applyinfo")->add($info);
			if($flag){
				//$state=2;
				 jump('你已经提交申请，稍后我们的工作人员会与你取得联系，谢谢。', U('personal/my'));
			}
		}
		//是否已经申请过分社
		$applay=M("Applyinfo")->where('user_id='.$user_id)->find();
		if($applay){
			$this->assign("applay",$applay);
		}
		//分社条款详情
		$content=M("Content")->where("id=2")->find();
		$user=M("User")->join('left join ec_userlevel on ec_userlevel.level_id=ec_user.level ')->where("ec_user.user_id=".$user_id)->find();
		//dd($user);
		//签到
		$counts=M('scoreinfo')->where($where1)->count();
	    $this->assign('counts',$counts);
		$this->assign("user",$user);
		//$this->assign("state",$state);
		$this->assign("content",$content);
		$this->display();
		
    }
	//学分规则
	public function creditrules(){
		$this->display();
	}
	//规则
	public function creditrules_1(){
		$id=I('get.id');
		$content=M("Content")->where("id=".$id." ")->find();
		$this->assign("content",$content);
		$this->display();
	}
	

}