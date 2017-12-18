<?php
namespace Admin\Controller;
use Think\Controller;
class LiveorderController extends Controller {

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
		
	//直播预约管理
    public function index(){
		$where="1 ";
		$info=I("info");
	    $live_id=I("get.live_id");
		if ($info){
			@extract($info);
			//live_id
			if($keyword){
				$info['keyword']=urldecode(trim($info['keyword']));
				$where.=" and (a.nickname ='".$info['keyword']."' or a.phone like '%".$info['keyword']."%'  or b.live_title like '%".$info['keyword']."%'  or ec_liveorder.order_id = '".$info['keyword']."' ) ";  
				$this->assign('keyword',$info['keyword']);
			}
			//预约时间
			if($starttime){
                $info['starttime']=urldecode(trim($info['starttime']));
                $where.=" and ec_liveorder.order_addtime >=".strtotime($info['starttime']."00:00:00")." ";
                $this->assign('starttime',$info['starttime']);
            }
           	if($endtime){
                $info['endtime']=urldecode(trim($info['endtime']));
                $where.=" and ec_liveorder.order_addtime <=".strtotime($info['endtime']."23:59:59")." ";
                $this->assign('endtime',$info['endtime']);
            }
		}
		
	    if($live_id){
				$where.=" and  ec_liveorder.live_id = '".$live_id."' "; 
				$this->assign('live_id',$live_id);				
		}
		$liveorder=M('Liveorder');
		// 查询满足要求的总记录数
		$count      = $liveorder
					->join('left join ec_user as a on a.user_id = ec_liveorder.user_id')
					->join('left join ec_liveinfo as b on b.live_id = ec_liveorder.live_id')
					->field('a.nickname,a.phone,b.live_title,ec_liveorder.order_id,ec_liveorder.order_addtime')
					->where($where)
					->count();
		$Page       = new \Think\Page($count,20);
		//分页跳转的时候保证查询条件
		if($info){
			foreach($info as $key=>$val) {
				$Page->parameter['info['.$key.']']   =   urlencode($val);
			}
		}
		$pageshow   = $Page->adminshow();
		// 进行分页数据查询
		$listinfo = $liveorder
		            ->join('left join ec_user as a on a.user_id = ec_liveorder.user_id')
					->join('left join ec_liveinfo as b on b.live_id = ec_liveorder.live_id')
					->field('a.nickname,a.phone,b.live_title,b.live_id as live_ids,ec_liveorder.order_id,ec_liveorder.order_addtime')
					->where($where)
					->order('ec_liveorder.order_id desc')
					->limit($Page->firstRow.','.$Page->listRows)
					->select();
		$this->assign('listinfo',$listinfo);
		$this->assign('pageshow',$pageshow);
		$this->display();
    }
	//删除预约
	public function delliveorder(){
		$order_id=I("get.order_id");
		$live_id=I("get.live_id");
		M('liveorder')->where('order_id='.$order_id)->delete();
		M('liveinfo')->where('live_id='.$live_id)->setDec('live_num',1);
		$this->success('预约学员删除成功！',U('liveorder/index'),3);
	}

}