<?php
namespace Admin\Controller;
use Think\Controller;

class BuyinfoController extends Controller {
	//三表联合查询
	public function index() {
			//模糊查询
			$where="1 ";
			$info=I("info");
			if ($info){
				@extract($info);
				if($focus_title){
					$info['focus_title']=urldecode(trim($info['focus_title']));
					$where.="and (ec_user.nickname like '%".$info['focus_title']."%' or ec_course.course_name like  '%".$info['focus_title']."%' )";
					$this->assign('focus_title',$info['focus_title']);
				}
				if($buy_type){
					$info['buy_type']=urldecode(trim($info['buy_type']));
					$where.="and buy_type ='".$info['buy_type']."'";
					$this->assign('buy_type',$info['buy_type']);
				}
				if($buy_flag){
					$info['buy_flag']=urldecode(trim($info['buy_flag']));
					$where.="and buy_flag ='".$info['buy_flag']."'";
					$this->assign('buy_flag',$info['buy_flag']);
				}

				 if($starttime){
                $info['starttime']=urldecode(trim($info['starttime']));
                $where.=" and ec_buyinfo.buy_addtime >=".strtotime($info['starttime']."00:00:00")." ";
                $this->assign('starttime',$info['starttime']);
            }
           		 if($endtime){
                $info['endtime']=urldecode(trim($info['endtime']));
                $where.=" and ec_buyinfo.buy_endtime <=".strtotime($info['endtime']."23:59:59")." ";
                $this->assign('endtime',$info['endtime']);
            }
//
			}

			$payinfo=M('buyinfo');
			$count=$payinfo->where	($where)
				->join('left join ec_user on ec_buyinfo.user_id = ec_user.user_id')
				->join('left join ec_course on ec_buyinfo.course_id = ec_course.course_id')
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
				->join('left join ec_user on ec_buyinfo.user_id = ec_user.user_id')
				->join('left join ec_course on ec_buyinfo.course_id = ec_course.course_id')
				->limit($Page->firstRow.','.$Page->listRows)
				->order('ec_buyinfo.buy_id desc')
				->select();

		  	$this -> assign('id',1);
			$this->assign('pageshow',$pageshow);
			$this->assign('buytype',D('buyinfo')->buytype());
			$this->assign('buyflag',D('buyinfo')->buyflag());
			$this->assign('arr',$arr);
			$this->display();

		}
}