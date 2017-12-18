<?php
namespace Admin\Controller;
use Think\Controller;
class LearnController extends Controller {
	
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
                $where .= " and (a.phone like '%" . $info['keyword'] . "%' or a.nickname like '%" . $info['keyword'] . "%' or c.lesson_name like '%" . $info['keyword'] . "%')";
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
            //按时间查询
            if ($starttime) {
                $info['starttime'] = urldecode(trim($info['starttime']));
                $where .= " and (ec_learninfoalone.learn_addtime >=" . strtotime($info['starttime'] . '00:00:00') . ") ";
                $this->assign('starttime', urldecode($info['starttime']));
            }
            if ($endtime) {
                $info['endtime'] = urldecode(trim($info['endtime']));
                $where .= " and (ec_learninfoalone.learn_addtime <=" . strtotime($info['endtime'] . '23:59:59') . ") ";
                $this->assign('endtime', urldecode($info['endtime']));
            }
        }
        $count = M("learninfoalone")
            ->join(" left join ec_user as a ON a.user_id = ec_learninfoalone.user_id")
            ->join(" left join ec_lessonalone as c ON c.lesson_id = ec_learninfoalone.lesson_id")
            ->field('c.lesson_name,a.*')
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
        $listinfo= M("learninfoalone")
            ->join(" left join ec_user as a ON a.user_id = ec_learninfoalone.user_id")
            ->join(" left join ec_lessonalone as c ON c.lesson_id = ec_learninfoalone.lesson_id")
            ->field('c.lesson_name,a.*,ec_learninfoalone.learn_addtime')
            ->order("learn_id desc")
            ->limit($Page->firstRow.','.$Page->listRows)
            ->where( $where )
            ->select();
        $this->assign('userLevel',D("focusinfo")->userLevel());
        $this->assign('vipLevel',D("focusinfo")->VipLevel());
        $this->assign('courseClass',D("focusinfo")->courseClass());
        $this->assign("pageshow",$Pageshow);
        $this->assign("infolist",$listinfo);
        $this->display();
    }
}


