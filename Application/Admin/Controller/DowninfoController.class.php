<?php
namespace Admin\Controller;
use Think\Controller;
class DowninfoController extends Controller {
	
    function __construct() {
		//继承父类
		parent::__construct();

		//判断登录状态
		if (!D('admininfo')->islogin()) {//未登录
			$this->error('您尚未登录，请先登录！', U('login/login'), 3);
		}
    }
	//列表页	
		public function downinfo() {

			$where="1 ";
			$info=I("info");
			if ($info){
				@extract($info);
				if($downinfo){
					$info['downinfo']=urldecode(trim($info['downinfo']));
					$where.="and (ec_downinfo.down_title like '%".$info['downinfo']."%') ";
					$this->assign('downinfo',$info['downinfo']);
				}
				if($down_type_){
					$info['down_type_']=urldecode(trim($info['down_type_']));
					$where.="and down_type ='".$info['down_type_']."' ";
					$this->assign('down_type_',$info['down_type_']);
					//如果有大分类调出小分类
					$this->assign('down_subtype_info',M("Down_subtype")->where("type_id=".$info['down_type_'])->select());
				}
				if($down_subtype){
					$info['down_subtype']=urldecode(trim($info['down_subtype']));
					$where.="and down_subtype ='".$info['down_subtype']."' ";
					$this->assign('down_subtype',$info['down_subtype']);
				}
			}

			$payinfo=M('downinfo');
			$count=$payinfo->where($where)
				->join("left join ec_down_subtype on ec_down_subtype.subtype_id=ec_downinfo.down_subtype")
				->count();
			$Page=new \Think\Page($count,15);
			//分页跳转的时候保证查询条件
			if($info){
				foreach($info as $key=>$val) {
					$Page->parameter['info['.$key.']'] = urlencode($val);
				}
			}
			$pageshow   = $Page->adminshow();
			$arr=$payinfo->where($where)
				->limit($Page->firstRow.','.$Page->listRows)
				->join("left join ec_down_subtype on ec_down_subtype.subtype_id=ec_downinfo.down_subtype")
				->order('ec_downinfo.down_id desc')
				->field("ec_downinfo.*,ec_down_subtype.subtype_name")
				->select();
		  	//$this -> assign('id',1);
			$this->assign('pageshow',$pageshow);
			$this->assign('down_type',D('buyinfo')->down_type()); //工具类型
			$this->assign('arr',$arr);
			$this->display();

		}
//删除
	public function del(){
		$down_id=I("get.down_id");
		M('downinfo')->where('down_id='.$down_id)->delete();
		$this->success('工具删除成功！',U('downinfo/downinfo'));
	}
//添加页面	
   public function addpage()
   {
	   $this->assign('down_type',D('buyinfo')->down_type()); //工具类型
	   $this->display("downinfo:addtool");
   }
//添加
   public function addtool()
   {
	  
		$data = $_POST['info'];   //用户提交数据
		//----------------//
		$flag = M('downinfo')->add($data);
		//----------------//
		if($flag){
			$this->success('添加工具成功！',U('downinfo/downinfo'));
		}else{
			$this->error('添加工具失败！',U('downinfo/downinfo'));
		}
   }
//修改
   public function upd(){
        if (IS_POST) {
            $input = I('post.');
            $data = M('downinfo');
            $where = array('down_id'=>$input['down_id']);
            $list = array(
                'down_title'=>$input['down_title'],
				'down_image'=>$input['down_image'],
				'down_file'=>$input['down_file'],
				'down_remarks'=>$input['down_remarks'],
				'down_type'=>$input['down_type'],
				'down_subtype'=>$input['down_subtype'],
            );
            $data->where($where)->save($list);
            $this->success('修改工具成功！',U('downinfo/downinfo'));
        }else{
			$this->assign('down_type_',D('buyinfo')->down_type());
            $data = M('downinfo');
            $id = I('get.down_id','','int');
            $list = $data ->find($id);
            $this ->assign('data',$list);
			//如果有大分类调出小分类
			$this->assign('down_subtype_info',M("Down_subtype")->where("type_id=".$list['down_type'])->select());

            $this->display("downinfo/upd");
        }
    }

	//ajax获取下载二级分类
	public function ajaxgetsubtype(){
		$down_type=I('get.down_type');
		$subtype=M("Down_subtype")->where("type_id=".$down_type)->select();
		$this->ajaxReturn($subtype);
	}

}


