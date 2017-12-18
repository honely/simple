<?php

/*
 * 张伟松
 * 
 * 课程模型
 * 
 * 2017年9月16日16:37:50
 */

namespace Home\Model;

use Think\Model;

class CourseModel extends Model {

    //判断用户是否有权限访问当前课程
    public function user_auth($course_id) {
        $user_id = session('user_id');
        $user = M("user")->find($user_id);
        //判断课程是不是免费课程
        $course = $this->find($course_id);
        if ($course['classify_id'] == 2) {
            if ($user['vip']) {
                return TRUE;
            } else {
                return FALSE;
            }
        }

        //如果用户是vip 或者是否购买专题
        if ($user['vip'] || M("buyinfo")->where("user_id=" . $user_id . " AND course_id=" . $course_id . " AND buy_flag=2 AND buy_endtime>" . time())->count()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //浏览量+1
    function lll($current_lesson_id) {
        M("lesson")->where("lesson_id=" . $current_lesson_id)->setInc("lesson_view");
    }
	
   //根据courseid获取专题的订阅量
    public function  getCourseBuy(){
        $CourseBuy=M("course")->field('course_id,course_buy')->select();
        $return=array();
        foreach ($CourseBuy as $key=>$value){
            $return[$value['course_id']]=$value["course_buy"];
        }
        return  $return;
    }

}
