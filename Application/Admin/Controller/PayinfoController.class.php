<?php
namespace Admin\Controller;

use Think\Controller;

class PayinfoController extends Controller{
    
    public function payoper() {  
    $where="1 ";
        $info=I("info");
        if ($info){
            @extract($info);
            if($focus_title){
                $info['focus_title']=urldecode(trim($info['focus_title']));
                $where.="and (ec_user.nickname like '%".$info['focus_title']."%' or ec_user.phone like '%".$info['focus_title']."%' or ec_payinfo.pay_no like '%".$info['focus_title']."%' )";
                $this->assign('focus_title',$info['focus_title']);
            }
            if($pay_type){
                $info['pay_type']=urldecode(trim($info['pay_type']));
                $where.="and pay_type ='".$info['pay_type']."'";
                $this->assign('pay_type',$info['pay_type']);
            }
            if($pay_flag){
                $info['pay_flag']=urldecode(trim($info['pay_flag']));
                $where.="and pay_flag ='".$info['pay_flag']."'";
                $this->assign('pay_flag',$info['pay_flag']);
            }
            //按时间查询
            if($starttime){
                $this->assign("starttime",$starttime);
            }
            if($endtime){
                $this->assign("endtime",$endtime);
            }
            }
            if(!$starttime){
                $starttime = date("Y-m-d",strtotime("-60 day"));$this->assign("starttime",$starttime);
            }
            if(!$endtime){
                $endtime = date("Y-m-d",SYS_TIME);$this->assign("endtime",$endtime);
            }
            $where.= " and ec_payinfo.pay_addtime>=".strtotime($starttime."00:00:00")." ";
            $where.= " and ec_payinfo.pay_addtime<=".strtotime($endtime."23:59:59")." ";
        $payinfo=M('payinfo');
        $count=$payinfo->where($where)
                        ->join('left join ec_user on ec_payinfo.user_id = ec_user.user_id')
                        ->count();
        $Page=new \Think\Page($count,15);
        //分页跳转的时候保证查询条件
         if($info){
            foreach($info as $key=>$val) {
                $Page->parameter['info['.$key.']'] = urlencode($val);
            }
        }
        $pageshow= $Page->adminshow();
        $arr=$payinfo->where($where)
                     ->join('left join ec_user on ec_payinfo.user_id = ec_user.user_id')
                     ->limit($Page->firstRow.','.$Page->listRows)
                     ->order('ec_payinfo.pay_id desc')
                     ->select(); 
        $this->assign('pageshow',$pageshow);
        $this->assign('paytype',D('Payinfo')->paytype());
        $this->assign('payflag',D('Payinfo')->payflag());
        $this->assign('arr',$arr);
        $this->display();
        
    }
    
}

























