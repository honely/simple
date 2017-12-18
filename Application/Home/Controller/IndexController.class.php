<?php

namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller {

    function __construct() {
	//继承父类
	parent::__construct();
	session("user_id", 7);
	if (ACTION_NAME != "attention") {
	    //session("user_id",null);die;
	    $referee = I("referee");
	    if (!session("user_id")) {
		session("user_id", null);
		header("Location:" . WEB_HOST . "index.php/home/weixin/wxlogin/referee/" . $referee);
		exit();
	    } else {
		//session user_id存在不等于undefined或者数据库不存在当前用户
		$id = M("User")->where('user_id=' . intval(session("user_id")))->find();
		if (!$id) {
		    header("Location:" . WEB_HOST . "index.php/home/weixin/wxlogin/referee/" . $referee);
		    exit();
		}
	    }
	    $user_id = session("user_id");
	    $user_infos_ = M("user")->where('user_id=' . intval($user_id))->find();

	    //vip 购买时间到期状态更改为0普通会员 (1判断会员是否是vip，不是直接VIP重置为0;) 
	    if ($user_infos_['vip'] && $user_infos_['vipendtime'] < SYS_TIME) {
		$info_['vip'] = 0;
		$info_['vipendtime'] = '';
		M('user')->where('user_id=' . intval($user_id))->save($info_);
	    }
	    //更新用户等级
	    $user_id = session("user_id");
	    $Userinfo_ = M("User")->where('user_id=' . intval($user_id))->find();
	    if ($Userinfo_) {//查找用户信息
		$userlevel_ = M("userlevel")->where("level_learntime<='" . $Userinfo_['learntime'] . "'")->order("level_learntime desc")->find(); //查找当前用户等级学习时长倒序最近的一个等级
		if ($Userinfo_['level'] != $userlevel_['level_id']) {
		    M("User")->where('user_id=' . intval($user_id))->save(array('level' => $userlevel_['level_id'], 'score' => $Userinfo_['score'] + $userlevel_['level_score']));
		    $info_score['user_id'] = $user_id;
		    $info_score['scroe_type'] = 1;
		    $info_score['score_score'] = $userlevel_['level_score'];
		    $info_score['score_addtime'] = SYS_TIME;
		    $info_score['score_remarks'] = "会员" . $user_id . "提升等级" . $userlevel_['level_name'] . "奖励学分" . $userlevel_['level_score'] . "于" . date("Y-m-d H:i:s");
		    if ($Userinfo_['learntime'] != 0) {
			M("scoreinfo")->add($info_score);
		    }
		}
	    }
	}
    }

    //空方法，防止报错
    public function _empty() {
	echo "非法操作！！！";
	exit();
    }

    //默认首页
    public function index() {
	$user_id = session("user_id"); //会员登录user_id
	//2 判断系统是有倒计时（结束时间是否大于系统时间）
	$time_info_ = M("course")->where('course_limittime>' . SYS_TIME)->fetchsql(false)->limit(1)->select();
	if ($time_info_) { //倒计时开启
	    foreach ($time_info_ as $k => $v) {
		$time_info_[$k]['course_limittime'] = date("Y/m/d H:i:s", $v['course_limittime']);
	    }
	    $this->assign('time_info_', $time_info_); 
	}
	//3 判断系统是否开启直播；客户需求首页去掉该项 时间: 2017.11.04 10:38
	/*	
	$live_info = M("liveinfo")->where('live_flag=2')->find();
	if ($live_info) { //直播开启
	    if ((strtotime($live_info['live_time'] . ":00") - SYS_TIME) > 0) { //可以预约
		$live_info['flag'] = 1;
	    } else {
		$live_info['flag'] = 2;
	    }

	    $this->assign('live_info', $live_info);
	}
	*/
	//4 判断系统是否开启海报；
	$focus_info_ = M("focusinfo")->where('focus_type=2')->order("focus_sort desc")->find();
	if ($focus_info_) { //海报开启
	    $this->assign('focus_info_', $focus_info_);
	}
	//显示会员信息
	$user_info = M("user")
		->where('ec_user.user_id=' . intval($user_id))
		->join('left join ec_userlevel on ec_userlevel.level_id = ec_user.level')
		->join('left join ec_viplevel on ec_viplevel.vip_id = ec_user.vip')
		->field('ec_user.*,ec_userlevel.level_name,ec_userlevel.level_image,ec_viplevel.vip_image')
		->find();
	 
	$this->assign('user_info', $user_info);
	//轮播图信息
	$focus_info = M("focusinfo")->where('focus_type=1')->order('focus_sort desc')->limit(4)->select();
	$this->assign('focus_info', $focus_info);
	//课程信息免费专题
	$course_info_ = M("course")
		->where('ec_course.course_isable=1 and ec_classify.classify_id=2')
		->join('left join ec_classify on ec_classify.classify_id = ec_course.classify_id')
		->field('ec_course.*')
		->limit(3)
		->select();
	//修改
	foreach ($course_info_ as $k=>$v){
	    $lesson_view = M("lesson")->where("course_id='".$v['course_id']."' ")->order("lesson_id asc")->field("lesson_view")->find();
	    $course_info_[$k]["lesson_view"]=$lesson_view;
	} 
	 
	$this->assign('course_info_', $course_info_);
	//课程信息
	$course_info = M("course")->where('course_isable=1 and classify_id=1 ')->order("course_sort desc")->limit(1, 12)->select();
	foreach ($course_info as $k => $v) {
	    if ($course_info[$k]['course_limittime'] > SYS_TIME) {
		$course_info[$k]['course_money'] = $v['course_limit'];
	    }
	}

	$this->assign('course_info', $course_info);
	//精彩专题　限时免费第一个跳转vip
	$course_info_time = M("course")->where('course_isable=1 and classify_id=1 ')->order("course_sort desc")->limit(1)->select();
	 
	if ($course_info_time[0]['course_limittime'] > SYS_TIME) {
	    $course_info_time[0]['course_money'] = $course_info_time[0]['course_limit'];
	}
	$countnum =  sizeof($course_info_time); //修改
	$this->assign('course_info_time', $course_info_time);
	//签到状态
	$t = time();
	//开始时间戳
	$start = mktime(0, 0, 0, date("m", $t), date("d", $t), date("Y", $t));
	//结束时间戳
	$end = mktime(23, 59, 59, date("m", $t), date("d", $t), date("Y", $t));
	//判断是否签到
	$where = " 1 and score_addtime >='" . $start . "' and score_addtime <='" . $end . "' and user_id='" . session("user_id") . "' ";
	$counts = M('scoreinfo')->where($where)->count();
	$this->assign('counts', $counts);
	$this->assign('countnum', $countnum);//修改
	$this->display();
    }

    //预约直播
    public function liveorder() {
	$user_id = session("user_id"); //会员登录user_id
	if ($user_id == "") {
	    jump('参数有误！', U('index/index'));
	}
	$live_id = I('get.live_id');
	$info_live['user_id'] = $user_id;
	$info_live['live_id'] = $live_id;
	$info_live['order_addtime'] = SYS_TIME;
	$flag = M("liveorder")->where("user_id='" . $user_id . "' and live_id='" . $live_id . "' ")->find();
	if ($flag) {
	    echo "noon";
	} else {
	    M('liveorder')->add($info_live);
	    M("liveinfo")->where('live_flag=2')->setInc('live_num', 1);
	    echo "ook";
	}
	exit();
    }

    //关注简异思维公众号
    public function attention() {
	$this->display();
    }

}
