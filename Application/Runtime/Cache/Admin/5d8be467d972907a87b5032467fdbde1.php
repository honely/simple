<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>配置管理</title>
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
					<li><a href="javascript:void(0);">配置管理</a></li>
					
				</ul>
			</div>
			<div class="min">
				<!--查询-->
							
				<div class="query">
					<form  name="seachform" id="seachform"  action="<?php echo U('set/index');?>"  method="post" class="form"  onsubmit="return checkkwd()">
						<div class="form_input mg_trb">
							<label class="text">快速检索</label>
							<input type="text" name="info[keyword]" value="<?php echo ($keyword); ?>"  placeholder="请输入查询内容"  maxlength="11"/>
						</div>
						
						<div class="button mg_trb">
                         <i class="fa fa-refresh ico"></i>
                         <input type="button" value="重置" class="but chongzhi" onclick="location.href='<?php echo U('set/index');?>'"/>
                        </div>
						
						<div class="button mg_trb">
							<i class="fa fa-search ico"></i>
							<input type="submit" value="查询" class="but chaxun"/>
						</div>
					</form>
				</div>
				<!--添加成员-->
				<div class="tianjia">
					<a class="tianjia_but" href="<?php echo U('set/addinfo');?>">
						<i class="fa fa-plus"></i>
						添加配置
					</a>
				</div>
				<div class="table_box">
					<table class="table" border="" cellspacing="" cellpadding="">
						<colgroup>
							<col width="80">
							<col width="100">
							<col width="100">
							<col width="200">
							<col>
						</colgroup>
						<thead>
							<tr>
								<th width="10%">序号</th>
								<th width="10%">配置key</th>
								<th width="35%">配置值</th>
								<th width="35%">配置详情</th>
								<th width="10%">操作</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($listinfo)): $i = 0; $__LIST__ = $listinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$admin): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($admin["set_id"]); ?></td>
								<td><?php echo ($admin["set_key"]); ?></td>
								<td><?php echo mb_substr($admin['set_value'],0,15,'utf-8'); if(strlen($admin['set_value'])>15){echo '...';}?></td>
								<td><?php echo ($admin["set_remark"]); ?></td>
								
								<td>
						
								
								
								
								
								<a href="<?php echo U('set/editinfo',array('set_id'=>$admin['set_id']));?>"  class="but chaxun">
								<i class="fa fa-edit"></i>
								编辑</a>
								
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