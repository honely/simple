<?php

namespace Admin\Controller;

use Think\Controller;

/*
 * 课程内容控制器
 * 张伟松
 * 2017年8月28日16:42:37
 */

class CourseController extends Controller {

    function __construct() {
        //继承父类
        parent::__construct();

        //判断登录状态
        if (!D('admininfo')->islogin()) { //未登录
            $this->error('您尚未登录，请先登录！', U('login/login'), 3);
        }
    }

    //空方法，防止报错
    public function _empty() {
        $this->index();
    }

    //课程视频列表
    public function index() {
        $where = "ec_course.course_isable=1 ";
        $info = I("info");
        //搜索 
        #1 课程名
        #2 分类
        #3 主讲老师
        #4 是否推荐
        if ($info) {
            @extract($info);
            if ($course_name) {
                $where .= " and ec_course.course_name like '%".urldecode(trim($info['course_name']))."%'";
                $this->assign('course_name', $course_name);
            }
            if ($classify_id) {
                $where .= " and ec_course.classify_id=" . $classify_id;
                $this->assign('classify_id', $classify_id);   
            }
            if ($course_speaker) {
                $where .= " and ec_course.course_speaker like '%$course_speaker%'";
                $this->assign('course_speaker', $course_speaker);
            }
            if ($course_hot) {
                $where .= " and ec_course.course_hot=" . $course_hot;
                $this->assign('course_hot', $course_hot);
            }
			if ($course_groom) {
                $where .= " and ec_course.course_groom=" . $course_groom;
                $this->assign('course_groom', $course_groom);
            }
        }

        // 查询满足要求的总记录数
        $count = M('course')
                ->join("LEFT JOIN ec_classify ON ec_classify.classify_id=ec_course.classify_id") 
                ->where($where)
                ->count();
        $Page = new \Think\Page($count, 20);
        //分页跳转的时候保证查询条件
        if ($info) {
            foreach ($info as $key => $val) {
                $Page->parameter['info[' . $key . ']'] = urlencode($val);
            }
        }
        $pageshow = $Page->adminshow();
        // 进行分页数据查询
        #视频课程列表
        $listinfo = M('course')
                //分类名称、 专题名称
                ->field("ec_course.*,ec_classify.classify_name,ec_classify.classify_id")
                ->join("LEFT JOIN ec_classify ON ec_classify.classify_id=ec_course.classify_id") 
                ->where($where)
                ->order('course_id desc')
                ->limit($Page->firstRow . ',' . $Page->listRows)
                ->select();
        $this->assign('listinfo', $listinfo);
        $this->assign('pageshow', $pageshow);
        $this->assign('is_course_hot', D("course")->course_hot()); //是否热播
		$this->assign('is_course_groom', D("course")->course_groom()); //是否推荐
        $this->assign('classifies', D("classify")->select()); //大分类  
        $this->display(); 
    }

    //添加课程专题
    public function addcourse() {
        if (IS_POST) {
            $data = I("info");
           
        
            if (!is_numeric($data['course_sort'])) {
                $this->error(' 排序只能是数字！', U('course/addcourse'), 3);
            }
            if (!is_numeric($data['course_allparts'])) {
                $this->error(' 总集数只能是数字！', U('course/addcourse'), 3);
            } 
            if (!is_float($data['course_money']) && !is_numeric($data['course_money'])) {
                $this->error(' 年费只能是数字或小数！', U('course/addcourse'), 3);
            }
            if (!is_float($data['course_limit']) && !is_numeric($data['course_limit'])) {
                $this->error(' 抢购价只能是数字或小数！', U('course/addcourse'), 3);
            }  
            $data['course_limittime'] = strtotime($data['course_limittime']);//抢购截止时间
            $data['course_addtime'] = time();//添加时间
            $data['course_retime'] = time();//更新时间
            $flag = M("course")->add($data); 
            if ($flag) {
                $this->success('添加课程专题成功！', U('course/index'), 3);
            } else {
                $this->error('添加课程专题失败！', U('course/index'), 3);
            }
        } else {
            $this->assign('classifies', D("classify")->select()); //大分类 
            $this->display();
        }
    }

    //编辑课程专题
    public function editcourse() {
        $id = I("get.id");
        if (IS_POST) { 
            $data = I("info");
        
            if (!is_numeric($data['course_sort'])) {
                $this->error(' 排序只能是数字！', U('course/addcourse'), 3);
            }
            if (!is_numeric($data['course_allparts'])) {
                $this->error(' 总集数只能是数字！', U('course/addcourse'), 3);
            } 
            if (!is_float($data['course_money']) && !is_numeric($data['course_money'])) {
                $this->error(' 年费只能是数字或小数！', U('course/addcourse'), 3);
            } 
            if (!is_float($data['course_limit']) && !is_numeric($data['course_limit'])) {
                $this->error(' 抢购价只能是数字或小数！', U('course/addcourse'), 3);
            }  
            $data['course_limittime'] = strtotime($data['course_limittime']);//抢购截止时间
            $data['course_retime'] = time();//更新时间
      
            M("course")->where("course_id=" . $id)->save($data);
            $this->success('编辑课程专题成功！', U('course/index'), 3);
        } else {
            $course = D("course")->find($id);
            //分集
           
            //course_images
            $this->assign('course_images', explode("|", $course['course_images']));
            $this->assign('course_ppt', explode("|", $course['course_ppt']));
            $this->assign('course', $course);

            $this->assign('classifies', D("classify")->select()); //大分类 
            $this->display(); 
        }
    }

    //删除文章
    public function delcourse() {
        $id = I("get.id");
		
        if (M('course')->where("course_id=".$id)->save(array("course_isable"=>0))) {
            $this->success('课程专题删除成功！', U('course/index'), 3);
        } else {
            $this->error('课程专题删除失败！', U('course/index'), 3);
        }
    }
	
    //发送模板消息
	public function sendtplmsg(){
		set_time_limit(0);
		$id=I("get.id");
		$courseinfo=M("course")->where("course_id=".$id." and course_isable=1")->find();
		//最新课程
		$lessoninfo=M("lesson")->where("course_id=".$id." and lesson_isable=1")->order('lesson_id desc')->find();
		$courseinfo['course_money']=$courseinfo['course_limittime']>SYS_TIME?$courseinfo['course_limit']:$courseinfo['course_money'];
		//获取需要发送的用户信息
		$user=array();
		$vip_userinfo=M("User")->where("vip!=0 and openid!=''")->field("user_id")->select();//所有vip用户
		foreach($vip_userinfo as $v){
			$user[]=$v['user_id'];
		}
		$buy_userinfo=M("Buyinfo")->where("course_id=".$id." and buy_endtime>".SYS_TIME)->field("user_id")->select();//所有购买专题的用户
		foreach($buy_userinfo as $v){
			$user[]=$v['user_id'];
		}
		array_unique($user);
		if(sizeof($user)){
			$userinfo=M("User")->where("user_id in(".join(",",$user).") and openid!=''")->field("user_id,openid")->select();
			$data=array();
			foreach($userinfo as $v){
				$info=array(
					'touser'=>$v['openid'],
					'template_id'=>'DUohOwP9633l9ilk84C_eTrIhZfkiD2rSFoNVzHDcaE',
					'url'=>C("WEB_URL")."index.php?c=course&a=video&course_id=".$id,
					'data'=>array(
							'course_name'=>array('value'=>$courseinfo['course_name'],'color'=>'#FF0000'),
							'course_money'=>array('value'=>$courseinfo['course_money'],'color'=>'#173177'),
							'course_parts'=>array('value'=>$courseinfo['course_parts']."/".$courseinfo['course_allparts']."集",'color'=>'#173177'),
							'course_retime'=>array('value'=>date("Y-m-d H:i",$courseinfo['course_retime']),'color'=>'#173177'),
							'course_lesson'=>array('value'=>$lessoninfo['lesson_name'],'color'=>'#173177'),
					      ),
				);
				$data[]=json_encode($info);
				//dump($data);die;
				unset($info);
			}
			sendtemplate($data);
		}
		$this->success('发送模板消息成功！',U('course/index'),3);
	}
}
