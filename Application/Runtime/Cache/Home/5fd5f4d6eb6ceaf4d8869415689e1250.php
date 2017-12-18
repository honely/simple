<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Cache-Control" content="no-transform" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <title>专题列表</title>
        <link rel="stylesheet" type="text/css" href="/Public/home/font/iconfont.css">
        <link rel="stylesheet" type="text/css" href="/Public/home/css/swiper-3.4.2.min.css"/>
        <link rel="stylesheet" type="text/css" href="/Public/home/css/html5.css"/>
        <script src="/Public/home/js/jquery-1.10.2.min.js" type="text/javascript" charset="utf-8"></script>
        <script>
            (function (doc, win) {
                var docEl = doc.documentElement,
                        resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
                        recalc = function () {
                            var clientWidth = docEl.clientWidth;
                            if (!clientWidth)
                                return;
                            docEl.style.fontSize = 25 * (clientWidth / 720) + 'px';
                        };
                if (!doc.addEventListener)
                    return;
                win.addEventListener(resizeEvt, recalc, false);
                doc.addEventListener('DOMContentLoaded', recalc, false);
            })(document, window);
        </script>
        <style>
			.btn00{ text-align:center; padding:0.75rem 0; font-size:0.95rem; color:#666; width:15rem;  margin:2rem auto;}
			.chongzhijilu_ul li {
				width: 100%;
				height: 3.5rem;
				padding: 0 3rem 0 2rem;
				border-bottom: 1px solid #f0f0f0;
				font-size: 1.3rem;
				line-height: 3.5rem;
				color: #363636;
				overflow: hidden;
			}
			.twlb_box{background: #fff;}
			.twlb_box .ct .twlb{margin-bottom: 0;border-bottom: 1px solid #E5E6E8;border-radius: 0;}
			.twlb_box .ct .twlb:last-child{border-bottom: none;}
        </style>
    </head>
    <body>
        <!--轮播图-->
        <div class="banner_box mg_b20">
            <div class="swiper-container">
                <div class="swiper-wrapper" id="swiper-wrapper">
                    <?php foreach($focus AS $k=>$v):?>
                    <div class="swiper-slide">
                        <a href="<?= $v['focus_url']?>">
                            <img src="<?= $v['focus_image']?>" alt="<?= $v['focus_title']?>">
                            <p><?= $v['focus_title']?></p>
                        </a>
                    </div>
                    <?php endforeach;?>

                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
        <div class="twlb_box">
            <div class="head">
                <i></i>
                <span>精彩专题</span>
                <i></i>
            </div>
            <div class="ct">
                <?php foreach($course_list AS $k=>$v):?>
                <dl class="twlb c">
                    <dt>
                        <a href="<?= U('course/video',array('course_id'=>$v['course_id']))?>">
                            <img src="<?= $v['course_images'][0]?>"/>
                        </a>
                    </dt>
                    <dd>
                        <div class="top">
                            <a href="<?= U('course/video',array('course_id'=>$v['course_id']))?>">
                                <h4>
                                    <?= $v['course_name']?>
                                    <?php if($v['course_hot'] == 2){echo "<span>热播</span>";}?>
                                </h4>
                            </a>
                        </div>
                        <div class="ct">
                            <div class="left">
                                <span>￥<?=$v['course_money']?>/年</span>
                            </div>
                            <div class="right">
                                <span><?=$v['course_update_status']?></span>
                            </div>
                        </div>
                        <div class="ct_1">
                            <div class="left">
                                <span>
                                    <a href="<?= U('course/video',array('course_id'=>$v['course_id']))?>">
                                        <i class="iconfont icon-shipin1"></i>
                                        <em>看视频</em>
                                    </a>
                                    <a href="<?= U('course/audio',array('course_id'=>$v['course_id']))?>">
                                        <i class="iconfont icon-headset"></i>
                                        <em>听音频</em>
                                    </a>
                                </span>
                            </div>
                            <div class="right">
                                <span><?=$v['course_buy']?>订阅</span>
                            </div>
                        </div>
                    </dd>
                </dl>
                <?php endforeach;?>
				<?php if($count_ >= 5): ?><div id="gundong"></div>
                <div onclick="getmore()" id="morebtn" data='1' class="btn00">加载更多</div><?php endif; ?>
            </div>
        </div>
    </body>
</html>
<script type="text/javascript" src="/Public/home/js/swiper-3.4.2.jquery.min.js"></script>
<script type="text/javascript">
                    window.onload = function () {
                        var mySwiper = new Swiper('.swiper-container', {
                            direction: 'horizontal',
                            pagination: '.swiper-pagination',
                            loop: true,
                            autoplay: 8000,
                            autoplayDisableOnInteraction: false,
                            paginationClickable: true,
                            onSlideChangeStart: function () {
                                //回调函数
                            }
                        });
                    };

                    //加载更多
                    function getmore() {
                        var page = parseInt($('#morebtn').attr("data")) + 1;
                        $('#morebtn').attr("data", page);//重置当前页数
                        //alert(page);
                        $.getJSON("<?php echo U('course/index');?>&p=" + page, function (data) {
                            if (data.length > 0) {
                                var html = ""; 
                                for (var i = 0; i < data.length; i++) { 
                                    html += '<dl class="twlb c">';
                                    html += '    <dt>';
                                    html += '        <a href="<?= U("course/video")?>&course_id=' + data[i].course_id + '">';
                                    html += '            <img src="' + data[i].course_images[0] + '"/>';
                                    html += '        </a>';
                                    html += '    </dt>';
                                    html += '    <dd>';
                                    html += '        <div class="top">';
                                    html += '            <a href="<?= U("course/video")?>&course_id=' + data[i].course_id + '">';
                                    html += '                <h4>';
                                    html +=  data[i].course_name ;
                                    if(data[i].course_hot == 2){ 
                                        html += '<span>热播</span>';
                                    } 
                                    html += '                </h4>';
                                    html += '            </a>';
                                    html += '        </div>';
                                    html += '        <div class="ct">';
                                    html += '            <div class="left">';
                                    html += '                <span>￥' + data[i].course_money + '/年</span>';
                                    html += '            </div>';
                                    html += '            <div class="right">';
                                    html += '                <span>' + data[i].course_update_status + '</span>';
                                    html += '            </div>';
                                    html += '        </div>';
                                    html += '        <div class="ct_1">';
                                    html += '            <div class="left">';
                                    html += '                <span>';
                                    html += '                    <a href="<?= U("course/video")?>&course_id=' + data[i].course_id + '">';
                                    html += '                        <i class="iconfont icon-shipin1"></i>';
                                    html += '                        <em>看视频</em>';
                                    html += '                    </a>';
                                    html += '                    <a href="<?= U("course/audio")?>&course_id=' + data[i].course_id + '">';
                                    html += '                        <i class="iconfont icon-headset"></i>';
                                    html += '                        <em>听音频</em>';
                                    html += '                    </a>';
                                    html += '                </span>';
                                    html += '            </div>';
                                    html += '            <div class="right">';
                                    html += '                <span>' + data[i].course_buy + '订阅</span>';
                                    html += '            </div>';
                                    html += '        </div>';
                                    html += '    </dd>';
                                    html += '</dl>';
                                }
                                $("#gundong").append(html); 
                            } else {
                                $("#morebtn").html('亲，没有数据了！').removeAttr('onclick');
                            }
                        });
                    }

</script>