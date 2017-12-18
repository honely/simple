<?php
namespace Admin\Controller;

use Think\Controller;
use Org\Util\Date;
use Think\Think;

class WorkinfoController extends Controller{
    
    public function workoper(){
        $where="1 ";
        $info=I('info');
        if($info){
            @extract($info);
            //查询
            if($focus_title){
                $info['focus_title']=urldecode(trim($info['focus_title']));
                $where.="and (ec_workinfo.work_address like '%".$info['focus_title']."%' or ec_workinfo.work_title like '%".$info['focus_title']."%') ";
                $this->assign('focus_title',$info['focus_title']);
            }
            if($work_type){
                $info['work_type']=urldecode(trim($info['work_type']));
                $where.="and (ec_workinfo.work_type = ".$info['work_type'].")";
                $this->assign('workTType',$work_type);
            }
            //按时间查询
            if($starttime){
                $this->assign('starttime',$starttime);
            }
            if($endtime){
                $this->assign('endtime',$endtime);
            }
            }
            if(!$starttime){
                $starttime = date("Y-m-d",strtotime("-60 day"));$this->assign("starttime",$starttime);
            }
            if(!$endtime){
                $endtime = date("Y-m-d",SYS_TIME);$this->assign("endtime",$endtime);
            }
            $where.= "and ec_workinfo.work_addtime>=".strtotime($starttime."00:00:00")." ";
            $where.= "and ec_workinfo.work_addtime<=".strtotime($endtime."23:59:59")." ";
        $workinfo=M('workinfo');
        $count=$workinfo->where($where)      
                        ->count();
        $Page=new \Think\Page($count,15);
        $pageshow=$Page->adminshow();
        $arr=$workinfo->where($where)
                      ->limit($Page->firstRow.','.$Page->listRows)
                      ->order("work_id desc")
                      ->select();
        $this->assign('pageshow',$pageshow);
        $this->assign('workType',D('focusinfo')->workType());
        $this->assign('arr',$arr);
        $this->display();
    }
    //发送模板消息
	public function sendtplmsg(){
		set_time_limit(0);
		$work_id=I("get.work_id");
		$workinfo=M("workinfo")->where("work_id=".$work_id)->find();
		$userinfo=M("User")->where("openid!=''")->select();
		$data=array();
		foreach($userinfo as $v){
			$info=array(
				'touser'=>$v['openid'],
				'template_id'=>'phEzjwdSVrfoWtBBp8dLDNfn7kro4x-qL9KxwIjFaEc',
				'url'=>C("WEB_URL")."index.php?c=bookinfo&a=yanxibanbaoming",
				'data'=>array(
					'work_title'=>array('value'=>$workinfo['work_title'],'color'=>'#FF0000'),
					'work_time'=>array('value'=>$workinfo['work_time'],'color'=>'#173177'),
					'work_address'=>array('value'=>$workinfo['work_address'],'color'=>'#173177'),
				),
			);
			$data[]=json_encode($info);
			unset($info);
		}
		sendtemplate($data);
		$this->success('发送模板消息成功！',U('workinfo/workoper'),3);
	}
//添加
    public function addinfo(){
        if (IS_POST){
            $info=I("info");
            $info['work_addtime']=time();
            $flag=M('workinfo')->add($info);
            if($flag){
                $this->success('添加成功！',U('workinfo/workoper'),3);
            }else{
                $this->error('添加失败！',U('workinfo/addinfo'),3);
            }
        }else{
            $this->display();
        }
    }
  //编辑
    public function edit(){
        $work_id=I("get.work_id");
        if (IS_POST){
            $info=I("info");
            $flag=M("workinfo")
                  ->where("ec_workinfo.work_id=".$work_id)
                  ->save($info);
            if($flag){
                $this->success('编辑成功！',U('workinfo/Workoper'),3);
            }else{
                $this->error('编辑失败！',U('workinfo/edit',array('work_id'=>$work_id)),3);
            }
        }else{
            $classify=M("workinfo")
                      ->where("work_id=".$work_id)
                      ->find();
            $this->assign('classify',$classify);
            $this->display();
        }
    }
    //删除
    public function delworkinfo(){
        $work_id=I("get.work_id");
        M("workinfo")->where("work_id=".$work_id)->delete();
        M("seatinfo")->where("work_id=".$work_id)->delete();
        M("signlist")->where("work_id=".$work_id)->delete();
        M("signinfo")->where("work_id=".$work_id)->delete();
        $this->success("删除成功",U("workinfo/workoper"));
    }

    //售罄
    public function soldOut(){
        $workId=I('get.work_id');
        $soldOut=M('workinfo')->where('work_id = '.$workId)->save(array('work_type'=>'2'));
        if($soldOut){
            $this->success('状态修改成功！',U('workinfo/Workoper'),3);
        }else{
            $this->error('状态修改失败！',U('workinfo/Workoper'),3);
        }
    }
    
    //每一个研习班的席位列表
    public function seat()
    {
        //$_get获取到每个研习班的ID根据研习班的ID找其对应的席位；
        $workId=$_GET['work_id'];
        $workTitle=$_GET['work_title'];
        $where='ec_seatinfo.work_id = '.$workId;
        $seatInfo=M('seatinfo')
            ->join(" left join ec_workinfo as a ON a.work_id = ec_seatinfo.work_id")
            ->field('ec_seatinfo.*,a.work_id,a.work_title')
            ->where($where)
            ->order('seat_id desc')
            ->select();
       //dump($seatInfo);
        $this->assign('work_title',$workTitle);
        $this->assign('seatInfo',$seatInfo);
        $this->assign('workId',$workId);
        $this->display();
    }

    //添加席位
    public function addseat()
    {
        $workId=$_GET['work_id'];
        if (IS_POST){
            $data=I("info");
            $addSeat=M('seatinfo')->add($data);
            if($addSeat){
                $this->success('添加成功！',U('workinfo/seat',array('work_id'=>$data['work_id'])),3);
            }else{
                $this->error('添加失败！',U('workinfo/seat',array('work_id'=>$data['work_id'])),3);
            }
        }else{
            $this->assign('workId',$workId);
            $this->assign('work_title',D('seatinfo')->getWorkNameById($workId));
            $this->display();
        }
    }

    //修改席位
    public function editseat()
    {
        $seatId=$_GET['seat_id'];
        if(IS_POST)
        {
            $info=I("info");
            $flag=M("seatinfo")
                ->where("ec_seatinfo.seat_id=".$seatId)
                ->save($info);
            if($flag){
                $this->success('修改席位成功！',U('workinfo/seat',array('work_id'=>$info['work_id'])),3);
            }else{
                $this->error('修改席位失败！',U('workinfo/editseat',array('seat_id'=>$seatId)),3);
            }
        }else{

            $seatInfo=M('seatinfo')->where('seat_id = '.$seatId)->find();
            $this->assign('seatInfo',$seatInfo);
            $workId=$seatInfo['work_id'];
            $this->assign('seatInfo',$seatInfo);
            $this->assign('work_title',D('seatinfo')->getWorkNameById($workId));
            $this->assign('workId',$workId);
            $this->display();
        }
    }

    //删除席位
    public function delseatinfo()
    {
        $seatId=I("get.seat_id");
        $work_title=I("get.work_title");
        $seatInfo=M('seatinfo')->where('seat_id = '.$seatId)->find();
        $workId=$seatInfo['work_id'];
        //删除相关席位报名
        M("signlist")->where("seat_id=".$seatId)->delete();

        M("seatinfo")->where("seat_id=".$seatId)->delete();
        $this->success('席位删除成功！',U('workinfo/seat',array('work_id'=>$workId,'work_title'=>$work_title)),3);
    }
	//发送短信通知
	public function sendmsg(){
		$work_id=I("get.work_id");
		$workinfo=M('workinfo')->where('work_id='.$work_id)->find();
		$signinfo=M('signinfo')->where('work_id='.$work_id)->join("left join ec_user on ec_signinfo.user_id=ec_user.user_id")->field("ec_user.phone,ec_user.realname,ec_user.sex")->select();
		foreach($signinfo as $k=>$v){
			$msg=$v['realname']."先生/女士您好，".$workinfo['work_title']."  即将开课，请按时参加！";
			if($v['phone']){
				sendphonemsg($phone,$msg);
			}
		}
		$this->success('发送研习班开课短信通知成功！',U('workinfo/workoper'),3);
	}
}
















