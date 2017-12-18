<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Cache-Control" content="no-transform" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>简异思维-互联型企业创新大学</title>
        <link rel="stylesheet" type="text/css" href="/Public/home/font/iconfont.css">
        <link rel="stylesheet" type="text/css" href="/Public/home/css/swiper-3.4.2.min.css"/>
        <link rel="stylesheet" type="text/css" href="/Public/home/css/html5.css"/>
        <link rel="stylesheet" type="text/css" href="/Public/home/css/mian.css"/>
        <script src="/Public/home/js/jquery-1.10.2.min.js" type="text/javascript" charset="utf-8"></script>
        <script>
            (function(doc, win) {
            var docEl = doc.documentElement,
                    resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
                    recalc = function() {
                    var clientWidth = docEl.clientWidth;
                    if (!clientWidth) return;
                    docEl.style.fontSize = 25 * (clientWidth / 720) + 'px';
                    };
            if (!doc.addEventListener) return;
            win.addEventListener(resizeEvt, recalc, false);
            doc.addEventListener('DOMContentLoaded', recalc, false);
            })(document, window);
        </script>
    </head>
    <body>
        <style>
            .grxx_box{padding:5px 1.2rem;border-radius:0px;}
            .nav,.zhibo{border-radius:0px;}
            .twlb_box .ct .twlb{ margin-bottom:0;border-radius:0px; border-bottom: 1px solid #E5E6E8;}
            .twlb_box .ct .twlb:last-child{border-bottom: none;}
            .twlb_box{background: #fff;}
            .twlb_box .ct .twlb dd .top a p{margin-top: 0; font-size: 1rem;}
        </style>
        <div>
            <div class="grxx_box c">
                <div class="right">
                    <!--不是会员的显示“升级会员按钮”，是会员的显示“排名、学分、签到”按钮-->
                    <?php if($user_info['vip'] == 0 ): ?><a class="shengjihuiyuan" href="<?php echo U('personal/shengjihuiyuan');?>">升级会员</a><?php endif; ?>
                    <?php if($user_info['vip'] != 0 ): ?><span class="qiandao" href="" onclick="qiandao()" >
                            <i class="iconfont icon-qiandao"></i>
                            <?php if($counts >= 1): ?><p >已签</p>
                                <?php else: ?>
                                <p >签到</p><?php endif; ?>
                        </span>
                        <a class="xuefen" href="<?php echo U('personal/xuexipaihangbang');?>">
                            <i class="iconfont icon-30xuefenpingjiatixi"></i>
                            <p>学分</p>
                        </a><?php endif; ?>
                </div>
                <dl class="left">
                    <dt>
                        <span>
                            <?php if($user_info['vip'] != 0 ): ?><i><img src="<?php echo ($user_info['vip_image']); ?>"></i><?php endif; ?>							
                            <img src="<?php echo ($user_info['avatar']); ?>"/>
                        </span>
                    </dt>
                    <dd>
                        <div class="top">
                            <span style=" max-width: 7rem;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"><?php echo ($user_info['nickname']); ?></span>
                            <em style=" vertical-align: top;">|</em>
                            <i style=" vertical-align: top;"><?php echo ($user_info['level_name']); ?></i>
                        </div>
                    </dd>
                </dl>
            </div>
        </div>
        <!--轮播图-->
        <div class="banner_box">
            <div class="swiper-container">
                <div class="swiper-wrapper" id="swiper-wrapper">
                    <?php if(is_array($focus_info)): $i = 0; $__LIST__ = $focus_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><div class="swiper-slide">
                            <a href="<?php echo ($data['focus_url']); ?>"><img src="<?php echo ($data['focus_image']); ?>" alt="<?php echo ($data['focus_title']); ?>"></a>
                        </div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
        <!--导航-->
        <div>
            <div class="nav c">
                <ul>
                    <li>
                        <a href="<?php echo U('lessonalone/video');?>">
                            <i class="iconfont icon-remenshipin"></i>
                            <p>免费</p>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo U('course/index');?>">
                            <i class="iconfont icon-theme-activities"></i>
                            <p>专题</p>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo U('bookinfo/zhibo');?>">
                            <i class="iconfont icon-zhibo"></i>
                            <p>直播</p>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo U('myinfo/xuexijilu');?>">
                            <i class="iconfont icon-jilu"></i>
                            <p>学习记录</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!--直播
        客户不要了 2017-11-4修改
    <?php if(count($live_info) != 0 ): ?><div class="mg_t10">
            <div class="zhibo">
                <div class="top">
                    <h4>直播即将开始</h4>	
                    <?php if($live_info['flag'] == 1 ): ?><span onclick="show('<?php echo ($live_info['live_id']); ?>');">点击预约</span><?php endif; ?>	
                    <?php if($live_info['flag'] == 2 ): ?><span onclick="location.href = '<?php echo ($live_info['live_url']); ?>'">点击直播</span><?php endif; ?>
                </div>
                <div class="ct">
                    <h4><?php echo ($live_info['live_title']); ?></h4>
                    <p><?php echo ($live_info['live_remarks']); ?></p>
                    <div class="bottom">
                        <span>主讲：<?php echo ($live_info['live_speaker']); ?></span>
                        <i>时间：<?php echo ($live_info['live_time']); ?></i>
                        <strong><em id="int_num"><?php echo ($live_info['live_num']); ?></em> 预约</strong>
                    </div>
                 </div>
             </div>
        </div><?php endif; ?>
     -->
                                    <!--限时特价-->
                                    <?php if(count($time_info_) != 0 ): ?><div class="xstj mg_t10 twlb_box">
                                            <div class="ct pd_lr06">
                                                <dl class="twlb c">
                                                    <dt>
                                                        <a href="<?php echo U('course/video',array('course_id'=>$time_info_[0]['course_id']));?>">
                                                            <?php
 $imgarr=explode("|",$time_info_[0]['course_images']); ?>
                                                            <img src="<?php echo $imgarr[0];?>"/>
                                                        </a>
                                                    </dt>
                                                    <dd>
                                                        <div class="top">
                                                            <a href="<?php echo U('course/video',array('course_id'=>$time_info_[0]['course_id']));?>">
                                                                <h4>
                                                                    <strong><?php echo ($time_info_[0]['course_name']); ?></strong>
                                                                </h4>
                                                                <p><?php echo ($time_info_[0]['course_remarks']); ?></p>
                                                            </a>
                                                        </div>
                                                        <div class="ct">
                                                            <div class="left">
                                                                <span>￥<?php echo ($time_info_[0]['course_limit']); ?>/年</span>
                                                            </div>
                                                            <div class="right">
                                                                <strong>
                                                                    <i class="iconfont icon-shijian"></i>
                                                                    <i>剩余时间</i>
                                                                    <i id="fnTimeCountDown0" data-end="<?php echo ($time_info_[0]['course_limittime']); ?>">
                                                                        <i class="hour">00</i>:
                                                                        <i class="mini">00</i>:
                                                                        <i class="sec">00</i>
                                                                        <!--<i class="hm">00</i>-->
                                                                    </i>			
                                                                </strong>
                                                            </div>
                                                        </div>
                                                        <div class="ct_1">
                                                            <div class="left">
                                                                <span style="text-decoration:line-through">￥<?php echo ($time_info_[0]['course_money']); ?>/年</span>
                                                            </div>
                                                            <div class="right">
                                                                <a href="<?php echo U('course/video',array('course_id'=>$time_info_[0]['course_id']));?>">
																<em>立即抢购</em>
																</a>
                                                            </div>
                                                        </div>
                                                    </dd>
                                                </dl>
                                            </div>
                                        </div><?php endif; ?>
                                    <!--限时免费-->
                                    <div class="mg_t10">
                                        <div class="xsmf twlb_box">
                                            <div class="head">
                                                <i></i>
                                                <span>热播HOT</span>
                                                <i></i>
                                            </div>

                                            <div class="xsmf_ct">
                                                <ul class="c">
                                                    <?php if(is_array($course_info_)): $i = 0; $__LIST__ = $course_info_;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$datas): $mod = ($i % 2 );++$i;?><li class="lb">
                                                            <div class="img">
                                                                <a href="<?php echo U('course/video',array('course_id'=>$datas['course_id']));?>">
                                                                    <?php
 $imgarr=explode("|",$datas['course_images']); ?>
                                                                    <img src="<?php echo $imgarr[0];?>"/>
                                                                </a>

                                                            </div>
                                                            <div class="text">
                                                                <h5>
                                                                    <a  href="<?php echo U('course/video',array('course_id'=>$datas['course_id']));?>"><?php echo ($datas['course_name']); ?></a>
                                                                </h5>
                                                                <span>
                                                                    <a href="<?php echo U('course/video',array('course_id'=>$datas['course_id']));?>" class="iconfont icon-11"></a>
                                                                </span>
                                                                <span>
                                                                    <a href="<?php echo U('course/audio',array('course_id'=>$datas['course_id']));?>" class="iconfont icon-erji"></a>
                                                                </span>
                                                                <strong>
                                                                   
                                                                    <i class="iconfont icon-yueduliang"></i>
                                                                    <?php if($datas['lesson_view']['lesson_view'] == ""):?>
                                                                    <em>0</em>
                                                                    <?php else:?>
                                                                    <em><?php echo ($datas['lesson_view']['lesson_view']>9999?'1万+':$datas['lesson_view']['lesson_view']); ?></em>
                                                                    <?php endif;?>
                                                                </strong>
                                                            </div>
                                                        </li><?php endforeach; endif; else: echo "" ;endif; ?>	
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if($countnum !== 0):?>
                                    <div class="twlb_box mg_t10">
                                        <div class="head">
                                            <i></i>
                                            <span>专题课程</span>
                                            <i></i>
                                        </div>
                                        <div class="ct pd_lr06">
                                            <!--专题第一个购买VIP__strat-->
                                            <dl class="twlb c">
                                                <dt>
                                                <?php if($user_info['vip'] == 0 ): ?><a class="shengjihuiyuan" href="<?php echo U('personal/shengjihuiyuan');?>"><?php endif; ?>
                                                <?php if($user_info['vip'] != 0 ): ?><a href="<?php echo U('course/video',array('course_id'=>$course_info_time[0]['course_id']));?>"><?php endif; ?>
                                              
                                                <img src="/Public/home/images/vip.png"/>
                                                </a>
                                                </dt>
                                                <dd>
                                                    <div class="top">
                                                        <?php if($user_info['vip'] == 0 ): ?><a class="shengjihuiyuan" href="<?php echo U('personal/shengjihuiyuan');?>"><?php endif; ?>
                                                        <?php if($user_info['vip'] != 0 ): ?><a href="<?php echo U('course/video',array('course_id'=>$course_info_time[0]['course_id']));?>"><?php endif; ?>

                                                        <h4>
                                                            <?php if($course_info_time[0]['course_hot'] == 2): ?><span>VIP</span><?php endif; ?>	
                                                            <strong><?php echo $course_info_time[0]['course_name'];?></strong>	
                                                        </h4>
                                                        <p><?php echo $course_info_time[0]['course_remarks'];?></p>
                                                        </a>
                                                    </div>
                                                    <div class="ct">
                                                        <div class="left">
                                                            <span>￥<?php echo ($course_info_time[0]['course_money']); ?>/年</span>
                                                        </div>
                                                        <div class="right">
                                                            <span>全年<?php echo ($course_info_time[0]['course_allparts']); ?>集，
                                                                <?php if($course_info_time[0]['course_allparts'] != $course_info_time[0]['course_parts'] ): echo str_cut($course_info_time[0]['course_partremarks'],20); endif; ?>
                                                                <?php if($course_info_time[0]['course_allparts'] == $course_info_time[0]['course_parts'] ): ?>更新完毕<?php endif; ?>								
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="ct_1">
                                                        <div class="left">
                                                            <span>

                                                                <?php if($user_info['vip'] == 0 ): ?><a class="shengjihuiyuan" href="<?php echo U('personal/shengjihuiyuan');?>"><?php endif; ?>
                                                                <?php if($user_info['vip'] != 0 ): ?><a href="<?php echo U('course/video',array('course_id'=>$course_info_time[0]['course_id']));?>"><?php endif; ?>
                                                                <i class="iconfont icon-shipin1"></i>
                                                                <em>看视频</em>
                                                                </a>
                                                                <?php if($user_info['vip'] == 0 ): ?><a class="shengjihuiyuan" href="<?php echo U('personal/shengjihuiyuan');?>"><?php endif; ?>
                                                                <?php if($user_info['vip'] != 0 ): ?><a href="<?php echo U('course/audio',array('course_id'=>$course_info_time[0]['course_id']));?>"><?php endif; ?>
                                                                <i class="iconfont icon-headset"></i>
                                                                <em>听音频</em>
                                                                </a>
                                                            </span>
                                                        </div>
                                                        <div class="right">
                                                            <span><?php echo ($course_info_time[0]['course_buy']); ?>订阅</span>
                                                        </div>
                                                    </div>
                                                </dd>
                                            </dl>
                                            <!--专题第一个购买VIP__end-->
                                            <?php if(is_array($course_info)): $key = 0; $__LIST__ = $course_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$datass): $mod = ($key % 2 );++$key;?><dl class="twlb c">
                                                    <dt>
                                                        <a href="<?php echo U('course/video',array('course_id'=>$datass['course_id']));?>">						
                                                            <?php
 $imgarr=explode("|",$datass['course_images']); ?>
                                                            <img src="<?php echo $imgarr[0];?>"/>
                                                        </a>
                                                    </dt>
                                                    <dd>
                                                        <div class="top">
                                                            <a href="<?php echo U('course/video',array('course_id'=>$datass['course_id']));?>">
                                                                <h4>
                                                                    <!--$datass['course_hot']==2-->
                                                                    <?php if($key == 1): ?><span>NEW</span><?php endif; ?>
                                                                    <strong><?php echo $datass['course_name'];?></strong>
                                                                </h4>
                                                                <p><?php echo $datass['course_remarks'];?></p>
                                                            </a>
                                                        </div>
                                                        <div class="ct">
                                                            <div class="left">
                                                                <span>￥<?php echo ($datass['course_money']); ?>/年</span>
                                                            </div>
                                                            <div class="right">
                                                                <span>共<?php echo ($datass['course_allparts']); ?>集，
                                                                    <?php if($datass['course_allparts'] != $datass['course_parts'] ): ?>更新到第<?php echo ($datass['course_parts']); ?>集<?php endif; ?>
                                                                    <?php if($datass['course_allparts'] == $datass['course_parts'] ): ?>更新完毕<?php endif; ?>								
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="ct_1">
                                                            <div class="left">
                                                                <span>
                                                                    <a href="<?php echo U('course/video',array('course_id'=>$datass['course_id']));?>">
                                                                        <i class="iconfont icon-shipin1"></i>
                                                                        <em>看视频</em>
                                                                    </a>
                                                                    <a href="<?php echo U('course/audio',array('course_id'=>$datass['course_id']));?>">
                                                                        <i class="iconfont icon-headset"></i>
                                                                        <em>听音频</em>
                                                                    </a>
                                                                </span>
                                                            </div>
                                                            <div class="right">
                                                                <span><?php echo ($datass['course_buy']); ?>订阅</span>
                                                            </div>
                                                        </div>
                                                    </dd>
                                                </dl><?php endforeach; endif; else: echo "" ;endif; ?>	

                                        </div>
                                    </div>
                                    <?php endif;?>
                                    <div class="banner_img mg_t10">
                                        <a href="<?php echo U('personal/shengjihuiyuan');?>"><img src="/Public/home/images/banner_img.png"/></a>
                                    </div>
                                    <div class="foot_img c">
                                        <ul>
                                            <li><a href="<?php echo U('school/index');?>"><img src="/Public/home/images/foot_img.png"/></a></li>
                                            <li><a href="<?php echo U('team/index');?>"><img src="/Public/home/images/foot_img2.png"/></a></li>
                                            <li><a href="<?php echo U('personal/tuijian');?>"><img src="/Public/home/images/foot_img3.png"/></a></li>
                                            <li><a href="<?php echo U('myinfo/gongjvxiazai');?>"><img src="/Public/home/images/foot_img4.png"/></a></li>
                                        </ul>
                                    </div>
                                    <div class="foot">
                                        <ul>
                                            <li class="link">
                                                <a href="<?php echo U('index/index');?>">
                                                    <span class="iconfont icon-xuexi"></span>
                                                    <p>学习</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo U('myinfo/jiangxuejin');?>">
                                                    <span class="iconfont icon-jiangxuejinv"></span>
                                                    <p>奖学金</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo U('alreadybuy/index');?>">
                                                    <span class="iconfont icon-gouwuche"></span>
                                                    <p>已购</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo U('personal/my');?>">
                                                    <span class="iconfont icon-wode"></span>
                                                    <p>我的</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!--海报弹出层-->
                                    <div class="xksx_box">
                                        <div class="xksx animated zoomIn">
                                            <a href="<?php echo ($focus_info_['focus_url']); ?>"><img src="<?php echo ($focus_info_['focus_image']); ?>"/></a>
                                            <span onclick="xksxHide();">×</span>
                                        </div>
                                    </div>
                                    </body>
                                    </html>
                                    <script type="text/javascript" src="/Public/home/js/layer/layer.js"></script>
                                    <script type="text/javascript" src="/Public/home/js/swiper-3.4.2.jquery.min.js"></script>
                                    <script type="text/javascript">
                                                window.onload = function(){
                                                var mySwiper = new Swiper('.banner_box .swiper-container', {
                                                direction: 'horizontal',
                                                        pagination: '.banner_box .swiper-pagination',
                                                        loop:true,
                                                        autoplay:8000,
                                                        autoplayDisableOnInteraction: false,
                                                        paginationClickable: true
                                                });
                                                var swiper = new Swiper('.xsmf .swiper-container', {
                                                slidesPerView: 'auto',
                                                        paginationClickable: true,
                                                        spaceBetween:0,
                                                        freeMode: true
                                                });
                                                };
                                                function show(live_id){
                                                if (live_id){
                                                //添加直播预约表记录
                                                var str = $.ajax({ async:false, cache:false, url:"<?php echo U('index/liveorder');?>&live_id=" + live_id + " ", data: "" }).responseText;
                                                var content = "预约成功";
                                                if (str == "noon"){
                                                content = "你已经预约过哦";
                                                } else{
                                                var int_num = $("#int_num").html()*1+1;
											
                                                $("#int_num").html(int_num);
                                                }
                                                msgs(content);
                                                }
                                                }
                                                //海报弹出层(第一次加载会有弹出层)
                                                function xksxShow(){
                                                $('.xksx_box').fadeTo(200, 1);
                                                }

                                                xksxShow();
                                                function xksxHide(){
                                                localStorage["tancheng_count"] = 1;
                                                $('.xksx_box').fadeOut(300);
                                                }
                                    </script>
                                    <script type="text/javascript">
                                        $.extend($.fn, {
                                        fnTimeCountDown:function(d){
                                        this.each(function(){
                                        var $this = $(this);
                                        var o = {
                                        hm: $this.find(".hm"),
                                                sec: $this.find(".sec"),
                                                mini: $this.find(".mini"),
                                                hour: $this.find(".hour"),
                                                day: $this.find(".day"),
                                                month:$this.find(".month"),
                                                year: $this.find(".year")
                                        };
                                        var f = {
                                        haomiao: function(n){
                                        if (n < 10)return "00" + n.toString();
                                        if (n < 100)return "0" + n.toString();
                                        return n.toString();
                                        },
                                                zero: function(n){
                                                var _n = parseInt(n, 10); //解析字符串,返回整数
                                                if (_n > 0){
                                                if (_n <= 9){
                                                _n = "0" + _n
                                                }
                                                return String(_n);
                                                } else{
                                                return "00";
                                                }
                                                },
                                                dv: function(){
                                                //d = d || Date.UTC(2050, 0, 1); //如果未定义时间，则我们设定倒计时日期是2050年1月1日
                                                var _d = $this.data("end") || d;
                                                var now = new Date(),
                                                        endDate = new Date(_d);
                                                //现在将来秒差值
                                                //alert(future.getTimezoneOffset());
                                                var dur = (endDate - now.getTime()) / 1000, mss = endDate - now.getTime(), pms = {
                                                hm:"000",
                                                        sec: "00",
                                                        mini: "00",
                                                        hour: "00",
                                                        day: "00",
                                                        month: "00",
                                                        year: "0"
                                                };
                                                if (mss > 0){
                                                pms.hm = f.haomiao(mss % 1000);
                                                pms.sec = f.zero(dur % 60);
                                                pms.mini = Math.floor((dur / 60)) > 0? f.zero(Math.floor((dur / 60)) % 60) : "00";
                                                pms.hour = Math.floor((dur / 3600)) > 0? f.zero(Math.floor((dur / 3600)) % 24) : "00";
                                                pms.day = Math.floor((dur / 86400)) > 0? f.zero(Math.floor((dur / 86400)) % 30) : "00";
                                                //月份，以实际平均每月秒数计算
                                                pms.month = Math.floor((dur / 2629744)) > 0? f.zero(Math.floor((dur / 2629744)) % 12) : "00";
                                                //年份，按按回归年365天5时48分46秒算
                                                pms.year = Math.floor((dur / 31556926)) > 0? Math.floor((dur / 31556926)) : "0";
                                                } else{
                                                pms.year = pms.month = pms.day = pms.hour = pms.mini = pms.sec = "00";
                                                pms.hm = "00";
                                                //alert('结束了');

                                                }
                                                return pms;
                                                },
                                                ui: function(){
                                                if (o.hm){
                                                o.hm.html((f.dv().hm).substring(0, 2));
                                                }
                                                if (o.sec){
                                                o.sec.html(f.dv().sec);
                                                }
                                                if (o.mini){
                                                o.mini.html(f.dv().mini);
                                                }
                                                if (o.hour){
                                                o.hour.html(f.dv().hour);
                                                }
                                                if (o.day){
                                                o.day.html(f.dv().day);
                                                }
                                                if (o.month){
                                                o.month.html(f.dv().month);
                                                }
                                                if (o.year){
                                                o.year.html(f.dv().year);
                                                }
                                                setTimeout(f.ui, 1);
                                                }
                                        };
                                        f.ui();
                                        });
                                        }
                                        });
                                        $("#fnTimeCountDown0").fnTimeCountDown($("#fnTimeCountDown0").attr("data-end"));
                                    </script>
                                    <script>
                                        function qiandao(){
                                        var qiandaotext = $('.qiandao p').text();
                                        if (qiandaotext == '已签'){
                                        msgs("已签到");
                                        } else{
                                        $.ajax({
                                        url: '<?php echo U("personal/qiandao");?>',
                                                type: 'post',
                                                data: {id:1},
                                                dataType:'json',
                                                success:function(data){
                                                if (data > 0){
                                                msgs("签到成功");
                                                $('.qiandao p').text('已签');
                                                } else{
                                                msgs("已签到");
                                                }
                                                }
                                        });
                                        }
                                        }
                                        function msgs(content){
                                        layer.open({
                                        content: content,
                                                skin: 'msg',
                                                time: 2 //2秒后自动关闭
                                        });
                                        }
                                        /* $(function () {
                                         var needRefresh = sessionStorage.getItem("need-refresh2");
                                         if(needRefresh){
                                         sessionStorage.removeItem("need-refresh2");
                                         location.reload();
                                         }
                                         });*/
                                    </script>