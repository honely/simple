<?php
namespace Admin\Controller;
use Think\Controller;
class CommentController extends Controller
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
    //评论管理
    public function comment(){
        $where = "1 ";
        $info = I('info');
        if($info) {
            @extract($info);
            //按姓名手机号
            if ($keyword) {
                $info['keyword'] = urldecode(trim($info['keyword']));
                $where .= " and (a.phone like '%" . $info['keyword'] . "%' or a.nickname like '%" . $info['keyword'] . "%')";
                $this->assign('keyword', $info['keyword']);
            }
            //按专题查询
            if ($course) {
                $info['course'] = urldecode(trim($info['course']));
                $where .= " and (b.course_name like '%" . $info['course'] . "%')";
                $this->assign('course', $info['course']);
            }
			 //按课程查询
            if ($lesson) {
                $info['lesson'] = urldecode(trim($info['lesson']));
                $where .= " and (c.lesson_name like '%" . $info['lesson'] . "%')";
                $this->assign('lesson', $info['lesson']);
            }
            //按时间查询
            if ($starttime) {
                $info['starttime'] = urldecode(trim($info['starttime']));
                $where .= " and (ec_comment.addtime >=" . strtotime($info['starttime'] . '00:00:00') . ") ";
                $this->assign('starttime', urldecode($info['starttime']));
            }
            if ($endtime) {
                $info['endtime'] = urldecode(trim($info['endtime']));
                $where .= " and (ec_comment.addtime <=" . strtotime($info['endtime'] . '23:59:59') . ") ";
                $this->assign('endtime', urldecode($info['endtime']));
            }

            //comment_flag
            if($comment_flag){
                $info['comment_flag']=urldecode(trim($info['comment_flag']));
                $where.="and comment_flag ='".$info['comment_flag']."'";
                $this->assign('comment_flag',$info['comment_flag']);
            }
        }
//        }else{
//            $starttime = date("Y-m-d",strtotime("-10 day"));
//            $where.=" and (ec_comment.addtime >=".strtotime($starttime.'00:00:00' ).") ";
//            $this->assign("starttime",$starttime);
//            $endtime=date('Y-m-d');
//            $where.=" and (ec_comment.addtime <=".strtotime($endtime.'23:59:59' ).") ";
//            $this->assign("endtime",$endtime);
//        }
        if($_GET['course_id']){
            $courseID=$_GET['course_id'];
            $courseName=$_GET['course_name'];
            $where.=' and b.course_id ='.$courseID;
            $this->assign('courseID',$courseID);
            $this->assign('courseName',$courseName);
            $this->assign('state',1);

        }
        //dump($where);
        //查询满足要求的总记录数
        $count = M("comment")
                ->where($where)
                ->join(" left join ec_user as a ON a.user_id = ec_comment.user_id")
                ->join(" left join ec_course as b ON b.course_id = ec_comment.course_id")
				->join(" left join ec_lesson as c ON c.lesson_id = ec_comment.lesson_id")
				->join(" left join ec_comment2 as d on b.course_id = d.course_id ")
                ->field('ec_comment.*,a.nickname,a.phone,b.course_id,b.course_name,c.lesson_name as lesson_name,d.comment2_good')
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
        $listinfo = M("comment")
                ->where($where)
                ->join(" left join ec_user as a ON a.user_id = ec_comment.user_id")
                ->join(" left join ec_course as b ON b.course_id = ec_comment.course_id")
                ->join(" left join ec_lesson as c ON c.lesson_id = ec_comment.lesson_id")
				->join(" left join ec_comment2 as d on b.course_id = d.course_id ")
                ->order(" ec_comment.comment_id desc")
                ->field('ec_comment.*,a.nickname,a.phone,b.course_id,b.course_name,c.lesson_name as lesson_name,d.comment2_good')
                ->limit($Page->firstRow.",".$Page->listRows)
                ->select();
        //dump($listinfo);
        //审核状态
        $this->assign('commentFlag',D("focusinfo")->commentFlag());
        $this->assign("pageshow",$Pageshow);
        $this->assign("infolist",$listinfo);
        $this->display();
    }
    //查看内容
    public function huifu(){
        $comment_id = I("get.comment_id");
        $data = M("comment")
                ->join(" left join ec_user as a ON a.user_id = ec_comment.user_id")
                ->join(" left join ec_course as b ON b.course_id = ec_comment.course_id")
                ->where('comment_id='.$comment_id)
                ->field('ec_comment.*,a.nickname,a.phone,b.course_id,b.course_name')
                ->find();
        $this->assign('data',$data);
        $this->display();
    }

    //删除评论
    public function delcollect(){
        $comment_id = I("get.comment_id");
        M("comment")->where("comment_id=".$comment_id)->delete();
		M("Comment2")->where("comment_id=".$comment_id)->delete();
        $this->success("删除成功",U("comment/comment"));
    }
	
	//置顶
	public function up(){
        $comment_id = I("get.comment_id");
        M("comment")->where("comment_id=".$comment_id)->save(array('comment_top'=>2));
        $this->success("置顶成功",U("comment/comment"));
    }
    //审核通过
    public function shenhe(){
        $comment_id = I("get.comment_id");
        M("comment")->where("comment_id=".$comment_id)->save(array('comment_flag'=>2));
        $this->success("审核通过",U("comment/comment"));
    }
	
    //取消置顶
	public function notup(){
        $comment_id = I("get.comment_id");
        M("comment")->where("comment_id=".$comment_id)->save(array('comment_top'=>1));
        $this->success("置顶取消成功",U("comment/comment"));
    }
	
	//查看专题的评论
    public function pinglun(){
		$comment_id = I("get.comment_id");
		$course_name = I("get.course_name");
		$where=" comment_id='".$comment_id."'  ";
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
				->order('ec_comment2.comment2_id desc')
				->limit($Page->firstRow.",".$Page->listRows)
                ->select();
		$this->assign("course_name",$course_name);
		$this->assign("comment_id",$comment_id);
		$this->assign("pageshow",$Pageshow);
        $this->assign('comment',$comment);
        $this->display();
    }
	//删除专题的评论
    public function delcomment(){
		$comment_id = I("get.comment_id");
        $comment2_id = I("get.comment2_id");
        M("comment2")->where("comment2_id=".$comment2_id)->delete();
		//给评论次数减1
		M('Comment')->where("comment_id=".$comment_id)->setDec('comment_count',1);
       $this->success('删除成功！',U('comment/pinglun',array('comment_id'=>$comment_id)),3);
    }
	
}