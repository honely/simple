<?php

namespace Home\Controller;

use Think\Controller;

/*
 * 前端主架构控制器0902
 * controller 控制器
 * action 方法
 * return true/false
 */

class ForumController extends Controller {

    function __construct() {
	//继承父类
	parent::__construct();
	    //判断登录状态
		$user_id=session("user_id");
		if($user_id==""){//未登录
				header("Location:".U('index/index'));
				exit();
		}

    }

    //空方法，防止报错
    public function _empty() {
	echo "非法操作！！！";
	exit();
    }

    //默认首页
    public function index() {
	$user_id = session("user_id"); 
	
	if ($user_id == "") {
	    
	} else {
	    //用户信息
	    $userinfo = M("user")
		    ->join("left join ec_userlevel on ec_user.level = ec_userlevel.level_id")
		    ->join("left join ec_viplevel on ec_user.vip = ec_viplevel.vip_id")
		    ->where("ec_user.user_id=" . $user_id)
		    ->field("ec_user.*,ec_viplevel.vip_id,ec_viplevel.vip_image,ec_userlevel.level_id,ec_userlevel.level_name")
		    ->find();
	    $this->assign("userinfo", $userinfo);
	}
	//轮播图
	$banner = M("focusinfo")
		->where("focus_type=3")
		->order("focus_sort desc")
		->limit(3)
		->select();
	//讨论内容
	//计算数量
	$count = M('forum')
		->join("left join ec_user on ec_forum.user_id = ec_user.user_id")
		->join("left join ec_viplevel on ec_user.vip = ec_viplevel.vip_id")
		->where("ec_forum.forum_flag = 2")
		->field("ec_forum.*,ec_user.nickname,ec_user.avatar,ec_viplevel.vip_id,ec_viplevel.vip_image")
		->count();
	$Page = new \Think\Page($count, 5);
	$forum = M("forum")
		->join("left join ec_user on ec_forum.user_id = ec_user.user_id")
		->join("left join ec_viplevel on ec_user.vip = ec_viplevel.vip_id")
		->where("ec_forum.forum_flag = 2")
		->field("ec_forum.*,ec_user.nickname,ec_user.avatar,ec_viplevel.vip_id,ec_viplevel.vip_image")
		->limit($Page->firstRow . ',' . $Page->listRows) 
		->order("ec_forum.forum_top desc,ec_forum.forum_id desc,ec_forum.forum_addtime desc")
		->select();	
	//计算评论次数
	foreach ($forum as $k => $v) {
	    $discuss = M("forumcomment")
		    ->where("forum_id='".$v["forum_id"]."' and comment_flag=2 ")
		    ->count();
	    $forum[$k]["forum_discuss"] = $discuss;
	}  
	foreach ($forum as $k => $v) {
	    $forum[$k]["forum_addtime"] = from_time($v['forum_addtime']);
	}
	if (IS_AJAX) {
	    if ($Page->totalPages >= $p) {
		$this->ajaxReturn(array('forum' => $forum));
	    } else {
		$this->ajaxReturn(array('forum' => array()));
	    }
	} else {
	    $this->assign("count", $count);
	    $this->assign("forum", $forum);
	    $this->assign("banner", $banner);
	    $this->display();
	}
    }

    //发布话题
    public function addforum() {
	$user_id = session("user_id");
	if ($user_id == "") {
	    jump('您尚未登录，请先登录！', U('index/index'));
	}
	if (IS_POST) {
	    $title = filterEmoji(I("post.title"));
	    $content = filterEmoji(I("post.content"));
	    if ($title == "" || $content == "") {
		jump('标题或内容为空,发布话题失败！', U('forum/index'));
	    } else {
		$info = array(
		    "forum_title" => $title,
		    "forum_content" => $content,
		    'forum_addtime' => SYS_TIME,
		    'user_id' => $user_id,
		    'forum_top' => 1,
		    'forum_flag' => 1,
		);
		$flag = M("forum")->add($info);
		if ($flag) {
		    jump('发布话题成功,等待后台审核！', U('forum/index'));
		} else {
		    jump('发布话题失败！', U('forum/index'));
		}
	    }
	}
    }

    //index浏览次数加1
    public function addview() {
	$forum_id = I('forum_id');
	$res = M("Forum")->where("forum_id='" . $forum_id . "'")->setInc('forum_view', 1);
	$row = M("Forum")->where("forum_id='" . $forum_id . "'")->find();
	$forum_view = $row['forum_view'];
	    if ($res) {
			$response = array(
			'errno' => 0,
			'forumview' => $forum_view,
			);
		} else {
			$response = array(
			'errno' => -1,
			);
		}
		echo json_encode($response);
    }

    //话题详情加话题评论
    public function foruminfo() {
	$forum_id = I("forum_id");
	$forum = M("forum")
		->join("left join ec_user on ec_forum.user_id = ec_user.user_id")
		->join("left join ec_viplevel on ec_user.vip = ec_viplevel.vip_id")
		->where("ec_forum.forum_flag = 2 and ec_forum.forum_id=" . $forum_id)
		->field("ec_forum.*,ec_user.nickname,ec_user.avatar,ec_viplevel.vip_id,ec_viplevel.vip_image")
		->find(); 
	//计算评论次数 
	$discuss = M("forumcomment")
		->where("forum_id='" . $forum['forum_id']."' and comment_flag=2")
		->count();
	$forum["forum_discuss"] = $discuss;
	$forum["forum_addtime"] = from_time($forum['forum_addtime']);
	//第一层评论内容
	//计算数量
	$count = M('forumcomment')
		->join("left join ec_user on ec_user.user_id = ec_forumcomment.user_id")
		->join("left join ec_viplevel on ec_user.vip = ec_viplevel.vip_id")
		->where("ec_forumcomment.forum_id= '".$forum_id."' and ec_forumcomment.comment_flag=2")
		->field("ec_forumcomment.*,ec_user.nickname,ec_user.avatar,ec_viplevel.vip_id,ec_viplevel.vip_image")
		->count();
	$Page = new \Think\Page($count, 5);
	$forumcomment = M("forumcomment")
		->join("left join ec_user on ec_user.user_id = ec_forumcomment.user_id")
		->join("left join ec_viplevel on ec_user.vip = ec_viplevel.vip_id")
		->where("ec_forumcomment.forum_id= '".$forum_id."' and ec_forumcomment.comment_flag=2")
		->field("ec_forumcomment.*,ec_user.nickname,ec_user.avatar,ec_viplevel.vip_id,ec_viplevel.vip_image")
		->limit($Page->firstRow . ',' . $Page->listRows)
		->order("ec_forumcomment.comment_top desc,ec_forumcomment.addtime desc,ec_forumcomment.comment_id desc")
		->select();  
	foreach ($forumcomment as $k => $v) {
	    $forumcomment[$k]["addtime"] = from_time($v['addtime']);
	}  
	if (IS_AJAX) {
	    if ($Page->totalPages >= $p) {
		$this->ajaxReturn(array('forumcomment' => $forumcomment));
	    } else {
		$this->ajaxReturn(array('forum' => array()));
	    }
	} else {
	    $this->assign("forum", $forum);
	    $this->assign("forumcomment", $forumcomment);
	    $this->assign("count", $count);
	    $this->display();
	}
    }

    //评论 
    public function forumcomment() {
	header("Expires:-1");
	header("Cache-Control:no_cache");
	header("Pragma:no-cache");
	$user_id = session("user_id");
	$forum_id = I("get.forum_id");
	if ($user_id == "") {
	    jump('您尚未登录，请先登录！', U('index/index'));
	}
	if (IS_POST) {
	    $comment = filterEmoji(I("post.comment"));
	    if ($comment == "") {
		jump('内容为空,评论失败！', U('forum/foruminfo', array('forum_id' => $forum_id)));
	    } else {
		$info = array(
		    "forum_id" => $forum_id,
		    "comment" => $comment,
		    'addtime' => SYS_TIME,
		    'user_id' => $user_id,
		    'comment_top' => 1,
		    'comment_flag' => 1,
		);
		$flag = M("forumcomment")->add($info); 
		if ($flag) {
		    jump('评论成功,等待后台审核！', U('forum/foruminfo', array('forum_id' => $forum_id)));
		} else {
		    jump('评论失败！', U('forum/foruminfo', array('forum_id' => $forum_id)));
		}
	    }
	}
    }

    //给forum点赞
    public function praise() {
	$user_id = session("user_id");
	$forum_id = I('post.forum_id');
	if ($user_id == "") {
	    $response = array(
		'errno' => 0,
	    );
	} else {
	    $sql = M("Forum")->where("forum_id='" . $forum_id . "'")->setInc('forum_good', 1);
	    $num = M("Forum")->where("forum_id='" . $forum_id . "'")->find();
	    $forum_good = $num['forum_good'];
	    if ($sql) {
		$response = array(
		    'errno' => 1,
		    'forum_good' => $forum_good,
		);
	    } else {
		$response = array(
		    'errno' => -1,
		);
	    }
	}
	echo json_encode($response);
    }

    //给forumcomment点赞
    public function support() {
	$user_id = session("user_id");
	$forum_id = I('post.forum_id');
	$comment_id = I('post.comment_id');
	if ($user_id == "") {
	    $response = array(
		'errno' => 0,
	    );
	} else {
	    $sql = M("forumcomment")->where("forum_id='" . $forum_id . "' and comment_id='" . $comment_id . "' ")->setInc('comment_good', 1);
	    $res = M("forumcomment")->where("forum_id='" . $forum_id . "' and comment_id='" . $comment_id . "' ")->find();
	    $comment_good = $res['comment_good'];
	    if ($sql) {
		$response = array(
		    'errno' => 1,
		    'comment_good' => $comment_good,
		);
	    } else {
		$response = array(
		    'errno' => -1,
		);
	    }
	}
	echo json_encode($response);
    }

    //评论的评论
    public function forumcommentinfo() {
	$user_id = session("user_id");
	$forum_id = I("get.forum_id");
	$comment_id = I("get.comment_id");
	//上层显示第一层评论
	$forumcomment = M("forumcomment")
		->join("left join ec_user on ec_forumcomment.user_id = ec_user.user_id")
		->join("left join ec_viplevel on ec_user.vip = ec_viplevel.vip_id")
		->field("ec_forumcomment.*,ec_user.nickname,ec_user.avatar,ec_viplevel.vip_id,ec_viplevel.vip_image")
		->where("ec_forumcomment.comment_id=" . $comment_id)
		->find();
	$forumcomment["addtime"] = from_time($forumcomment['addtime']);
	//全部评论的评论
	//计算数量
	$count = M('forumcomment2')
		->join("left join ec_user on ec_forumcomment2.user_id = ec_user.user_id")
		->join("left join ec_viplevel on ec_user.vip = ec_viplevel.vip_id")
		->where("ec_forumcomment2.comment_id='".$comment_id."'and ec_forumcomment2.comment2_flag=2 ")
		->field("ec_forumcomment2.*,ec_user.nickname,ec_user.avatar,ec_viplevel.vip_id,ec_viplevel.vip_image")
		->count();
	$Page = new \Think\Page($count, 5);
	$forumcomment2 = M("forumcomment2")
		->join("left join ec_user on ec_forumcomment2.user_id = ec_user.user_id")
		->join("left join ec_viplevel on ec_user.vip = ec_viplevel.vip_id")
		->where("ec_forumcomment2.comment_id='".$comment_id."'and ec_forumcomment2.comment2_flag=2 ")
		->field("ec_forumcomment2.*,ec_user.nickname,ec_user.avatar,ec_viplevel.vip_id,ec_viplevel.vip_image")
		->limit($Page->firstRow . ',' . $Page->listRows)
		->order("ec_forumcomment2.addtime2 desc")
		->select();
	foreach ($forumcomment2 as $k => $v) {
	    $forumcomment2[$k]["addtime2"] = from_time($v['addtime2']);
	}
	if (IS_AJAX) {
	    if ($Page->totalPages >= $p) {
		$this->ajaxReturn(array('forumcomment2' => $forumcomment2));
	    } else {
		$this->ajaxReturn(array('forumcomment2' => array()));
	    }
	} else {
	    $this->assign("forumcomment", $forumcomment);
	    $this->assign("count", $count);
	    $this->assign("forumcomment2", $forumcomment2);
	    $this->display();
	}
    }

    //评论 
    public function forumcommentadd2() {
	$user_id = session("user_id");
	$forum_id = I("get.forum_id");
	$comment_id = I("get.comment_id");
	if ($user_id == "") {
	    jump('您尚未登录，请先登录！', U('index/index'));
	}
	if (IS_POST) {
	    $comment2 = filterEmoji(I("post.comment2"));
	    if ($comment2 == "") {
		jump('内容为空,评论失败！', U('forum/forumcommentinfo', array('forum_id' => $forum_id, 'comment_id' => $comment_id)));
	    } else {
		$info = array(
		    "forum_id" => $forum_id,
		    "comment_id" => $comment_id,
		    'addtime2' => SYS_TIME,
		    'user_id' => $user_id,
		    'comment2' => $comment2, 
		    'comment2_flag' => 1,
		);
		$flag = M("forumcomment2")->add($info);
		//每次评论给forumcomment加1
		//$sql = M("forumcomment")->where("comment_id='" . $comment_id . "'")->setInc('comment_count', 1);
		if ($flag) {
		    jump('评论成功,等待后台审核!', U('forum/forumcommentinfo', array('forum_id' => $forum_id, 'comment_id' => $comment_id)));
		} else {
		    jump('评论失败！', U('forum/forumcommentinfo', array('forum_id' => $forum_id, 'comment_id' => $comment_id)));
		}
	    }
	}
    }

    //给forumcomment2点赞
    public function thumbs_up() {
	$user_id = session("user_id");
	$forum_id = I('post.forum_id');
	$comment2_id = I('post.comment2_id');
	if ($user_id == "") {
	    $response = array(
		'errno' => 0,
	    );
	} else {
	    $sql = M("forumcomment2")->where("forum_id='" . $forum_id . "' and comment2_id='" . $comment2_id . "' ")->setInc('comment2_good', 1);
	    $res = M("forumcomment2")->where("forum_id='" . $forum_id . "' and comment2_id='" . $comment2_id . "' ")->find();
	    $comment2_good = $res['comment2_good'];
	    if ($sql) {
				$response = array(
					'errno' => 1,
					'comment2_good' => $comment2_good,
				);
			} else {
				$response = array(
					'errno' => -1,
				);
	        }
	}
	echo json_encode($response);
    }

}
