<?php
namespace  Admin\Controller;
use Think\Controller;
class BuxiyanfaController extends Controller
{
    function __construct() {
        //继承父类
        parent::__construct();
    
    
        //判断登录状态
        if(!D('admininfo')->islogin()){//未登录
            $this->error('您尚未登录，请先登录！',U('login/login'),3);
        }
    
    }
    
    //空方法，防止报错
    public function _empty(){
        $this->index();
    }
    //研发班报名
    public function buxiyanfa(){
        $where ='1 ';
        $info = I("info");
        if($info){
            @extract($info);
            //按姓名手机号
            if($status && $status==1){
                $wordID=$_GET['work_id'];
                $where.=' and ec_signinfo.work_id ='.$wordID;
                $this->assign('wordTitle',$wordTitle);
                $this->assign('state',1);
            }
            if($keyword){
                $info['keyword']=urldecode(trim($info['keyword']));
                $where.=" and (ec_signinfo.fullname like '%".$info['keyword']."%' or ec_signinfo.phone like '%".$info['keyword']."%' or ec_user.phone like '%".$info['keyword']."%' or ec_user.nickname like '%".$info['keyword']."%' or ec_workinfo.work_title like '%".$info['keyword']."%')";
                $this->assign('keyword',$info['keyword']);
            }
			 //按支付状态
            if($pay_flag){
                $info['pay_flag']=urldecode(trim($info['pay_flag']));
                $where.=" and (ec_signinfo.pay_flag =".$info['pay_flag'].") ";
                $this->assign('pay_flag_',urldecode($info['pay_flag']));
            }
            //按时间查询
            if($starttime){
                $info['starttime']=urldecode(trim($info['starttime']));
                $where.=" and (ec_signinfo.sign_addtime >=".strtotime($info['starttime'].'00:00:00' ).") ";
                $this->assign('starttime',urldecode($info['starttime']));
            }
            if($endtime){
                $info['endtime']=urldecode(trim($info['endtime']));
                //$where.=" and ec_signinfo.sign_addtime  <= ".urldecode(strtotime($info['endtime']))." ";

                $where.=" and (ec_signinfo.sign_addtime <=".strtotime($info['endtime'].'23:59:59' ).") ";
                $this->assign('endtime',urldecode($info['endtime']));
            }
        }else{
            $starttime = date("Y-m-d",strtotime("-60 day"));
            $where.=" and (ec_signinfo.sign_addtime >=".strtotime($starttime.'00:00:00' ).") ";
            $this->assign("starttime",$starttime);
            $endtime=date('Y-m-d');
            $where.=" and (ec_signinfo.sign_addtime <=".strtotime($endtime.'23:59:59' ).") ";
            $this->assign("endtime",$endtime);
        }
        if($_GET['work_id']){
            $wordID=$_GET['work_id'];
            $wordTitle=$_GET['work_title'];
            $where.=' and ec_signinfo.work_id ='.$wordID;
            $this->assign('wordTitle',$wordTitle);
            $this->assign('workId',$wordID);
            $this->assign('state',1);
        }
        $count = M('signinfo')
            ->where($where)
            ->join("left join ec_user ON ec_user.user_id = ec_signinfo.user_id")
            ->join("left join ec_workinfo ON ec_workinfo.work_id = ec_signinfo.work_id")
            ->field("ec_signinfo.*,ec_user.nickname,ec_user.phone as mobile,ec_workinfo.work_title,ec_workinfo.work_id")
            ->count();
        $Page = new \Think\Page($count,15);
        //分页跳转的时候保证查询条件
        if($info){
            foreach($info as $key=>$val) {
                $Page->parameter['info['.$key.']'] = urlencode($val);
            }
        }
        $pageshow = $Page->adminshow();
        // 进行分页数据查询
        $infolist = M('signinfo')
            ->where($where)
            ->join("left join ec_user ON ec_user.user_id = ec_signinfo.user_id")
            ->join("left join ec_workinfo ON ec_workinfo.work_id = ec_signinfo.work_id")
            ->field("ec_signinfo.*,ec_user.nickname,ec_user.phone as mobile,ec_workinfo.work_title")
            ->order('sign_id desc')
            ->limit($Page->firstRow.','.$Page->listRows)
            ->select();
        $this->assign('infolist',$infolist);
        $this->assign('count',$count);
        $this->assign('isself',D('Buyinfo')->isself());
		$this->assign('pay_flag',D('Buyinfo')->pay_flag());//研习班报名表支付状态，1未支付，2已支付
		$this->assign('pay_type',D('Buyinfo')->pay_type());//研习班报名表支付方式，1微信，2余额
        $this->assign('content','暂无条件查询结果！');
        $this->assign('pageshow',$pageshow);
        $this->display();
    }
    //详情
    public function yanfaxq(){
        $sign_id = I("get.sign_id");
        $data = M("signinfo")
            ->where('sign_id='.$sign_id)
    		->join("left join ec_workinfo ON ec_workinfo.work_id = ec_signinfo.work_id")
            ->find();
		$infolist = M("signlist")
            ->where('sign_id='.$sign_id)
    		->join("left join ec_seatinfo ON ec_seatinfo.seat_id = ec_signlist.seat_id")
			->field("ec_signlist.*,ec_seatinfo.seat_name")
            ->select();	
        $this->assign('data',$data);
		$this->assign('infolist',$infolist);
		$this->assign('pay_flag',D('Buyinfo')->pay_flag());//研习班报名表支付状态，1未支付，2已支付
		$this->assign('pay_type',D('Buyinfo')->pay_type());//研习班报名表支付方式，1微信，2余额
        $this->display();

    }
    //删除
    public function delet(){
        $sign_id = I("get.sign_id");
        $arr = M("signinfo")->where('sign_id='.$sign_id)->find();
        $work_id = $arr['work_id'];
        if(M("signinfo")->delete($sign_id)){
			M("signlist")->where('sign_id='.$sign_id)->delete();//删除报名席位ec_signlist
            $reslut = M("workinfo")
                    ->where('work_id='.$work_id)
                    ->setDec('work_num',1);
            $this->success("删除成功",U("buxiyanfa/buxiyanfa"),3);die;
        }else{
            $this->error("删除失败");
        }
         
    }

    
}