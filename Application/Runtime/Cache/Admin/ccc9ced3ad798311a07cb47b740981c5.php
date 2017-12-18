<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>文章管理</title>
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
					<li><a href="javascript:void(0);">其他设置</a></li>
					<li> > </li>
					<li><a href="<?php echo U('content/index');?>">文章列表</a></li>
				</ul>
			</div>
			<div class="min">
				<!--查询-->
				<div class="query">
					<form name="seachform" id="seachform" action="<?php echo U('content/index');?>"  method="post" class="form">
						<div class="form_input mg_trb">
							<label class="text">快速检索</label>
							<input type="text" name="info[keyword]" id="keyword" value="<?php echo ($keyword); ?>" placeholder="请输入文章标题" maxlength="30"/>
						</div>
						<div class="select mg_trb">
							<span class="text">文章类型</span>
							<select  id="classtype" name="info[classtype]">
								<option value="">请选择类型</option>
								<?php if(is_array($class_type)): $i = 0; $__LIST__ = $class_type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($key == $classtype ): ?>selected<?php endif; ?>><?php echo ($data); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
						</div>
						<div class="button mg_trb">
							<i class="fa fa-refresh ico"></i>
							<input type="button" value="重置" class="but chongzhi" onclick="location.href='<?php echo U('content/index');?>'"/>
						</div>
						<div class="button mg_trb">
							<i class="fa fa-search ico"></i>
							<input type="submit" value="查询" class="but chaxun"/>
						</div>
					</form>
				</div>
				<div class="tianjia">
					<a class="tianjia_but" href="<?php echo U('content/addcontent');?>">
						<i class="fa fa-plus"></i>
						添加文章
					</a>
				</div>
				<div class="table_box">
					<table class="table" border="" cellspacing="" cellpadding="">
						<colgroup>
							<col width="80">
							<col width="300">
							<col width="100">
							<col width="200">
							<col>
						</colgroup>
						<thead>
							<tr>
								<th>编号</th>
								<th>文章标题</th>
								<th>文章分类</th>
								<th>添加时间</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($listinfo)): $i = 0; $__LIST__ = $listinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$content): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($content["id"]); ?></td>
								<td><?php echo ($content["title"]); ?></td>
								<td><?php echo ($class_type[$content['classtype']]); ?></td>						
								<td><?php echo (date("Y-m-d H:i:s",$content["addtime"])); ?></td>
								<td>
									<a  href="<?php echo U('content/editcontent',array('id'=>$content['id']));?>"  class="but chaxun">
										<i class="fa fa-edit"></i>
										编辑
									</a>	
									<a href="<?php echo U('content/delcontent',array('id'=>$content['id']));?>" onclick="{if(confirm('确认删除?')){return true;}return false;}"   class="but chongzhi">
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