<?php
namespace Home\Controller;
use Think\Controller;

/*
 *前端主架构控制器0902
 * controller 控制器
 * action 方法
 * return true/false
 */
class BookinfoController extends Controller {
    function __construct()
    {
        parent::__construct();
		//判断登录状态
		$user_id=session("user_id");
		if($user_id==""){//未登录
			header("Location:".U('index/index'));
			exit();
		}
    }
    //空方法，防止报错
    public function _empty(){
        echo "非法操作！！！";
        exit();
    }
    //默认首页
    public function index(){
        $this->display();
    }
    //报名预约
    public function baomingyuyue()
    {
        $user_id=session("user_id");
		$userInfo=M('user')->where('ec_user.user_id = '.$user_id)->field('ec_user.user_id,ec_user.vip')->find();
        $isVip=$userInfo['vip'];
        $work_id=$_GET['work_id'];
        //找到相应的席位和价格；
        $seatInfo=M('seatinfo')->where('work_id ='.$work_id)->select();
        $userInfo=M('user')
            ->where('ec_user.user_id = '.$user_id)
            ->join('left join ec_viplevel on ec_viplevel.vip_id = ec_user.vip')
            ->field('ec_user.user_id,ec_user.avatar,ec_user.nickname,ec_user.level,ec_user.vip,ec_viplevel.vip_image')
            ->find();
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
		$this->assign('isVip',$isVip);
        $this->assign('user_level',D('userlevel')->get_userlevel());
        $this->assign('userInfo',$userInfo);
        $this->assign('seatInfo',$seatInfo);
        $this->assign('work_id',$work_id);
        $this->display();
    }

    //我的预约
    public function wodeyuyue()
    {
        $user_id=session("user_id");
        $book=M('signinfo');
        $count = $book
            ->where('ec_signinfo.pay_flag = 2 and ec_signinfo.user_id='.$user_id)
            ->join(" left join ec_workinfo as a ON a.work_id = ec_signinfo.work_id")
            ->field('a.work_title,a.work_time,a.work_address,ec_signinfo.num')
            ->count();
        $Page       = new \Think\Page($count,6);
        $bookinfo=$book
            ->join(" left join ec_workinfo as a ON a.work_id = ec_signinfo.work_id")
            ->field('a.work_title,a.work_time,a.work_address,ec_signinfo.num')
            ->order('ec_signinfo.sign_id desc')
            ->where('ec_signinfo.pay_flag = 2 and ec_signinfo.user_id='.$user_id)
            ->limit($Page->firstRow.','.$Page->listRows)
            ->select();
        if(IS_AJAX){
            if($Page->totalPages>=$p){
                $this->ajaxReturn(array('bookinfo'=>$bookinfo));
            }else{
                $this->ajaxReturn(array('bookinfo'=>array()));
            }
        } else{
            $this->assign('count',$count);
            $this->assign('bookinfo',$bookinfo);
            $this->display();
        }

    }
    //研习班报名//不能重复报名
    //去报名表查看该课程 该用户是否报过名；
    public function yanxibanbaoming()
    {
        $user_id=session("user_id");
        $work=M('workinfo');
        $bookinfo=$work->order('work_id desc')->find();
        $seatInfo=M('seatinfo')->where('work_id ='.$bookinfo['work_id'])->select();
        if(!empty($bookinfo) && !empty($seatInfo)){
            $workId=$bookinfo['work_id'];
            $where='user_id = '.$user_id.' and pay_flag = 2 and  work_id = '.$workId;
            $signInfo=M('signinfo')->where($where)->select();
            if($signInfo){
                //1表示报过名，不能重复报名
                $signFlag=1;
            }else{
                //2表示没有报名，可以继续报名
                $signFlag=2;
            }
            $this->assign('signFlag',$signFlag);
            $this->assign('bookinfo',$bookinfo);
        }else{
            jump("暂时还没有开班，敬请期待", U("personal/my"));
        }
        $this->display();
    }
    //立即购买
    public function lijigoumai()
    {
        $user_id=session("user_id");
        if (IS_POST)
        {
            $data=I("info");
            $allmoney=0;
            $allnum=0;
            foreach($_POST['money'] as $k=>$v)
            {
                $allnum+=intval($_POST['num'][$k]);
                $allmoney+=intval($_POST['num'][$k])*$_POST['money'][$k];
            }
            $data['isself']?$data['isself']:$data['isself']='2';
            $data['num']=$allnum;
            $data['user_id']=$user_id;
            $data['work_id']=$_POST['work_id'];
            $data['pay_money']=$allmoney;
            $data['sign_addtime']=time();
            //报名表插入数据；
            $signId=M('signinfo')->add($data);
            //研习班报名表-辅助表之席位明细插入数据
            $dalist['sign_id']=$signId;
            $dalist['work_id']=$_POST['work_id'];

            foreach ($_POST['seat'] as $k => $v) {
                $dalist['seat_id']=$_POST['seat'][$k];
                $dalist['seat_num']=intval($_POST['num'][$k]);
                M('signlist')->add($dalist);
            }
            $workContent=M('workinfo')
                ->where('ec_workinfo.work_id ='.$_POST['work_id'])
                ->field('ec_workinfo.work_title')
                ->find();
        }
        //用户余额
        $userMoney=M('user')->where('ec_user.user_id ='.$user_id)->field('money')->find();
        $this->assign('signId',$signId);
        $this->assign('userMoney',$userMoney);
        $this->assign('workContent',$workContent);
        $this->assign('payMoney',$allmoney);
        $this->display();
    }
    //奖学金余额支付购买席位
    public function userMoneyPay()
    {
        $user_id=session("user_id");
        if(IS_AJAX){
            $sign_id = I('post.sign_id');
            //给报名表里面更改支付数据
            $data['pay_type']=2;//用户余额支付
            $data['pay_no']=C('WxPayConf.APPID').time().random(2);
            $data['pay_flag']=2;
            $signInfo=M('signinfo')
                ->where('sign_id = '.$sign_id)
                ->save($data);
            //报名课程所需的金额；
            $signInfo1=M('signinfo')->where('sign_id = '.$sign_id)->field('pay_money')->find();
            $signMoney=$signInfo1['pay_money'];
            //更改用户表中的奖学金余额,用户表余额变动
            $user=M('user')->where('ec_user.user_id = '.$user_id)->setDec('money',$signMoney);
            if( $signInfo && $user ){
                $this->ajaxreturn(array("flag"=>1));
            } else {
                $this->ajaxreturn(array("flag"=>0));
            }
        }else {
            jump('非法操作',U("index/index"),3);
        }
    }
    //微信支付购买席位
    public function weiChatPay(){
        $sign_id = I('get.sign_id');
        if(!$sign_id)jump('微信支付参数错误',U("bookinfo/lijigoumai"),3);
        $user_id=session("user_id");
        //给报名表里面更改支付数据
        //pay_type=1;微信支付
        $data['pay_type']=1;
        $data['pay_no']=C('WxPayConf.APPID').time().random(2);
        $data['pay_flag']=1;
        $signInfo=M('signinfo')
            ->where('sign_id = '.$sign_id)
            ->save($data);
        //报名课程所需的金额；
        $signInfo1=M('signinfo')->where('sign_id = '.$sign_id)->field('pay_money')->find();
        //订单号
        $out_trade_no =$data['pay_no'];
        //总金额
        $amount=abs($signInfo1['pay_money']);
        $token=md5($sign_id."jysw".$amount);
        $this->redirect('bookinfo/weixinpay', array('sign_id'=>$sign_id,'out_trade_no'=>$out_trade_no,'amount'=>$amount,"token"=>$token),0, '页面跳转中...');
    }

    //微信支付
    public function weixinpay(){
        $sign_id = I('get.sign_id');
        $out_trade_no = I('get.out_trade_no');
        $amount = abs(I('get.amount'));
        $token=I("token");
        if($token!=md5($sign_id."jysw".$amount)){
            $this->jump('非法操作', U('index/index'),3);
        }

        session("weixinpay_orderid",$sign_id);
        session("weixinpay_out_trade_no",$out_trade_no);

        //引入WxpayAPI
        vendor('WxpayAPI.WxPayJsApiPay');

        //①、获取用户openid
        $jsApi = new \JsApiPay();
        $openId = $jsApi->GetOpenid();

        //②、统一下单
        //获取客户订单号，微信下单
        $input = new \WxPayUnifiedOrder();
        $input->SetBody('微信支付课程预约购买席位'.$amount.'元');//商品描述
        $input->SetAttach($sign_id);//附加数据-订单id
        $input->SetOut_trade_no($out_trade_no);//商户系统内部订单号，要求32个字符内、且在同一个商户号下唯一
        //$input->SetTotal_fee(1);//订单总金额，单位为分
        $input->SetTotal_fee($amount*100);//订单总金额，单位为分
        $input->SetTime_start(date("YmdHis"));//交易起始时间
        $input->SetTime_expire(date("YmdHis", time() + 600));//交易结束时间
        $input->SetGoods_tag("微信支付课程预约购买席位");//商品标记
        $input->SetNotify_url(C('WxPayConf.NOTIFY_URL_SEAT'));//通知地址
        $input->SetTrade_type("JSAPI");//交易类型 取值如下：JSAPI，NATIVE，APP等
        $input->SetOpenid($openId);
        $order = \WxPayApi::unifiedOrder($input);
        $jsApiParameters = $jsApi->GetJsApiParameters($order);

        //获取共享收货地址js函数参数
        //$editAddress = $jsApi->GetEditAddressParameters();

        $this->assign('jsApiParameters',$jsApiParameters);
        $token=md5($sign_id."jysw");
        $this->assign('SuccessUrl',U('bookinfo/SuccessUrl',array("sign_id"=>$sign_id,"token"=>$token)));//支付成功跳转页面
        $this->assign('FailUrl',U('bookinfo/FailUrl',array("sign_id"=>$sign_id)));//支付失败跳转页面
        //echo $jsApiParameters;
        $this->display();
    }
    //支付成功页面
    public function SuccessUrl(){
        $user_id=session("user_id");
        $sign_id=I("sign_id");
        $token=I("token");
        if($token!=md5($sign_id."jysw")){
            jump('非法操作，参数错误！', U('bookinfo/lijigoumai'),3);
        }
        //引入WxpayAPI
        vendor('WxpayAPI.WxPayJsApiPay');
        vendor('WxpayAPI.WxPayNotify');
        //使用通用通知接口
        $notify = new \PayNotify();
        $flag=$notify->Queryorder_out_trade_no(session("weixinpay_out_trade_no"));
        if(!$flag){
            jump('非法操作，订单不存在！', U('bookinfo/lijigoumai'),3);
        }
        //更改报名表的支付状态
        $updatePayFlag=M('signinfo')->where('sign_id = '.$sign_id)->save(array('pay_flag'=>2));
	
        if($updatePayFlag){
            jump('课程预约成功', U('bookinfo/wodeyuyue'),3);
        }else{
            jump('非法操作，数据更新失败！', U('index/index'),3);
        }
    }
    //支付失败页面
    public function FailUrl(){
        $sign_id=I("sign_id");
        jump('微信支付课程预约失败', U('bookinfo/lijigoumai'),3);
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
          M("signinfo")->where("pay_flag=1 and pay_no='".session("weixinpay_out_trade_no")."'")->save(array('pay_flag'=>2));		
            session("weixinpay_orderid","");
            session("weixinpay_out_trade_no","");
        }
        $notify->Handle(false);
    }


    //发送短信验证码
    public function smsCode()
    {
        $Sendsms = new \Org\Util\Sendsms;
        $tel=I('get.tel');
        $msg=I('get.msg');
        $text="您的验证码是：".$msg."。请不要把验证码泄露给其他人。如非本人操作，可不用理会！";
        $Sendsms->sendmsg($tel,$text);
    }

    //直播
    public function zhibo(){
        //3 判断系统是否开启直播；
        $live_info = M("liveinfo")->where('live_flag=2')->find();
        if ($live_info) { //直播开启
            if ((strtotime($live_info['live_time'] . ":00") - SYS_TIME) > 0) { //可以预约
                $live_info['flag'] = 1;
            } else {
                $live_info['flag'] = 2;
            }

            $this->assign('live_info', $live_info);
        }
        $this->display();
    }

    //章节我的收藏
    public function mycollect(){
        $user_id=session("user_id");
        //dump($user_id);
        //$user_id=1;
        // 查询满足要求的总记录数
        $count      =M("Collectalone")
            ->join("left join  ec_user on ec_user.user_id=ec_collectalone.user_id")
            ->join("left join  ec_lessonalone on ec_lessonalone.lesson_id=ec_collectalone.lesson_id")
            ->field("ec_collectalone.collect_id,ec_collectalone.user_id,ec_user.nickname,ec_lessonalone.lesson_id,ec_lessonalone.lesson_name,ec_lessonalone.lesson_remarks,ec_lessonalone.lesson_image,ec_lessonalone.lesson_ishot ")
            ->where('ec_collectalone.user_id='.$user_id)
            ->count();

        $Page       = new \Think\Page($count,5);
        $collect=M("Collectalone")
            ->join("left join  ec_user on ec_user.user_id=ec_collectalone.user_id")
            ->join("left join  ec_lessonalone on ec_lessonalone.lesson_id=ec_collectalone.lesson_id")
            ->field("ec_collectalone.collect_id,ec_collectalone.user_id,ec_user.nickname,ec_lessonalone.lesson_id,ec_lessonalone.lesson_name,ec_lessonalone.lesson_remarks,ec_lessonalone.lesson_image,ec_lessonalone.lesson_ishot ")
            ->where("ec_collectalone.user_id='".$user_id."'  ")
            ->order('ec_collectalone.collect_id desc ')
            ->limit($Page->firstRow.','.$Page->listRows)
            ->fetchSql(false)
            ->select();
        //dump($collect);
        //加载更多
        if(IS_AJAX){
            if($Page->totalPages>=$p){
                $this->ajaxReturn(array('collect'=>$collect));
            }else{
                $this->ajaxReturn(array('collect'=>array()));
            }
        } else{
            $this->assign("collect",$collect);
            $this->assign("count",$count);
            $this->display();
        }
    }

    //删除收藏
    public function delcollect(){
        $collect_id = I("get.collect_id");
        M("collectalone")->where("collect_id=".$collect_id)->delete();
        jump("删除成功",U("bookinfo/mycollect"));
    }
    //删除收藏(ajax)
    public function del(){
        if(IS_AJAX){
            $collect_id = $_POST['collect_id'];
            $info=M("collectalone")->where("collect_id=".$collect_id)->delete();
            if($info){
                $this->ajaxReturn("删除成功");
            }else{
                $this->ajaxReturn("删除失败");
            }
        }
    }

}