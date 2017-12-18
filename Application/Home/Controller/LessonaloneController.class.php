<?php

namespace Home\Controller;

use Think\Controller;

/*
 * 单独课程控制器
 */

class LessonaloneController extends Controller {

    function __construct() {
        //继承父类
        parent::__construct();
        //判断是否在微信中打开
        if (__ACTION == "notify") {
            //
        } else {
            //判断登录状态
            $user_id = session("user_id");
            if ($user_id == "") {//未登录
                header("Location:" . U('index/index'));
                exit();
            }
        }
    }

    //空方法，防止报错
    public function _empty() {
        echo "非法操作！！！";
        exit();
    }
	//视频播放
    public function video() {
        $user_id = session('user_id');
        //查课程lesson
        $lessons = M("Lessonalone")->where("lesson_isable=1")->order("lesson_sort desc,lesson_id asc")->select();
        if(!$lessons){
            jump("您要查看的课程不存在", U("index/index"));
        }
		//当前课程
        $current_lesson_id = I("lesson_id") ? I("lesson_id") : $lessons[0]["lesson_id"];
        $margin = 0;
        foreach ($lessons AS $k => $v) {
            if ($v['lesson_id'] == $current_lesson_id) {
                $margin = $k;
            }
        }
        $current_lesson = M("lessonalone")->find($current_lesson_id);
        if(!$current_lesson){
            jump("您要查看的课程不存在", U("index/index"));
        }
        //lesson浏览量
        $current_lesson['lesson_image'] = explode("|", $current_lesson['lesson_image']);
        $user_auth=D("Lessonalone")->user_auth_lesson($current_lesson_id);
		D("Lessonalone")->lll($current_lesson_id);
		if($current_lesson['lesson_money']){
			if (!$user_auth) {
				$current_lesson['lesson_audio'] = $current_lesson['lesson_try_audio'];
				$current_lesson['lesson_video'] = $current_lesson['lesson_try_video'];
			}
		}else{//0元价格
			//
		}
		/*2017-12-16去掉评论
        //评论
        $count = D("comment")
            ->where("lesson_id=" . $current_lesson_id . " AND comment_flag=2")
            ->count();
        $Page = new \Think\Page($count, 5);
        //评论按照时间倒序
        $lessoncomment['commentsalone'] = D("commentalone")
            ->field("ec_commentalone.*,ec_user.avatar,ec_user.nickname")
            ->join("LEFT JOIN ec_user ON ec_user.user_id=ec_commentalone.user_id")
            ->where("ec_commentalone.lesson_id=" . $current_lesson_id . " AND ec_commentalone.comment_flag=2")
            ->limit($Page->firstRow . ',' . $Page->listRows)
            ->order("ec_commentalone.comment_top desc,ec_commentalone.addtime DESC")
            ->select();
        //评论的评论
        foreach ($lessoncomment['commentsalone'] AS $k => $v) {
            $lessoncomment['commentsalone'][$k]['addtime'] = from_time($v['addtime'], 'Y-m-d');
            $lessoncomment['commentsalone'][$k]['comments2alone'] = D("comment2alone")
                ->field("ec_comment2alone.*,ec_user.avatar,ec_user.nickname")
                ->join("LEFT JOIN ec_user ON ec_user.user_id=ec_comment2alone.user_id")
                ->where("comment_id=" . $v['comment_id'] . " AND comment2_flag=2")
                ->order("ec_comment2alone.addtime2 DESC")
                ->limit(3)
                ->select();
            foreach ($lessoncomment['commentsalone'][$k]['comments2alone'] AS $k2 => $v2) {
                $lessoncomment['commentsalone'][$k]['comments2alone'][$k2]['addtime2'] = from_time($v2['addtime2'], 'Y-m-d');
            }
        }
		*/
        $this->assign("margin", $margin); //偏移量
        $this->assign("lessons", $lessons); //当前播放集数
        $this->assign("episode", $current_lesson_id); //当前播放集数
        $this->assign("current_lesson_id", $current_lesson_id); //当前播放集数
        $this->assign("user_auth", $user_auth);
        $this->assign("current_lesson", $current_lesson);
		$this->assign('userinfo',M("User")->find($user_id));
		$this->assign("lessoncomment", $lessoncomment);
        $this->assign("is_cool", M("collectalone")->where("user_id=" . $user_id . " AND lesson_id=" . $current_lesson_id)->count()); //是否收藏
		/*2017-12-16去掉推荐
        //推荐
        $tuijian = M("Lessonalone")->where("lesson_isable=1 and lesson_id!=" . $current_lesson_id)->limit(20)->order("lesson_sort desc,lesson_id asc")->select();
        foreach ($tuijian AS $k => $v) {
            $tuijian[$k]['lesson_image'] = explode("|", $v['lesson_image']);
        }
        $this->assign("tuijian", $tuijian);
		*/
		//免费的
		$freelesson = M("Lessonalone")->where("lesson_isable=1 and lesson_money<=0 and lesson_id!=" . $current_lesson_id)->order("lesson_sort desc,lesson_id asc")->select();
		//$freelesson = M("Lessonalone")->where("lesson_isable=1 and lesson_money<=0")->order("lesson_sort desc,lesson_id asc")->select();
        foreach ($freelesson AS $k => $v) {
            $freelesson[$k]['lesson_image'] = explode("|", $v['lesson_image']);
        }
        $this->assign("freelesson", $freelesson);
		//收费的
		$feelesson = M("Lessonalone")->where("lesson_isable=1 and lesson_money>0 and lesson_id!=" . $current_lesson_id)->order("lesson_sort desc,lesson_id asc")->select();
        foreach ($feelesson AS $k => $v) {
            $feelesson[$k]['lesson_image'] = explode("|", $v['lesson_image']);
        }
        $this->assign("feelesson", $feelesson);

        $this->display();
    }

    //音频播放
    public function audio() {
		$user_id = session('user_id');
        //查课程lesson
        $lessons = M("lessonalone")->where("lesson_isable=1")->order("lesson_id ASC")->select();
        if(!$lessons){
            jump("您要查看的课程不存在", U("index/index"));
        }
        $current_lesson_id = I("lesson_id") ? I("lesson_id") : $lessons[I("margin") ? I("margin") : 0]["lesson_id"];
        foreach ($lessons AS $k => $v) {
            if ($v['lesson_id'] == $current_lesson_id) {
                $margin = $k;
            }
        }
		$current_lesson = M("lessonalone")->find($current_lesson_id);
        if(!$current_lesson){
            jump("您要查看的课程不存在", U("index/index"));
        }
        $current_lesson['lesson_image'] = explode("|", $current_lesson['lesson_image']);
        $user_auth=D("Lessonalone")->user_auth_lesson($current_lesson_id);
		if($current_lesson['lesson_money']){
			if (!$user_auth) {
				$current_lesson['lesson_audio'] = $current_lesson['lesson_try_audio'];
				$current_lesson['lesson_video'] = $current_lesson['lesson_try_video'];
			}
		}else{//0元价格
			//
		}
        $this->assign("user_auth", $user_auth);
		/*2017-12-16去掉推荐
        //推荐
		$tuijian = M("Lessonalone")->where("lesson_isable=1 and lesson_id!=" . $current_lesson_id)->limit(20)->order("lesson_sort desc,lesson_id asc")->select();

        foreach ($tuijian AS $k => $v) {
            $tuijian[$k]['lesson_image'] = explode("|", $v['lesson_image']);
        }
		*/
        foreach ($lessons AS $k => $v) {
            $lessons[$k]['lesson_image'] = explode("|", $v['lesson_image']);
			//每个课程判断收费免费
			$user_auth=D("Lessonalone")->user_auth_lesson($v['lesson_id']);
			if($v['lesson_money']){
				if (!$user_auth) {
					$lessons[$k]['lesson_audio'] = $v['lesson_try_audio'];
					$lessons[$k]['lesson_video'] = $v['lesson_try_video'];
				}
			}else{//0元价格
				//
			}
			unset($user_auth);
        }
		$this->assign("is_cool", M("collectalone")->where("user_id=" . $user_id . " AND lesson_id=" . $current_lesson_id)->count()); //是否收藏

        $this->assign("count_lesson", count($lessons)); //
		$this->assign('courseBuy',D('course')->getCourseBuy());
        $this->assign("lessons", $lessons); //
        $this->assign("margin", $margin); //偏移量
		$this->assign("current_lesson", $current_lesson);
        $this->assign("current_lesson_id", $current_lesson_id); //当前播放集数
        $this->assign("tuijian", $tuijian);
		$this->assign('userinfo',M("User")->find($user_id));
		//评论数
		$this->assign('count_comment',D("comment")
            ->where("lesson_id=" . $current_lesson_id . " AND comment_flag=2")
            ->count());		
        $this->display();
    }

	//播放次数+1
    function add_play_number() {
        $lesson_id = I("lesson_id");
        M("lessonalone")->where("lesson_id=" . $lesson_id)->setInc("lesson_play");
    }

    //获取视频页评论
    public function gvideo() {
        $lesson_id = I("lesson_id");
        $count = D("commentalone")
            ->where("lesson_id=" . $lesson_id . " AND comment_flag=2")
            ->count();
        $Page = new \Think\Page($count, 5);
        //评论按照时间倒序
        $comments = D("commentalone")
            ->field("ec_commentalone.*,ec_user.avatar,ec_user.nickname")
            ->join("LEFT JOIN ec_user ON ec_user.user_id=ec_commentalone.user_id")
            ->where("ec_commentalone.lesson_id=" . $lesson_id . " AND ec_commentalone.comment_flag=2")
            ->limit($Page->firstRow . ',' . $Page->listRows)
            ->order("ec_commentalone.comment_top desc,ec_commentalone.addtime DESC")
            ->select();

        //评论的评论
        foreach ($comments AS $k => $v) {
            $comments[$k]['addtime'] = from_time($v['addtime'], 'Y-m-d');
            $comments[$k]['comments2alone'] = D("comment2alone")
                ->field("ec_comment2alone.*,ec_user.avatar,ec_user.nickname")
                ->join("LEFT JOIN ec_user ON ec_user.user_id=ec_comment2alone.user_id")
                ->where("comment_id=" . $v['comment_id'] . " AND comment2_flag=2")
                ->order("ec_comment2alone.addtime2 DESC")
                ->limit(3)
                ->select();
            foreach ($comments[$k]['comments2'] AS $k2 => $v2) {
                $comments[$k]['comments2'][$k2]['addtime2'] = from_time($v2['addtime2'], 'Y-m-d');
            }
        }
        $this->ajaxReturn($comments);
    }
	//课程评论
    public function course_comment() { //ajax 评论
        $user_id = session('user_id');
        $course_id = I("get.course_id");
        $lesson_id = I("get.lesson_id");
        $data['lesson_id'] = $lesson_id;
        $data['user_id'] = $user_id;
        $data['comment'] = filterEmoji(I("get.content"));
        $data['addtime'] = time(); 
        $flag = M("commentalone")->add($data);
        //返回评论的这条内容
        $comment = D("commentalone")
            ->field("ec_commentalone.*,ec_user.avatar,ec_user.nickname")
            ->join("LEFT JOIN ec_user ON ec_user.user_id=ec_commentalone.user_id")
            ->find($flag);
        $comment['addtime'] = from_time($comment['addtime'], 'Y-m-d');
        $this->ajaxReturn(array("flag" => $flag, "data" => $comment));
    }

    //评论回复
    public function comment_comment() {
        $user_id = session('user_id');
        $data['comment_id'] = I("get.comment_id");
        $data['user_id'] = $user_id;
        $data['comment2'] = filterEmoji(I("get.content"));
        $data['addtime2'] = time();
        $flag = M("comment2alone")->add($data);
        //评论数+1
        M("commentalone")->where("comment_id=" . $data['comment_id'])->setInc("comment_count");
        $count = M("commentalone")->where("comment_id=" . $data['comment_id'])->find();
        //返回评论的这条内容
        $comment = D("comment2alone")
            ->field("ec_comment2alone.*,ec_user.avatar,ec_user.nickname")
            ->join("LEFT JOIN ec_user ON ec_user.user_id=ec_comment2alone.user_id")
            ->find($flag);
        $comment['addtime2'] = from_time($comment['addtime2'], 'Y-m-d');
        $this->ajaxReturn(array("flag" => $flag, "data" => $comment, "count" => $count['comment_count']));
    }

    //点赞
    public function dianzan() {
        $comment_id = I("comment_id");
        M("commentalone")->where("comment_id=" . $comment_id)->setInc("comment_good");
        $comment = M("commentalone")->find($comment_id);
        echo $comment['comment_good'];
    }

    //收藏
    public function shoucang() {
        $data["user_id"] = session('user_id');
        $data["lesson_id"] = I("lesson_id");
        $data["collect_addtime"] = time();
        M("collectalone")->add($data);
    }

    //取消收藏
    public function quxiaoshoucang() {
        $data["lesson_id"] = I("lesson_id");
        $data["user_id"] = session('user_id');
        M("collectalone")->where($data)->delete();
    }

    //用户学习时间
    function learntime() {
        $user_id = session("user_id");
        $user = D("user")->find($user_id);
        $lesson_id = I("lesson_id");
        $this->learn_record($lesson_id);
        //总时间+5s
        D("user")->where("user_id=" . $user_id)->setInc("learntime", 5);
        //时长更新时间
        if (time() - $user['longlearn_time'] > 10) {
            //如果超过10秒没学习， 持续学习时长清零
            D("user")->where("user_id=" . $user_id)->data(array("longlearn_time" => time(), "longlearn" => 0))->save();
        } else {
            D("user")->where("user_id=" . $user_id)->data(array("longlearn_time" => time()))->save();
            D("user")->where("user_id=" . $user_id)->setInc("longlearn", 5);
        }
    }

    function learn_record($lesson_id) {
        $user_id = session("user_id");
        $daybegin = strtotime(date("Y-m-d 00:00:00")); //今天開始時間
        $dayend = strtotime(date("Y-m-d 23:59:59")); //今天結束時間
        $today_learn = M("learninfoalone")->where("user_id=" . $user_id . " AND lesson_id=" . $lesson_id)->find();
        //dd(date("d H:i:s",$today_learn['learn_addtime']));
        //今天已经有学习记录 只需要更新，否则新增
        if ($today_learn) {
            M("learninfo")->where("learn_id=" . $today_learn['learn_id'])->save(array("learn_addtime" => time(),"lesson_id" => $lesson_id));
        } else {
            $data['user_id'] = $user_id;
            $data['lesson_id'] = $lesson_id;
            $data['learn_addtime'] = time();
            M("learninfoalone")->data($data)->add();
        }
    }

	//购买课程专题--奖学金购买
    public function paycourse() {
        $user_id = session("user_id");
        if (IS_AJAX) {
            $lesson_id = I('post.lesson_id');
            $money_2 = abs(floatval(I('post.money_2')));
            $buyinfoalone = M('buyinfoalone');
            $timeStamps = time();
            $endtime = time() + 60 * 60 * 24 * 365;
            $trade_no = C('WxPayConf.APPID') . $timeStamps . random(2);
            //从数据库中查找user_id
            $res = M("user")->find($user_id);
            if ($res && $res['money']>=$money_2) {
                $result = $buyinfoalone->data(array(
                    'user_id' => $user_id,
                    'lesson_id' => $lesson_id,
                    'buy_addtime' => time(),
                    'buy_flag' => 2,
                    'buy_type' => 2,
                    'buy_no' => $trade_no,
                    'buy_money' => $money_2,
                    'buy_endtime' => $endtime,
                ))->add();
                $res = M("user")->where("user_id=" . $user_id)->find();
                $money = round(floatval($res['money'] - $money_2),2);
                $result1 = M("user")->where("user_id=" . $user_id)->save(array("money" => $money));
				M("Lessonalone")->where("lesson_id=" . $lesson_id)->setInc("lesson_buy");				
            }
            if ($result && $result1) {
                $this->ajaxreturn(array("flag" => 1));
            } else {
                $this->ajaxreturn(array("flag" => 0));
            }
        } else {
            jump('非法操作', U("index/index"), 3);
        }
    }
    //选择支付方式
    public function xuanzezhifu() {
        $where = "user_id=" . session("user_id");
        //用户奖学金
        $userinfo = M('user')->where($where)->field('money')->find();
        $this->assign('userinfo', $userinfo);
        //课程年费
        $lesson_id = I('lesson_id');
        $lessoninfo = M("lessonalone")->find($lesson_id);
		$lesson_money=$lessoninfo['lesson_money'];//课程购买价格
		if($lesson_money<=0){
			jump('参数错误请联系管理员', U("index/index"), 3);
		}

        $this->assign('lesson_money', $lesson_money);
        $this->assign('lessoninfo', $lessoninfo);
        $this->display();
    }

    //微信购买课程
    public function weixinpayorder() {
        $lesson_id = I('get.lesson_id');
        $lessoninfo = M("lessonalone")->find($lesson_id);
		$lesson_money=$lessoninfo['lesson_money'];//课程购买价格
		if($lesson_money<=0){
			jump('参数错误请联系管理员', U("index/index"), 3);
		}
        //$pay_type = I('get.pay_type');
        if (!$lesson_money || !$lesson_id)
            jump('微信支付参数错误', U("index/index"), 3);
        $user_id = session("user_id");

        //自定义订单号
        $timeStamp = time();
        $out_trade_no = C('WxPayConf.APPID') . $timeStamp . random(2);
        $amount = abs(floatval($lesson_money));

        //购买记录
        $buyinfoalone = M('buyinfoalone');
        $info_buy = array(
            'user_id' => $user_id,
            'lesson_id' => $lesson_id,
            'buy_addtime' => time(),
            'buy_endtime' => time() + 60 * 60 * 24 * 365,
            'buy_flag' => 1,
            'buy_type' => 1,
            'buy_no' => $out_trade_no,
            'buy_money' => $amount,
        );

        //从数据库中查找user_id
        $res = M("user")->find($user_id);
        if ($res) {
            $orderbuy_id = $buyinfoalone->add($info_buy);
        }
        $token = md5($orderbuy_id . "jysw" . $amount); //???
        $this->redirect('Lessonalone/weixinpay', array('lesson_id' => $lesson_id, 'orderbuy_id' => $orderbuy_id, 'out_trade_no' => $out_trade_no, 'amount' => $amount, "token" => $token), 0, '页面跳转中...');
    }

    //微信支付
    public function weixinpay() {
        $orderbuy_id = I('get.orderbuy_id');
        $lesson_id = I('get.lesson_id');
        $out_trade_no = I('get.out_trade_no');
        $amount = abs(I('get.amount'));
        $token = I("token");
        if ($token != md5($orderbuy_id . "jysw" . $amount)) {
            jump('非法操作', U('index/index'), 3);
        }
        session("weixinpay_orderid", $orderbuy_id);
        session("weixinpay_out_trade_no", $out_trade_no);
        //引入WxpayAPI
        vendor('WxpayAPI.WxPayJsApiPay');

        //①、获取用户openid
        $jsApi = new \JsApiPay();
        $openId = $jsApi->GetOpenid();

        //②、统一下单
        //获取客户订单号，微信下单
        $input = new \WxPayUnifiedOrder();
        $input->SetBody('微信购买课程' . $amount . '元'); //商品描述
        $input->SetAttach($orderbuy_id); //附加数据-订单id
        $input->SetOut_trade_no($out_trade_no); //商户系统内部订单号，要求32个字符内、且在同一个商户号下唯一
        $input->SetTotal_fee(1); //订单总金额，单位为分
        //$input->SetTotal_fee($amount * 100); //订单总金额，单位为分
        $input->SetTime_start(date("YmdHis")); //交易起始时间
        $input->SetTime_expire(date("YmdHis", time() + 600)); //交易结束时间
        $input->SetGoods_tag("微信购买课程"); //商品标记
        $input->SetNotify_url(C('WxPayConf.NOTIFY_URL_COURSE')); //通知地址
        $input->SetTrade_type("JSAPI"); //交易类型 取值如下：JSAPI，NATIVE，APP等
        $input->SetOpenid($openId);
        $order = \WxPayApi::unifiedOrder($input);

        $jsApiParameters = $jsApi->GetJsApiParameters($order);


        //获取共享收货地址js函数参数
        //$editAddress = $jsApi->GetEditAddressParameters();

        $this->assign('jsApiParameters', $jsApiParameters);
        $token = md5($orderbuy_id . "jysw");
        $this->assign('SuccessUrl', U('Lessonalone/SuccessUrl', array("lesson_id" => $lesson_id, 'orderbuy_id' => $orderbuy_id, "token" => $token))); //支付成功跳转页面
        $this->assign('FailUrl', U('Lessonalone/FailUrl', array("orderbuy_id" => $orderbuy_id,"lesson_id" => $lesson_id))); //支付失败跳转页面
        //echo $jsApiParameters;
        $this->display();
    }

    //支付成功页面
    public function SuccessUrl() {
        $orderbuy_id = I("orderbuy_id");
        $lesson_id = I("lesson_id");
        $token = I("token");
        $user_id = session("user_id");
        if ($token != md5($orderbuy_id . "jysw")) {
            jump('非法操作，参数错误！', U('index/index'), 3);
        }

        //引入WxpayAPI
        vendor('WxpayAPI.WxPayJsApiPay');
        vendor('WxpayAPI.WxPayNotify');
        //使用通用通知接口
        $notify = new \PayNotify();
        $flag = $notify->Queryorder_out_trade_no(session("weixinpay_out_trade_no"));
        if (!$flag) {
            jump('非法操作，订单不存在！', U('index/index'), 3);
        }
        //更新购买记录
        $flag2 = M("buyinfoalone")->where("buy_flag=1 and buy_id=" . $orderbuy_id . " and user_id=" . session("user_id"))->save(array("buy_flag" => 2));
        if ($flag2) {
			M("Lessonalone")->where("lesson_id=" . $lesson_id)->setInc("lesson_buy");	
            jump('微信购买课程成功', U('Lessonalone/video', array('lesson_id' => $lesson_id)), 3);
        } else {
            jump('非法操作，数据更新失败！', U('index/index'), 3);
        }
    }

    //支付失败页面
    public function FailUrl() {
        $orderbuy_id = I("orderbuy_id");
		$lesson_id = I("lesson_id");
        jump('微信购买课程失败', U('Lessonalone/video', array('lesson_id' => $lesson_id)), 3);
    }

    //支付通知页面
    public function notify() {
        //引入WxpayAPI
        vendor('WxpayAPI.WxPayJsApiPay');
        vendor('WxpayAPI.WxPayNotify');
        //使用通用通知接口
        $notify = new \PayNotify();
        $flag = $notify->Queryorder_out_trade_no(session("weixinpay_out_trade_no")); //查询订单 by out_trade_no 商户订单号
        if ($flag) {
            //这里写要支付成功的操作
            M("buyinfoalone")->where("buy_flag=1 and buy_no='" . session("weixinpay_out_trade_no") . "'")->save(array("buy_flag" => 2));
            session("weixinpay_orderid", "");
            session("weixinpay_out_trade_no", "");
        }
        $notify->Handle(false);
    }
}
