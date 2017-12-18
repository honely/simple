<?php
namespace Admin\Controller;
use Think\Controller;

class ContentController extends Controller {

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
	
	//文章列表
    public function index(){
		$where="1 ";
		$info=I("info");
		if ($info){
			@extract($info);
			if($keyword){
				$info['keyword']=urldecode(trim($info['keyword']));
                $where.="and title like '%".$info['keyword']."%'";  
                $this->assign('keyword',urldecode($info['keyword']));
			}
			if($classtype){
				$info['classtype']=urldecode(trim($info['classtype']));
                $where.="and classtype like '%".$info['classtype']."%'";  
                $this->assign('classtype',urldecode($info['classtype']));
				
			}
			
		}

		$content=M('Content');
		// 查询满足要求的总记录数
		$count      = $content->where($where)->count();
		$Page       = new \Think\Page($count,15);
		//分页跳转的时候保证查询条件
		if($info){
			foreach($info as $key=>$val) {
				$Page->parameter['info['.$key.']']   =   urlencode($val);
			}
		}
		$pageshow   = $Page->adminshow();
		// 进行分页数据查询
		$listinfo = $content->where($where)->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('listinfo',$listinfo);
		$this->assign('pageshow',$pageshow);
		$this->assign('class_type',D("Content")->get_classtype());//文章分类
		$this->display();
    }

	//添加文章
    public function addcontent(){
		if (IS_POST){
			$info=I("info");
			$info['addtime']=SYS_TIME;
			$flag=M("Content")->add($info);
			if($flag){
				$this->success('添加文章成功！',U('content/index'),3);
			}else{
				$this->error('添加文章失败！',U('content/index'),3);
			}
		}else{
			$this->assign('class_type',D("Content")->get_classtype());//文章分类
			$this->display();
		}
    }

	//编辑文章
    public function editcontent(){
		$id=I("get.id");
		if (IS_POST){
			$info=I("info");
			$flag=M("Content")->where("id=".$id)->save($info);
			$this->success('编辑文章成功！',U('content/index'),3);			
		}else{
			$content=M("Content")->where("id=".$id)->find();
			$this->assign('content',$content);
			$this->assign('class_type',D("Content")->get_classtype());//文章分类
			$this->display();
		}
    }

	//删除文章
	public function delcontent(){
		$id=abs(I("get.id"));
		$content_=M('Content')->where('id='.$id)->find();
		if($content_){
			if($content_['classtype']==1){
				$this->error('文章单页禁止删除！',U('content/index'),3);
			}
			M('Content')->where('id='.$id)->delete();
			$this->success('文章删除成功！',U('content/index'),3);
		}else{
			$this->error('文章删除失败！',U('content/index'),3);	
		}	
	}

}