<?php
namespace Admin\Controller;
use Think\Controller;
//文章控制器0808
/*
 * controller 控制器
 * action 方法
 * return true/false
 */
class SubtypeController extends Controller {

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
	
	//下载分类列表
    public function index(){
		$where="1 ";
		$info=I("info");
		if ($info){
			@extract($info);
			if($downinfo){
				$info['downinfo']=urldecode(trim($info['downinfo']));
				$where.="and (ec_down_subtype.subtype_name like '%".$info['downinfo']."%')";
				$this->assign('downinfo',$info['downinfo']);
			}
			if($down_type_){
				$info['down_type_']=urldecode(intval(trim($info['down_type_'])));
				$where.="and ec_down_subtype.type_id =".$info['down_type_']." ";
				$this->assign('down_type_',$info['down_type_']);
			}

		}

		$subtype=M('down_subtype');
		// 查询满足要求的总记录数
		$count      = $subtype->where($where)->count();
		$Page       = new \Think\Page($count,20);
		//分页跳转的时候保证查询条件
		if($info){
			foreach($info as $key=>$val) {
				$Page->parameter['info['.$key.']']   =   urlencode($val);
			}
		}
		$pageshow   = $Page->adminshow();
		// 进行分页数据查询
		$listinfo =  $subtype
					->where($where)
					->order('ec_down_subtype.subtype_id desc')
					->limit($Page->firstRow.','.$Page->listRows)
					->select();
		$this->assign('listinfo',$listinfo);
		$this->assign('down_type',D('buyinfo')->down_type()); //工具类型
		$this->assign('pageshow',$pageshow);
		$this->display();
    }

	//添加
    public function add(){
		if (IS_POST){
			$info=I("info");
			$flag=M("down_subtype")->add($info);//echo $flag;die;
			if($flag){
				$this->success('添加下载分类成功！',U('subtype/index'),3);
				
			}else{
				$this->error('添加下载分类失败！',U('subtype/index'),3);
			}
		}else{
			$this->assign('down_type',D('buyinfo')->down_type()); //工具类型
			$this->display();
		}
    }

	//编辑
    public function edit(){
		$subtype_id=I("get.subtype_id");
		if (IS_POST){
			$info=I("info");
			$flag=M("down_subtype")->where("subtype_id=".$subtype_id)->save($info);//echo $flag;die;
			if($flag){
				$this->success('编辑下载分类成功！',U('subtype/index'),3);
			}else{
				$this->error('编辑下载分类失败！',U('subtype/index'),3);
			}
		}else{
			$subtype=M("down_subtype")->where("subtype_id=".$subtype_id)->find();
			$this->assign('down_type',D('buyinfo')->down_type()); //工具类型
			$this->assign('subtype',$subtype);
			$this->display();
		}
    }

	//删除
	public function del(){
		$subtype_id=I("get.subtype_id");
		M('down_subtype')->where('subtype_id='.$subtype_id)->delete();
		$this->success('下载分类删除成功！',U('subtype/index'),3);
	}
	
	//名称去重
    public function quchong(){
		$subtype_name=I("subtype_name");
		if(!$subtype_name){
			$status="n";
			$info="内容不能为空";
		}else{
			//添加时验证
			$count=M("down_subtype")->where(" subtype_name = '".$subtype_name."'")->count();
			if($count){//存在，验证失败
				$status="n";
				$info="此名称已存在";
			}else{//不存在，验证成功
				$status="y";
				$info="此名称不存在，可以增加";
			}
		}
		$this->ajaxReturn(array('status'=>$status,'info'=>$info));
	}
	
	
}