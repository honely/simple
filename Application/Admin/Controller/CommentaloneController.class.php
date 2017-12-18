<?php
namespace Admin\Controller;
use Think\Controller;
class CommentaloneController extends Controller
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
        $where = " 1 ";  
        $info = I('info');
        if($info) {
            @extract($info);
            //按姓名
            if ($keyword) {
                $info['keyword'] = urldecode(trim($info['keyword']));
                $where .= " and  ec_user.nickname like '%" . $info['keyword'] . "%' ";
                $this->assign('keyword', $info['keyword']);
            }
            
			 //按课程名称查询
            if ($lesson) {
                $info['lesson'] = urldecode(trim($info['lesson']));
                $where .= " and (ec_lessonalone.lesson_name like '%" . $info['lesson'] . "%')";
                $this->assign('lesson', $info['lesson']);
            }
            //按时间查询
            if ($starttime) {
                $info['starttime'] = urldecode(trim($info['starttime']));
                $where .= " and (ec_commentalone.addtime >=" . strtotime($info['starttime'] . '00:00:00') . ") ";
                $this->assign('starttime', urldecode($info['starttime']));
            }
            if ($endtime) {
                $info['endtime'] = urldecode(trim($info['endtime']));
                $where .= " and (ec_commentalone.addtime <=" . strtotime($info['endtime'] . '23:59:59') . ") ";
                $this->assign('endtime', urldecode($info['endtime']));
            } 
            if($comment_flag){
                $info['comment_flag']=urldecode(trim($info['comment_flag']));
                $where.=" and ec_commentalone.comment_flag ='".$info['comment_flag']."'";
                $this->assign('comment_flag',$info['comment_flag']);
            }  
        }
    
        
        //查询满足要求的总记录数
        $count = M("commentalone")
                ->where($where)
                ->join(" left join ec_user  ON ec_user.user_id = ec_commentalone.user_id") 
				->join(" left join ec_lessonalone  ON ec_lessonalone.lesson_id = ec_commentalone.lesson_id")
				->join(" left join ec_comment2alone  on ec_comment2alone.comment_id = ec_commentalone.comment_id ")
                 ->field("ec_commentalone.*,ec_user.nickname,ec_lessonalone.lesson_name,ec_comment2alone.comment_id as id")
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
        $listinfo = M("commentalone")
                ->where($where)
                ->join(" left join ec_user  ON ec_user.user_id = ec_commentalone.user_id") 
                ->join(" left join ec_lessonalone  ON ec_lessonalone.lesson_id = ec_commentalone.lesson_id")
                ->join(" left join ec_comment2alone  on ec_comment2alone.comment_id = ec_commentalone.comment_id ") 
                ->field("ec_commentalone.*,ec_user.nickname,ec_lessonalone.lesson_name,ec_comment2alone.comment_id as id")
                ->order("ec_commentalone.comment_top desc,ec_commentalone.comment_id desc")
                ->limit($Page->firstRow.",".$Page->listRows)
                ->select();

        //审核状态  
        $this->assign('commentFlag',D("focusinfo")->commentFlag());
        $this->assign("pageshow",$Pageshow);
        $this->assign("infolist",$listinfo);
        $this->display();
    }
    //查看内容
    public function huifu(){ 
        $comment_id = I("get.comment_id");
        $data = M("commentalone")
                ->join(" left join ec_user  ON ec_user.user_id = ec_commentalone.user_id")
                ->join(" left join ec_lessonalone   ON ec_lessonalone.lesson_id = ec_commentalone.lesson_id")
                ->where('comment_id='.$comment_id)
                ->field('ec_commentalone.*,ec_user.nickname,ec_user.phone,ec_lessonalone.lesson_name')
                ->find();

        $this->assign('data',$data);
        $this->display();
    }

    //删除评论
    public function delcollect(){
        $comment_id = I("get.comment_id");
        M("commentalone")->where("comment_id=".$comment_id)->delete();
		M("comment2alone")->where("comment_id=".$comment_id)->delete();
        $this->success("删除成功",U("commentalone/comment"));
    }
	
	//置顶
	public function up(){
        $comment_id = I("get.comment_id");
        M("commentalone")->where("comment_id=".$comment_id)->save(array('comment_top'=>2));
        $this->success("置顶成功",U("commentalone/comment"));
    }
    //审核通过
    public function shenhe(){
        $comment_id = I("get.comment_id");
        M("commentalone")->where("comment_id=".$comment_id)->save(array('comment_flag'=>2));
        $this->success("审核通过",U("commentalone/comment"));
    }
	
    //取消置顶
	public function notup(){
        $comment_id = I("get.comment_id");
        M("commentalone")->where("comment_id=".$comment_id)->save(array('comment_top'=>1));
        $this->success("置顶取消成功",U("commentalone/comment"));
    } 




     
    public function comments(){
        $lesson_id = I('get.lesson_id'); 
        
        $where = " 1 and ec_lessonalone.lesson_id='".$lesson_id."' ";
        $lesson = M('lessonalone')->where("lesson_id = '".$lesson_id."' ")->field("lesson_name,lesson_id")->find();
        $this->assign("lesson",$lesson);
        
        $info = I('info');
        if($info) {
            @extract($info); 
            //按姓名
            if ($keyword) {
                $info['keyword'] = urldecode(trim($info['keyword']));
                $where .= " and  ec_user.nickname like '%" . $info['keyword'] . "%' ";
                $this->assign('keyword', $info['keyword']);
            }  
            //按时间查询
            if ($starttime) {
                $info['starttime'] = urldecode(trim($info['starttime']));
                $where .= " and (ec_commentalone.addtime >=" . strtotime($info['starttime'] . '00:00:00') . ") ";
                $this->assign('starttime', urldecode($info['starttime']));
            }
            if ($endtime) {
                $info['endtime'] = urldecode(trim($info['endtime']));
                $where .= " and (ec_commentalone.addtime <=" . strtotime($info['endtime'] . '23:59:59') . ") ";
                $this->assign('endtime', urldecode($info['endtime']));
            } 
            if($comment_flag){
                $info['comment_flag']=urldecode(trim($info['comment_flag']));
                $where.=" and ec_commentalone.comment_flag ='".$info['comment_flag']."'";
                $this->assign('comment_flag',$info['comment_flag']);
            } 

        }
    
        
        //查询满足要求的总记录数
        $count = M("commentalone")
                ->where($where)
                ->join(" left join ec_user  ON ec_user.user_id = ec_commentalone.user_id") 
                ->join(" left join ec_lessonalone  ON ec_lessonalone.lesson_id = ec_commentalone.lesson_id")
                ->join(" left join ec_comment2alone  on ec_comment2alone.comment_id = ec_commentalone.comment_id ")
                 ->field("ec_commentalone.*,ec_user.nickname,ec_lessonalone.lesson_name,ec_comment2alone.comment_id as id")
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
        $listinfo = M("commentalone")
                ->where($where)
                ->join(" left join ec_user  ON ec_user.user_id = ec_commentalone.user_id") 
                ->join(" left join ec_lessonalone  ON ec_lessonalone.lesson_id = ec_commentalone.lesson_id")
                ->join(" left join ec_comment2alone  on ec_comment2alone.comment_id = ec_commentalone.comment_id ") 
                ->field("ec_commentalone.*,ec_user.nickname,ec_lessonalone.lesson_name,ec_comment2alone.comment_id as id")
                ->order("ec_commentalone.comment_top desc,ec_commentalone.comment_id desc")
                ->limit($Page->firstRow.",".$Page->listRows)
                ->fetchSql(false)
                ->select();  
        //审核状态  
        $this->assign('commentFlag',D("focusinfo")->commentFlag());
        $this->assign("pageshow",$Pageshow);
        $this->assign("infolist",$listinfo);
        $this->display();
    }  
    //查看内容
    public function huifus(){ 
        $comment_id = I("get.comment_id"); 
        $data = M("commentalone")
                ->join(" left join ec_user  ON ec_user.user_id = ec_commentalone.user_id")
                ->join(" left join ec_lessonalone   ON ec_lessonalone.lesson_id = ec_commentalone.lesson_id")
                ->where('comment_id='.$comment_id)
                ->field('ec_commentalone.*,ec_user.nickname,ec_user.phone,ec_lessonalone.lesson_name')
                ->find(); 
        $this->assign('data',$data);
        $this->display();
    }

    //删除评论
    public function delcollects(){
        $comment_id = I("get.comment_id");
        $lesson_id = I("get.lesson_id");  
        M("commentalone")->where("comment_id=".$comment_id)->delete();
        M("comment2alone")->where("comment_id=".$comment_id)->delete();
        $this->success("删除成功",U("commentalone/comments",array('lesson_id'=>$lesson_id)));
    }
    
    //置顶
    public function ups(){
        $comment_id = I("get.comment_id");
        $lesson_id = I("get.lesson_id"); 
        M("commentalone")->where("comment_id=".$comment_id)->save(array('comment_top'=>2));
        $this->success("置顶成功",U("commentalone/comments",array('lesson_id'=>$lesson_id)));
    }
    //审核通过
    public function shenhes(){
        $comment_id = I("get.comment_id");
        $lesson_id = I("get.lesson_id"); 
        M("commentalone")->where("comment_id=".$comment_id)->save(array('comment_flag'=>2));
        $this->success("审核通过",U("commentalone/comments",array('lesson_id'=>$lesson_id)));
    }
    
    //取消置顶
    public function notups(){
        $comment_id = I("get.comment_id");
        $lesson_id = I("get.lesson_id"); 
        M("commentalone")->where("comment_id=".$comment_id)->save(array('comment_top'=>1));
        $this->success("置顶取消成功",U("commentalone/comments",array('lesson_id'=>$lesson_id)));
    }  
	
}