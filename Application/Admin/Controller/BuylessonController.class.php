<?php
/**
 * Created by PhpStorm.
 * User: DangMeng
 * Date: 2017/11/27 0027
 * Time: 上午 10:22
 */
namespace Admin\Controller;
use Think\Controller;
class BuylessonController extends Controller {

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

    //课程购买明细
    public function index(){
        $where="1 ";
        $info=I("info");
        if ($info){
            @extract($info);
            if($nickname){
                $info['nickname']=urldecode(trim($info['nickname']));
                $where.="and (ec_user.nickname like '%".$info['nickname']."%')";
                $this->assign('nickname',$info['nickname']);
            }
            if($buy_type){
                $info['buy_type']=urldecode(trim($info['buy_type']));
                $where.="and ec_buyinfoalone.buy_type ='".$info['buy_type']."'";
                $this->assign('buy_type',$info['buy_type']);
            }
            if($buy_flag){
                $info['buy_flag']=urldecode(trim($info['buy_flag']));
                $where.="and ec_buyinfoalone.buy_flag ='".$info['buy_flag']."'";
                $this->assign('buy_flag',$info['buy_flag']);
            }
            if($starttime){
                $info['starttime']=urldecode(trim($info['starttime']));
                $where.=" and ec_buyinfoalone.buy_addtime >=".strtotime($info['starttime']."00:00:00")." ";
                $this->assign('starttime',$info['starttime']);
            }
            if($endtime){
                $info['endtime']=urldecode(trim($info['endtime']));
                $where.=" and ec_buyinfoalone.buy_addtime <=".strtotime($info['endtime']."23:59:59")." ";
                $this->assign('endtime',$info['endtime']);
            }
        }
        $buylesson=M('buyinfoalone');
        // 查询满足要求的总记录数
        $count      = $buylesson
                    ->join('left join ec_user on ec_user.user_id = ec_buyinfoalone.user_id')
                    ->join('left join ec_lessonalone on ec_lessonalone.lesson_id = ec_buyinfoalone.lesson_id')
                    ->field('ec_buyinfoalone.*,ec_lessonalone.lesson_name,ec_user.nickname,ec_user.realname')
                    ->where($where)
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
        $buyinfo = $buylesson
            ->where($where)
            ->join('left join ec_user on ec_user.user_id = ec_buyinfoalone.user_id')
            ->join('left join ec_lessonalone on ec_lessonalone.lesson_id = ec_buyinfoalone.lesson_id')
            //->order('')
                ->field('ec_buyinfoalone.*,ec_lessonalone.lesson_name,ec_user.nickname,ec_user.realname')
            ->limit($Page->firstRow.','.$Page->listRows)
            ->order('ec_buyinfoalone.buy_id desc')
            ->select();
       // dump($buyinfo);
        $this->assign('buyInfo',$buyinfo);
        $this->assign('pageshow',$pageshow);
        $this->assign('buyType',D('Focusinfo')->payType());
        $this->assign('buyFlag',D('Focusinfo')->payFlag());
        $this->display();
    }
}