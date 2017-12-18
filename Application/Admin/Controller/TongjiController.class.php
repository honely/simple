<?php
namespace Admin\Controller;
use Think\Controller;

class TongjiController extends Controller {

	function __construct() {
		//继承父类
		parent::__construct();
		
		//判断登录状态
		if(!D('admininfo')->islogin()){//未登录
			$this->error('您尚未登录，请先登录！',U('login/login'),3);
		}		
				
    }
	//空方法，防止报错
	public function _empty(){
        $this->index();
    }
	
	//学员注册统计
    public function index(){
		$where="1 ";
		$info=I("info");
		if ($info){
			@extract($info);
			if($keyword){$where.="and (nickname like '%$keyword%' or phone like '%$keyword%') ";$this->assign('keyword',$keyword);}
			if($starttime){$this->assign('starttime',$starttime);}
			if($endtime){$this->assign('endtime',$endtime);}
		}
		if(!$starttime){
			$starttime=date("Y-m-d",strtotime("-30 day"));$this->assign('starttime',$starttime);
		}
		if(!$endtime){
			$endtime=date("Y-m-d",SYS_TIME);$this->assign('endtime',$endtime);
		}

		$daylist=$this->get_daylist($starttime,$endtime);
		$infolist=array();
		foreach($daylist as $k=>$v){
			$where_=$where;
			$where_.="and addtime>=".strtotime($v." 00:00:00")." ";
			$where_.="and addtime<=".strtotime($v." 23:59:59")." ";
			$infolist[$v] = M("User")->where($where_)->count();
		}

		$this->assign('infolist',$infolist);
		
        $this->display();
    }

	//学员城市统计
    public function usercity(){
		$where="1 ";
		$info=I("info");
		if ($info){
			@extract($info);
			if($keyword){$where.="and (nickname like '%$keyword%' or phone like '%$keyword%') ";$this->assign('keyword',$keyword);}
			if($starttime){$this->assign('starttime',$starttime);}
			if($endtime){$this->assign('endtime',$endtime);}
		}
		if(!$starttime){
			$starttime=date("Y-m-d",strtotime("-30 day"));$this->assign('starttime',$starttime);
		}
		if(!$endtime){
			$endtime=date("Y-m-d",SYS_TIME);$this->assign('endtime',$endtime);
		}

		$infolist=array();
		$where_=$where;
		$where_.="and addtime>=".strtotime($starttime." 00:00:00")." ";
		$where_.="and addtime<=".strtotime($endtime." 23:59:59")." ";
		$infolist=M("User")->where($where_)->group('city')->field('city,count(*) as counts')->order("counts desc")->limit(30)->select();
		$this->assign('infolist',$infolist);
		
        $this->display();
    }

	//学员支付统计
    public function payinfo(){
		$where="1 ";
		$info=I("info");
		if ($info){
			@extract($info);
			if($keyword){$where.="and (nickname like '%$keyword%' or phone like '%$keyword%') ";$this->assign('keyword',$keyword);}
			if($starttime){$this->assign('starttime',$starttime);}
			if($endtime){$this->assign('endtime',$endtime);}

			if($pay_type!=""){$where.="and pay_type=$pay_type ";$this->assign('pay_type',$pay_type);}
			if($pay_flag!=""){$where.="and pay_flag=$pay_flag ";$this->assign('pay_flag',$pay_flag);}
		}
		if(!$starttime){
			$starttime=date("Y-m-d",strtotime("-30 day"));$this->assign('starttime',$starttime);
		}
		if(!$endtime){
			$endtime=date("Y-m-d",SYS_TIME);$this->assign('endtime',$endtime);
		}

		$daylist=$this->get_daylist($starttime,$endtime);
		$infolist=array();
		foreach($daylist as $k=>$v){
			$where_=$where;
			$where_.="and pay_addtime>=".strtotime($v." 00:00:00")." ";
			$where_.="and pay_addtime<=".strtotime($v." 23:59:59")." ";
			$pay_money = M("Payinfo")->where($where_)->join("left join ec_user on ec_user.user_id=ec_payinfo.user_id")->sum('pay_money');
			$infolist[$v] = $pay_money?$pay_money:0;
		}
		$this->assign('infolist',$infolist);

		$this->assign('payflag',D("Payinfo")->payflag());//支付状态
		$this->assign('paytype',D("Payinfo")->paytype());//支付方式
		
        $this->display();
    }

	//学员订阅统计
    public function buyinfo(){
		$where="1 ";
		$info=I("info");
		if ($info){
			@extract($info);
			if($keyword){$where.="and (nickname like '%$keyword%' or phone like '%$keyword%') ";$this->assign('keyword',$keyword);}
			if($starttime){$this->assign('starttime',$starttime);}
			if($endtime){$this->assign('endtime',$endtime);}

			if($buy_type!=""){$where.="and buy_type=$buy_type ";$this->assign('buy_type',$buy_type);}
			if($buy_flag!=""){$where.="and buy_flag=$buy_flag ";$this->assign('buy_flag',$buy_flag);}
		}
		if(!$starttime){
			$starttime=date("Y-m-d",strtotime("-30 day"));$this->assign('starttime',$starttime);
		}
		if(!$endtime){
			$endtime=date("Y-m-d",SYS_TIME);$this->assign('endtime',$endtime);
		}

		$daylist=$this->get_daylist($starttime,$endtime);
		$infolist=array();
		foreach($daylist as $k=>$v){
			$where_=$where;
			$where_.="and buy_addtime>=".strtotime($v." 00:00:00")." ";
			$where_.="and buy_addtime<=".strtotime($v." 23:59:59")." ";
			$infolist[$v] = M("Buyinfo")->where($where_)->join("left join ec_user on ec_user.user_id=ec_buyinfo.user_id")->count();
		}
		$this->assign('infolist',$infolist);

		$this->assign('buyflag',D("Buyinfo")->buyflag());//支付状态
		$this->assign('buytype',D("Buyinfo")->buytype());//支付方式
		
        $this->display();
    }

	//学员等级统计
    public function levelinfo(){
		$where="1 ";
		$info=I("info");
		if ($info){
			@extract($info);
			if($keyword){$where.="and (nickname like '%$keyword%' or phone like '%$keyword%') ";$this->assign('keyword',$keyword);}
			if($starttime){$this->assign('starttime',$starttime);}
			if($endtime){$this->assign('endtime',$endtime);}

		}
		if(!$starttime){
			$starttime=date("Y-m-d",strtotime("-30 day"));$this->assign('starttime',$starttime);
		}
		if(!$endtime){
			$endtime=date("Y-m-d",SYS_TIME);$this->assign('endtime',$endtime);
		}


		$level=M("Userlevel")->order("level_id desc")->select();
		$where_=$where;
		$where_.="and addtime>=".strtotime($starttime." 00:00:00")." ";
		$where_.="and addtime<=".strtotime($endtime." 23:59:59")." ";
		$infolist=array();
		foreach($level as $k=>$v){
			$infolist[$k]['count'] = M("User")->where($where_."and level=".$v['level_id']." ")->count();
			$infolist[$k]['levelname'] = $v['level_name'];
			$infolist[$k]['level_id'] = $v['level_id'];
		}

		$this->assign('infolist',$infolist);
		
        $this->display();
    }

	//学员VIP统计
    public function vipinfo(){
		$where="1 ";
		$info=I("info");
		if ($info){
			@extract($info);
			if($keyword){$where.="and (nickname like '%$keyword%' or phone like '%$keyword%') ";$this->assign('keyword',$keyword);}
			if($starttime){$this->assign('starttime',$starttime);}
			if($endtime){$this->assign('endtime',$endtime);}

		}
		if(!$starttime){
			$starttime=date("Y-m-d",strtotime("-30 day"));$this->assign('starttime',$starttime);
		}
		if(!$endtime){
			$endtime=date("Y-m-d",SYS_TIME);$this->assign('endtime',$endtime);
		}


		$level=M("viplevel")->order("vip_id desc")->select();
		$where_=$where;
		$where_.="and addtime>=".strtotime($starttime." 00:00:00")." ";
		$where_.="and addtime<=".strtotime($endtime." 23:59:59")." ";
		foreach($level as $k=>$v){
			$infolist[$k]['count'] = M("User")->where($where_."and vip=".$v['vip_id']." ")->count();
			$infolist[$k]['vipname'] = $v['vip_name'];
		}
		$this->assign('infolist',$infolist);
		
        $this->display();
    }

	//专题订阅统计
	public function coursebuy(){
		$infolist=M("course")->order("course_buy desc,course_id desc")->limit(30)->field("course_name,course_buy,course_retime,course_speaker")->where("course_buy>0")->select();
		$this->assign('infolist',$infolist);
		
        $this->display();
	}
	//专题浏览统计
	public function courseview(){	//课程浏览统计(新)
		$infolist=M("lesson")->order("lesson_view desc,lesson_id desc")->limit(30)->field("lesson_name,lesson_view,lesson_addtime")->where("lesson_view>0")->select();
		$this->assign('infolist',$infolist);
		
        $this->display();
	}
	//专题播放统计
	public function courseplay(){ //课程播放统计(新)
		$infolist=M("lesson")->order("lesson_play desc,lesson_id desc")->limit(30)->field("lesson_name,lesson_play,lesson_addtime")->where("lesson_play>0")->select();
		
		$this->assign('infolist',$infolist);
	
        $this->display();
	}

	//课程评论统计
    public function commentcount(){
		$where="1 ";
		$info=I("info");
		if ($info){
			@extract($info);
			if($keyword){$where.="and (nickname like '%$keyword%' or phone like '%$keyword%' or lesson_name like '%$keyword%') ";$this->assign('keyword',$keyword);}
			if($starttime){$this->assign('starttime',$starttime);}
			if($endtime){$this->assign('endtime',$endtime);}

		}
		if(!$starttime){
			$starttime=date("Y-m-d",strtotime("-30 day"));$this->assign('starttime',$starttime);
		}
		if(!$endtime){
			$endtime=date("Y-m-d",SYS_TIME);$this->assign('endtime',$endtime);
		}

		$daylist=$this->get_daylist($starttime,$endtime);
		$infolist=array();
		foreach($daylist as $k=>$v){
			$where_=$where;
			$where_.="and ec_comment.addtime>=".strtotime($v." 00:00:00")." ";
			$where_.="and ec_comment.addtime<=".strtotime($v." 23:59:59")." ";
			$infolist[$v] = M("comment")->where($where_)
				->join("left join ec_user on ec_user.user_id=ec_comment.user_id")
				->join("left join ec_lesson on ec_lesson.lesson_id=ec_comment.lesson_id")->count();
		}
		$this->assign('infolist',$infolist);
		
        $this->display();
    }

	///////////////////////////////////////////////////////////////////////
	//获取两个日期段内所有日期
	public function get_daylist($startdate,$enddate){
		$stimestamp = strtotime($startdate);
		$etimestamp = strtotime($enddate);
		// 计算日期段内有多少天
		$days = ($etimestamp-$stimestamp)/86400+1;
		// 保存每天日期
		$date = array();
		for($i=0; $i<$days; $i++){
			$date[] = date('Y-m-d', $stimestamp+(86400*$i));
		}
		return array_reverse($date); ;
	}
}