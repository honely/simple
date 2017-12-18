<?php
namespace Admin\Controller;
use Think\Controller;
//角色控制器828
/*
 * controller 控制器
 * action 方法
 * return true/false
 */
class adminroleController extends Controller {

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
	
	//管理角色列表
    public function index(){
		$where="1 ";
		$info=I("info");
		if ($info){
			@extract($info);
			if($keyword){
				$where.="and role_name like '%$keyword%' ";
				$this->assign('keyword',$keyword);
			}
		}

		$admingroup=M('adminrole');
		// 查询满足要求的总记录数
		$count      = $admingroup->where($where)->count();
		$Page       = new \Think\Page($count,15);
		//分页跳转的时候保证查询条件
		if($info){
			foreach($info as $key=>$val) {
				$Page->parameter['info['.$key.']']   =   urlencode($val);
			}
		}
		$pageshow   = $Page->adminshow();
		// 进行分页数据查询
		$listinfo = $admingroup
					->where($where)
					->order('role_id desc')
					->limit($Page->firstRow.','.$Page->listRows)
					->select();
		$this->assign('listinfo',$listinfo);
		$this->assign('pageshow',$pageshow);
		$this->display();
    }

	//添加角色
    public function addadmingroup(){
		if (IS_POST){
			$info=I("info");
			$info['role_name']=trim($info['role_name']);
			$menu_id=$info['menu_id'];
			$info['role_power']=join(",",$menu_id);
			unset($info['menu_id']);
			$flag=M("adminrole")->add($info);
			if($flag){
				F("group_menu_".$flag,$menu_id);
		
				$this->success('添加角色成功！',U('adminrole/index'),3);
			}else{
				$this->error('添加角色失败！',U('adminrole/index'),3);
			}
		}else{
			$adminmenu=D("adminmenu")->getmenuninfo(0);
			$this->assign('adminmenu',$adminmenu);
			$this->display();
		}
    }

	//编辑角色
    public function editadmingroup(){
		$role_id=I("get.role_id");
		if (IS_POST){
			$info=I("info");
			$info['role_name']=trim($info['role_name']);
			$menu_id=$info['menu_id'];
			$info['role_power']=join(",",$menu_id);
			unset($info['menu_id']);
			
			$flag=M("adminrole")->where("role_id=".$role_id)->save($info);			
			F("group_menu_".$role_id,$menu_id);
			$this->success('编辑角色成功！',U('adminrole/index'),3);
			
		}else{
			$groupinfo=M("adminrole")->where("role_id=".$role_id)->find();
			$this->assign('groupinfo',$groupinfo);

			$adminmenu=D("adminmenu")->getmenuninfo(0);
			$this->assign('adminmenu',$adminmenu);
			$this->display();
		}
    }

	//删除角色
	public function deladmingroup(){
		$role_id=I("get.role_id");
		M('adminrole')->where('role_id='.$role_id)->delete();
		$this->success('角色删除成功！',U('adminrole/index'),3);
	}

}