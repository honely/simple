<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Cache-Control" content="no-transform" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <title>你问我答-详情</title>
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
                        <?php if($forum['vip_id']==""):?>
                        <?php else:?> 
                        <i><img style="width:1.3rem;height:1.3rem;" src="<?php echo ($forum["vip_image"]); ?>"/></i>
                        <?php endif;?>
                        <span><img src="<?php echo ($forum["avatar"]); ?>"/></span>
                    </a>
                </dt>
                <dd>
                    <div class="top">
                        <a href="">
                            <h4><?php echo ($forum["nickname"]); ?>
                                <?php if($forum['forum_top']==1):?>
                                 
                                <?php else:?>
                                <em>置顶</em>
                                <?php endif;?>
                            </h4>
                            <span><?php echo ($forum["forum_addtime"]); ?></span>
                        </a>
                    </div>
                    <div class="ct">
                        <a href="#">
                            <h4 style="color:#353535"><?php echo ($forum["forum_title"]); ?></h4>
                            <p>
                                <?php echo ($forum["forum_content"]); ?>
                            </p>
                        </a>
                    </div>
                    <div class="bottom">
                        <span>
                            <i class="iconfont icon-yueduliang"></i>
                            <em><?php echo ($forum["forum_view"]); ?></em>
                        </span>
                        <span>
                            <i class="iconfont icon-zan"></i> 
                            <em id="num"><?php echo ($forum["forum_good"]); ?></em>  
                        </span>
                        <span>
                            <i class="iconfont icon-xiaoxi1"></i>
                            <em><?php echo ($forum["forum_discuss"]); ?></em>
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
            <center >暂无评论!</center> 
            <?php else:?>
            <?php if(is_array($forumcomment)): $i = 0; $__LIST__ = $forumcomment;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><dl class="wenda c">
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
                            <a href="<?php echo U('forum/forumcommentinfo',array('comment_id'=>$vo['comment_id'],'forum_id'=>$vo['forum_id']));?>">
                                <h4><?php echo ($vo["nickname"]); ?>
                                    <?php if($vo['comment_top']==1):?>
                                     
                                    <?php else:?>
                                    <em>置顶</em>
                                    <?php endif;?>
                                </h4>
                                <span><?php echo ($vo["addtime"]); ?></span>
                            </a>
                        </div>
                        <div class="ct">
                            <a href="<?php echo U('forum/forumcommentinfo',array('comment_id'=>$vo['comment_id'],'forum_id'=>$vo['forum_id']));?>">
                                <p><?php echo ($vo["comment"]); ?></p>
                            </a>
                        </div>
                        <div class="bottom"> 
                            <span>
                                <i class="iconfont icon-zan" id="support<?php echo ($vo["comment_id"]); ?>" onclick="support('<?php echo ($vo["forum_id"]); ?>', '<?php echo ($vo["comment_id"]); ?>')"></i>
                                <em id="numsss<?php echo ($vo["comment_id"]); ?>"><?php echo ($vo["comment_good"]); ?></em>
                            </span>
                            <span>
                                <i class="iconfont icon-xiaoxi1" onclick="location.href = '<?php echo U('forum/forumcommentinfo',array('comment_id'=>$vo['comment_id'],'forum_id'=>$vo['forum_id']));?>'"></i>
                                <em><?php echo ($vo["comment_count"]); ?></em>
                            </span>
                        </div>
                    </dd>
                </dl><?php endforeach; endif; else: echo "" ;endif; ?>
            <?php endif;?>
            <div id="gundong"></div>
            <?php if($count > 5): ?><a onclick="getmore('<?php echo ($forum["forum_id"]); ?>')" id="morebtn" data='1' style="text-align: center; color: #a53e00;font-size: 1.3rem; margin:3rem 0;display: block;">加载更多</a><?php endif; ?>
        </div>
        <div class="but_footer">
            <ul>
                <li>
                    <a onclick="pinglu();">
                        <i class="iconfont icon-xiaoxi1"></i>
                        <em>评论</em>
                    </a>
                </li>
                <li>
                    <a id="praise" onclick="praise('<?php echo ($forum["forum_id"]); ?>');">
                        <i class="iconfont icon-zan"></i>
                        <em id="nums"><?php echo ($forum["forum_good"]); ?></em>
                    </a>
                </li>
                <li>
                    <a href="<?php echo U('personal/tuijian',array('forum_id'=>$forum['forum_id']));?>">
                        <i class="iconfont icon-zhuanfa"></i>
                        <em>转发</em>
                    </a>
                </li>
            </ul>
        </div>
        <div id="textarea_box" style="display:none;">
            <div class="form_textarea c">
                <form class="c" action="<?php echo U('forum/forumcomment',array('forum_id'=>$forum['forum_id']));?>" method="post">
                    <textarea name="comment"  placeholder="请输入内容 最多输入200字" maxlength="200"></textarea>
                    <input type="submit" class="but" value="发表" >
                </form>
            </div>
        </div>
    </body>
</html>
<script type="text/javascript" src="/Public/home/js/layer/layer.js"></script>
<script type="text/javascript">
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
    function praise(forum_id) { 
		$("#praise").removeAttr("onclick");
		var url = "<?php echo (C("WEB_HOST")); ?>index.php?m=Home&c=forum&a=praise";
		var data = {"forum_id": forum_id};
		var success = function (response) {
		if (response.errno == 0) {
			location.href = "<?php echo U('index/index');?>";
		} else if (response.errno == 1) { 
                    //点赞次数
                    var forum_good = response.forum_good;
                    $("#num").html("<em>"+forum_good+"</em> ");
                    $("#nums").html("<em>"+forum_good+"</em> "); 
                    layer.open({
                        content: '点赞成功！',
                        skin: 'msg',
                        time: 2 //2秒后自动关闭 		 
                    });  
			
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

    

    function getmore(forum_id){
		var page = parseInt($('#morebtn').attr("data")) + 1;
		$.getJSON("<?php echo U('forum/foruminfo');?>&forum_id=" + forum_id + "&p=" + page, function(result){
			$('#morebtn').attr("data", page); //重置当前页数
				var data = result.forumcomment;
				if (data.length > 0){
				var html = "";
				for (var i = 0; i < data.length; i++){
					html += '<dl class=\"wenda c\">';
					html += '<dt>';
					html += '<a>';
					if (data[i].vip_id == null){
					} else{
					html += '<i><img style="width:1.3rem;height:1.3rem;" src=' + data[i].vip_image + '  		/></i>';
					}
					html += '<span><img src=' + data[i].avatar + '  /></span>';
					html += '</a>';
					html += '</dt>';
					html += '<dd>';
					html += '<div class=\"top\">';
					html += '<a href="<?php echo U('forum/forumcommentinfo');?>&comment_id=' + data[i].comment_id + '&forum_id=' + data[i].forum_id + ' ">';
					html += '<h4>' + data[i].nickname + '';
					if (data[i].comment_top == 1){
					 
					} else{
					html += '<em>置顶</em>';
					}
					html += '</h4>';
					html += '<span>' + data[i].addtime + '</span>';
					html += '</a>';
					html += '</div>';
					html += '<div class=\"ct\">';
					html += '<a href="<?php echo U('forum/forumcommentinfo');?>&comment_id=' + data[i].comment_id + '&forum_id=' + data[i].forum_id + ' ">';
					html += '<p>' + data[i].comment + '</p>';
					html += '</a>';
					html += '</div>';
					html += '<div class=\"bottom\"> ';
					html += '<span>';
					html += '<i class=\"iconfont icon-zan\" id="support'+data[i].comment_id+'"    onclick="support(' + data[i].forum_id + ',' + data[i].comment_id + ')"></i>';
					html += '<em id="numm'+data[i].comment_id+'">' + data[i].comment_good + '</em>';
					html += '</span>';
					html += '<span>';
					html += '<i class=\"iconfont icon-xiaoxi1\"  onclick="tiao(' + data[i].forum_id + ',' + data[i].comment_id + ')"></i>';
					html += '<em>' + data[i].comment_count + '</em>';
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
	
	
    function tiao(forum_id, comment_id){
            location.href = "<?php echo U('forum/forumcommentinfo');?>&forum_id=forum_id&comment_id=" + comment_id;
    } 
    
    function support(forum_id, comment_id) { 
		$("#support"+comment_id).removeAttr("onclick"); 
		var url = "<?php echo (C("WEB_HOST")); ?>index.php?m=Home&c=forum&a=support";
		var data = {"forum_id": forum_id, "comment_id":comment_id};
		var success = function (response) {
		if (response.errno == 0) {
			location.href = "<?php echo U('index/index');?>";
			} else if (response.errno == 1) {
                            //点赞次数
                            var comment_good = response.comment_good; 
                            $("#numsss"+comment_id).html("<em>"+comment_good+"</em> ");
                            $("#numm"+comment_id).html("<em>"+comment_good+"</em> ");  
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
    sessionStorage.setItem("need-refresh", true); 
</script>