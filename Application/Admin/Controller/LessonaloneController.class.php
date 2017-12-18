<?php

namespace Admin\Controller;

use Think\Controller;

class LessonaloneController extends Controller {

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
		$where=" lesson_isable=1 ";	
		$info=I("info");
		if ($info){
			@extract($info);
			if($lesson_name){
				$info['lesson_name']=urldecode(trim($info['lesson_name']));
                $where.="and (lesson_name like '%".$info['lesson_name']."%' )";  
                $this->assign('lesson_name',urldecode($info['lesson_name']));
			}
			if ($lesson_ishot) {
                $where.= " and lesson_ishot=" . $lesson_ishot;
                $this->assign('lesson_ishot', $lesson_ishot);
            }

			
		}
	
		$lesson=M('Lessonalone');
		// 查询满足要求的总记录数
		$count      = $lesson
					->where($where)
					->count();
		$Page       = new \Think\Page($count,15);
		//分页跳转的时候保证查询条件
		if($info){
			foreach($info as $key=>$val) {
				$Page->parameter['info['.$key.']']   =   urlencode($val);
			}
		}
		$pageshow   = $Page->adminshow();
		// 进行分页数据查询
		$listinfo = $lesson
					->where($where)
					->order('lesson_id desc')
					->limit($Page->firstRow.','.$Page->listRows)
					->select();
			
		$this->assign('listinfo',$listinfo);
		$this->assign('is_course_hot', D("course")->course_hot()); //是否热播
		$this->assign('course_id',$course_id);
		$this->assign('pageshow',$pageshow);
		$this->display();
    }

    //添加课程
    public function addlesson() {
      	if (IS_POST){
			$info=I("info");
			$info['lesson_view']=0;
			$info['lesson_play']=0;
			$info['lesson_buy']=0;
			$info['lesson_addtime']=SYS_TIME;	
			$flag=M("Lessonalone")->add($info);
			$this->success('添加课程成功！',U('Lessonalone/index'),3);	
		}else{
			$this->display();
		}
    }

    //编辑课程
    public function editlesson() {
		$lesson_id=I("get.lesson_id");
		if (IS_POST){
			$info=I("info");
			$flag=M("Lessonalone")->where("lesson_id=".$lesson_id)->save($info);
		
			$this->success('编辑课程成功！',U('Lessonalone/index'),3);			
		}else{
			$lesson=M("Lessonalone")->where("lesson_id=".$lesson_id)->find();
			$this->assign('lesson_image', explode("|", $lesson['lesson_image']));
			$this->assign('lesson',$lesson);
			$this->display();
		}
    }

    //删除课程
    public function dellesson() {
        $lesson_id = abs(I("get.lesson_id"));
		$flag=M('Lessonalone')->where("lesson_id=".$lesson_id)->save(array('lesson_isable'=>0));
        $this->success('课程删除成功！', U('Lessonalone/index'), 3);
       
    }
	//获取课程排名_暂时不用
	public function  lessoncode($course_id){
		$lesson_=M('Lessonalone')->where("course_id='".$course_id."' and  lesson_isable=1")->order("lesson_id asc")->select();
		foreach($lesson_ as  $k=>$v){
			M('Lessonalone')->where("lesson_id=".$v['lesson_id'])->save(array('lesson_code'=>$k+1));  
		}
		
	}
	
   
}
