<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Cache-Control" content="no-transform" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <title>你问我答-评论-详情</title>
        <link rel="stylesheet" type="text/css" href="/Public/home/font/iconfont.css">
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
            body{background: #fff;}
            .grxx_box .left{margin-right: 0;}
            .grxx_box .left dd .top{height: 2rem; line-height: initial;}
            .wenda_ct{margin-bottom: 4.2rem; padding-bottom: 1rem;}
            .form_textarea textarea{height: 100px;}
            .wenda-xq_head.wenda_ct{margin-bottom:0; padding-bottom: 0; }
            .wenda-xq_head.wenda_ct .wenda{margin-bottom: 0;}
            .but_footer{padding: 0;}
        </style>
        <div class="wenda-xq_head wenda_ct">
            <dl class="wenda c">
                <dt>
                    <a href="#">
                        <?php if($forumcomment['vip_id']==""):?>
                        <?php else:?> 
                        <i><img style="width:1.3rem;height:1.3rem;" src="<?php echo ($forumcomment["vip_image"]); ?>"/></i>
                        <?php endif;?>
                        <span><img src="<?php echo ($forumcomment["avatar"]); ?>"/></span>
                    </a>
                </dt>
                <dd>
                    <div class="top">
                        <a href="">
                            <h4><?php echo ($forumcomment["nickname"]); ?>
                                <?php if($forumcomment['comment_top']==1):?>
                                 
                                <?php else:?>
                                <em>置顶</em>
                                <?php endif;?>
                            </h4>
                            <span><?php echo ($forumcomment["addtime"]); ?></span>
                        </a>
                    </div>
                    <div class="ct">
                        <a href="#">
                            <p>
                                <?php echo ($forumcomment["comment"]); ?>
                            </p>
                        </a>
                    </div>
                    <div class="bottom">
                        <span>
                            <i class="iconfont icon-zan" id="support<?php echo ($forumcomment["comment_id"]); ?>"  onclick="support('<?php echo ($forumcomment["forum_id"]); ?>','<?php echo ($forumcomment["comment_id"]); ?>')"></i>
                            <em id="comment_good"><?php echo ($forumcomment["comment_good"]); ?></em>
                        </span>
                        <span>
                            <i class="iconfont icon-xiaoxi1"></i>
                            <em><?php echo ($forumcomment["comment_count"]); ?></em>
                        </span>
                    </div>
                </dd>
            </dl>
        </div>
        <div class="wenda-xq_pl">
            <h4>全部评论</h4>
        </div>
        <div class="wenda_ct">
            <?php if($count == 0):?> 
            暂无评论! 
            <?php else:?>
            <?php if(is_array($forumcomment2)): $i = 0; $__LIST__ = $forumcomment2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><dl class="wenda c">
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
                            <a href="">
                                <h4><?php echo ($vo["nickname"]); ?></h4>  
                                <span><?php echo ($vo["addtime2"]); ?></span>
                            </a>
                        </div>
                        <div class="ct">
                            <a href="#">
                                <p>
                                    <?php echo ($vo["comment2"]); ?>
                                </p>
                            </a>
                        </div>
                        <div class="bottom">
                            <span>
                                <i class="iconfont icon-zan" id="up<?php echo ($vo["comment2_id"]); ?>" onclick="thumbs_up('<?php echo ($vo["forum_id"]); ?>','<?php echo ($vo["comment2_id"]); ?>')"></i>
                                <em id="comment2_good<?php echo ($vo["comment2_id"]); ?>"><?php echo ($vo["comment2_good"]); ?></em>
                            </span>   
                        </div>
                    </dd>
                </dl><?php endforeach; endif; else: echo "" ;endif; ?>
            <?php endif;?>
			<div id="gundong"></div>
            <?php if($count > 5): ?><a onclick="getmore('<?php echo ($forumcomment["forum_id"]); ?>','<?php echo ($forumcomment["comment_id"]); ?>')" id="morebtn" data='1' style="text-align: center; color: #a53e00;font-size: 1.3rem; margin:3rem 0;display: block;">加载更多</a><?php endif; ?>
        </div>
        <div class="but_footer">
            <span onclick="pinglu();" class="but">评论</span>
        </div>
        <div id="textarea_box" style="display:none;">
            <div class="form_textarea c">
                <form class="c" method="post" id="pinglun" action="<?php echo U('forum/forumcommentadd2',array('comment_id'=>$forumcomment['comment_id'],'forum_id'=>$forumcomment['forum_id']));?>" >
                    <textarea  placeholder="请输入内容 最多输入200字" name="comment2" maxlength="200"></textarea>
                    <input type="submit" class="but" value="发表" >
                </form>
            </div>
        </div>  
    </body>
</html>
<script type="text/javascript" src="/Public/home/js/layer/layer.js"></script>
<script>
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
    //给forumcomment点赞
    function support(forum_id,comment_id) { 
		$("#support"+comment_id).removeAttr("onclick"); 
        var url = "<?php echo (C("WEB_HOST")); ?>index.php?m=Home&c=forum&a=support";
        var data = {"forum_id": forum_id,"comment_id":comment_id};
        var success = function (response) {
            if (response.errno == 0) {
                location.href = "<?php echo U('index/index');?>";
            } else if (response.errno == 1) {
                 //点赞次数
                var comment_good = response.comment_good; 
                $("#comment_good").html("<em>"+comment_good+"</em> ");
                layer.open({
                    content: '点赞成功！',
                    skin: 'msg',
                    time: 2 //2秒后自动关闭
                });
                //window.location.reload();
            } else {
                layer.open({
                    content: '点赞失败！',
                    skin: 'msg',
                    time: 2 //2秒后自动关闭
                });
            }
        }
        $.post(url, data, success, 'json');
    }
     
	
	function getmore(forum_id,comment_id){
		var page = parseInt($('#morebtn').attr("data")) + 1;
		$.getJSON("<?php echo U('forum/forumcommentinfo');?>&forum_id=" +forum_id+ "&comment_id=" +comment_id+ "&p=" + page, function(result){
			$('#morebtn').attr("data", page); //重置当前页数
			var data = result.forumcomment2; 
			if (data.length > 0){ 
				var html = "";
				for (var i = 0; i < data.length; i++){
					html += '<dl class=\"wenda c\">';
                    html += '<dt>';
                        html += '<a> ';
							if (data[i].vip_id == null){
							} else{
                            html += '<i><img style="width:1.3rem;height:1.3rem;" src=' + data[i].vip_image + ' /></i>'; 
							}
                            html += '<span><img src=' + data[i].avatar + ' /></span>';
                        html += '</a>';
                    html += '</dt>';
                    html += '<dd>';
                        html += '<div class=\"top\">';
                            html += '<a>';
                                html += '<h4>' + data[i].nickname + '</h4>';  
                                html += '<span>' + data[i].addtime2 + '</span>';
                            html += '</a>';
                        html += '</div>';
                        html += '<div class=\"ct\">';
                            html += '<a>';
                                html += '<p>' + data[i].comment2 + '</p>';   
                            html += '</a>';
                        html += '</div>';
                        html += '<div class=\"bottom\"> ';
                            html += '<span>';  
								html += '<i class=\"iconfont icon-zan\" id="up'+data[i].comment2_id+'"  onclick="thumbs_up(' + data[i].forum_id + ',' + data[i].comment2_id + ')"></i>';  
								html += '<em id="comment2_good'+data[i].comment2_id+'">' + data[i].comment2_good + '</em>';
                            html += '</span>';   
                        html += '</div>';
                    html += '</dd>';
                html += '</dl>';
				}
				$("#gundong").append(html);
			} else{
				$("#morebtn").html('亲，没有数据了！');
			}  
		});
	}
	
	//给forumcomment2点赞
    function thumbs_up(forum_id,comment2_id) {
		$("#up"+comment2_id).removeAttr("onclick"); 
        var url = "<?php echo (C("WEB_HOST")); ?>index.php?m=Home&c=forum&a=thumbs_up";
        var data = {"forum_id": forum_id,"comment2_id":comment2_id};
        var success = function (response) {
            if (response.errno == 0) {
                location.href = "<?php echo U('index/index');?>";
            } else if (response.errno == 1) {
                 //点赞次数
                var comment2_good = response.comment2_good;
                $("#comment2_good"+comment2_id).html("<em>"+comment2_good+"</em> ");
                layer.open({
                    content: '点赞成功！',
                    skin: 'msg',
                    time: 2 //2秒后自动关闭
                });
                //window.location.reload();
            } else {
                layer.open({
                    content: '点赞失败！',
                    skin: 'msg',
                    time: 2 //2秒后自动关闭
                });
            }
        }
        $.post(url, data, success, 'json');
    }
	
	
	
	
</script>