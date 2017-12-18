<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/4 0004
 * Time: 上午 9:39
 */
namespace Admin\Model;
use Think\Model;
class ScoreinfoModel extends Model{

    public function scroe_type(){
        return array(
            '1' => '学习',
            '2' => '签到',
			'3' => '其他',
        );
    }
}