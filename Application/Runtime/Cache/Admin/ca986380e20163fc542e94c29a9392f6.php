<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>管理员管理</title>
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
					<li><a href="javascript:void(0);">管理员设置</a></li>
					<li> > </li>
					<li><a href="<?php echo U('admininfo/index');?>">管理员管理</a></li>
				</ul>
			</div>
			<div class="min">
				<!--查询-->
				<div class="query">
					<form  name="seachform" id="seachform"  action="<?php echo U('admininfo/index');?>"  method="post" class="form"  onsubmit="return checkkwd()">
						<div class="form_input mg_trb">
							<label class="text">快速检索</label>
							<input type="text" name="info[keyword]" id="keyword" value="<?php echo ($keyword); ?>"  placeholder="请输入用户姓名或手机号"  maxlength="11"/>
						</div>
						<div class="select mg_trb">
							<span class="text">状态</span>
							<select name="info[isable]">
								<option value="">--请选择状态--</option>
								<?php if(is_array($admin_isable)): $i = 0; $__LIST__ = $admin_isable;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($key == $isable ): ?>selected<?php endif; ?>><?php echo ($data); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
						</div>
						<div class="button mg_trb">
							<i class="fa fa-refresh ico"></i>
							<input type="button" value="重置" class="but chongzhi" onclick="location.href='<?php echo U('admininfo/index');?>'"/>
						</div>
						
						<div class="button mg_trb">
							<i class="fa fa-search ico"></i>
							<input type="submit" value="查询" class="but chaxun"/>
						</div>
					</form>
				</div>
				<!--添加成员-->
				<div class="tianjia">
					<a class="tianjia_but" href="<?php echo U('admininfo/addadmin');?>">
						<i class="fa fa-plus"></i>
						添加管理员
					</a>
				</div>
				<div class="table_box">
					<table class="table" border="" cellspacing="" cellpadding="">
						<colgroup>
							<col width="80">
							<col width="100">
							<col width="100">
							<col width="100">
							<col width="100">
							<col width="100">
							<col width="200">
							<col>
						</colgroup>
						<thead>
							<tr>
								<th>编号</th>
								<th>用户名</th>
								<th>角色</th>
								<th>姓名</th>
								<th>电话</th>
								<th>状态</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($listinfo)): $i = 0; $__LIST__ = $listinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$admin): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($admin["admin_id"]); ?></td>
								<td><?php echo ($admin["username"]); ?></td>
								<td><?php echo ($admin["group_name"]); ?></td>
								<td><?php echo ($admin["realname"]); ?></td>
								<td><?php echo ($admin["phone"]); ?></td>
								<td><?php echo ($admin_isable[$admin['isable']]); ?></td>
								<td>
						
								<a href="<?php echo U('admininfo/editadmin',array('admin_id'=>$admin['admin_id']));?>" class="but chaxun">
								<i class="fa fa-edit"></i>
								编辑</a>
								<a href="<?php echo U('admininfo/repassword',array('admin_id'=>$admin['admin_id']));?>" class="but chaxun" onclick="{if(confirm('你确定要重置密码为123456吗?')){return true;}return false;}">
								<i class="fa fa-lock"></i>
								重置密码</a>
								<?php if($admin["admin_id"] != 1 ): if($admin["isable"] == 1 ): ?><a href="<?php echo U('admininfo/isable',array('admin_id'=>$admin['admin_id'],'isable'=>2));?>" onclick="{if(confirm('确认要禁用当前管理员?')){return true;}return false;}" class="but chaxun">
									<i class="fa fa-toggle-off" ></i>
									禁用</a><?php endif; ?>
									<?php if($admin["isable"] == 2 ): ?><a href="<?php echo U('admininfo/isable',array('admin_id'=>$admin['admin_id'],'isable'=>1));?>" onclick="{if(confirm('确认要启用当前管理员?')){return true;}return false;}" class="but chaxun">
									<i class="fa fa-toggle-on"></i>
									启用</a><?php endif; ?>
									<?php if($admin["admin_id"] != 1 ): ?><a href="<?php echo U('admininfo/deladmin',array('admin_id'=>$admin['admin_id']));?>" onclick="{if(confirm('确认删除?')){return true;}return false;}" class="but chongzhi">
									<i class="fa fa-trash-o"></i>
									删除</a><?php endif; endif; ?>
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