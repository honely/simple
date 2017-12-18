<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>vip等级管理</title>
		<link rel="stylesheet" type="text/css" href="/Public/admin/css/html5.css"/>
		<link rel="stylesheet" type="text/css"  href="/Public/admin/font/iconfont.css">
		<link rel="stylesheet" type="text/css"  href="/Public/admin/font/css/font-awesome.css">
		<link rel="stylesheet" type="text/css" href="/Public/admin/css/index.css"/>
		<script src="/Public/admin/js/jquery-1.10.2.min.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>
		<div class="right_min">
			<div class="crumbs_nav">
				<i class="iconfont icon-shouye"></i>
				<ul>
					<li><a href="<?php echo U('index/welcome');?>">首页</a></li>
					<li> > </li>
					<li><a href="#">课程管理</a></li>
					<li> > </li>
					<li><a href="javascript:void(0);">vip等级管理</a></li>
				</ul>
			</div>
			<div class="min">
				<div class="tianjia">
					<a class="tianjia_but" href="<?php echo U('level/add_viplevel');?>">
						<i class="fa fa-plus"></i>
						添加vip等级
					</a>
				</div>
				<div class="table_box">
					<table class="table" border="" cellspacing="" cellpadding="">
		
						<thead>
							<tr>
								<th>VIP名称</th>
								<th>年份(年)</th>
								<th>升级费用(元)</th>
								<th>返现金额(元)</th>
								<th>等级图标</th>
								<th>VIP描述</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						<?php if(is_array($levelinfo)): $i = 0; $__LIST__ = $levelinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$level): $mod = ($i % 2 );++$i;?><tr>
							<td><?php echo ($level["vip_name"]); ?></td>
							<td><?php echo ($level["vip_year"]); ?></td>
							<td><?php echo ($level["vip_money"]); ?></td>
							<td><?php echo ($level["vip_backmoney"]); ?></td>
							<td><img style="height: 30px;width:30px;" src="<?php echo ($level["vip_image"]); ?>"  /></td>
							<td><?php echo ($level["vip_title"]); ?></td>
							<td>
							<a href="<?php echo U('level/edit_viplevel',array('vip_id'=>$level['vip_id']));?>" class="but chaxun">
							<i class="fa fa-edit"></i>
							编辑</a>
							<a href="<?php echo U('level/del_viplevel',array('vip_id'=>$level['vip_id']));?>" onclick="{if(confirm('确认删除?')){return true;}return false;}" class="but chongzhi">
							<i class="fa fa-trash-o"></i>
							删除</a>
							</td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						
						</tbody>
					</table>
				</div>
				<?php echo ($pageshow); ?>
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">
	$(function(){
		$(".right_min").height($(window).height());
	});
</script>