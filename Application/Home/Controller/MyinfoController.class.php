<?php
namespace Home\Controller;
use Think\Controller;

/*
 *前端主架构控制器0902
 * controller 控制器
 * action 方法
 * return true/false
 */
class MyinfoController extends Controller {

	function __construct() {
		//继承父类
		parent::__construct();
		//判断是否在微信中打开
		/*if(!is_weixin()){
			header("Content-Type: text/html; charset=utf-8");
			echo "<center style='font-size:5rem;padding-top:3rem;'>系统提示：<br>请在微信中打开。。。</center>";
			exit();
		}*/
		if (ACTION_NAME != "down") {
			//判断登录状态
			$user_id=session("user_id");
			if($user_id==""){//未登录
					header("Location:".U('index/index'));
					exit();
			}
		}
		//通过header来禁用缓存
		header("Expires:-1");
		header("Cache-Control:no_cache");
		header("Pragma:no-cache");
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
	
	//学习记录
    public function xuexijilu(){
		$user_id=session("user_id");
		// 查询满足要求的总记录数
		$count    =M('Learninfo')
		          ->where('ec_user.user_id='.$user_id)
				  ->join('left join ec_user on ec_user.user_id=ec_learninfo.user_id')
				  ->join('left join ec_course on ec_learninfo.course_id=ec_course.course_id')
				  ->join('left join ec_lesson on ec_lesson.lesson_id=ec_learninfo.lesson_id')
				  ->count();
		$Page       = new \Think\Page($count,5);
		$learnlist=M('Learninfo')
		          ->where('ec_user.user_id='.$user_id)
				  ->join('left join ec_user on ec_user.user_id=ec_learninfo.user_id')
				  ->join('left join ec_course on ec_learninfo.course_id=ec_course.course_id')
				  ->join('left join ec_lesson on ec_lesson.lesson_id=ec_learninfo.lesson_id')
				  ->order('ec_learninfo.learn_id desc ')
				  ->limit($Page->firstRow.','.$Page->listRows)
				  ->select();
		foreach($learnlist as $k=>$v){
		   $learnlist[$k]['learn_addtime']=date('Y-m-d H:i:s',$v['learn_addtime']);
		}
	    if(IS_AJAX){
			  if($Page->totalPages>=$p){
				  $this->ajaxReturn(array('learnlist'=>$learnlist));
			  }else{
				  $this->ajaxReturn(array('learnlist'=>array()));
			  }
        } else{
              $this->assign('learnlist',$learnlist);
			  $this->assign('count',$count);
			  $this->display();
        }		  
		
    }
	//删除学习记录
	public function del(){
		if(IS_AJAX){
			$learn_id = $_POST['learn_id'];
			$info=M("learninfo")->where("learn_id=".$learn_id)->delete();
			if($info){
				   $this->ajaxReturn("删除成功");
				}else{
				   $this->ajaxReturn("删除失败");
				}
		}
    }

	//章节学习记录
    public function xuexijilu_alone(){
		$user_id=session("user_id");
		// 查询满足要求的总记录数
		$count    =M('Learninfoalone')
		          ->where('ec_user.user_id='.$user_id)
				  ->join('left join ec_lessonalone on ec_lessonalone.lesson_id=ec_learninfoalone.lesson_id')
				  ->join('left join ec_user on ec_user.user_id=ec_learninfoalone.user_id')
				  ->count();
		$Page       = new \Think\Page($count,5);
		$learnlist=M('Learninfoalone')
		          ->where('ec_user.user_id='.$user_id)
				  ->join('left join ec_lessonalone on ec_lessonalone.lesson_id=ec_learninfoalone.lesson_id')
				  ->join('left join ec_user on ec_user.user_id=ec_learninfoalone.user_id')
				  ->order('ec_learninfoalone.learn_id desc ')
				  ->limit($Page->firstRow.','.$Page->listRows)
				  ->select();
				  
		foreach($learnlist as $k=>$v){
		   $learnlist[$k]['learn_addtime']=date('Y-m-d H:i:s',$v['learn_addtime']);
		}
		//查询所有lession_id
		$lesson=M('lesson')->field('lesson_id')->select();
	    if(IS_AJAX){
			  if($Page->totalPages>=$p){
				  $this->ajaxReturn(array('learnlist'=>$learnlist));
			  }else{
				  $this->ajaxReturn(array('learnlist'=>array()));
			  }
        } else{
              $this->assign('learnlist',$learnlist);
			  $this->assign('count',$count);
			  $this->assign('lesson',$lesson);
			  $this->display();
        }		  
		
    }
	//删除章节学习记录
	public function del_alone(){
		if(IS_AJAX){
			$learn_id = $_POST['learn_id'];
			$info=M("learninfoalone")->where("learn_id=".$learn_id)->delete();
			if($info){
				   $this->ajaxReturn("删除成功");
				}else{
				   $this->ajaxReturn("删除失败");
				}
		}
    }
	//资料完善
    public function ziliaowanshan(){
		$user_id=session("user_id");
		if (IS_POST){
			$info=I("info");
			$chengshi=explode('-',$info['cheng']);
			$info['province']=$chengshi[0];
			$info['city']=$chengshi[1];
			$flag=M("User")->where('user_id='.$user_id)->save($info);
			if($flag){
				jump('资料完善成功！',U('personal/my'));
				
			}else{
				jump('资料完善失败！',U('myinfo/ziliaowanshan'));
			}
		}else{
		    //查询性别
		    $list=M('User')->where('user_id='.$user_id)->find();
			$this->assign('list',$list);
			$this->display();
		}
		
    }
	
	//工具下载
	 public function gongjvxiazai(){
        //类型：1管理工具；2落地方案；3行业资料
         $magTools=M('down_subtype')->where('type_id = 1')->select();//1管理工具
         $scheme=M('down_subtype')->where('type_id = 2')->select();//2落地方案
         $information=M('down_subtype')->where('type_id = 3')->select();//3行业资料
         $this->assign('magTools',$magTools);
         $this->assign('scheme',$scheme);
         $this->assign('information',$information);
		 $this->display();
	 }

	 //工具下载详情页
    public function download(){
	     $down_subtype=I('get.down_subtype');
	     $downInfo=M('downinfo')->where('down_subtype = '.$down_subtype)->select();
	     $this->assign('downInfo',$downInfo);
         $this->assign('subtype',M("down_subtype")->where("subtype_id=".$down_subtype)->find());
	     //判断用户是否为VIP
         $user_id=session("user_id");
         $userinfo=M("User")->where("user_id=".$user_id)->field("vip")->find();
         $this->assign('userinfo',$userinfo);
         $this->display();
    }
	  
     public function down(){
		 $down_id=I('get.down_id');
		 $dizhi=M('Downinfo')->where('down_id='.$down_id)->order('down_id desc ')->find();
         M('Downinfo')->where('down_id='.$down_id)->setInc('down_count',1);
		 /*
		 echo "<script>location.href='".$dizhi['down_file']."'</script>";
		 exit();
		 */
         //文件保存目录路径
         $save_path = THINK_PATH . '../uploadfile/';
         //文件保存目录URL
         $save_url =  C("WEB_URL") . 'uploadfile/';
         $filepath=str_replace($save_url,$save_path,$dizhi['down_file']);		 
         header('Content-Description: File Transfer');
         header('Content-Type: application/octet-stream');
         header('Content-Disposition: attachment; filename='.basename($filepath));
         header('Content-Transfer-Encoding: binary');
         header('Expires: 0');
         header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
         header('Pragma: public');
         header('Content-Length: ' . filesize($filepath));
         readfile($filepath);
	 }
	 
    //奖学金
	 public function jiangxuejin(){
		$user_id=session("user_id"); 
		$where="refree_id='".$user_id."' and user_id!=".$user_id." ";
		//签到状态
		$t = time();
		//开始时间戳
		$start = mktime(0,0,0,date("m",$t),date("d",$t),date("Y",$t));
		//结束时间戳
		$end = mktime(23,59,59,date("m",$t),date("d",$t),date("Y",$t));
		//判断是否签到
		$wheres=" 1 and score_addtime >='".$start."' and score_addtime <='".$end."' and user_id='".$user_id."' and  scroe_type = 2 ";
		$count_s=M('scoreinfo')->where($wheres)->count();
		// 查询满足要求的总记录数
		$count    =M('User')->where($where)->join('left join ec_userlevel on ec_userlevel.level_id=ec_user.level')->count();
		//查询邀请的vip个数
		$counts    =M('User')->where($where." and vip!=0")->join('left join ec_userlevel on ec_userlevel.level_id=ec_user.level')->count();
		//查询邀请的普通会员个数
		$countss    =M('User')->where($where." and vip=0")->join('left join ec_userlevel on ec_userlevel.level_id=ec_user.level')->count();
		//查询奖学金
		$yue=M('User')->where('user_id='.$user_id)->join('left join ec_viplevel on ec_viplevel.vip_id=ec_user.vip')->find();
		$Page      = new \Think\Page($counts,6);//vip
		$Pages      = new \Think\Page($countss,6);//普通会员
		//邀请的vip
		$vip=M('User')
			->where($where." and vip!=0 ")
			->join('left join ec_userlevel on ec_userlevel.level_id=ec_user.level')
			->join('left join ec_viplevel on ec_viplevel.vip_id=ec_user.vip')
			->order('ec_user.user_id desc')
			->limit($Page->firstRow.','.$Page->listRows)
			->select();
		//邀请的普通会员
		$huiyuan=M('User')
			->where($where." and vip=0 ")
			->join('left join ec_userlevel on ec_userlevel.level_id=ec_user.level')
			->order('ec_user.user_id desc')
			->limit($Pages->firstRow.','.$Pages->listRows)
			->select();				
		if(IS_AJAX){
			$state=I('get.state');//state=1为普通会员 
			if(!$state){
					if($Page->totalPages>=$p){
						$this->ajaxReturn(array('vip'=>$vip));
					    }else{
						$this->ajaxReturn(array('vip'=>array()));
						}
		       }else{
					if($Pages->totalPages>=$p){
						$this->ajaxReturn(array('huiyuan'=>$huiyuan));
						}else{
						$this->ajaxReturn(array('huiyuan'=>array()));
						}
			   }
		}else{
			$this->assign('user_id',$user_id); 
			$this->assign('yue',$yue);
			$this->assign('count',$count); 
			$this->assign('count_s',$count_s); 
			$this->assign('counts',$counts); 
			$this->assign('countss',$countss); 
			$this->assign('huiyuan',$huiyuan);
			$this->assign('vip',$vip);	
			$this->assign('user_level',D('userlevel')->get_userlevel()); 
			$this->display();	
		}		
	 }

    //下级列表
	public function xiajiliebiao(){
		$user_id=session("user_id"); 
		$where="refree_id='".$user_id."' and user_id!=".$user_id." ";
		$count=M('User')->where($where)->join('left join ec_userlevel on ec_userlevel.level_id=ec_user.level')->count();
		$Page      = new \Think\Page($counts,10);//vip
		$zengsong=M('User')->where($where)->join('left join ec_userlevel on ec_userlevel.level_id=ec_user.level')->limit($Page->firstRow.','.$Page->listRows)
		->select();
		if(IS_AJAX){
			if($Page->totalPages>=$p){
			$this->ajaxReturn(array('zengsong'=>$zengsong));
			}else{
			$this->ajaxReturn(array('zengsong'=>array()));
			}
		}else{
			$this->assign('zengsong',$zengsong); 
			$this->assign('count',$count); 
			$this->display();
		}
	}
	
	//赠送奖学金
	public function zengsong(){
		$user_id=session("user_id");  
		$to_user_id=I("to_user_id"); //赠送的对象
		$money=abs(floatval(I("jine")));//赠送的金额
		//先查询自己的奖学金余额
		$yue=M('User')->where('user_id='.$user_id)->field('money')->find();
		if(IS_POST){
			if(abs(floatval($yue['money']))>=$money && $money!=''){
				//减自己的奖学金
				M('User')->where('user_id='.$user_id )->setDec('money',$money);
				//赠送对象增加的奖学金
				M('User')->where('user_id='.$to_user_id )->setInc('money',$money);
				//加赠送记录
				M('moneyinfo')->add(array('user_id'=>$to_user_id,'money_type'=>2,'money_money'=>$money,'money_remarks'=>'赠送奖学金【'.$user_id.'】TO【'.$to_user_id.'】','money_addtime'=>time(),'send_user_id'=>$user_id));   
				jump('赠送成功！',U('myinfo/xiajiliebiao'));
			}else{
				jump('奖学金不足,赠送失败！',U('myinfo/xiajiliebiao'));	
			}
		}
	}
	 
	 
}