<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/16 0016
 * Time: 上午 9:36
 */
namespace Admin\Model;
use Think\Model;

class SeatinfoModel extends Model
{
    //根据研习班的ID获取研习班的名称
    public function getWorkNameById($seatId)
    {
        $seatData=M('workinfo')->field('work_id,work_title')->where('work_id= ' . $seatId)->select();
        foreach ($seatData as $item){
            $result=$item['work_title'];
        }
        return $result;

    }
}