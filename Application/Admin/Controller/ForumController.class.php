<?php

namespace Admin\Controller;

use Think\Controller;

class ForumController extends Controller {

    function __construct() {
	//继承父类
	parent::__construct();

	//判断登录状态
	if (!D('admininfo')->islogin()) {//未登录
	    $this->error('您尚未登录，请先登录！', U('login/login'), 3);
	}
    }

    //空方法，防止报错
    public function _empty() {
	$this->index();
    }

    //问答列表
    public function index() {
	$where = "1 ";
	$info = I("info");
	if ($info) {
	    @extract($info);
	    if ($keyword) {
		$info['keyword'] = urldecode(trim($info['keyword']));
		$where .= "and ec_user.nickname like '%" . $info['keyword'] . "%' or ec_forum.forum_title like '%" . $info['keyword'] . "%' ";
		$this->assign('keyword', $keyword);
	    }
	    if ($forum_top) {
		$where .= "and ec_forum.forum_top =" . $forum_top . " ";
		$this->assign('forum_top1', $forum_top);
	    }
	    if ($forum_flag) {
		$where .= "and ec_forum.forum_flag =  " . $forum_flag . " ";
		$this->assign('forum_flag1', $forum_flag);
	    }
	    if ($starttime) {
		$info['starttime'] = urldecode(trim($info['starttime']));
		$where .= " and ec_forum.forum_addtime >=" . strtotime($info['starttime'] . "00:00:00") . " ";
		$this->assign('starttime', $info['starttime']);
	    }
	    if ($endtime) {
		$info['endtime'] = urldecode(trim($info['endtime']));
		$where .= " and ec_forum.forum_addtime <=" . strtotime($info['endtime'] . "23:59:59") . " ";
		$this->assign('endtime', $info['endtime']);
	    }
	}

	$forum = M('Forum');
	// 查询满足要求的总记录数
	$count = $forum
		->where($where)
		->join('left join ec_user on ec_forum.user_id=ec_user.user_id')
		->field('ec_forum.*,ec_user.user_id,ec_user.nickname')
		->count();
	$Page = new \Think\Page($count, 15);
	//分页跳转的时候保证查询条件
	if ($info) {
	    foreach ($info as $key => $val) {
		$Page->parameter['info[' . $key . ']'] = urlencode($val);
	    }
	}
	$pageshow = $Page->adminshow();
	// 进行分页数据查询
	$foruminfo = $forum
		->join('left join ec_user on ec_forum.user_id=ec_user.user_id')
		->where($where)
		->order('ec_forum.forum_id desc')
		->field('ec_forum.*,ec_user.user_id,ec_user.nickname')
		->limit($Page->firstRow . ',' . $Page->listRows)
		->select();
	$this->assign('foruminfo', $foruminfo);
	$this->assign('pageshow', $pageshow);
	$this->assign('forum_top', D("Forum")->get_forum_top()); //置顶状态
	$this->assign('forum_flag', D("Forum")->get_forum_flag()); //审核状态
	$this->display();
    }

    //删除问答
    public function delforum() {
	$forum_id = I("get.forum_id");
	if ($forum_id) {
	    M('forum')->where('forum_id=' . $forum_id)->delete();
	    M('forumcomment')->where('forum_id=' . $forum_id)->delete();
	    M('forumcomment2')->where('forum_id=' . $forum_id)->delete();
	    $this->success('问答删除成功！', U('forum/index'), 3);
	} else {
	    $this->error('问答删除失败！', U('forum/index'), 3);
	}
    }

    //审核通过
    public function edituserforum() {
	$forum_id = I("get.forum_id");
	$row = M("forum")->where('forum_id = ' . $forum_id)->save(array('forum_flag' => 2));
	if ($row) {
	    $this->success('审核成功！', U('forum/index'), 3);
	} else {
	    $this->error('审核失败！', U('forum/index'), 3);
	}
    }

    //置顶
    public function edituserforum2() {
	$forum_id = I("get.forum_id");
	$row = M("forum")->where('forum_id = ' . $forum_id)->save(array('forum_top' => 2));
	if ($row) {
	    $this->success('置顶成功！', U('forum/index'), 3);
	} else {
	    $this->error('置顶失败！', U('forum/index'), 3);
	}
    }
    
     //取消置顶
    public function edituserforum3() {
	$forum_id = I("get.forum_id");
	$row = M("forum")->where('forum_id = ' . $forum_id)->save(array('forum_top' =>1));
	if ($row) {
	    $this->success('取消置顶成功！', U('forum/index'), 3);
	} else {
	    $this->error('取消置顶失败！', U('forum/index'), 3);
	}
    }

    //查看回复
    public function forumlist() {
	$where = "1 ";
	$info = I("info");
	$forum_id = I("get.forum_id");  
	if ($info) {
	    @extract($info);
	    if ($keyword) {
		$info['keyword'] = urldecode(trim($info['keyword']));
		$where .= "and ec_user.nickname like '%" . $info['keyword'] . "%' ";
		$this->assign('keyword', $keyword);
	    }
	    if ($comment_top) {
		$where .= "and ec_forumcomment.comment_top =" . $comment_top . " ";
		$this->assign('comment_top1', $comment_top);
	    }
	    if ($starttime) {
		$info['starttime'] = urldecode(trim($info['starttime']));
		$where .= " and ec_forumcomment.addtime >=" . strtotime($info['starttime'] . "00:00:00") . " ";
		$this->assign('starttime', $info['starttime']);
	    }
	    if ($endtime) {
		$info['endtime'] = urldecode(trim($info['endtime']));
		$where .= " and ec_forumcomment.addtime <=" . strtotime($info['endtime'] . "23:59:59") . " ";
		$this->assign('endtime', $info['endtime']);
	    }
	}
	$forumcomment = M('forumcomment');
	// 查询满足要求的总记录数
	$count = $forumcomment
		->join('left join ec_user on ec_forumcomment.user_id=ec_user.user_id')
		->where($where . "and ec_forumcomment.forum_id = '" . $forum_id . "' ")
		->field('ec_forumcomment.*,ec_user.user_id,ec_user.nickname')
		->count();
	$Page = new \Think\Page($count, 15);
	//分页跳转的时候保证查询条件
	if ($info) {
	    foreach ($info as $key => $val) {
		$Page->parameter['info[' . $key . ']'] = urlencode($val);
	    }
	}
	$pageshow = $Page->adminshow();
	$forumcomment1 = $forumcomment
		->join('left join ec_user on ec_forumcomment.user_id=ec_user.user_id')
		->where($where . "and ec_forumcomment.forum_id = '" . $forum_id . " ' ")
		->field('ec_forumcomment.*,ec_user.user_id,ec_user.nickname')
		->order('ec_forumcomment.comment_id desc')
		->select();
	 
	$this->assign('forumcomment', $forumcomment1);
	$this->assign('comment_top', D("Forum")->get_forum_top()); //置顶状态
	$this->assign('forum_id', $forum_id);
	$this->assign('pageshow', $pageshow);
	$this->display();
    }
    
    //删除评论
    public function delforumlist() {
	$comment_id = I("get.comment_id");
	$forum_id = I("get.forum_id");
	if ($comment_id) {   
	    M('forumcomment')->where('comment_id=' . $comment_id)->delete();
	    M('forumcomment2')->where('comment_id=' . $comment_id)->delete();
	    $this->success('评论删除成功！', U('forum/forumlist', array('forum_id' => $forum_id)), 3);
	} else {
	    $this->error('评论删除失败！', U('forum/forumlist', array('forum_id' => $forum_id)), 3);
	}
    }
    
    //置顶
    public function editforumlist() {
	$comment_id = I("get.comment_id");
	$forum_id = I("get.forum_id");
	$row = M("forumcomment")->where('comment_id = ' . $comment_id)->save(array('comment_top' => 2));
	if ($row) {
	    $this->success('置顶成功！', U('forum/forumlist',array('forum_id' => $forum_id)), 3);
	} else {
	    $this->error('置顶失败！', U('forum/forumlist',array('forum_id' => $forum_id)), 3);
	}
    }
    
    //取消置顶
    public function editforumlist1() {
	$comment_id = I("get.comment_id");
	$forum_id = I("get.forum_id");
	$row = M("forumcomment")->where('comment_id = ' . $comment_id)->save(array('comment_top' => 1));
	if ($row) {
	    $this->success('取消置顶成功！', U('forum/forumlist',array('forum_id' => $forum_id)), 3);
	} else {
	    $this->error('取消置顶失败！', U('forum/forumlist',array('forum_id' => $forum_id)), 3);
	}
    }
    
    
    //查看回复的回复
    public function forumlist1() {
	$where = "1 ";
	//帖子标题
	$forum_id = I("get.forum_id");   
	$comment_id = I("get.comment_id");  
	$forum_title = M("forum")
		->where("forum_id = " . $forum_id)
		->field("forum_title")
		->find(); 
	$info = I("info"); 
	$forumcomment2 = M('forumcomment2'); 
	if ($info) {
	    @extract($info);
	    if ($keyword) {
		$info['keyword'] = urldecode(trim($info['keyword']));
		$where .= "and ec_user.nickname like '%" . $info['keyword'] . "%' ";
		$this->assign('keyword', $keyword);
	    }
	    if ($starttime) {
		$info['starttime'] = urldecode(trim($info['starttime']));
		$where .= " and ec_forumcomment2.addtime2 >=" . strtotime($info['starttime'] . "00:00:00") . " ";
		$this->assign('starttime', $info['starttime']);
	    }
	    if ($endtime) {
		$info['endtime'] = urldecode(trim($info['endtime']));
		$where .= " and ec_forumcomment2.addtime2 <=" . strtotime($info['endtime'] . "23:59:59") . " ";
		$this->assign('endtime', $info['endtime']);
	    }
	}

	// 查询满足要求的总记录数
	$count = $forumcomment2
		->join('left join ec_user on ec_forumcomment2.user_id=ec_user.user_id')
		->join('left join ec_forum on ec_forumcomment2.forum_id=ec_forum.forum_id')
		->where($where . "and ec_forumcomment2.comment_id = '" . $comment_id . "' ")
		->field('ec_forumcomment2.*,ec_user.user_id,ec_user.nickname,ec_forum.forum_id,ec_forum.forum_title')
		->count();
	$Page = new \Think\Page($count, 15);
	//分页跳转的时候保证查询条件
	if ($info) {
	    foreach ($info as $key => $val) {
		$Page->parameter['info[' . $key . ']'] = urlencode($val);
	    }
	}
	$pageshow = $Page->adminshow();
	$forumcomment2 = $forumcomment2
		->join('left join ec_user on ec_forumcomment2.user_id=ec_user.user_id')
		->join('left join ec_forum on ec_forumcomment2.forum_id=ec_forum.forum_id')
		->where($where . "and ec_forumcomment2.comment_id = '" . $comment_id . "' ")
		->field('ec_forumcomment2.*,ec_user.user_id,ec_user.nickname,ec_forum.forum_id,ec_forum.forum_title')
		->order('ec_forumcomment2.comment2_id desc')
		->select();
	$this->assign('forum_title', $forum_title);
	$this->assign('forumcomment2', $forumcomment2);
	$this->assign('comment_id', $comment_id);
	$this->assign('forum_id', $forum_id);
	$this->assign('pageshow', $pageshow);
	$this->display();
    }

    

    //删除评论的评论
    public function delforumlist1() {
	$comment2_id = I("get.comment2_id");
	$comment_id = I("get.comment_id"); 
	$forum_id = I("get.forum_id");
	if ($comment2_id) {
	    M('forumcomment2')->where('comment2_id=' . $comment2_id)->delete();
	    $listinfo = M('forumcomment')->where('comment_id=' . $comment_id)->find();
	    M('forumcomment')->where('comment_id=' . $comment_id)->save(array("comment_count" => $listinfo["comment_count"] - 1));
	    $this->success('评论删除成功！', U('forum/forumlist1', array('comment_id' => $comment_id,'forum_id'=>$forum_id)), 3);
	} else {
	    $this->error('评论删除失败！', U('forum/forumlist1', array('comment_id' => $comment_id,'forum_id'=>$forum_id)), 3);
	}
    }
    
    //评论审核列表
    public function forum() {
	$where = "1 ";
	$info = I("info");  
	if ($info) {
	    @extract($info);
	    if ($keyword) {
		$info['keyword'] = urldecode(trim($info['keyword']));
		$where .= "and ec_user.nickname like '%" . $info['keyword'] . "%' ";
		$this->assign('keyword', $keyword);
	    }
	    
	    if ($starttime) {
		$info['starttime'] = urldecode(trim($info['starttime']));
		$where .= " and ec_forumcomment.addtime >=" . strtotime($info['starttime'] . "00:00:00") . " ";
		$this->assign('starttime', $info['starttime']);
	    }
	    if ($endtime) {
		$info['endtime'] = urldecode(trim($info['endtime']));
		$where .= " and ec_forumcomment.addtime <=" . strtotime($info['endtime'] . "23:59:59") . " ";
		$this->assign('endtime', $info['endtime']);
	    }
	}
	$forumcomment = M('forumcomment');
	// 查询满足要求的总记录数
	$count = $forumcomment
		->join('left join ec_user on ec_forumcomment.user_id=ec_user.user_id')
		->where($where . "and ec_forumcomment.comment_flag = 1 ")
		->field('ec_forumcomment.*,ec_user.user_id,ec_user.nickname')
		->count();
	$Page = new \Think\Page($count, 15);
	//分页跳转的时候保证查询条件
	if ($info) {
	    foreach ($info as $key => $val) {
		$Page->parameter['info[' . $key . ']'] = urlencode($val);
	    }
	}
	$pageshow = $Page->adminshow();
	$forumcomment1 = $forumcomment
		->join('left join ec_user on ec_forumcomment.user_id=ec_user.user_id')
		->where($where . "and ec_forumcomment.comment_flag = 1 ")
		->field('ec_forumcomment.*,ec_user.user_id,ec_user.nickname')
		->order('ec_forumcomment.comment_id desc')
		->select(); 
	$this->assign('forumcomment', $forumcomment1);   
	$this->assign('pageshow', $pageshow);
	$this->display(); 
	 
    }
    //评论审核的审核
    public function pass() {
	$comment_id = I("get.comment_id"); 
	$row = M("forumcomment")->where('comment_id = ' . $comment_id)->save(array('comment_flag' => 2));
	if ($row) {
	    $this->success('审核成功！', U('forum/forum'), 3);
	} else {
	    $this->error('审核失败！', U('forum/forum'), 3);
	}
    }
    
    //评论审核删除
    public function delpass() {
	$comment_id = I("get.comment_id");
	$row = M("forumcomment")->where('comment_id = ' . $comment_id)->delete();
	if ($row) {
	    $this->success('删除成功！', U('forum/forum'), 3);
	} else {
	    $this->error('删除失败！', U('forum/forum'), 3);
	}
    }
    
    //评论的评论审核列表
    public function forum2() {
	$where = "1 "; 
	$info = I("info"); 
	$forumcomment2 = M('forumcomment2'); 
	if ($info) {
	    @extract($info);
	    if ($keyword) {
		$info['keyword'] = urldecode(trim($info['keyword']));
		$where .= "and ec_user.nickname like '%" . $info['keyword'] . "%' ";
		$this->assign('keyword', $keyword);
	    }
	    if ($starttime) {
		$info['starttime'] = urldecode(trim($info['starttime']));
		$where .= " and ec_forumcomment2.addtime2 >=" . strtotime($info['starttime'] . "00:00:00") . " ";
		$this->assign('starttime', $info['starttime']);
	    }
	    if ($endtime) {
		$info['endtime'] = urldecode(trim($info['endtime']));
		$where .= " and ec_forumcomment2.addtime2 <=" . strtotime($info['endtime'] . "23:59:59") . " ";
		$this->assign('endtime', $info['endtime']);
	    }
	}

	// 查询满足要求的总记录数
	$count = $forumcomment2
		->join('left join ec_user on ec_forumcomment2.user_id=ec_user.user_id')  
		->where($where . "and ec_forumcomment2.comment2_flag = 1 ")
		->field('ec_forumcomment2.*,ec_user.user_id,ec_user.nickname')
		->count();
	$Page = new \Think\Page($count, 15);
	//分页跳转的时候保证查询条件
	if ($info) {
	    foreach ($info as $key => $val) {
		$Page->parameter['info[' . $key . ']'] = urlencode($val);
	    }
	}
	$pageshow = $Page->adminshow();
	$forumcomment2 = $forumcomment2
		->join('left join ec_user on ec_forumcomment2.user_id=ec_user.user_id') 
		->where($where . "and ec_forumcomment2.comment2_flag = 1 ")
		->field('ec_forumcomment2.*,ec_user.user_id,ec_user.nickname')
		->order('ec_forumcomment2.comment2_id desc')
		->select(); 
	$this->assign('forumcomment2', $forumcomment2); 
	$this->assign('pageshow', $pageshow);
	$this->display();
    }
    
    //评论审核的审核
    public function passtwo() {
	$comment2_id = I("get.comment2_id");
	$info = M('forumcomment2')->where('comment2_id=' . $comment2_id)->find();
	$comment_id = $info['comment_id'];
	M('forumcomment')->where('comment_id=' . $comment_id)->setInc('comment_count',1);
	$row = M("forumcomment2")->where('comment2_id = ' . $comment2_id)->save(array('comment2_flag' => 2));
	if ($row) {
	    $this->success('审核成功！', U('forum/forum2'), 3);
	} else {
	    $this->error('审核失败！', U('forum/forum2'), 3);
	}
    }
    
    //评论审核删除
    public function delpasstwo() {
	$comment2_id = I("get.comment2_id"); 
	$info = M('forumcomment2')->where('comment2_id=' . $comment2_id)->find();
	$comment_id = $info['comment_id']; 
	M('forumcomment')->where('comment_id=' . $comment_id)->setDec('comment_count',1);
	$row = M("forumcomment2")->where('comment2_id = ' . $comment2_id)->delete();
	if ($row) {
	    $this->success('删除成功！', U('forum/forum2'), 3);
	} else {
	    $this->error('删除失败！', U('forum/forum2'), 3);
	}
    }

}
