<?php
namespace Admin\Controller;
use Think\Controller;
//管理员控制器0808
/*
 * controller 控制器
 * action 方法
 * return true/false
 */
class ApplyinfoController extends Controller {

public function index(){

    //模糊查询
    $where="1 ";
    $info=I("info");
    if ($info) {
        @extract($info);
        if ($keyword) {
            $info['keyword'] = urldecode(trim($info['keyword']));
            $where.="and (ec_user.nickname like '%".$info['keyword']."%' or ec_applyinfo.phone like '%".$info['keyword']."%'or ec_applyinfo.city like '%".$info['keyword']."%')";
            $this->assign('keyword',$info['keyword']);
        }
		//状态
        if($apply_flag){
                $info['apply_flag']=urldecode(trim($info['apply_flag']));
                $where.="and apply_flag ='".$info['apply_flag']."'";
                $this->assign('apply_flag',$info['apply_flag']);
            }
		//分社级别
		if($apply_type){
			$info['apply_type']=urldecode(trim($info['apply_type']));
			$where.="and apply_type ='".$info['apply_type']."'";
			$this->assign('apply_type',$info['apply_type']);
		}
    }
     //按时间查询
    if($starttime){$this->assign("starttime",$starttime);}
    if($endtime){$this->assign("endtime",$endtime);}

    if(!$starttime){
        $starttime = date("Y-m-d",strtotime("-60 day"));$this->assign("starttime",$starttime);
    }
    if(!$endtime){
        $endtime = date("Y-m-d",SYS_TIME);$this->assign("endtime",$endtime);
    }
    $where.= " and ec_applyinfo.apply_addtime>=".strtotime($starttime."00:00:00")." ";
    $where.= " and ec_applyinfo.apply_addtime<=".strtotime($endtime."23:59:59")." ";

    $admin=M('applyinfo');
    // 查询满足要求的总记录数
    $count    = $admin
        ->where($where)
        ->join('left join ec_user on ec_applyinfo.user_id = ec_user.user_id')
        ->field('ec_user.nickname,ec_applyinfo.*')
        ->count();

    $Page     = new \Think\Page($count,15);
    //多表联合查询
    $applyinfo = M ("applyinfo")-> where($where)
        ->limit($Page->firstRow.','.$Page->listRows)
        ->join('left join ec_user on ec_applyinfo.user_id = ec_user.user_id')
        ->field('ec_user.nickname,ec_applyinfo.*')
        ->order("ec_applyinfo.apply_id desc")
        ->select();
    //分页跳转的时候保证查询条件
    if($info){
        foreach($info as $key=>$val) {
            $Page->parameter['info['.$key.']']   =   urlencode($val);
        }
    }


    $this ->assign('info',$applyinfo);
    $pageshow   = $Page->adminshow();
    $this->assign('pageshow',$pageshow);
    $this ->assign('applyflag',D('Applyinfo')->applyflag());
    $this ->assign('applytype',D('Applyinfo')->get_applytype());
    $this->display();
  }




    public function adoptno(){//驳回
        $id=I('get.apply_id');
        //dump($id);
        $aa = M('applyinfo')->where("apply_id=".$id)->save(array('apply_flag'=>3));
        if($aa){
            $this->success('驳回成功');
        }else{
            $this->error('驳回失败');
        }
    }


    public function adopt(){//通过
        $id=I('get.apply_id');
        //dump($id);
        $aa = M('applyinfo')->where("apply_id=".$id)->save(array('apply_flag'=>2));
        if($aa){
            $this->success('通过成功');
        }else{
            $this->error('通过失败');
        }
    }
}







