<?php
namespace Admin\Controller;
use Think\Controller;
class ClassifyController extends Controller {

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
	
	//栏目列表
    public function index(){
		$where="1 ";
		$info=I("info");
		if ($info){
			@extract($info);
			if($keyword){
				$info['keyword']=urldecode(trim($info['keyword']));
				$where.="and classify_name like '%".$info['keyword']."%' or classify_id like '%".$info['keyword']."%' ";  
				$this->assign('keyword',$info['keyword']);
			}			
		}
	
		$classify=M('classify');
		// 查询满足要求的总记录数
		$count      = $classify->where($where)->count();
		$Page       = new \Think\Page($count,15);
		//分页跳转的时候保证查询条件
		if($info){
			foreach($info as $key=>$val) {
				$Page->parameter['info['.$key.']']   =   urlencode($val);
			}
		}
		$pageshow   = $Page->adminshow();
		// 进行分页数据查询
		$listinfo = $classify
					->where($where)
					->order('classify_sort desc,classify_id desc')
					->limit($Page->firstRow.','.$Page->listRows)
					->select();
		$this->assign('listinfo',$listinfo);
		$this->assign('pageshow',$pageshow);
		$this->display();
    }

	//添加栏目
    public function addclassify(){
		if (IS_POST){
			$info=I("info");
            $classify_name_count=M('classify')->where(" classify_name='".$info['classify_name']."' ")->count();
			if($classify_name_count>0){
				$this->error('添加栏目失败,此栏目已存在！',U('classify/index'),3);
			}
			$flag=M("classify")->add($info);
			
			if($flag){
				$this->success('添加栏目成功！',U('classify/index'),3);
			}else{
				$this->error('添加栏目失败！',U('classify/index'),3);
			}
		}else{
			$this->display();
		}
    }
	//编辑栏目
    public function editclassify(){
		$classify_id=I("get.classify_id");
		if (IS_POST){
			$info=I("info");
			$count_type=M('classify')->where(" classify_name='".$info['classify_name']."' and classify_id!=".$classify_id." ")->count();			
			if($count_type>0){
				$this->error('编辑栏目失败,此栏目已存在！',U('classify/index'),3);
			}
			$flag=M("classify")->where("classify_id=".$classify_id)->save($info);
			if($flag){
				$this->success('编辑栏目成功！',U('classify/index'),3);
			}else{
				$this->error('编辑栏目失败！',U('classify/index'),3);
			}
		}else{
			$classify=M("classify")->where("classify_id=".$classify_id)->find();
			$this->assign('classify',$classify);
			$this->display();
		}
    }
	//删除栏目
	public function delclassify(){
		$classify_id=I("get.classify_id");
		M('classify')->where('classify_id='.$classify_id)->delete();
		$this->success('栏目删除成功！',U('classify/index'),3);
	}

}