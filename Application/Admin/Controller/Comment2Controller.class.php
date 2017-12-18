<?php
namespace Admin\Controller;
use Think\Controller;
class Comment2Controller extends Controller
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
   
	//查看专题的评论的评论
    public function index(){
		$where="1 and ec_comment2.comment2_flag=1 ";
		$info = I("info");
		if($info){
        @extract($info);
           //按姓名
            if($keyword){
    				$info['keyword']=urldecode(trim($info['keyword']));
    				$where.=" and ( ec_user.nickname like '%".$info['keyword']."%')";  
    				$this->assign('keyword',$info['keyword']);
    			}
		    //按时间查询
            if($starttime){
                $info['starttime']=urldecode(trim($info['starttime']));
                $where.=" and (ec_comment2.addtime2 >=".strtotime($info['starttime'].'00:00:00' ).") ";
                $this->assign('starttime',urldecode($info['starttime']));
            }
            if($endtime){
                $info['endtime']=urldecode(trim($info['endtime']));
                $where.=" and (ec_comment2.addtime2 <=".strtotime($info['endtime'].'23:59:59' ).") ";
                $this->assign('endtime',urldecode($info['endtime']));
            }
        }
		//查询满足要求的总记录数
        $count = M("Comment2")
                ->where($where)
                ->join(" left join ec_user ON ec_user.user_id = ec_comment2.user_id")
                ->join(" left join ec_course  ON ec_course.course_id = ec_comment2.course_id")
				->join(" left join ec_comment  ON ec_comment.comment_id = ec_comment2.comment_id")
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
        $comment = M("Comment2")
                ->where($where)
                ->join(" left join ec_user ON ec_user.user_id = ec_comment2.user_id")
                ->join(" left join ec_course  ON ec_course.course_id = ec_comment2.course_id")
                ->join(" left join ec_comment  ON ec_comment.comment_id = ec_comment2.comment_id")
				->field("ec_comment2.*,ec_user.nickname as nickname,ec_course.course_name as course_name,ec_comment.comment as comment")
				->order('ec_comment2.comment2_id desc')
				->limit($Page->firstRow.",".$Page->listRows)
                ->select();
		$this->assign("pageshow",$Pageshow);
        $this->assign('comment',$comment);
        $this->display();
    }
	
	//审核评论的评论
	public function shenhe(){
		$comment2_id = I("get.comment2_id");
		$flag=M("comment2")->where("comment2_id=".$comment2_id)->save(array('comment2_flag'=>2));
		if($flag){
			$this->success('审核评论的评论成功！',U('comment2/index'),3);
		}else{
			$this->error('审核评论的评论失败！',U('comment2/index'),3);
		}
		
	}
	//删除评论的评论
    public function delcomment2(){
        $comment_id = I("get.comment_id");
        $comment2_id = I("get.comment2_id");
        M("comment2")->where("comment2_id=".$comment2_id)->delete();
		//给评论次数减1
		M('Comment')->where("comment_id=".$comment_id)->setDec('comment_count',1);
       $this->success('删除成功！',U('comment2/index'),3);
    }
	
}