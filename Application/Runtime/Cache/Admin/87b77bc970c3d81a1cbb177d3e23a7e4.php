<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>课程播放统计</title>
		<link rel="stylesheet" type="text/css" href="/Public/admin/css/html5.css"/>
		<link rel="stylesheet" type="text/css"  href="/Public/admin/font/iconfont.css">
		<link rel="stylesheet" type="text/css"  href="/Public/admin/font/css/font-awesome.css">
		<link rel="stylesheet" type="text/css" href="/Public/admin/css/index.css"/>
		<script src="/Public/admin/js/jquery-1.10.2.min.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript" src="/Public/My97DatePicker/WdatePicker.js"></script>
	</head>
	<body>
		<div class="right_min">
			<div class="crumbs_nav">
				<i class="iconfont icon-shouye"></i>
				<ul>
					<li><a href="<?php echo U('index/welcome');?>">首页</a></li>
					<li> > </li>
					<li><a href="javascript:void(0);">统计管理</a></li>
					<li> > </li>
					<li><a href="javascript:void(0);">课程播放统计</a></li>
				</ul>
			</div>
			<div class="min">
				<!--查询-->
				<div class="table_box">
					<table class="table" border="" cellspacing="" cellpadding="">
						<colgroup>
							<col width="100">
							<col width="100">
							<col width="100">
							<col width="100">
						</colgroup>
						<thead>
							<tr>
								<th>名称</th>
								<th>播放量</th>
								<th>日期</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($infolist)): $i = 0; $__LIST__ = $infolist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($info["lesson_name"]); ?></td>
								<td><?php echo ($info["lesson_play"]); ?></td>
								<td><?php echo (date("Y-m-d H:i:s",$info["lesson_addtime"])); ?></td>
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
	//搜索
	function checkkwd(){
		var keyword=$('#keyword').val();
		/*
		if(keyword==""){
			alert("请输入要检索的关键词!");
			return false;
		}
		*/
	}
</script>