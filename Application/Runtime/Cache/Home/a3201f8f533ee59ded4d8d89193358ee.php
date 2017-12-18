<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta http-equiv="Cache-Control" content="no-transform" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<title>排行榜</title>
		<link rel="stylesheet" type="text/css" href="/Public/home/css/html5.css"/>
		<link rel="stylesheet" type="text/css" href="/Public/home/css/mian.css" />
		<script src="/Public/home/js/jquery-1.10.2.min.js" type="text/javascript" charset="utf-8"></script>
		<script>
			(function(doc, win) {
				var docEl = doc.documentElement,
					resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
					recalc = function() {
						var clientWidth = docEl.clientWidth;
						if(!clientWidth) return;
						docEl.style.fontSize = 25 * (clientWidth / 720) + 'px';
					};
				if(!doc.addEventListener) return;
				win.addEventListener(resizeEvt, recalc, false);
				doc.addEventListener('DOMContentLoaded', recalc, false);
			})(document, window);
		</script>
		<style>
		.btn00{ text-align:center; padding:0.75rem 0; font-size:0.95rem; color:#666; width:15rem;  margin:2rem auto;}
		</style>
	</head>
	<body>
		<style type="text/css">
			body{background: #fff;}
		</style>
		<div class="xxphb">
			<div class="top">
				<h4 style="max-width:12rem;overflow:hidden;text-overflow: ellipsis;white-space: nowrap;"><?php echo ($userinfo['nickname']); ?></h4>
				<p>
					<span>第<?php echo ($user_order); ?>名</span>
					<i><?php echo ($userinfo['score']); ?>学分</i>
				</p>
			</div>
			<div class="ct">
				<ul>
					<?php foreach($userinfos as $key=>$val): ?>
						<li>
							<h6><?php echo ($val['paiming']); ?></h6>
							<strong></strong>
							<i><img src="<?php echo ($val['avatar']); ?>"/></i>
							<p><mark style="max-width:10rem;overflow:hidden;text-overflow: ellipsis;white-space: nowrap;vertical-align: top; color:#363636;"><?php echo ($val['nickname']); ?></mark><mark><?php echo ($user_level[$val['level']]); ?></mark></p>
							<em><?php echo ($val['score']); ?>学分</em>
						</li>
					<?php endforeach; ?>
				</ul>
				 <?php if($count_ >= 10): ?><ol id="gundong"></ol>
				<div onclick="getmore()" id="morebtn" data='1' class="btn00">加载更多</div><?php endif; ?>
			</div>
		</div>
		
	</body>
	<script>
		function getmore(){
		var page=parseInt($('#morebtn').attr("data"))+1;
		$('#morebtn').attr("data",page);//重置当前页数
		$.getJSON("<?php echo U('personal/xuexipaihangbang');?>&p="+page,function(result){
			var data=result.userinfos;
			if(data.length>0){
				var html="";
				var str="";
				for(var i=0;i<data.length;i++){
					html+="<li>";
					html+="<h6 >"+data[i].paiming+"</h6>";
					html+="<strong>";
					html+="</strong>";
					html+="<i>";
					html+="<img src="+data[i].avatar+">";
					html+="</i>";
					html+="<p ><mark style=\"max-width:10rem;overflow:hidden;text-overflow: ellipsis;white-space: nowrap;vertical-align: top;  color:#363636;\">"+data[i].nickname+"</mark><mark>"+data[i].level_name+"</mark></p>";
					html+="<em >"+data[i].score+"学分"+"</em>";
					html+="</li>";
				}
				$("#gundong").append(html);
			}else{
				$("#morebtn").html('亲，没有数据了！');
			}
		});
	}
	</script>
</html>