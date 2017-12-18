<?php
namespace Admin\Controller;
use Think\Controller;
class LearnlogController extends Controller {
	
	function __construct() {
	//继承父类
	parent::__construct();

	//判断登录状态
	if (!D('admininfo')->islogin()) {//未登录
	    $this->error('您尚未登录，请先登录！', U('login/login'), 3);
	}
    }

    //学习记录
    public function index(){
        $where = "1 ";
        $info = I('info');
        if($info) {
            @extract($info);
            //按姓名手机号
            if ($keyword) {
                $info['keyword'] = urldecode(trim($info['keyword']));
                $where .= " and (a.phone like '%" . $info['keyword'] . "%' or a.nickname like '%" . $info['keyword'] . "%' or b.course_name like '%" . $info['keyword'] . "%'  )";
                $this->assign('keyword', $info['keyword']);
            }
            if($vip){
                $info['vip']=urldecode(intval(trim($info['vip'])));
                $where.=" and a.vip = ".$info['vip'];
                $this->assign('vip',$info['vip']);
            }
            if($level){
                $info['level']=urldecode(trim($info['level']));
                $where.=" and a.level = ".$info['level'];
                $this->assign('level',$info['level']);
            }
            if($classify_id){
                $info['classify_id']=urldecode(trim($info['classify_id']));
                $where.=" and b.classify_id ='".$info['classify_id']."'";
                $this->assign('classify_id',$info['classify_id']);
            }
            //按时间查询
            if ($starttime) {
                $info['starttime'] = urldecode(trim($info['starttime']));
                $where .= " and (ec_learninfo.learn_addtime >=" . strtotime($info['starttime'] . '00:00:00') . ") ";
                $this->assign('starttime', urldecode($info['starttime']));
            }
            if ($endtime) {
                $info['endtime'] = urldecode(trim($info['endtime']));
                $where .= " and (ec_learninfo.learn_addtime <=" . strtotime($info['endtime'] . '23:59:59') . ") ";
                $this->assign('endtime', urldecode($info['endtime']));
            }
        }
        $count = M("learninfo")
            ->join(" left join ec_user as a ON a.user_id = ec_learninfo.user_id")
            ->join(" left join ec_course as b ON b.course_id = ec_learninfo.course_id")
            ->join(" left join ec_lesson as c ON c.lesson_id = ec_learninfo.lesson_id")
            ->field('c.lesson_name,b.classify_id,b.course_name,a.*')
            ->order("learn_id desc")
            ->where( $where )
            ->count();
        $Page = new\Think\Page($count,15);
        //分页跳转的时候保证查询条件
        if($info){
            foreach ($info as $key=>$v){
                $Page->parameter['info['.$key.']'] = urlencode($v);
            }
        }
        $Pageshow = $Page->adminshow();
        //进行分页数据查询
        $listinfo= M("learninfo")
            ->join(" left join ec_user as a ON a.user_id = ec_learninfo.user_id")
            ->join(" left join ec_course as b ON b.course_id = ec_learninfo.course_id")
            ->join(" left join ec_lesson as c ON c.lesson_id = ec_learninfo.lesson_id")
            ->field('c.lesson_name,b.classify_id,b.course_name,a.*,ec_learninfo.learn_addtime')
            ->order("learn_id desc")
            ->limit($Page->firstRow.','.$Page->listRows)
            ->where( $where )
            ->select();
        //dump($listinfo);
        $this->assign('userLevel',D("focusinfo")->userLevel());
        $this->assign('vipLevel',D("focusinfo")->VipLevel());
        $this->assign('courseClass',D("focusinfo")->courseClass());
        $this->assign("pageshow",$Pageshow);
        $this->assign("infolist",$listinfo);
        $this->display();
    }
}


