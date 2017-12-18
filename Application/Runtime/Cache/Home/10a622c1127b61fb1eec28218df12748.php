<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta http-equiv="Cache-Control" content="no-transform" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<title>学分规则</title>
		<link rel="stylesheet" type="text/css" href="/Public/home/font/iconfont.css">
		<link rel="stylesheet" href="/Public/home/css/ziliaowanshan.css" />
		<link rel="stylesheet" type="text/css" href="/Public/home/css/html5.css"/>
		<link rel="stylesheet" href="/Public/home/css/district.css" />
		<link rel="stylesheet" href="/Public/home/css/my.css"/>
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
	</head>
	<body>
		<style type="text/css">
			.list ul{border-radius: 0;}
		</style>
		<div class="list">
			<ul>
				<li>
					<a href="<?php echo U('collect/creditrules_1',array('id'=>10));?>">
						<p>学分规则</p>
						<span class="iconfont icon-right"></span>
					</a>
				</li>
				<li>
					<a href="<?php echo U('collect/creditrules_1',array('id'=>13));?>">
						<p>奖学金制度</p>
						<span class="iconfont icon-right"></span>
					</a>
				</li>
				<li>
					<a href="<?php echo U('collect/creditrules_1',array('id'=>14));?>">
						<p>关于简易思维</p>
						<span class="iconfont icon-right"></span>
					</a>
				</li>
			</ul>
		</div>
	</body>
</html>