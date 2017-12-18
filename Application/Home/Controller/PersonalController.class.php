<?php
namespace Home\Controller;
use Think\Controller;

/*
 *前端主架构控制器0902
 * controller 控制器
 * action 方法
 * return true/false
 */
class PersonalController extends Controller {

	function __construct() {
		//继承父类
		parent::__construct();

		if(__ACTION=="notify"){
			//
		}else{
			//判断登录状态
			$user_id=session("user_id");
			if($user_id==""){//未登录
			    	header("Location:".U('index/index'));
					exit();
			}
		}
    }

	//空方法，防止报错
	public function _empty(){
        echo "非法操作！！！";
		exit();
    }
	
	//默认首页
    public function index(){
		$this->display('my');
    }
	//个人中心
    public function my(){
       
		$where=" 1 and ec_user.user_id =".session("user_id");
		$userinfo=M('user')
		        ->join('left join ec_viplevel on ec_viplevel.vip_id = ec_user.vip ')
		        ->where($where)
				->field('ec_user.learntime,ec_user.avatar,ec_user.nickname,ec_user.vip,ec_user.score,ec_user.level,ec_viplevel.vip_image')
				->find();
		$this->assign('userinfo',$userinfo);
		//学习时间
		$learntime=sprintf("%.2f", $userinfo['learntime']/60/60).'H';
		$this->assign('learntime',$learntime);
		$this->assign('user_level',D('userlevel')->get_userlevel());//用户等级
		//订阅专题数
		$buyinfo=M('buyinfo')->where(" user_id ='".session("user_id")."' and  buy_flag = 2 and course_id!=0 and buy_endtime>".time()  )->count();
		$this->assign('buyinfo',$buyinfo);
		//按学分排名
		$user=M('user')->order('score desc')->field('user_id')->select();
		$user_score=array();
		foreach($user as $k=>$v){
			$user_score[$k]=$v['user_id'];
		}
		$user_order=array_search(session("user_id"),$user_score);
		$this->assign('user_order',$user_order+1);
		//签到状态
		$t = time();
		//开始时间戳
		$start = mktime(0,0,0,date("m",$t),date("d",$t),date("Y",$t));
		//结束时间戳
		$end = mktime(23,59,59,date("m",$t),date("d",$t),date("Y",$t));
		//判断是否签到
		$where1=" 1 and score_addtime >='".$start."' and score_addtime <='".$end."' and user_id='".session("user_id")."' and scroe_type=2 ";
		$counts=M('scoreinfo')->where($where1)->count();
	    $this->assign('counts',$counts);
		//客服电话，校长电话
		$xiaozhang=M('setinfo')->where('set_id=4')->find();
		$kefuphone=M('setinfo')->where('set_id=2')->find();
		$this->assign('kefuphone',$kefuphone['set_value']);
		$this->assign('xiaozhang',$xiaozhang['set_value']);
		$this->display();
    }
	//升级会员
    public function shengjihuiyuan(){
		$where="user_id=".session("user_id");
		$userinfo=M('user')->join('left join ec_viplevel on ec_viplevel.vip_id = ec_user.vip ')->where($where)->field('nickname,score,level,avatar,vip_image,vip')->find();
		$this->assign('userinfo',$userinfo);//会员信息
		$this->assign('user_level',D('userlevel')->get_userlevel());//用户等级
		//VIP等级
		$viplevel=M('viplevel')->order('vip_id asc')->select();
		$this->assign('viplevel',$viplevel);//会员信息
		$this->display();
    }
	//推荐好友
    public function tuijian(){
		//引入WxpayAPI
        vendor('WxpayAPI.WxPayJsApiPay'); 
		$jsApi = new \JsApiPay();
		$signPackage = $jsApi->GetSignPackage();
		$this->assign('signPackage',$signPackage);
		//帖子id
		$forum_id=I('get.forum_id');

		if($forum_id){
		   $foruminfo=M('forum')->where('forum_id='.$forum_id)->field('forum_title')->find(); 
		   $forum_title=$foruminfo['forum_title'];
		}else{
		   $forum_title="简异思维，你的互联网大学";
		}
		$this->assign('forum_title',$forum_title);
		$this->display();
    }
	//图片链接
    public function tupianlianjie(){
		
		$this->display();
    }
    //选择支付前
    public function proxuanzezhifu(){
    	$vip_id=I("get.vip_id");
    	$where="user_id=".session("user_id");
		if(IS_POST){
			$info=I('info');
			M("user")->where($where)->save($info);
			header("Location:".U('personal/xuanzezhifu',array("vip_id"=>$vip_id)));
		}else{
			$where="user_id=".session("user_id");
			$userinfo=M('user')->where($where)->find();
			$this->assign('userinfo',$userinfo);//会员信息
			
			$this->assign('user_level',D('userlevel')->get_userlevel());//用户等级	
			$this->assign('vip_id',$vip_id);
			$this->display();
		}
    }
	//选择支付
    public function xuanzezhifu(){
		$where="user_id=".session("user_id");
		$userinfo=M('user')->where($where)->field('money,vip')->find();
		$this->assign('userinfo',$userinfo);//会员信息

		//VIP等级
		$vip_id=I('get.vip_id');
		$viplevel=M('viplevel')->where('vip_id ='.$vip_id)->find();
		if(!$viplevel){
			jump("此VIP等级不存在！",U("personal/shengjihuiyuan"));
			exit();
		}
		$this->assign('viplevel',$viplevel);//会员信息
		$this->assign('vip_id',$vip_id);//所购买VIP的id
		$this->display();
    }
	//学习排行榜
    public function xuexipaihangbang(){
		//用户信息
		$where="user_id=".session("user_id");
		$userinfo=M('user')->where($where)->field('nickname,score')->find();
		$this->assign('userinfo',$userinfo);
		//按学分排名
		$user=M('user')->order('score desc')->field('user_id')->select();
		$user_score=array();
		foreach($user as $k=>$v){
			$user_score[$k]=$v['user_id'];
		}
		$user_order=array_search(session("user_id"),$user_score);
		$this->assign('user_order',$user_order+1);
		//排名
		// 查询满足要求的总记录数
		$count    =M('user')
		         ->join('left join ec_userlevel on ec_userlevel.level_id = ec_user.level ')
				 ->field('avatar,nickname,score,level,level_name')
				 ->count();
		$Page     = new \Think\Page($count,10);
		$this->assign('count_',$count);
        $nowpage=$Page->nowRow;
		$userinfos=M('user')
					->join('left join ec_userlevel on ec_userlevel.level_id = ec_user.level ')
				    ->field('avatar,nickname,score,level,level_name')
					->order(' score desc')
					->limit($Page->firstRow.','.$Page->listRows)
					->select();
		$this->assign('user_level',D('userlevel')->get_userlevel());//用户等级	
        foreach($userinfos as $kk=>$vv){
		                 $userinfos[$kk]['paiming']=($kk+1)+($nowpage-1)*($Page->listRows);
		}
	    if(IS_AJAX){
			  if($Page->totalPages>=$p){
				 
				  $this->ajaxReturn(array('userinfos'=>$userinfos));
			  }else{
				  
				  $this->ajaxReturn(array('userinfos'=>array()));
			  }
        } else{
              $this->assign('userinfos',$userinfos);
			  $this->display();
        }		
	
    }
	//签到
    public function qiandao(){
		
		$qiandao=$_POST['id'];  
		if($qiandao){
			$signin=M('setinfo')->where('set_id= 5 ')->find();
			$info['user_id']=session("user_id");
			$info['scroe_type']=2;
			$info['score_score']=$signin['set_value'];
			$info['score_addtime']=TIME();
			$info['score_remarks']="签到送学分".$signin['set_value'];
			
			$t = time();
			//开始时间戳
			$start = mktime(0,0,0,date("m",$t),date("d",$t),date("Y",$t));
			//结束时间戳
			$end = mktime(23,59,59,date("m",$t),date("d",$t),date("Y",$t));
			
	        //判断是否签到
			$where=" 1 and score_addtime >='".$start."' and score_addtime <='".$end."' and user_id='".session("user_id")."' and  scroe_type = 2";

			$counts=M('scoreinfo')->where($where)->count();
			
			if($counts>0){
                $result=0;	
			}else{	
				//增加签到记录（学分增加）
				$result=M('scoreinfo')->add($info);
				//更新会员学分
				M('user')->where('user_id='.session('user_id'))->setInc('score',$signin['set_value']);
			}
			echo json_encode($result);
		}
    }
    //奖学金升级VIP
	public function shengji_jxj() {//之前作废的代码
		$user_id=session("user_id");
        
		if(IS_AJAX){
			$vip_id = I('post.vipid');
			//升级vip金额
			$shengji_money=M('viplevel')->where(' vip_id ='.$vip_id)->field('vip_money,vip_backmoney,vip_year')->find();
		   	$user = M('User')->where(array('user_id'=>session("user_id")))->field('money,refree_id')->find();
		   	if($user['money']>=$shengji_money['vip_money']){
				//更改用户表中的奖学金余额
				$data['vip']=$vip_id;
				$data['vipendtime']=time()+$shengji_money['vip_year']*60*60*24*365;
				$data['money']=$user['money']-$shengji_money['vip_money'];
			   	$result= M('user')->where("user_id='".session("user_id")."'")->save($data);
			   	//同时给buyinfo表添加数据
			   	$buyinfo = M('buyinfo');
				//自定义订单号
				$timeStamps = time();
				$endtime=time()+$shengji_money['vip_year']*60*60*24*365;
                $trade_no = C('WxPayConf.APPID').$timeStamps.random(2);
			  	$result1 = $buyinfo->data(array(
	   					'user_id'=>$user_id, 
						'course_id'=>0,
 						'buy_addtime'=>time(),
						'buy_flag'=>2,
						'buy_type'=>2,
						'buy_no'=>$trade_no,
						'buy_money'=>$shengji_money['vip_money'],
	   					'buy_endtime'=>$endtime,
						'buy_remarks'=>$shengji_money['vip_year']."年VIP学员",
			   	))->add();
				if($user['refree_id']>0){
				   //同时给moneyinfo表添加数据(奖学金变动表)
					$moneyinfo = M('moneyinfo');
					$result3 = $moneyinfo->data(array(
							'user_id'=>$user['refree_id'], 
							'money_type'=>1,
							'money_addtime'=>time(),
							'money_money'=>$shengji_money['vip_backmoney'],
							'money_remarks' => '下级【id='.session('user_id').'】VIP升级返现'.$shengji_money['vip_backmoney'].'元',
					))->add();
				//更新上级用户金额(返佣)
				$result4 = M('User')->where('user_id='.$user['refree_id'])->setInc('money',$shengji_money['vip_backmoney']);
				}
			   	if( $result && $result1 ){
					$this->ajaxreturn(array("flag"=>1));
			   	} else {
					$this->ajaxreturn(array("flag"=>0));
			   	}
		   }
		} else {
			$this->jump('非法操作',U("index/index"),3);
		}
	}
	//微信支付（vip升级）
	public function weixinpayorder(){
		$vip_id = I('get.vip_id');
		if(!$vip_id)jump('微信支付参数错误',U("personal/shengjihuiyuan"),3);
		$user_id=session("user_id");
		//升级vip金额
		$shengji_money=M('viplevel')->where(' vip_id ='.$vip_id)->field('vip_money,vip_year')->find();
		$user = M('User')->where(array('user_id'=>$user_id))->field('money')->find();

		//自定义订单号
        $timeStamp = time();
        $out_trade_no = C('WxPayConf.APPID').$timeStamp.random(2);
		$amount=abs($shengji_money['vip_money']);
		//购买记录
		$buyinfo = M('buyinfo');
		$info_buy=array(
				'user_id'=>$user_id, 
				'course_id'=>0,
				'buy_addtime'=>time(),
				'buy_flag'=>1,
				'buy_type'=>1,
				'buy_no'=>$out_trade_no,
				'buy_money'=>$amount,
				'buy_endtime'=>time()+$shengji_money['vip_year']*60*60*24*365,
				'buy_remarks'=>$shengji_money['vip_year']."年VIP学员",
		);
		$orderbuy_id = $buyinfo->add($info_buy);
		
		$token=md5($orderbuy_id."jysw".$amount);
		$this->redirect('personal/weixinpay', array('vip_id'=>$vip_id,'orderbuy_id'=>$orderbuy_id,'out_trade_no'=>$out_trade_no,'amount'=>$amount,"token"=>$token),0, '页面跳转中...');
	}
	
	//微信支付
	public function weixinpay(){
		
		$orderbuy_id = I('get.orderbuy_id');
		$vip_id = I('get.vip_id');
		$out_trade_no = I('get.out_trade_no');
		$amount = abs(I('get.amount'));
		$token=I("token");
		
		if($token!=md5($orderbuy_id."jysw".$amount)){
			jump('非法操作', U('index/index'),3);
		}

		session("weixinpay_orderid",$orderbuy_id);
		session("weixinpay_out_trade_no",$out_trade_no);

		//引入WxpayAPI
        vendor('WxpayAPI.WxPayJsApiPay'); 
		
		//①、获取用户openid
		$jsApi = new \JsApiPay();
		$openId = $jsApi->GetOpenid();

		//②、统一下单
		//获取客户订单号，微信下单
		$input = new \WxPayUnifiedOrder();
		$input->SetBody('微信支付vip升级'.$amount.'元');//商品描述
		$input->SetAttach($orderbuy_id);//附加数据-订单id
		$input->SetOut_trade_no($out_trade_no);//商户系统内部订单号，要求32个字符内、且在同一个商户号下唯一
		$input->SetTotal_fee(1);//订单总金额，单位为分
		//$input->SetTotal_fee($amount*100);//订单总金额，单位为分
		$input->SetTime_start(date("YmdHis"));//交易起始时间
		$input->SetTime_expire(date("YmdHis", time() + 600));//交易结束时间
		$input->SetGoods_tag("微信支付vip升级");//商品标记
		$input->SetNotify_url(C('WxPayConf.NOTIFY_URL'));//通知地址
		$input->SetTrade_type("JSAPI");//交易类型 取值如下：JSAPI，NATIVE，APP等
		$input->SetOpenid($openId);
		$order = \WxPayApi::unifiedOrder($input);
		$jsApiParameters = $jsApi->GetJsApiParameters($order);

		//获取共享收货地址js函数参数
		//$editAddress = $jsApi->GetEditAddressParameters();
        
        $this->assign('jsApiParameters',$jsApiParameters);
		$token=md5($orderbuy_id."jysw");
		$this->assign('SuccessUrl',U('personal/SuccessUrl',array("vip_id"=>$vip_id,'orderbuy_id'=>$orderbuy_id,"token"=>$token)));//支付成功跳转页面
		$this->assign('FailUrl',U('personal/FailUrl',array("orderbuy_id"=>$orderbuy_id)));//支付失败跳转页面
	
		//echo $jsApiParameters;
        $this->display();
	}
	//支付成功页面
	public function SuccessUrl(){
        $orderbuy_id=I("orderbuy_id");
		$vip_id=I("vip_id");
		$token=I("token");
		$user_id=session("user_id");
		if($token!=md5($orderbuy_id."jysw")){
			jump('非法操作,参数错误！', U('personal/shengjihuiyuan'),3);
		}

		//引入WxpayAPI
        vendor('WxpayAPI.WxPayJsApiPay');
        vendor('WxpayAPI.WxPayNotify');
        //使用通用通知接口
        $notify = new \PayNotify();
		$flag=$notify->Queryorder_out_trade_no(session("weixinpay_out_trade_no"));
		if(!$flag){
			jump('非法操作，订单不存在！', U('personal/shengjihuiyuan'),3);
		}
		//更新购买记录
		$flag2=M("buyinfo")->where("buy_flag=1 and buy_id=".$orderbuy_id." and user_id=".session("user_id"))->save(array("buy_flag"=>2));
		//更改用户表中的vip等级以及到期时间
		$shengji_money=M('viplevel')->where(' vip_id ='.$vip_id)->field('vip_money,vip_backmoney,vip_year')->find();
		$data['vip']=$vip_id;
		$data['vipstarttime']=time();
		$data['vipendtime']=time()+$shengji_money['vip_year']*60*60*24*365;
		$result= M('user')->where("user_id='".$user_id."'")->save($data);
		//同时给moneyinfo表添加数据(奖学金变动表)
		$user = M('User')->where(array('user_id'=>$user_id))->field('money,refree_id')->find();
		if($user['refree_id']>0){
			$moneyinfo = M('moneyinfo');
			$result3 = $moneyinfo->data(array(
					'user_id'=>$user['refree_id'], 
					'money_type'=>1,
					'money_addtime'=>time(),
					'money_money'=>$shengji_money['vip_backmoney'],
					'money_remarks' => '下级【id='.session('user_id').'】VIP升级返现'.$shengji_money['vip_backmoney'].'元',
			))->add();
			//更新上级用户金额(返佣)
			$result4 = M('User')->where('user_id='.$user['refree_id'])->setInc('money',$shengji_money['vip_backmoney']);
		}
		if($flag2 && $result){
			jump('微信支付VIP升级成功', U('personal/my'),3);
		}else{
			jump('非法操作，数据更新失败！,', U('index/index'),3);
		}
	}
	//支付失败页面
	public function FailUrl(){
		$orderbuy_id=I("orderbuy_id");
		
		jump('微信支付vip升级失败', U('personal/shengjihuiyuan'),3);
	}
	//支付通知页面
	public function notify() {
		//引入WxpayAPI
        vendor('WxpayAPI.WxPayJsApiPay');
        vendor('WxpayAPI.WxPayNotify');

        //使用通用通知接口
        $notify = new \PayNotify();
		$flag=$notify->Queryorder_out_trade_no(session("weixinpay_out_trade_no"));
		if($flag){
			M("buyinfo")->where("buy_flag=1 and buy_no='".session("weixinpay_out_trade_no")."'")->save(array("buy_flag"=>2));
			session("weixinpay_orderid","");
			session("weixinpay_out_trade_no","");
		}
		$notify->Handle(false);
    }

}