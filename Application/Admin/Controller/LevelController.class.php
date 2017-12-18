<?php
namespace Admin\Controller;
use Think\Controller;
//文章控制器0808
/*
 * controller 控制器
 * action 方法
 * return true/false
 */
class LevelController extends Controller {

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
	

	//等级列表
    public function levellist(){
		$where=" 1 ";
		$info=I("info");

		$level=M('Userlevel');
		// 查询满足要求的总记录数
		$count      = $level->where($where)->count();
		$Page       = new \Think\Page($count,20);
		//分页跳转的时候保证查询条件
		if($info){
			foreach($info as $key=>$val) {
				$Page->parameter['info['.$key.']']   =   urlencode($val);
			}
		}
		$pageshow   = $Page->adminshow();
		// 进行分页数据查询
		$levelinfo =  $level
					->where($where)
					->order('ec_userlevel.level_id desc')
					->limit($Page->firstRow.','.$Page->listRows)
					->select();
		$this->assign('levelinfo',$levelinfo);
		$this->assign('pageshow',$pageshow);
		$this->display();
    }

	//添加等级
    public function addlevel(){
		if (IS_POST){
			$info=I("info");
			$flag=M("Userlevel")->add($info);//echo $flag;die;
			if($flag){
				$this->success('添加等级成功！',U('level/levellist'),3);
				
			}else{
				$this->error('添加等级失败！',U('level/levellist'),3);
			}
		}else{
			$this->display();
		}
    }

	//编辑等级
    public function editlevel(){
		$level_id=I("get.level_id");
		if (IS_POST){
			$info=I("info");
			$flag=M("Userlevel")->where("level_id=".$level_id)->save($info);//echo $flag;die;
			if($flag){
				$this->success('编辑等级成功！',U('level/levellist'),3);
			}else{
				$this->error('编辑等级失败！',U('level/levellist'),3);
			}
		}else{
			$level=M("Userlevel")->where("level_id=".$level_id)->find();
			$this->assign('level',$level);
			$this->display();
		}
    }

	//删除等级
	public function dellevel(){
		$level_id=I("get.level_id");
		M('Userlevel')->where('level_id='.$level_id)->delete();
		$this->success('等级删除成功！',U('level/levellist'),3);
	}	
	
	
	//vip等级列表
    public function viplevellist(){
		$where=" 1 ";
		$info=I("info");

		$level=M('Viplevel');
		// 查询满足要求的总记录数
		$count      = $level->where($where)->count();
		$Page       = new \Think\Page($count,20);
		//分页跳转的时候保证查询条件
		if($info){
			foreach($info as $key=>$val) {
				$Page->parameter['info['.$key.']']   =   urlencode($val);
			}
		}
		$pageshow   = $Page->adminshow();
		// 进行分页数据查询
		$levelinfo =  $level
					->where($where)
					->order('ec_viplevel.vip_id desc')
					->limit($Page->firstRow.','.$Page->listRows)
					->select();
		$this->assign('levelinfo',$levelinfo);
		$this->assign('pageshow',$pageshow);
		$this->display();
    }

	//添加vip等级
    public function add_viplevel(){
		if (IS_POST){
			$info=I("info");
			$flag=M("Viplevel")->add($info);//echo $flag;die;
			if($flag){
				$this->success('添加vip等级成功！',U('level/viplevellist'),3);
				
			}else{
				$this->error('添加vip等级失败！',U('level/viplevellist'),3);
			}
		}else{
			$this->display();
		}
    }

	//编辑vip等级
    public function edit_viplevel(){
		$vip_id=I("get.vip_id");
		if (IS_POST){
			$info=I("info");
			$flag=M("Viplevel")->where("vip_id=".$vip_id)->save($info);//echo $flag;die;
			if($flag){
				$this->success('编辑vip等级成功！',U('level/viplevellist'),3);
			}else{
				$this->error('编辑vip等级失败！',U('level/viplevellist'),3);
			}
		}else{
			
			$level=M("Viplevel")->where("vip_id=".$vip_id)->find();
			$this->assign('level',$level);
			$this->display();
		}
    }

	//删除vip等级
	public function del_viplevel(){
		$vip_id=I("get.vip_id");
		M('Viplevel')->where('vip_id='.$vip_id)->delete();
		$this->success('vip等级删除成功！',U('level/viplevellist'),3);
	}
	
	
}