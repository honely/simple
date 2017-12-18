<?php

namespace Admin\Controller;

use Think\Controller;

class LessonController extends Controller {

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
	    $course_id = abs(I("get.course_id"));
		if($course_id){
			 $where=" ec_lesson.course_id='".$course_id."' and ec_lesson.lesson_isable=1 ";
		}else{
			 $this->error('课程参数有误！', U('course/index'), 3);
		}
       
		$info=I("info");
		if ($info){
			@extract($info);
			if($lesson_name){
				$info['lesson_name']=urldecode(trim($info['lesson_name']));
                $where.="and (ec_lesson.lesson_name like '%".$info['lesson_name']."%' or ec_course.course_name like '%".$info['lesson_name']."%' )";  
                $this->assign('lesson_name',urldecode($info['lesson_name']));
			}
			if ($lesson_ishot) {
                $where.= " and ec_lesson.lesson_ishot=" . $lesson_ishot;
                $this->assign('lesson_ishot', $lesson_ishot);
            }

			
		}
	
		$lesson=M('lesson');
		// 查询满足要求的总记录数
		$count      = $lesson
					->where($where)
					->join("LEFT JOIN ec_course ON ec_course.course_id=ec_lesson.course_id") 
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
					->join("LEFT JOIN ec_course ON ec_course.course_id=ec_lesson.course_id") 
					->order('lesson_id desc')
					->limit($Page->firstRow.','.$Page->listRows)
					->field('ec_lesson.*,ec_course.course_name')
					->select();
			
		$this->assign('listinfo',$listinfo);
		$this->assign('is_course_hot', D("course")->course_hot()); //是否热播
		$this->assign('course_id',$course_id);
		$course_=M("course")->where("course_id=".$course_id)->find();
		$this->assign('course_name',$course_['course_name']);
		$this->assign('pageshow',$pageshow);
		$this->display();
    }

    //添加课程
    public function addlesson() {
		$course_id = abs(I("get.course_id"));
      	if (IS_POST){
			$info=I("info");
			$info['course_id']=$course_id;
			$info['lesson_view']=0;
			$info['lesson_play']=0;
			$info['lesson_addtime']=SYS_TIME;
			$flag=M("lesson")->add($info);
			if($flag){
				$this->lessoncode($course_id);
				//更新集数
				$lesson_num=M('lesson')->where("course_id='".$course_id."' and  lesson_isable=1" )->count();
				M('course')->where("course_id=".$course_id)->save(array('course_parts'=>$lesson_num));
				
				$this->success('添加课程成功！',U('lesson/index',array('course_id'=>$course_id)),3);
			}else{
				$this->error('添加课程失败！',U('lesson/index',array('course_id'=>$course_id)),3);
			}
		}else{
			$this->assign('course_id',$course_id);
			$this->display();
		}
    }

    //编辑课程
    public function editlesson() {
		$course_id = abs(I("get.course_id"));
		$lesson_id=I("get.lesson_id");
		if (IS_POST){
			$info=I("info");
			$flag=M("lesson")->where("lesson_id=".$lesson_id)->save($info);
			$this->lessoncode($course_id);
			//更新集数
			$lesson_num=M('lesson')->where("course_id='".$course_id."' and  lesson_isable=1" )->count();
			M('course')->where("course_id=".$course_id)->save(array('course_parts'=>$lesson_num));
			$this->success('编辑课程成功！',U('lesson/index',array('course_id'=>$course_id)),3);			
		}else{
			$lesson=M("lesson")->where("lesson_id=".$lesson_id)->find();
			$this->assign('lesson_image', explode("|", $lesson['lesson_image']));
			$this->assign('lesson',$lesson);
			$this->display();
		}
    }

    //删除课程
    public function dellesson() {
        $lesson_id = abs(I("get.lesson_id"));
		$course_id = abs(I("get.course_id"));
		$flag=M('lesson')->where("lesson_id=".$lesson_id)->save(array('lesson_isable'=>0));
		//更新集数
		$lesson_num=M('lesson')->where("course_id='".$course_id."' and  lesson_isable=1" )->count();
		M('course')->where("course_id=".$course_id)->save(array('course_parts'=>$lesson_num));
        if ($flag) {
			$this->lessoncode($course_id);
            $this->success('课程删除成功！', U('lesson/index',array('course_id'=>$course_id)), 3);
        } else {
            $this->error('课程删除失败！', U('lesson/index',array('course_id'=>$course_id)), 3);
        }
    }
	//获取课程排名
	public function  lessoncode($course_id){
		$lesson_=M('lesson')->where("course_id='".$course_id."' and  lesson_isable=1")->order("lesson_id asc")->select();
		foreach($lesson_ as  $k=>$v){
			M('lesson')->where("lesson_id=".$v['lesson_id'])->save(array('lesson_code'=>$k+1));  
		}
		
	}
	
   
}
