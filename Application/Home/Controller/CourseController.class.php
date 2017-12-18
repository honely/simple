<?php

namespace Home\Controller;

use Think\Controller;

/*
 * 专题控制器
 */

class CourseController extends Controller {

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

    //默认首页
    public function index() {
        //课程列表
        $count = D('course')
            ->where("course_isable=1 and classify_id=1")
            ->count();
		$this->assign("count_", $count);	
        $Page = new \Think\Page($count, 5);
        $course_list = D("course")
            ->where("course_isable=1 and classify_id=1")
            ->order("course_id desc")
            ->limit($Page->firstRow . ',' . $Page->listRows)
            ->select();
        foreach ($course_list AS $k => $v) {
            $course_list[$k]['course_images'] = explode("|", $v['course_images']);
            if ($v['course_limittime'] > time()) {
                $course_list[$k]['course_money'] = $v['course_limit'];
            }
            if ($v['course_allparts'] == $v['course_parts']) {
                $course_list[$k]['course_update_status'] = '共' . $v['course_allparts'] . '集，更新完毕';
            } else {
                $course_list[$k]['course_update_status'] = '共' . $v['course_allparts'] . '集，更新到第' . $v['course_parts'] . '集';
            }
        }
        if (IS_AJAX) {
            $this->ajaxReturn($course_list);
        } else {
            //轮播图4
            $focus = D("focusinfo")->where("focus_type=4")->order("focus_sort ASC")->limit(3)->select();
            $this->assign("focus", $focus);

            $this->assign("course_list", $course_list);
            $this->display();
        }
		
    }

    //客户需求重写热播2017-09-30---作废用原来的--作废
    public function hotnew() {
        $user_id = session('user_id');
        //如果1登录 2是会员
        //1 登录 不是会员但是买了该课程
        $course_id = 1; //默认专题1作为热播专题，特殊化处理
        D("course")->lll($course_id);
        $user_auth = D("course")->user_auth($course_id);
        $course = D("course")->where("course_isable=1")->find($course_id);
        if (!$course) {
            jump("您要查看的课程不存在", U("index/index"));
        }
        $course['course_title'] = explode("|", $course['course_title']);
        $course['course_audio'] = explode("|", $course['course_audio']);
        $course['course_audio_time'] = explode("|", $course['course_audio_time']);
        $course['course_video'] = explode("|", $course['course_video']);
        $course['course_video_time'] = explode("|", $course['course_video_time']);

        $course['course_try_audio'] = explode("|", $course['course_try_audio']);
        $course['course_try_audio_time'] = explode("|", $course['course_try_audio_time']);
        $course['course_try_video'] = explode("|", $course['course_try_video']);
        $course['course_try_video_time'] = explode("|", $course['course_try_video_time']);

        $course['course_images'] = explode("|", $course['course_images']);
        if (!$user_auth) {
            /*
              foreach ($course['course_video'] AS $k => $v) {
              $course['course_video'][$k] = $course['course_try_video'];
              $course['course_audio'][$k] = $course['course_try_audio'];
              }
             */
            $course['course_audio'] = $course['course_try_audio'];
            //$course['course_audio_time']=$course['course_try_audio_time'];
            $course['course_video'] = $course['course_try_video'];
            //$course['course_video_time']=$course['course_try_video_time'];
        }
        $this->assign("user_auth", $user_auth);
        $this->assign("course", $course);
        $this->assign("is_cool", M("collect")->where("user_id=" . $user_id . " AND course_id=" . $course_id)->count());
        //推荐
        /*
          SELECT	* FROM	`ec_course` WHERE course_id NOT IN ( SELECT course_id FROM `ec_buyinfo` WHERE user_id = 1 AND buy_endtime > unix_timestamp())
         */
        $tuijian = M("course")->where("course_groom=2 AND course_isable=1 and course_id!=1")->limit(3)->select();

        foreach ($tuijian AS $k => $v) {
            $tuijian[$k]['course_images'] = explode("|", $v['course_images']);
            if ($v['course_limittime'] > time()) {
                $tuijian[$k]['course_money'] = $v['course_limit'];
            }
        }
        $this->assign("tuijian", $tuijian);
        $this->display();
    }

    public function hot() { //热播--作废
        //如果是正在抢购的专题，course_money = course_limit
        //抢购倒计时时间 course_limittime > 当前时间time()
        $count = D('course')
            ->where("course_isable=1 AND course_hot=2 and classify_id=1")//热播
            ->count();
        $Page = new \Think\Page($count, 5);
        $course_list = D("course")
            ->where("course_isable=1 AND course_hot=2 and classify_id=1")//热播
            ->limit($Page->firstRow . ',' . $Page->listRows)
            ->order("course_id desc")
            ->select();
        foreach ($course_list AS $k => $v) {
            if ($v['course_limittime'] > time()) {
                $course_list[$k]['course_money'] = $v['course_limit'];
            }

            $course_list[$k]['course_images'] = explode("|", $v['course_images']);
            if ($v['course_allparts'] == $v['course_parts']) {
                $course_list[$k]['course_update_status'] = '共' . $v['course_allparts'] . '集，更新完毕';
            } else {
                $course_list[$k]['course_update_status'] = '共' . $v['course_allparts'] . '集，更新到第' . $v['course_parts'] . '集';
            }
        }
        if (IS_AJAX) {
            $this->ajaxReturn($course_list);
        } else {
            //轮播图4
            $focus = D("focusinfo")->where("focus_type=4")->order("focus_sort ASC")->limit(3)->select();
            $this->assign("focus", $focus);
            $this->assign("course_list", $course_list);
            $this->display();
        }
    }

    //播放次数+1
    function add_play_number() {
        $course_id = I("course_id");
        $lesson_id = I("lesson_id");
        M("lesson")->where("course_id=" . $course_id." and lesson_id=" . $lesson_id)->setInc("lesson_play");
    }

    //获取视频页评论
    public function gvideo() {
        $course_id = I("course_id"); //评论
        $lesson_id = I("lesson_id");
        $count = D("comment")
            ->where("course_id=" . $course_id . " AND lesson_id=" . $lesson_id . " AND comment_flag=2")
            ->count();
        $Page = new \Think\Page($count, 5);
        //评论按照时间倒序
        $comments = D("comment")
            ->field("ec_comment.*,ec_user.avatar,ec_user.nickname")
            ->join("LEFT JOIN ec_user ON ec_user.user_id=ec_comment.user_id")
            ->where("ec_comment.course_id=" . $course_id . " AND ec_comment.lesson_id=" . $lesson_id . " AND ec_comment.comment_flag=2")
            ->limit($Page->firstRow . ',' . $Page->listRows)
            ->order("ec_comment.comment_top desc,ec_comment.addtime DESC")
            ->select();

        //评论的评论
        foreach ($comments AS $k => $v) {
            $comments[$k]['addtime'] = from_time($v['addtime'], 'Y-m-d');
            $comments[$k]['comments2'] = D("comment2")
                ->field("ec_comment2.*,ec_user.avatar,ec_user.nickname")
                ->join("LEFT JOIN ec_user ON ec_user.user_id=ec_comment2.user_id")
                ->where("comment_id=" . $v['comment_id'] . " AND comment2_flag=2")
                ->order("ec_comment2.addtime2 DESC")
                ->limit(3)
                ->select();
            foreach ($comments[$k]['comments2'] AS $k2 => $v2) {
                $comments[$k]['comments2'][$k2]['addtime2'] = from_time($v2['addtime2'], 'Y-m-d');
            }
        }
        $this->ajaxReturn($comments);
    }

    //视频播放
    public function video() {
        $user_id = session('user_id');
        //如果1登录 2是会员
        //1 登录 不是会员但是买了该课程
        $course_id = I("course_id");
        $user_auth = D("course")->user_auth($course_id); //当前用户是否有权限
        $course = D("course")->where("course_isable=1")->find($course_id);
        if (!$course) {
            jump("您要查看的课程不存在", U("index/index"));
        }
        //查课程lesson
        $lessons = M("lesson")->where("course_id=" . $course_id." and lesson_isable=1")->order("lesson_id ASC")->select();
        if(!$lessons){
            jump("您要查看的课程不存在", U("index/index"));
        }
        $current_lesson_id = I("lesson_id") ? I("lesson_id") : $lessons[0]["lesson_id"];
        $margin = 0;
        foreach ($lessons AS $k => $v) {
            if ($v['lesson_id'] == $current_lesson_id) {
                $margin = $k;
            }
        }
        $current_lesson = M("lesson")->find($current_lesson_id);
        if(!$current_lesson){
            jump("您要查看的课程不存在", U("index/index"));
        }
        //lesson浏览量
        $current_lesson['lesson_image'] = explode("|", $current_lesson['lesson_image']);
        D("course")->lll($current_lesson_id);
        if($course['classify_id']==2){//免费的这样操作
            //
        }else{//非免费的
            if (!$user_auth) {
                $current_lesson['lesson_audio'] = $current_lesson['lesson_try_audio'];
                $current_lesson['lesson_video'] = $current_lesson['lesson_try_video'];
            }
        }

        //评论
        $count = D("comment")
            ->where("course_id=" . $course_id . " AND lesson_id=" . $current_lesson_id . " AND comment_flag=2")
            ->count();
        $Page = new \Think\Page($count, 5);
        //评论按照时间倒序
        $course['comments'] = D("comment")
            ->field("ec_comment.*,ec_user.avatar,ec_user.nickname")
            ->join("LEFT JOIN ec_user ON ec_user.user_id=ec_comment.user_id")
            ->where("ec_comment.course_id=" . $course_id . " AND ec_comment.lesson_id=" . $current_lesson_id . " AND ec_comment.comment_flag=2")
            ->limit($Page->firstRow . ',' . $Page->listRows)
            ->order("ec_comment.comment_top desc,ec_comment.addtime DESC")
            ->select();
        //评论的评论
        foreach ($course['comments'] AS $k => $v) {
            $course['comments'][$k]['addtime'] = from_time($v['addtime'], 'Y-m-d');
            $course['comments'][$k]['comments2'] = D("comment2")
                ->field("ec_comment2.*,ec_user.avatar,ec_user.nickname")
                ->join("LEFT JOIN ec_user ON ec_user.user_id=ec_comment2.user_id")
                ->where("comment_id=" . $v['comment_id'] . " AND comment2_flag=2")
                ->order("ec_comment2.addtime2 DESC")
                ->limit(3)
                ->select();
            foreach ($course['comments'][$k]['comments2'] AS $k2 => $v2) {
                $course['comments'][$k]['comments2'][$k2]['addtime2'] = from_time($v2['addtime2'], 'Y-m-d');
            }
        }
        $this->assign("margin", $margin); //偏移量
        $this->assign("lessons", $lessons); //当前播放集数
        $this->assign("episode", $current_lesson_id); //当前播放集数
        $this->assign("current_lesson_id", $current_lesson_id); //当前播放集数
        $this->assign("user_auth", $user_auth);
        $this->assign("current_lesson", $current_lesson);
        $this->assign("course", $course);
        $this->assign("is_cool", M("collect")->where("user_id=" . $user_id . " AND course_id=" . $course_id . " AND lesson_id=" . $current_lesson_id)->count()); //是否收藏
        //推荐
        /*
          SELECT	* FROM	`ec_course` WHERE course_id NOT IN ( SELECT course_id FROM `ec_buyinfo` WHERE user_id = 1 AND buy_endtime > unix_timestamp())
         */
        $tuijian = M("course")->where("course_groom=2 AND course_isable=1 and course_id!=" . $course_id)->limit(3)->select();

        foreach ($tuijian AS $k => $v) {
            $tuijian[$k]['course_images'] = explode("|", $v['course_images']);
            if ($v['course_limittime'] > time()) {
                $tuijian[$k]['course_money'] = $v['course_limit'];
            }
        }
        $this->assign("tuijian", $tuijian);
        $this->display();
    }

    //音频播放
    public function audio() {
        $course_id = I("course_id");
        $user_auth = D("course")->user_auth($course_id);
        $course = D("course")->where("course_isable=1")->find($course_id);
        if (!$course) {
            jump("您要查看的课程不存在", U("index/index"));
        }
        //查课程lesson
        $lessons = M("lesson")->where("course_id=" . $course_id." and lesson_isable=1")->order("lesson_id ASC")->select();
        if(!$lessons){
            jump("您要查看的课程不存在", U("index/index"));
        }
        $current_lesson_id = I("lesson_id") ? I("lesson_id") : $lessons[I("margin") ? I("margin") : 0]["lesson_id"];
        foreach ($lessons AS $k => $v) {
            if ($v['lesson_id'] == $current_lesson_id) {
                $margin = $k;
            }
        }
		$current_lesson = M("lesson")->find($current_lesson_id);
        if(!$current_lesson){
            jump("您要查看的课程不存在", U("index/index"));
        }
        $current_lesson['lesson_image'] = explode("|", $current_lesson['lesson_image']);
        //不增加浏览量和播放量了
        if($course['classify_id']==2){//免费的这样操作
            //
        }else{//非免费的
            if (!$user_auth) {
                $current_lesson['lesson_audio'] = $current_lesson['lesson_try_audio'];
                $current_lesson['lesson_video'] = $current_lesson['lesson_try_video'];
            }
        }
        $this->assign("user_auth", $user_auth);
        $this->assign("course", $course);
        //推荐
        $tuijian = M("course")->where("course_groom=2 AND course_isable=1 and course_id!=" . $course_id)->limit(3)->select();

        foreach ($tuijian AS $k => $v) {
            $tuijian[$k]['course_images'] = explode("|", $v['course_images']);
        }
        foreach ($lessons AS $k => $v) {
            $lessons[$k]['lesson_image'] = explode("|", $v['lesson_image']);
        }
        $this->assign("course", $course); //
        $this->assign("count_lesson", count($lessons)); //
		$this->assign('courseBuy',D('course')->getCourseBuy());
        $this->assign("lessons", $lessons); //
        $this->assign("margin", $margin); //偏移量
		$this->assign("current_lesson", $current_lesson);
        $this->assign("current_lesson_id", $current_lesson_id); //当前播放集数
        $this->assign("tuijian", $tuijian);
		//评论数
		$this->assign('count_comment',D("comment")
            ->where("lesson_id=" . $current_lesson_id . " AND comment_flag=2")
            ->count());	
        $this->display();
    }

    //课程评论
    public function course_comment() { //ajax 评论
        $user_id = session('user_id');
        $course_id = I("get.course_id");
        $lesson_id = I("get.lesson_id");
        $data['course_id'] = $course_id;
        $data['lesson_id'] = $lesson_id;
        $data['user_id'] = $user_id;
        $data['comment'] = filterEmoji(I("get.content"));
        $data['addtime'] = time();
        $flag = M("comment")->add($data);
        //返回评论的这条内容
        $comment = D("comment")
            ->field("ec_comment.*,ec_user.avatar,ec_user.nickname")
            ->join("LEFT JOIN ec_user ON ec_user.user_id=ec_comment.user_id")
            ->find($flag);
        $comment['addtime'] = from_time($comment['addtime'], 'Y-m-d');
        $this->ajaxReturn(array("flag" => $flag, "data" => $comment));
    }

    //评论回复
    public function comment_comment() {
        $user_id = session('user_id');
        $data['comment_id'] = I("get.comment_id");
        $data['course_id'] = I("get.course_id");
        $data['user_id'] = $user_id;
        $data['comment2'] = filterEmoji(I("get.content"));
        $data['addtime2'] = time();
        $flag = M("comment2")->add($data);
        //评论数+1
        M("comment")->where("comment_id=" . $data['comment_id'])->setInc("comment_count");
        $count = M("comment")->where("comment_id=" . $data['comment_id'])->find();
        //返回评论的这条内容
        $comment = D("comment2")
            ->field("ec_comment2.*,ec_user.avatar,ec_user.nickname")
            ->join("LEFT JOIN ec_user ON ec_user.user_id=ec_comment2.user_id")
            ->find($flag);
        $comment['addtime2'] = from_time($comment['addtime2'], 'Y-m-d');
        $this->ajaxReturn(array("flag" => $flag, "data" => $comment, "count" => $count['comment_count']));
    }

    //点赞
    public function dianzan() {
        $comment_id = I("comment_id");
        M("comment")->where("comment_id=" . $comment_id)->setInc("comment_good");
        $comment = M("comment")->find($comment_id);
        echo $comment['comment_good'];
    }

    //收藏
    public function shoucang() {
        $data["course_id"] = I("course_id");
        $data["user_id"] = session('user_id');
        $data["lesson_id"] = I("lesson_id");
        $data["collect_addtime"] = time();
        M("collect")->add($data);
    }

    //取消收藏
    public function quxiaoshoucang() {
        $data["course_id"] = I("course_id");
        $data["lesson_id"] = I("lesson_id");
        $data["user_id"] = session('user_id');
        M("collect")->where($data)->delete();
    }

    //用户学习时间
    function learntime() {
        $user_id = session("user_id");
        $user = D("user")->find($user_id);
        $course_id = I("course_id");
        $lesson_id = I("lesson_id");
        $this->learn_record($course_id, $lesson_id);
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

    function learn_record($course_id, $lesson_id) {
        $user_id = session("user_id");
        $daybegin = strtotime(date("Y-m-d 00:00:00")); //今天開始時間
        $dayend = strtotime(date("Y-m-d 23:59:59")); //今天結束時間
        //$today_learn = M("learninfo")->where("user_id=" . $user_id . " AND course_id=" . $course_id . " AND learn_addtime>" . $daybegin . " AND learn_addtime < " . $dayend)->find();
        $today_learn = M("learninfo")->where("user_id=" . $user_id . " AND course_id=" . $course_id)->find();
        //dd(date("d H:i:s",$today_learn['learn_addtime']));
        //今天已经有学习记录 只需要更新，否则新增
        if ($today_learn) {
            M("learninfo")->where("learn_id=" . $today_learn['learn_id'])->save(array("learn_addtime" => time(),"lesson_id" => $lesson_id));
        } else {
            $data['user_id'] = $user_id;
            $data['course_id'] = $course_id;
            $data['lesson_id'] = $lesson_id;
            $data['learn_addtime'] = time();
            M("learninfo")->data($data)->add();
        }
    }

    //选择支付方式
    public function xuanzezhifu() {
        $where = "user_id=" . session("user_id");
        //用户奖学金
        $userinfo = M('user')->where($where)->field('money')->find();
        $this->assign('userinfo', $userinfo);
        //课程年费
        $course_id = I('course_id');
        $courseinfo = M("course")->find($course_id);
        //判断抢购时间
        if ($courseinfo["course_limittime"] < SYS_TIME) {
            $course_money = $courseinfo["course_money"];
        } else {
            $course_money = $courseinfo["course_limit"];
        }
        $this->assign('course_money', $course_money);
        $this->assign('courseinfo', $courseinfo);
        $this->display();
    }

    //微信购买课程
    public function weixinpayorder() {
        $course_id = I('get.course_id');
        $courseinfo = M("course")->find($course_id);
        //判断抢购时间
        if ($courseinfo["course_limittime"] < SYS_TIME) {
            $course_money = $courseinfo["course_money"];
        } else {
            $course_money = $courseinfo["course_limit"];
        }
        //$pay_type = I('get.pay_type');
        if (!$course_money || !$course_id)
            jump('微信支付参数错误', U("index/index"), 3);
        $user_id = session("user_id");


        //自定义订单号
        $timeStamp = time();
        $out_trade_no = C('WxPayConf.APPID') . $timeStamp . random(2);
        $amount = abs(floatval($course_money));

        //购买记录
        $buyinfo = M('buyinfo');
        $info_buy = array(
            'user_id' => $user_id,
            'course_id' => $course_id,
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
            $orderbuy_id = $buyinfo->add($info_buy);
        }
        $token = md5($orderbuy_id . "jysw" . $amount); //???
        $this->redirect('course/weixinpay', array('course_id' => $course_id, 'orderbuy_id' => $orderbuy_id, 'out_trade_no' => $out_trade_no, 'amount' => $amount, "token" => $token), 0, '页面跳转中...');
    }

    //微信支付
    public function weixinpay() {
        $orderbuy_id = I('get.orderbuy_id');
        $course_id = I('get.course_id');
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
        $input->SetBody('微信购买专题' . $amount . '元'); //商品描述
        $input->SetAttach($orderbuy_id); //附加数据-订单id
        $input->SetOut_trade_no($out_trade_no); //商户系统内部订单号，要求32个字符内、且在同一个商户号下唯一
        $input->SetTotal_fee(1); //订单总金额，单位为分
        //$input->SetTotal_fee($amount * 100); //订单总金额，单位为分
        $input->SetTime_start(date("YmdHis")); //交易起始时间
        $input->SetTime_expire(date("YmdHis", time() + 600)); //交易结束时间
        $input->SetGoods_tag("微信购买专题"); //商品标记
        $input->SetNotify_url(C('WxPayConf.NOTIFY_URL_COURSE')); //通知地址
        $input->SetTrade_type("JSAPI"); //交易类型 取值如下：JSAPI，NATIVE，APP等
        $input->SetOpenid($openId);
        $order = \WxPayApi::unifiedOrder($input);

        $jsApiParameters = $jsApi->GetJsApiParameters($order);


        //获取共享收货地址js函数参数
        //$editAddress = $jsApi->GetEditAddressParameters();

        $this->assign('jsApiParameters', $jsApiParameters);
        $token = md5($orderbuy_id . "jysw");
        $this->assign('SuccessUrl', U('course/SuccessUrl', array("course_id" => $course_id, 'orderbuy_id' => $orderbuy_id, "token" => $token))); //支付成功跳转页面
        $this->assign('FailUrl', U('course/FailUrl', array("orderbuy_id" => $orderbuy_id,))); //支付失败跳转页面
        //echo $jsApiParameters;
        $this->display();
    }

    //支付成功页面
    public function SuccessUrl() {
        $orderbuy_id = I("orderbuy_id");
        $course_id = I("course_id");
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
        $flag2 = M("buyinfo")->where("buy_flag=1 and buy_id=" . $orderbuy_id . " and user_id=" . session("user_id"))->save(array("buy_flag" => 2));
        $result2 = M("course")->where("course_id=" . $course_id)->setInc('course_buy', 1);
        if ($flag2) {
            jump('微信购买专题成功', U('course/video', array('course_id' => $course_id)), 3);
        } else {
            jump('非法操作，数据更新失败！', U('index/index'), 3);
        }
    }

    //支付失败页面
    public function FailUrl() {
        $orderbuy_id = I("orderbuy_id");
        jump('微信购买专题失败', U('index/index'), 3);
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
            M("buyinfo")->where("buy_flag=1 and buy_no='" . session("weixinpay_out_trade_no") . "'")->save(array("buy_flag" => 2));
            session("weixinpay_orderid", "");
            session("weixinpay_out_trade_no", "");
        }
        $notify->Handle(false);
    }
    //购买课程专题--奖学金购买
    public function paycourse() {
        $user_id = session("user_id");
        if (IS_AJAX) {
            $course_id = I('post.course_id');
            $money_2 = abs(floatval(I('post.money_2')));
            $buyinfo = M('buyinfo');
            $timeStamps = time();
            $endtime = time() + 60 * 60 * 24 * 365;
            $trade_no = C('WxPayConf.APPID') . $timeStamps . random(2);
            //从数据库中查找user_id
            $res = M("user")->find($user_id);
            if ($res && $res['money']>=$money_2) {
                $result = $buyinfo->data(array(
                    'user_id' => $user_id,
                    'course_id' => $course_id,
                    'buy_addtime' => time(),
                    'buy_flag' => 2,
                    'buy_type' => 2,
                    'buy_no' => $trade_no,
                    'buy_money' => $money_2,
                    'buy_endtime' => $endtime,
                ))->add();
                $res = M("user")->where("user_id=" . $user_id)->find();
                $money = $res['money'] - $money_2;
                $result1 = M("user")->where("user_id=" . $user_id)->save(array("money" => $money));
                $result2 = M("course")->where("course_id=" . $course_id)->setInc('course_buy', 1);
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

    public function popular(){
        $user_id = session('user_id');
        $where='1 and lesson_ishot = 2 and lesson_isable=1 ';
        //是自动播放或者点击列表进入
        $lesson_id=intval(I('get.lesson_id'));
        if($lesson_id){
            $where.='and lesson_id = '.$lesson_id;
        }
        //是直接推荐进入
        $lesson=M('lesson')
            ->where($where)
            ->order('lesson_view desc,lesson_id desc')
            ->find();
		$lesson['lesson_image']=explode("|",$lesson['lesson_image']);
        $lesson_id=$lesson_id?$lesson_id:$lesson['lesson_id'];
        if(!empty($lesson_id)){
			//对应专题信息
			$this->assign('course_info',M("course")->where("course_id=".$lesson['course_id'])->find());

            $this->assign('lesson_id',$lesson_id);
            if(!$lesson_id){ //没有传递$lesson_id
                $lesson_id =$lesson['lesson_id'];
            }
            $course_id =$lesson['course_id'];
            //增加浏览量
            D("course")->lll($lesson_id);
            //判断用户是否有权限查看课程；
            //$user_auth = D("course")->user_auth($course_id);
			$user_auth = D("course")->user_auth($course_id);
            $course=M('course')->where('ec_course.course_id = '.$course_id)->field('ec_course.course_id,ec_course.classify_id')->find();

            if($course['classify_id']==2){//免费的这样操作
                //
            }else{//非免费的
                if (!$user_auth) {
                    $lesson['lesson_audio']=$lesson['lesson_try_audio'];
                    $lesson['lesson_video']=$lesson['lesson_try_video'];
                }
            }
            //其他热播；
            $lessoninfo=M('lesson')
                ->where('1 and lesson_ishot = 2 ')
                ->order(' lesson_id desc')
                ->select();
            $this->assign('lessonNum',count($lessoninfo));
            $this->assign('tuijian',$lessoninfo);
            $this->assign('user_auth',$user_auth);
            $this->assign('courseBuy',D('course')->getCourseBuy());
			$this->assign('userinfo',M("User")->find($user_id));
            $this->assign('lesson',$lesson);
            $this->assign("is_cool", M("collect")->where("user_id=" . $user_id . " AND course_id=" . $course_id ." and lesson_id = ".$lesson['lesson_id'])->count());
        }else{
            jump("暂无热播课程，敬请期待", U("index/index"));
        }
        $this->display();
    }

    //热播的音频播放
    public function popaudio() {
        $user_id = session('user_id');
        //获取到的lesson_id；
        $lesson_id = I("lesson_id");
        $lesson=M('lesson')->where('lesson_id = '.$lesson_id." and lesson_ishot = 2")->find();
        $course_id=$lesson['course_id'];
        $course = D("course")->where("course_isable=1")->find($course_id);
        if (!$course) {
            jump("您要查看的课程不存在", U("index/index"));
        }
        //判断用户是否有权限查看课程；
        //$user_auth = D("course")->user_auth($course_id);
		$user_auth = D("course")->user_auth($course_id);
        if($course['classify_id']==2){//免费的这样操作
            //
        }else{//非免费的
            if (!$user_auth) {
                $lesson['lesson_audio']=$lesson['lesson_try_audio'];
                $lesson['lesson_video']=$lesson['lesson_try_video'];
            }
        }
        //热播课程
        $lessoninfo = M("lesson")->where("lesson_ishot = 2")->join("left join ec_course on ec_course.course_id=ec_lesson.course_id")->order("lesson_id ASC")->field("ec_lesson.*,ec_course.course_name")->select();

        foreach ($lessoninfo AS $k => $v) {
            $lessoninfo[$k]['lesson_image'] = explode("|", $v['lesson_image']);
            $lessoninfo[$k]['lesson_image']=$lessoninfo[$k]['lesson_image'][0];
        }
        $this->assign('lessoninfo',$lessoninfo);
        $this->assign('user_auth',$user_auth);
        $this->assign('courseBuy',D('course')->getCourseBuy());
		$this->assign('userinfo',M("User")->find($user_id));
        $this->assign('lesson',$lesson);
        $this->assign("is_cool", M("collect")->where("user_id=" . $user_id . " AND course_id=" . $course_id ." AND lesson_id = ".$lesson_id)->count());
        $this->display();
    }
}
