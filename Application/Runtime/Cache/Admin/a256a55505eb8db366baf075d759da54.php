<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>专题评论详情</title>
		<link rel="stylesheet" type="text/css" href="/Public/admin/css/html5.css"/>
		<link rel="stylesheet" type="text/css"  href="/Public/admin/font/iconfont.css">
		<link rel="stylesheet" type="text/css"  href="/Public/admin/font/css/font-awesome.css">
		<link rel="stylesheet" type="text/css" href="/Public/admin/css/index.css"/>
		<script src="/Public/admin/js/jquery-1.10.2.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/Public/admin/js/icheck/icheck.js" type="text/javascript" charset="utf-8"></script>
		<link rel="stylesheet" type="text/css" href="/Public/admin/js/icheck/square/green.css">
	</head>
	<body>
		<div class="right_min">
			<div class="crumbs_nav">
				<i class="iconfont icon-shouye"></i>
				<ul>
					<li><a href="javascript:void(0);">评论详情</a></li>
				</ul>
			</div>
			<div class="min">
				<div class="message">
					<dl class="message-block">
						<dt class="message-left">专题名称：</dt>
						<dd class="message-right">
							<span class="text-inline"><?php echo ($data["course_name"]); ?></span>
						</dd>
					</dl>
					<dl class="message-block">
						<dt class="message-left">评论内容：</dt>
						<dd class="message-right">
							<span class="text-block"><?php echo ($data["comment"]); ?></span>
						</dd>
					</dl>
					<dl class="message-block">
						<dt class="message-left">学员姓名：</dt>
						<dd class="message-right">
							<span class="text-inline"><?php echo ($data["nickname"]); ?></span>
						</dd>
					</dl>
					<dl class="message-block">
						<dt class="message-left">评论时间：</dt>
						<dd class="message-right">
							<span class="text-inline"><?php echo (date("Y-m-d H:i:s",$data["addtime"])); ?></span>
						</dd>
					</dl>
				</div>
			</div>
		</div>
	</body>
</html>
<script src="/Public/admin/js/layer/layer.js"></script>
<script type="text/javascript">
	$(function(){
		$(".right_min").height($(window).height());
		$('.table_box input').iCheck({
			checkboxClass: 'icheckbox_square-green',
			radioClass: 'iradio_square-green',
		});
		var index = parent.layer.getFrameIndex(window.name);
		$('#net').on('click', function(){
			parent.layer.close(index);
		});
	});
</script>