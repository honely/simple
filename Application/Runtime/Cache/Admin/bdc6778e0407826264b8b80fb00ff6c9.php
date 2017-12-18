<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>学员订阅统计</title>
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
					<li><a href="javascript:void(0);">学员订阅统计</a></li>
				</ul>
			</div>
			<div class="min">
				<!--查询-->
							
				<div class="query">
					<form  name="seachform" id="seachform"  action="<?php echo U('tongji/buyinfo');?>"  method="post" class="form"  onsubmit="return checkkwd()">
						<div class="form_input mg_trb">
							<label class="text">快速检索</label>
							<input type="text" name="info[keyword]" id="keyword" value="<?php echo ($keyword); ?>"  placeholder="请输入用户姓名或手机号"  maxlength="11"/>
						</div>
						<div class="select mg_trb">
							<span class="text">支付方式</span>
							<select name="info[buy_type]">
								<option value="">--请选择支付方式--</option>
								<?php if(is_array($buytype)): $i = 0; $__LIST__ = $buytype;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($key == $buy_type ): ?>selected<?php endif; ?>><?php echo ($data); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
						</div>
						<div class="select mg_trb">
							<span class="text">支付状态</span>
							<select name="info[buy_flag]">
								<option value="">--请选择支付状态--</option>
								<?php if(is_array($buyflag)): $i = 0; $__LIST__ = $buyflag;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($key == $buy_flag ): ?>selected<?php endif; ?>><?php echo ($data); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
						</div>
						<div class="form_input form-date mg_trb">
							<label class="text">支付时间</label>
							<input name="info[starttime]" id="starttime" class="dfinput " type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',maxDate:'#F{ $dp.$D(\'endtime\')||\'2100-10-01\' }'})" datatype="*" errormsg="时间范围开始值不能为空！" maxlength="20" style="width: 120px;" readonly value="<?php echo ($starttime); ?>" />
							<span>-</span>
							<input name="info[endtime]" id="endtime" class="dfinput" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'#F{ $dp.$D(\'starttime\') }',maxDate:'2100-10-01'})" datatype="*" errormsg="时间范围结束值范围不能为空！" maxlength="20" style="width: 120px;" readonly value="<?php echo ($endtime); ?>" />
							<i class="Validform_checktip"></i></li>
						</div>	
						<div class="button mg_trb">
							<i class="fa fa-refresh ico"></i>
							<input type="button" value="重置" class="but chongzhi" onclick="location.href='<?php echo U('tongji/buyinfo');?>'"/>
						</div>
						
						<div class="button mg_trb">
							<i class="fa fa-search ico"></i>
							<input type="submit" value="查询" class="but chaxun"/>
						</div>
					</form>
				</div>
				<div class="table_box">
					<table class="table" border="" cellspacing="" cellpadding="">
						<colgroup>
							<col width="100">
							<col width="100">
						</colgroup>
						<thead>
							<tr>
								<th>日期</th>
								<th>个数</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($infolist)): $i = 0; $__LIST__ = $infolist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($key); ?></td>
								<td><?php echo ($info); ?></td>
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