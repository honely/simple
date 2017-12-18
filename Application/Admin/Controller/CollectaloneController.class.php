<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/28 0028
 * Time: 下午 2:20
 */

namespace Admin\Controller;
use Think\Controller;
class CollectaloneController extends Controller{

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
                $where.=" and  a.nickname like '%".$info['keyword']."%' or a.phone like  '%".$info['keyword']."%'";$this->assign("keyword",$info['keyword']);
			}
			if($lesson_name){
                $info['lesson_name']=urldecode(trim($info['lesson_name']));
                $where.=" and  c.lesson_name like '%".$info['lesson_name']."%'";
				$this->assign("lesson_name",$info['lesson_name']);
			}	
            if($starttime){$this->assign("starttime",$starttime);}
            if($endtime){$this->assign("endtime",$endtime);}
        }
        if(!$starttime){
            $starttime = date("Y-m-d",strtotime("-60 day"));$this->assign("starttime",$starttime);
        }
        if (!$endtime){
            $endtime = date("Y-m-d",time());$this->assign("endtime",$endtime);
        }

        $where.= " and ec_collectalone.collect_addtime>=".strtotime($starttime."00:00:00")." ";
        $where.= " and ec_collectalone.collect_addtime<=".strtotime($endtime."23:59:59")." ";

        //查询满足要求的总记录数
        $count = M("collectalone")
	       	->join(" left join ec_user as a ON a.user_id = ec_collectalone.user_id")
            ->join(" left join ec_lessonalone as c ON c.lesson_id = ec_collectalone.lesson_id")
            ->where($where)
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
        $listinfo = M("collectalone")
            ->join(" left join ec_user as a ON a.user_id = ec_collectalone.user_id")
			->join(" left join ec_lessonalone as c ON c.lesson_id = ec_collectalone.lesson_id")
			->field("ec_collectalone.*,a.nickname as nickname ,a.phone as phone,c.lesson_name as lesson_name")
			->where($where)
            ->order(" ec_collectalone.collect_id desc")
            ->limit($Page->firstRow.",".$Page->listRows)
            ->select();
        $this->assign("Pageshow",$Pageshow);
        $this->assign("listinfo",$listinfo);
        $this->display();
    }

    public function delcollect(){
        $collect_id = I("get.collect_id");
        M("collectalone")->where("collect_id=".$collect_id)->delete();
        $this->success("删除成功",U("Collect_alone/index"));
    }
}