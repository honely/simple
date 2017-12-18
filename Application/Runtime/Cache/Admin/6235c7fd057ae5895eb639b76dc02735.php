<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>工具下载管理</title>
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
					<li><a>其他设置</a></li>
					<li> > </li>
					<li><a href="<?php echo U('downinfo/downinfo');?>">工具下载管理</a></li>
				</ul>
			</div>
			<div class="min">
				<!--查询-->
				<div class="query">
					<form name="seachform" id="seachform" action="<?php echo U('downinfo/downinfo');?>"  method="post" class="form" >
						<div class="form_input mg_trb">
							<label class="text">快速检索</label>
							<input type="text" name="info[downinfo]" id="keyword" value="<?php echo ($downinfo); ?>" placeholder="请输入标题搜索" maxlength="15"/>							
						</div>

						<div class="button mg_trb">
							<i class="fa fa-refresh ico"></i>
							<input type="button" value="重置" class="but chongzhi" onclick="location.href='<?php echo U('downinfo/downinfo');?>'"/>
						</div>
						<div class="button mg_trb">
							<i class="fa fa-search ico"></i>
							<input type="submit" value="查询" class="but chaxun"/>
						</div>
					</form>
				</div>
				<div class="tianjia">
					<a class="tianjia_but" href="<?php echo U('downinfo/addpage');?>">
						<i class="fa fa-plus"></i>
						添加工具
					</a>
				</div>
				<div class="table_box">
					<table class="table" border="" cellspacing="" cellpadding="">
						<colgroup>
							<col width="100">
							<col width="100">
							<col width="100">
							<col width="100">
							<col width="100">
						</colgroup>
						<thead>
							<tr>
								<th>编号</th>
								<th>下载标题</th>
								<th>下载次数</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($arr)): $i = 0; $__LIST__ = $arr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($vo["down_id"]); ?></td>
								<td><?php echo ($vo["down_title"]); ?></td>
								
								<td><?php echo ($vo["down_count"]); ?></td>

								<td>
									<a href="<?php echo U('downinfo/upd',array('down_id'=>$vo['down_id']));?>"  class="but chaxun">
										<i class="fa fa-edit"></i>
										编辑
									</a>
								
									<a href="<?php echo U('downinfo/del',array('down_id'=>$vo['down_id']));?>" onclick="{if(confirm('确认删除?')){return true;}return false;}"  class="but chongzhi">
										<i class="fa fa-trash-o"></i>
										删除
									</a>
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