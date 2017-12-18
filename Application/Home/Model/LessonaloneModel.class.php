<?php

/*
 * 张伟松
 * 
 * 单独课程模型
 * 
 * 2017年9月16日16:37:50
 */

namespace Home\Model;

use Think\Model;

class LessonaloneModel extends Model {

	//判断用户是否有权限访问当前课程
    public function user_auth_lesson($lesson_id) {
        $user_id = session('user_id');
        $user = M("user")->find($user_id);
		if($user['vip']){
			return true;
		}else{
			//是否购买课程
			if (M("buyinfoalone")->where("user_id=" . $user_id . " AND lesson_id=" . $lesson_id . " AND buy_flag=2 AND buy_endtime>" . time())->count()) {
				return TRUE;
			} else {
				//判断是否课程0元
				if ($this->where("lesson_id=" . $lesson_id . " and lesson_money<=0")->count()) {
					return TRUE;
				}else{
					return FALSE;
				}
			}
		}
    }

    //浏览量+1
    function lll($current_lesson_id) {
        M("Lessonalone")->where("lesson_id=" . $current_lesson_id)->setInc("lesson_view");
    }
}
