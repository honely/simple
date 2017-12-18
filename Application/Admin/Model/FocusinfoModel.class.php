<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/28 0028
 * Time: 下午 2:20
 */
namespace Admin\Model;
use Think\Model;

class FocusinfoModel extends Model {

    //轮播类型
    public function focus_type(){
        return array(
            '1'=>'首页轮播',
            '2'=>'宣传海报',
			'3'=>'问答轮播',
			'4'=>'专题列表轮播',
        );
    }
    //排序
    public function focus_sort(){
        return array(
            '1'=>'1',
            '2'=>'2',
            '3'=>'3',
            '4'=>'4',
            '5'=>'5',
            '6'=>'6',
            '7'=>'7',
            '8'=>'8',
            '9'=>'9',
            '10'=>'10',
        );
    }

    //审核状态，，1未审核，2已审核'
    public function commentFlag(){
        return array(
            '1'=>'未审核',
            '2'=>'已审核',
        );
    }

    //获取VIP等级
    public function  VipLevel(){
        $qatypelist=M("viplevel")->select();
        $return=array();
        foreach ($qatypelist as $key=>$value){
            $return[$value['vip_id']]=$value["vip_name"];
        }
		$return[0]="非vip会员";
        return  $return;
    }

    //获取用户等级
    public function  userLevel(){
        $qatypelist=M("userlevel")->select();
        $return=array();
        foreach ($qatypelist as $key=>$value){
            $return[$value['level_id']]=$value["level_name"];
        }
        return  $return;
    }

    //获取课程分类
    public function  courseClass(){
        $qatypelist=M("classify")->select();
        $return=array();
        foreach ($qatypelist as $key=>$value){
            $return[$value['classify_id']]=$value["classify_name"];
        }
        return  $return;
    }
    //lessonName
    public function  lessonName(){
        $qatypelist=M("lesson")->select();
        $return=array();
        foreach ($qatypelist as $key=>$value){
            $return[$value['lesson_id']]=$value["lesson_name"];
        }
        return  $return;
    }
    //研习班状态  是否售罄
    public function workType(){
        //研习班状态，1正常，2售罄',
        return array(
            '1'=>'正常',
            '2'=>'售罄',
        );
    }

    //课程购买明细支付方式，1微信，2余额'
    public function payType(){
        return array(
            '1'=>'微信',
            '2'=>'余额',
        );
    }
    //课程购买明细支付状态，1未支付，2已支付
    public function payFlag(){
        return array(
            '1'=>'未支付',
            '2'=>'已支付',
        );
    }
}