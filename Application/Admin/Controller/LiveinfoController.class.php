<?php
namespace Admin\Controller;
use Think\Controller;
class LiveinfoController extends Controller {

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
	
	//视频直播
    public function index(){
		$where="1 ";
		$info=I("info");
		if ($info){
			@extract($info);
			if($keyword){
				$info['keyword']=urldecode(trim($info['keyword']));
				$where.="and live_title like '%".$info['keyword']."%'";  
				$this->assign('keyword',$info['keyword']);
			}

            if($live_flag){
				$info['live_flag']=urldecode(trim($info['live_flag']));
				$where.="and live_flag like '%".$info['live_flag']."%'";  
				$this->assign('liveflag',$info['live_flag']);
			}			
		}
	
		$liveinfo=M('Liveinfo');
		// 查询满足要求的总记录数
		$count      = $liveinfo->where($where)->count();
		$Page       = new \Think\Page($count,20);
		//分页跳转的时候保证查询条件
		if($info){
			foreach($info as $key=>$val) {
				$Page->parameter['info['.$key.']']   =   urlencode($val);
			}
		}
		$Pageshow   = $Page->adminshow();
		// 进行分页数据查询
		$listinfo = $liveinfo
					->where($where)
					->order('live_id desc')
					->limit($Page->firstRow.','.$Page->listRows)
					->select();
		foreach($listinfo as $k=>$v){
			$st=strtotime(date("Y-m-d 00:00:00",strtotime($v['live_time'].":00")))-3600*24;
			$et=strtotime(date("Y-m-d 23:59:59",strtotime($v['live_time'].":00")))-3600*24;
			if($st<=SYS_TIME && SYS_TIME<=$et){
				$listinfo[$k]['showsendmsg']=1;
			}else{
				$listinfo[$k]['showsendmsg']=0;
			}
		}
		$this->assign('live_flag',D('Liveinfo')->liveflag());
		$this->assign('listinfo',$listinfo);
		$this->assign('Pageshow',$Pageshow);
		$this->display();
    }

	//添加视频
    public function addlive(){
		if (IS_POST){
			$info=I("info");
			//  `live_flag` tinyint(4) default '0' COMMENT '直播状态，1关闭，2开启',
		    $info['live_flag']=1;
            $live_title=M('Liveinfo')->where(" live_title='".trim($info['live_title'])."' ")->count();
			if($live_title>0){
				$this->error('添加直播失败,此直播已存在！',U('liveinfo/index'),3);
			}
			$flag=M("Liveinfo")->add($info);
			if($flag){
				$this->success('添加直播成功！',U('liveinfo/index'),3);
			}else{
				$this->error('添加直播失败！',U('liveinfo/index'),3);
			}
		}else{
			$this->display();
		}
    }
	//编辑视频
    public function editlive(){
		$live_id=I("get.live_id");
		if (IS_POST){
			$info=I("info");
			$info['live_flag']=1;
			$flag=M("Liveinfo")->where("live_id=".$live_id)->save($info);
			if($flag){
				$this->success('编辑直播成功！',U('liveinfo/index'),3);
			}else{
				$this->error('编辑直播失败！',U('liveinfo/index'),3);
			}
		}else{
			$liveinfo=M("liveinfo")->where("live_id=".$live_id)->find();
			$this->assign('liveinfo',$liveinfo);
			$this->display();
		}
    }
	
	//删除直播
	public function dellive(){
		$live_id=I("get.live_id");
		M('Liveinfo')->where('live_id='.$live_id)->delete();//删除直播视频
		M('Liveorder')->where('live_id='.$live_id)->delete();//删除直播预约
		$this->success('直播删除成功！',U('liveinfo/index'),3);
	}
   //开启
	public function setlive(){
	    $live_id=I("get.live_id");
	    M('Liveinfo')->where('1 ')->save(array('live_flag'=>1));
	    M('Liveinfo')->where('live_id='.$live_id)->save(array('live_flag'=>2)); 
	    $this->success('开启成功！',U('liveinfo/index'),3);
	}
	//关闭
	public function setliveclose(){
		$live_id=I("get.live_id");
		M('Liveinfo')->where('live_id='.$live_id)->save(array('live_flag'=>1));
		  $this->success('关闭成功！',U('liveinfo/index'),3);
	}
	//发送短信通知
	public function sendmsg(){
		$live_id=I("get.live_id");
		$liveinfo=M('Liveinfo')->where('live_id='.$live_id)->find();
		$liveorder=M('Liveorder')->where('live_id='.$live_id)->join("left join ec_user on ec_liveorder.user_id=ec_user.user_id")->field("ec_user.phone,ec_user.realname,ec_user.sex")->select();
		foreach($liveorder as $k=>$v){
			$msg=$v['realname']."先生/女士您好，".$liveinfo['live_title']."  即将开播，请按时参加！";
			if($v['phone']){
				sendphonemsg($phone,$msg);
			}
		}
		$this->success('发送直播开播短信通知成功！',U('liveinfo/index'),3);
	}
}