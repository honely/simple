<?php
namespace Admin\Controller;
use Think\Controller;
class PinglunaloneController extends Controller
{
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
   
	//查看专题的评论
    public function pinglun(){
		$comment_id = I("get.comment_id");
        $lesson_name = I("get.lesson_name");
		$where=" ec_comment2alone.comment_id='".$comment_id."'  ";
		$info = I("info");
		if($info){
        @extract($info);
           //按姓名手机号
            if($keyword){
    				$info['keyword']=urldecode(trim($info['keyword']));
    				$where.=" and ( ec_user.nickname like '%".$info['keyword']."%')";  
    				$this->assign('keyword',$info['keyword']);
    			}
		    //按时间查询
            if($starttime){
                $info['starttime']=urldecode(trim($info['starttime']));
                $where.=" and (ec_comment2alone.addtime2 >=".strtotime($info['starttime'].'00:00:00' ).") ";
                $this->assign('starttime',urldecode($info['starttime']));
            }
            if($endtime){
                $info['endtime']=urldecode(trim($info['endtime']));
                $where.=" and (ec_comment2alone.addtime2 <=".strtotime($info['endtime'].'23:59:59' ).") ";
                $this->assign('endtime',urldecode($info['endtime']));
            }
        }
		//查询满足要求的总记录数
        $count = M("Comment2alone")
                ->where($where)
                ->join(" left join ec_user ON ec_user.user_id = ec_comment2alone.user_id")
                ->join(" left join ec_commentalone ON ec_commentalone.comment_id = ec_comment2alone.comment_id")
                ->join(" left join ec_lessonalone  ON ec_lessonalone.lesson_id = ec_commentalone.lesson_id")
                ->count();
        $Page = new\Think\Page($count,15);
        //分页跳转的时候保证查询条件
        if($info){
            foreach ($info as $key=>$v){
                $Page->parameter['info['.$key.']'] = urlencode($v);
            }
        }
        $Pageshow = $Page->adminshow();
        //进行分页数据查询
        $comment = M("Comment2alone")
                ->where($where)
                ->join(" left join ec_user ON ec_user.user_id = ec_comment2alone.user_id")
                ->join(" left join ec_commentalone ON ec_commentalone.comment_id = ec_comment2alone.comment_id")
                ->join(" left join ec_lessonalone  ON ec_lessonalone.lesson_id = ec_commentalone.lesson_id")
				->order('ec_comment2alone.comment2_id desc')
				->limit($Page->firstRow.",".$Page->listRows)
                ->select();       
		$this->assign("comment_id",$comment_id);
		$this->assign("pageshow",$Pageshow);
        $this->assign('comment',$comment);
        $this->assign('lesson_name',$lesson_name);
        $this->display();
    }
		//删除评论的评论
    public function delcomment(){
        $comment_id = I("get.comment_id");
        $comment2_id = I("get.comment2_id");
        M("Comment2alone")->where("comment2_id=".$comment2_id)->delete();
		//给评论次数减1
		M('Commentalone')->where("comment_id=".$comment_id)->setDec('comment_count',1);
       $this->success('删除成功！',U('pinglunalone/pinglun'),3);
    }
	
}