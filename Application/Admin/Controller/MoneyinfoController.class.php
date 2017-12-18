<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/30 0030
 * Time: 上午 9:50
 */
namespace Admin\Controller;
use Think\Controller;
class MoneyinfoController extends Controller{

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


    public function index(){

        $where = "1 ";
        $info = I("info");
        if($info){
            @extract($info);
            if($keyword){
                $info['keyword']=urldecode(trim($info['keyword']));
                $where.=" and  a.nickname like '%".$info['keyword']."%' or a.phone like  '%".$info['keyword']."%'";$this->assign("keyword",$info['keyword']);}
            if($money_type){
                $info['money_type']=urldecode(trim($info['money_type']));
                $where.= "and money_type ='".$info['money_type']."'";$this->assign("money_type",$info['money_type']);}
            if($starttime){$this->assign("starttime",$starttime);}
            if($endtime){$this->assign("endtime",$endtime);}
        }
        if(!$starttime){
            $starttime = date("Y-m-d",strtotime("-60 day"));$this->assign("starttime",$starttime);
        }
        if (!$endtime){
            $endtime = date("Y-m-d",SYS_TIME);$this->assign("endtime",$endtime);
        }

        $where.= " and ec_moneyinfo.money_addtime>=".strtotime($starttime."00:00:00")." ";
        $where.= " and ec_moneyinfo.money_addtime<=".strtotime($endtime."23:59:59")." ";
        //查询满足要求的总记录数
        $count = M("moneyinfo")
            ->where($where)
            ->join(" left join ec_user as a ON a.user_id = ec_moneyinfo.user_id")
            ->count();
        $Page = new\Think\Page($count,15);
        //分页跳转的时候保证查询条件
        if($info){
            foreach ($info as $key=>$v){
                $Page->parameter['info['.$key.']'] = urlencode($v);
            }
        }
        $Pageshow = $Page->adminshow();
        //进行分页数据查询
        $listinfo = M("moneyinfo")
            ->where($where)
            ->join(" left join ec_user as a ON a.user_id = ec_moneyinfo.user_id")
            ->limit($Page->firstRow.",".$Page->listRows)
            ->order(" ec_moneyinfo.money_id desc")
            ->select();
        $this->assign("Pageshow",$Pageshow);
        $this->assign('moneytype',D('moneyinfo')->moneytype());
        $this->assign("listinfo",$listinfo);
        $this->display();
    }


    public function delmoneyinfo(){

        $money_id = I("get.money_id");
        M("moneyinfo")->where("money_id=".$money_id)->delete();
        $this->success("删除成功",U("moneyinfo/index"));
    }

}