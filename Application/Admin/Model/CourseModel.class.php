<?php

namespace Admin\Model;

use Think\Model;

/*
 * 课程模型
 */

class CourseModel extends Model {

    //'是否推荐，1非热播，2热播',
    public function course_hot() {
        return array(
            1 => '非热播',
            2 => '热播',
        );
    }

	//'是否推荐，1非推荐，2推荐',
    public function course_groom() {
        return array(
            1 => '非推荐',
            2 => '推荐',
        );
    }

    //'是否删除，1正常，0删除',
    public function course_isable() {
        return array(
            0 => '删除',
            1 => '正常',
        );
    }

}
