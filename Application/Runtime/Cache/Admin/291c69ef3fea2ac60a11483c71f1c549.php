<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>申请分社管理</title>
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
				<li><a href="javascript:void(0);">  学员管理 > 申请分社管理 </a></li>
			</ul>
		</div>
		<div class="min">
			<!--查询-->
			<div class="query">
				<form  name="seachform" id="seachform"  action="<?php echo U('Applyinfo/index');?>"  method="post" class="form">
					<div class="form_input mg_trb">
						<label class="text">查询</label>
						<input type="text" name="info[keyword]" id="keyword" value="<?php echo ($keyword); ?>"  placeholder="输入姓名 电话或城市"  maxlength="11" style="width: 150px"/>
					</div>
					<div class="form_input mg_trb form-date">
						<label class="text">时间</label>
						<input type="text" class="laydate-icon layer-date" name="info[starttime]"  value="<?php echo ($starttime); ?>"  id="start" placeholder="开始时间" readonly/>
						<span>--</span>
						<input type="text" class="laydate-icon layer-date" name="info[endtime]"  value="<?php echo ($endtime); ?>"  id="end" placeholder="结束时间" readonly/>
					</div>
					<div class="select mg_trb">
						<span class="text">分社级别</span>
						<select name="info[apply_type]">
							<option value="">--请选择--</option>
							<?php if(is_array($applytype)): $i = 0; $__LIST__ = $applytype;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($key == $apply_type): ?>selected<?php endif; ?>><?php echo ($data); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
					</div>
					<div class="select mg_trb">
						<span class="text">状态</span>
						<select name="info[apply_flag]">
							<option value="">--请选择--</option>
							<?php if(is_array($applyflag)): $i = 0; $__LIST__ = $applyflag;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($key == $apply_flag): ?>selected<?php endif; ?>><?php echo ($data); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
					</div>

					<div class="button mg_trb" style="color: red;">
						<i class="fa fa-refresh ico"></i>
						<input type="button" value="重置" class="but chongzhi" onclick="location.href='<?php echo U('Applyinfo/index');?>'"/>
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
							<col width="80">
							<col width="100">
							<col width="100">
							<col width="200">
							<col width="200">
							<col width="200">
							<col width="100">
							<col width="100">
						</colgroup>
						<thead>
							<tr>
								<th>编号</th>
								<th>姓名</th>
								<th>电话</th>
								<th>城市</th>
								<th>时间</th>
								<th>分社级别</th>
								<th>状态</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
                         <?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($v["apply_id"]); ?></td>
								<td><?php echo ($v["nickname"]); ?></td>
								<td><?php echo ($v["phone"]); ?></td>
								<td><?php echo ($v["city"]); ?></td>
								<td><?php echo (date('Y-m-d H:i:s',$v["apply_addtime"])); ?></td>
								<td><?php echo ($applytype[$v['apply_type']]); ?></td>
								<td><?php echo ($applyflag[$v['apply_flag']]); ?></td>
								<?php if($v["apply_flag"] == 1): ?><td>
										<a href="<?php echo U('applyinfo/adopt',array('apply_id'=>$v['apply_id']));?>" onclick="{if(confirm('确认通过?')){return true;} return false;}" class="but chaxun">
										<i class="fa fa-edit"></i>通过</a>
										<a href="<?php echo U('applyinfo/adoptno',array('apply_id'=>$v['apply_id']));?>" onclick="{if(confirm('确认驳回?')){return true;} return false;}" class="but chaxun">
											<i class="fa fa-edit"></i>驳回</a>
									</td>
								<?php else: ?>
									<td>---</td><?php endif; ?>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				</div>
				<?php echo ($pageshow); ?>
			</div>
		</div>
	</body>
</html>
<script src="/Public/admin/js/laydate/laydate.js"></script>
<script type="text/javascript">
	$(function(){
		$(".right_min").height($(window).height());
	});


	var start = {
		elem: "#start",
		format: "YYYY-MM-DD",
		min: "2000-01-01",
		max: "2100-01-01",
		istime: false,
		istoday: false,
		choose: function (datas) {
			end.min = datas;
			end.start = datas
		}
	};
	var end = {
		elem: "#end",
		format: "YYYY-MM-DD",
		min: "2000-01-01",
		max: "2100-01-01",
		istime: false,
		istoday: false,
		choose: function (datas) {
			start.max = datas
		}
	};
	laydate(start);
	laydate(end);
</script>