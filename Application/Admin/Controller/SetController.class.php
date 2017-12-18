<?php
namespace Admin\Controller;
use Think\Controller;
//管理员控制器0808
/*
 * controller 控制器
 * action 方法
 * return true/false
 */
class SetController extends Controller {

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
	
	//列表
    public function index(){
		
		$where="1 ";
		$info=I("info");
		if ($info){
			@extract($info);
			if($keyword){
				$info['keyword']=urldecode(trim(str_replace("'",'"',$info['keyword'])));
				$where.="and (set_key like '%".$info['keyword']."%' or set_value like '%".$info['keyword']."%' or set_remark like '%".$info['keyword']."%')";  
				$this->assign('keyword',$info['keyword']);
			}
		}
		$admin=M('setinfo');
		// 查询满足要求的总记录数
		$count      = $admin->where($where)->count();
		$Page       = new \Think\Page($count,15);
		//分页跳转的时候保证查询条件
		if($info){
			foreach($info as $key=>$val) {
				$Page->parameter['info['.$key.']']   =   urlencode($val);
			}
		}
		$pageshow   = $Page->adminshow();
		// 进行分页数据查询
		$listinfo = $admin
					->where($where)
					->order('set_id desc')
					->limit($Page->firstRow.','.$Page->listRows)
					->select();
		
		$this->assign('listinfo',$listinfo);
 
		$this->assign('pageshow',$pageshow);
		$this->display();
    }
	//添加配置
	public function addinfo(){
		
		if (IS_POST){
			$info=I("info");
			$data=array('set_key'=>$info['set_key']);
			$res=M('setinfo')->field('set_key')->where($data)->select();
			if($res){
				$this->error('添加配置key不可重复！',U('set/addinfo'),3);
			}else{
				$info['set_remark']=str_replace("，",",",$info['set_remark']);
				$flag=D("setinfo")->addinfo($info);
				if($flag){
				$this->success('添加配置成功！',U('set/addinfo'),3);
				}else{
				$this->error('添加配置失败！',U('set/addinfo'),3);
				}
			}
		}else{
			
			$this->display();
		}
    }
    //编辑配置
	public function editinfo(){
		$set_id=I("get.set_id");
		if (IS_POST){
			$info=I("info");
			$info['set_remark']=str_replace("，",",",$info['set_remark']);
			$set_id=$info['set_id'];
			$flag=M("setinfo")->where("set_id=$set_id")->save($info);
			if($flag!==false){
				$this->success('编辑配置成功！',U('set/index'),3);
			}else{
				$this->error('编辑配置失败！',U('set/index'),3);
				}
		}else{
			$setinfo=M("setinfo")->where("set_id=".$set_id)->find();
			$this->assign('setinfo',$setinfo);
			$this->display();
		}
    }

}