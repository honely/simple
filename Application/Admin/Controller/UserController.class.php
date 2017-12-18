<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/08/28 0028
 * Time: 14:26:25
 */

namespace Admin\Controller;
use Think\Controller;


class UserController extends Controller
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

    //学员列表
    public  function  index(){
        $where="1 ";
        $info=I("info");
        if ($info){
            @extract($info);
            if($keyword){
                $info['keyword']=urldecode(trim(str_replace("'","",$info['keyword'])));
                $where.=" and (ec_user.nickname like '%".$info['keyword']."%' or ec_user.phone like '%".$info['keyword']."%')";
                $this->assign('keyword',$info['keyword']);
            }
            if($starttime){
                $info['starttime']=urldecode(trim($info['starttime']));
                $where.=" and ec_user.addtime >=".strtotime($info['starttime']."00:00:00")." ";
                $this->assign('starttime',$info['starttime']);
            }
            if($endtime){
                $info['endtime']=urldecode(trim($info['endtime']));
                $where.=" and ec_user.addtime <=".strtotime($info['endtime']."23:59:59")." ";
                $this->assign('endtime',$info['endtime']);
            }
            if($vip_level){
                $info['vip_level']=urldecode(intval(trim($info['vip_level'])));
                $where.=" and ec_user.vip =".$info['vip_level']." ";
                $this->assign('vip_level',$info['vip_level']);
            }
            if($user_level){
                $info['user_level']=urldecode(trim($info['user_level']));
                $where.=" and ec_user.level =".$info['user_level']." ";
                $this->assign('user_level',$info['user_level']);
            }
        }
    /*   if (!$starttime){
            $starttime = date("Y-m-d",strtotime("-1 day"));
            $where.=" and ec_user.addtime >=".strtotime($starttime."00:00:00")." ";
            $this->assign("starttime",$starttime);
        }
        if (!$endtime){
            $endtime = date("Y-m-d",SYS_TIME);
            $where.=" and ec_user.addtime <=".strtotime($endtime."23:59:59")." ";
            $this->assign("endtime",$endtime);
        }*/
        $user=M('User');
        // 查询满足要求的总记录数
        $count      = $user->where($where)
            ->join("left join ec_userlevel on ec_userlevel.level_id=ec_user.level")
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
        $listinfo = $user
            ->where($where)
            ->join("left join ec_userlevel on ec_userlevel.level_id=ec_user.level")
            ->field("ec_user.*,ec_userlevel.level_name as levelname")
            ->order('ec_user.user_id desc')
            ->limit($Page->firstRow.','.$Page->listRows)
            ->select();
        foreach ($listinfo as $key=>$value){
            $listinfo[$key]['learntime']=$this->secsToStr($value['learntime']);
        }

        $this->assign('listinfo',$listinfo);
        //vip等级
        $this->assign('viplevel',D("User")->ger_viplevel());
        //用户等级
        $this->assign('userlevel',D("User")->ger_userlevel());
        $this->assign('pageshow',$pageshow);
        $this->display();
    }

    //查看详情
    public function xiangqing(){
        $user_id=I('get.user_id');
        $user=M("User")
            ->where("ec_user.user_id=".$user_id)
            ->join("left join ec_userlevel on ec_userlevel.level_id=ec_user.level")
            ->join("left join ec_user as user1 on user1.user_id=ec_user.refree_id")
            ->field("ec_user.*,ec_userlevel.level_name as levelname,user1.nickname as refreename")
            ->find();

        $user['learntime']=$this->secsToStr($user['learntime']);
        $this->assign('user',$user);
        //vip等级
        $this->assign('viplevel',D("User")->ger_viplevel());
        //用户等级
        $this->assign('userlevel',D("User")->ger_userlevel());
        //dump($user);
        $this->display();
    }
    //充值
    public function chongzhi(){
        $user_id=I('get.user_id');
        $status=1;
        if(IS_POST){
            $info=I("info");
            $info['user_id']=$user_id;
            $info['pay_type']=2;//2手动充值
            $info['pay_addtime']=SYS_TIME;
            $info['pay_flag']=2;//2 已支付
            $info['pay_no']="jy".SYS_TIME.rand(111,999);
            $flag=M("Payinfo")->add($info);
            $user=M("User")->where("user_id=".$user_id)->find();
            $money=$user['money']+$info['pay_money'];
            $flag1=M("User")->where("user_id=".$user_id)->save(array('money'=>$money));
            if($flag&&$flag1){
                $status=2;
            }
        }
        $user=M("User")->where("user_id=".$user_id)->find();
        $this->assign("user",$user);
        $this->assign('status',$status);
        $this->display();
    }
    //时间转化
    function secsToStr($secs) {
        if($secs>=86400){$days=floor($secs/86400);
            $secs=$secs%86400;
            $r=$days.'d ';
            //if($days<>1){$r.='s';}
            //if($secs>0){$r.=', ';}
        }
        if($secs>=3600){$hours=floor($secs/3600);
            $secs=$secs%3600;
            $r.=$hours.'h ';
            //if($hours<>1){$r.='s';}
            //if($secs>0){$r.=', ';}
        }
        if($secs>=60){$minutes=floor($secs/60);
            $secs=$secs%60;
            $r.=$minutes.'m ';
            // if($minutes<>1){$r.='s';}
            // if($secs>0){$r.=', ';}
        }
        $r.=$secs.'s ';
        //if($secs<>1){$r.='s';
        //}
        return $r;
    }
}