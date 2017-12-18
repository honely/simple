<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Cache-Control" content="no-transform" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <title>你问我答</title>
        <link rel="stylesheet" type="text/css" href="/Public/home/font/iconfont.css">
        <link rel="stylesheet" type="text/css" href="/Public/home/css/swiper-3.4.2.min.css"/>
        <link rel="stylesheet" type="text/css" href="/Public/home/css/html5.css"/>
        <link rel="stylesheet" type="text/css" href="/Public/home/css/mian.css" />
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
    </head>
    <body>
        <style type="text/css">
            .grxx_box .left{margin-right: 0;}
            .grxx_box .left dd .top{height: 2rem; line-height: initial;}
            .wenda_ct{margin-bottom: 4.2rem; padding-bottom: 1rem;}
            .form_textarea textarea{height: 100px;}
        </style>
        <div class="wenda_head">
            <div class="grxx_box c">
                <dl class="left">
                    <dt>
                        <span> 
                            <?php if($userinfo['avatar']==""):?>
                            <img src="/Public/home/images/touxiang.jpg"/>
                            <?php else:?>
                            <?php if($userinfo['vip_id']==""):?>
                            <?php else:?> 
                            <i><img src="<?php echo ($userinfo["vip_image"]); ?>"/></i>
                            <?php endif;?>
                            <img onclick="tiao()" src="<?php echo ($userinfo["avatar"]); ?>"/>
                            <?php endif;?>
                        </span>
                    </dt>
                    <dd>
                        <div class="top">
                            <?php if($userinfo['nickname']==""):?>
                            <span>游客</span>
                            <em>|</em>
                            <?php else:?>
                            <span onclick="tiao()" style=" max-width: 7rem;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"><?php echo ($userinfo["nickname"]); ?></span>
                            <em style=" vertical-align: top;">|</em>
                            <?php endif;?>
                            <?php if($userinfo['level_name']==""):?>
                            <i>暂无</i>
                            <?php else:?>
                            <i  style=" vertical-align: top;"><?php echo ($userinfo["level_name"]); ?></i>
                            <?php endif;?>
                        </div>
                        <span class="ct">学分：
                            <?php if($userinfo['nickname']==""):?>
                            <em>0分</em>
                            <?php else:?>
                            <em><?php echo ($userinfo["score"]); ?>分</em>
                            <?php endif;?>
                        </span>
                    </dd>
                </dl>
            </div>
            <div class="but c">
                <a href="<?php echo U('course/popular');?>">热门课程</a>
                <a href="<?php echo U('index/attention');?>">关注简异思维</a>
            </div>
        </div>
        <!--轮播图-->
        <div class="banner_box mg_t10">
            <div class="swiper-container">
                <div class="swiper-wrapper" id="swiper-wrapper">
                    <?php if(is_array($banner)): $i = 0; $__LIST__ = $banner;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="swiper-slide">
                        <a href="<?php echo ($vo["focus_url"]); ?>"><img src="<?php echo ($vo["focus_image"]); ?>" alt="<?php echo ($vo["focus_title"]); ?>图片"></a>
                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>		
        <div class="twlb_box pd_lr06 mg_t15">
            <div class="head">
                <i></i>
                <span>讨论内容</span>
                <i></i>
            </div>
        </div>
        <div class="wenda_ct" >
            <?php if($count == 0):?> 
            暂无讨论内容! 
            <?php else:?>
            <?php if(is_array($forum)): $i = 0; $__LIST__ = $forum;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><dl class="wenda c" onclick="addview('<?php echo ($vo["forum_id"]); ?>')">
                    <dt>
                        <a href="#">
                            <?php if($vo['vip_id'] == ""):?> 
                            <?php else:?>
                            <i><img style="width:1.3rem;height:1.3rem;" src="<?php echo ($vo["vip_image"]); ?>"/></i>
                            <?php endif;?> 
                            <span><img src="<?php echo ($vo["avatar"]); ?>"/></span>
                        </a>
                    </dt>
                    <dd>
                        <div class="top">
                            <a>
                                <h4><?php echo ($vo["nickname"]); ?>
                                    <?php if($vo['forum_top']==1):?>  
                                    <?php else:?>
                                    <em>置顶</em>
                                    <?php endif;?>
                                </h4>
                                <span><?php echo ($vo["forum_addtime"]); ?></span>
                            </a>
                        </div>
                        <div class="ct" >
                            <a>
                                <h4 style="color:#353535"><?php echo ($vo["forum_title"]); ?></h4>
                                <p>
                                    <?php echo ($vo["forum_content"]); ?>
                                </p>
                            </a>
                        </div>
                        <div class="bottom">
                            <span>
                                <i class="iconfont icon-yueduliang"></i>
                                <em id="view<?php echo ($vo["forum_id"]); ?>"><?php echo ($vo["forum_view"]); ?></em>
                            </span>
                            <span>
                                <i class="iconfont icon-zan"></i>
                                <em><?php echo ($vo["forum_good"]); ?></em>
                            </span>
                            <span>
                                <i class="iconfont icon-xiaoxi1" ></i>
                                <em><?php echo ($vo["forum_discuss"]); ?></em>
                            </span>
                        </div>
                    </dd>
                </dl><?php endforeach; endif; else: echo "" ;endif; ?>
            <?php endif;?>
            <div id="gundong"></div>
            <?php if($count > 5): ?><a onclick="getmore()" id="morebtn" data='1' style="text-align: center; color: #a53e00;font-size: 1.3rem; margin:3rem 0;display: block;">加载更多</a><?php endif; ?>
        </div>
        <div class="but_footer">
            <span onclick="pinglu();" class="but">发布话题</span>
        </div>
        <div id="textarea_box" style="display:none;">
            <div class="form_textarea c">
                <form class="c" method="post" id="pinglun" action="<?php echo U('forum/addforum');?>" >
                    <input type="text" class="input-text"  name="title" placeholder="请输入标题 最多输入30字" maxlength="30"/>
                    <textarea  placeholder="请输入内容 最多输入200字" name="content" maxlength="200"></textarea>
                    <input type="submit" class="but" value="发表" >
                </form>
            </div>
        </div>
    </body>
</html>
<script type="text/javascript" src="/Public/home/js/layer/layer.js"></script>
<script type="text/javascript" src="/Public/home/js/swiper-3.4.2.jquery.min.js"></script>
<script type="text/javascript">
    window.onload = function () {
        var mySwiper = new Swiper('.banner_box .swiper-container', {
            direction: 'horizontal',
            pagination: '.banner_box .swiper-pagination',
            loop: true,
            autoplay: 8000,
            autoplayDisableOnInteraction: false,
            paginationClickable: true
        });
    }
    function pinglu() {
        var html = $("#textarea_box").html();
        //layer.closeAll();关闭
        layer.open({
            type: 1,
            content: html,
            anim: 'up',
            style: 'position:fixed; bottom:0; left:0; width: 100%;  padding:0; border:none; background:none;'
        });
    }
     
    function getmore(){
        var page=parseInt($('#morebtn').attr("data"))+1; 
        $.getJSON("<?php echo U('forum/index');?>&p="+page,function(result){
            $('#morebtn').attr("data",page);//重置当前页数
            var data = result.forum;
            if(data.length>0){
                var html="";
                for(var i=0;i<data.length;i++){ 	 
                    html+='<dl class=\"wenda c\" onclick="addview('+data[i].forum_id+')">';
                        html+='<dt>'; 
                            html+='<a>'; 
                            if(data[i].vip_id==null){  
                            }else{ 
                            html+='<i><img style="width:1.3rem;height:1.3rem;" src='+data[i].vip_image+'  		/></i>';
                            } 
                            html+='<span><img src='+data[i].avatar+'  /></span>';  
                            html+='</a>';
                        html+='</dt>';
                        html+='<dd>';
                            html+='<div class=\"top\"  >';
                                html+='<a>'; 
                                    html+='<h4>'+data[i].nickname+'';
                                    if(data[i].forum_top==1){  
                                    }else{
                                    html+='<em>置顶</em>';   
                                    }
                                    html+='</h4>';
                                    html+='<span>'+data[i].forum_addtime+'</span>';
                                html+='</a>';
                            html+='</div>';
                            html+='<div class=\"ct\" >';
                                html+='<a>';
                                    html+='<h4>'+data[i].forum_title+'</h4>';
                                    html+='<p>'+data[i].forum_content+'</p>';
                                html+='</a>';
                            html+='</div>';
                            html+='<div class=\"bottom\">';
                                html+='<span>';
                                    html+='<i class=\"iconfont icon-yueduliang\"></i>';
                                    html+='<em id="cishu'+data[i].forum_id+'" >'+data[i].forum_view+'</em>';  
                                html+='</span>';
                                html+='<span>';
                                    html+='<i class=\"iconfont icon-zan\"></i>';
                                    html+='<em>'+data[i].forum_good+'</em>';
                                html+='</span>';
                                html+='<span>';
                                    html+='<i class=\"iconfont icon-xiaoxi1\" ></i>';
                                    html+='<em>'+data[i].forum_discuss+'</em>';
                                html+='</span>';
                            html+='</div>';
                        html+='</dd>';
                    html+='</dl>';
                }
                $("#gundong").append(html);
            }else{
                $("#morebtn").html('亲，没有数据了！');
            }
        });
    }
    
    //浏览次数加1
    function addview(forum_id){
        var url="<?php echo (C("WEB_HOST")); ?>index.php?m=Home&c=forum&a=addview";
		var data={"forum_id":forum_id};
		var success=function(response){
			if(response.errno == 0){
				var forum_view = response.forumview;   
				$("#view"+forum_id).html("<em>"+forum_view+"</em> ");
				$("#cishu"+forum_id).html("<em>"+forum_view+"</em> ");      
			}
		}
        location.href="<?php echo U('forum/foruminfo');?>&forum_id="+forum_id;
		$.post(url,data,success,'json')
    }
    
    //跳转个人中心
    function tiao(){
        location.href = "<?php echo U('personal/my');?>";
    }
    $(function () {
        var needRefresh = sessionStorage.getItem("need-refresh");
        if(needRefresh){
            sessionStorage.removeItem("need-refresh");
            location.reload();
        }
    });
</script>