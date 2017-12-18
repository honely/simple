<?php
namespace Admin\Controller;
use Think\Controller;
//系统主架构控制器0808
/*
 * controller 控制器
 * action 方法
 * return true/false
 */
class IndexController extends Controller {

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
	
	//默认首页
    public function index(){
		$this->display();
    }

	//欢迎页
	public function welcome(){
		//会员（全部会员个数）
		$user_count=M('user')->where('1')->count();
		$user_count=$user_count?$user_count:0;
		$user_info['user_count']=$user_count;
		//VIP（全部VIP个数）
		$user_vip_count=M('user')->where('vip!=0')->count();
		$user_vip_count=$user_vip_count?$user_vip_count:0;
		$user_info['user_vip_count']=$user_vip_count;
		//订阅金额（全部购买金额）
		$user_buy_money=M('buyinfo')->where('buy_flag=2')->sum('buy_money');
		$user_buy_money=$user_buy_money?$user_buy_money:0;
		$user_info['user_buy_money']=$user_buy_money;
		//购买课程金额（全部购买金额）
		$user_buy_lesson=M('buyinfoalone')->where('buy_flag=2')->sum('buy_money');
		$user_buy_lesson=$user_buy_lesson?$user_buy_lesson:0;
		$user_info['user_buy_lesson']=$user_buy_lesson;
		//充值金额（全部充值金额）
		$user_pay_money=M('payinfo')->where('pay_flag=2')->sum('pay_money');
		$user_pay_money=$user_pay_money?$user_pay_money:0;
		$user_info['user_pay_money']=$user_pay_money;
		//奖金金额（全部奖学金金额）
		//$user_money_money=M('moneyinfo')->where('1')->sum('money_money');//变动记录合计
		$user_money_money=M('user')->where('1')->sum('money');
		$user_money_money=$user_money_money?$user_money_money:0;
		$user_info['user_money_money']=$user_money_money;
		//论坛未审核
		$forum=M('forum')->where('forum_flag=1')->count();
		$forum=$forum?$forum:0;
		$user_info['forum']=$forum;
		//评论未审核
		$forumcomment=M('forumcomment')->where('comment_flag=1')->count();
		$forumcomment=$forumcomment?$forumcomment:0;
		$user_info['forumcomment']=$forumcomment;
		//评论的评论未审核
		$forumcomment2=M('forumcomment2')->where('comment2_flag=1')->count();
		$forumcomment2=$forumcomment2?$forumcomment2:0;
		$user_info['forumcomment2']=$forumcomment2;
		//专题评论的评论未审核
		$comment=M('comment')->where('comment_flag=1')->count();
		$comment=$comment?$comment:0;
		$user_info['comment']=$comment;
		//专题评论的评论未审核
		$comment2=M('comment2')->where('comment2_flag=1')->count();
		$comment2=$comment2?$comment2:0;
		$user_info['comment2']=$comment2;

		//课程评论的评论未审核
		$commentalone=M('commentalone')->where('comment_flag=1')->count();
		$commentalone=$commentalone?$commentalone:0;
		$user_info['commentalone']=$commentalone;
		//课程评论的评论未审核
		$comment2alone=M('comment2alone')->where('comment2_flag=1')->count();
		$comment2alone=$comment2alone?$comment2alone:0;
		$user_info['comment2alone']=$comment2alone;
		//dd($user_buy_money);
		$this->assign('user_info',$user_info);
		$this->display();
    }

	//顶部菜单
	public function top(){
	
		$this->display();
    }

	//左边菜单
	public function left(){
		$group_id = session('admin.adminrole',"");//管理员role
		$groupinfo=F('group_menu_'.$group_id);//获取本管理员组的group_menu缓存数组
		if($groupinfo==""){
			$this->error('您尚无此操作权限！',U('index/welcome'),3);
		}
		$groupinfo=join(",",$groupinfo);
	
		//左侧一级菜单
			$menuinfo=M("adminmenu")->where("menu_fatherid=0 and menu_type=1 and menu_id in (".$groupinfo.")")->order('sort desc,menu_id asc')->fetchsql(false)->order('sort desc,menu_id asc')->select();

		//dd($menuinfo);
		foreach($menuinfo as $k=>$v){
			//左侧二级菜单
			$menuinfo[$k]['child']=M("adminmenu")->where("menu_fatherid=".$v['menu_id']." and menu_type=1  and menu_id in (".$groupinfo.")")->order('sort desc,menu_id asc')->select();
			
			foreach($menuinfo[$k]['child'] as $m=>$v){
				//左侧三级菜单
				$menuinfo[$k]['child'][$m]['childchild']=M("adminmenu")->where("menu_fatherid=".$v['menu_id']." and menu_type=1  and menu_id in (".$groupinfo.")")->order('sort desc,menu_id asc')->select();
				
			}
		}
		$this->assign('menuinfo',$menuinfo);
		
		$this->display();
    }
}