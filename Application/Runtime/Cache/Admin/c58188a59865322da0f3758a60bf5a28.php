<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>研习班报名详情</title>
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
				    <li><a href="javascript:void(0);">首页</a></li>
					<li> > </li>
					<li><a href="javascript:void(0);">学员管理</a></li>
					<li> > </li>
					<li><a href="javascript:void(0);">研习班报名</a></li>
					<li> > </li>
					<li><a href="javascript:void(0);">研习班报名详情</a></li>
				</ul>
			</div>
			<div class="min">
				<div class="message">
					<dl class="message-block">
						<dt class="message-left">学员姓名：</dt>
						<dd class="message-right">
							<span class="text-inline"><?php echo ($data["fullname"]); ?></span>
						</dd>
					</dl>
					<dl class="message-block">
						<dt class="message-left">学员电话：</dt>
						<dd class="message-right">
							<span class="text-inline"><?php echo ($data["phone"]); ?></span>
						</dd>
					</dl>
					<dl class="message-block">
						<dt class="message-left">报名时间：</dt>
						<dd class="message-right">
							<span class="text-inline"><?php echo (date("Y-m-d H:i:s",$data["sign_addtime"])); ?></span>
						</dd>
					</dl>
					<dl class="message-block">
						<dt class="message-left">研发班名称：</dt>
						<dd class="message-right">
							<span class="text-inline"><?php echo ($data["work_title"]); ?></span>
						</dd>
					</dl>
					<dl class="message-block">
						<dt class="message-left">身份证号：</dt>
						<dd class="message-right">
							<span class="text-inline"><?php echo ($data["idcard"]); ?></span>
						</dd>
					</dl>
					<dl class="message-block">
						<dt class="message-left">公司名称：</dt>
						<dd class="message-right">
							<span class="text-inline"><?php echo ($data["company"]); ?></span>
						</dd>
					</dl>
					<dl class="message-block">
						<dt class="message-left">职位：</dt>
						<dd class="message-right">
							<span class="text-inline"><?php echo ($data["job"]); ?></span>
						</dd>
					</dl>
					<dl class="message-block">
						<dt class="message-left">报名人数：</dt>
						<dd class="message-right">
							<span class="text-inline"><?php echo ($data["num"]); ?></span>
						</dd>
					</dl>
					<dl class="message-block">
						<dt class="message-left">支付状态：</dt>
						<dd class="message-right">
							<span class="text-inline"><?php echo ($pay_flag[$data[pay_flag]]); ?></span>
						</dd>
					</dl>
					<dl class="message-block">
						<dt class="message-left">支付方式：</dt>
						<dd class="message-right">
							<span class="text-inline"><?php echo ($pay_type[$data[pay_type]]); ?></span>
						</dd>
					</dl>
					<dl class="message-block">
						<dt class="message-left">支付金额：</dt>
						<dd class="message-right">
							<span class="text-inline"><?php echo ($data["pay_money"]); ?></span>
						</dd>
					</dl>
					<dl class="message-block">
						<dt class="message-left">订单编号：</dt>
						<dd class="message-right">
							<span class="text-inline"><?php echo ($data["pay_no"]); ?></span>
						</dd>
					</dl>
					<dl class="message-block">
						<dt class="message-left">其它信息：</dt>
						<dd class="message-right">
							<span class="text-block"><?php echo ($data["remarks"]); ?></span>
						</dd>
					</dl>
				</div>
				 <!-- 学员列表 -->
				<div class="table_box">
					<table class="table" border="" cellspacing="" cellpadding="">
					
						<thead>
							<tr>
								<th>席位编号</th>
								<th>席位名称</th>
								<th>席位人数</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($infolist)): foreach($infolist as $key=>$v): ?><tr>
									<td><?php echo ($v["list_id"]); ?></td>
									<td><?php echo ($v["seat_name"]); ?></td>
									<td><?php echo ($v["seat_num"]); ?></td>
								</tr><?php endforeach; endif; ?>

						</tbody>
					</table>
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