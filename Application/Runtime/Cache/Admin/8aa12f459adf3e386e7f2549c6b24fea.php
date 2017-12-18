<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>直播预约管理</title>
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
					<li><a>学员管理</a></li>
					<?php if($live_id != '' ): ?><li> > </li>
					<li><a href="<?php echo U('liveinfo/index');?>">视频直播管理</a></li><?php endif; ?>
					<li> > </li>
					<li><a href="javascript:void(0);">直播预约管理</a></li>
				</ul>
			</div>
			<div class="min">
				<!--查询-->
				<div class="query">
					<form name="seachform" id="seachform" action="<?php echo U('liveorder/index',array('live_id'=>$live_id));?>"  method="post" class="form">
					
						<div class="form_input mg_trb">
							<label class="text">快速检索</label>
							<input type="text" name="info[keyword]" id="keyword" value="<?php echo ($keyword); ?>" placeholder="搜索编号/学员/标题/电话" maxlength="50"/>
						</div>
						<div class="form_input mg_trb form-date">
							<label class="text">预约时间</label>
							<input type="text" class="laydate-icon layer-date" name="info[starttime]"  value="<?php echo ($starttime); ?>"  id="start" placeholder="开始时间" readonly/>
							<span>--</span>
							<input type="text" class="laydate-icon layer-date" name="info[endtime]"  value="<?php echo ($endtime); ?>"  id="end" placeholder="结束时间" readonly/>
						</div>
						<div class="button mg_trb">
							<i class="fa fa-refresh ico"></i>
							<input type="button" value="重置" class="but chongzhi" onclick="location.href='<?php echo U('liveorder/index',array('live_id'=>$live_id));?>'"/>
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
							<col width="200">
							<col width="200">
							<col width="200">
							<col width="200">
							<col width="200">
							<col width="200">
						</colgroup>
						<thead>
							<tr>
								<th>编号</th>
								<th>直播标题</th>
								<th>学员</th>
								<th>电话号码</th>
								<th>预约时间</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($listinfo)): $i = 0; $__LIST__ = $listinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$content): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($content["order_id"]); ?></td>
								<td><?php echo ($content["live_title"]); ?></td>
								<td><?php echo ($content["nickname"]); ?></td>
								<td><?php echo ($content["phone"]); ?></td>	
								<td><?php echo (date('Y-m-d H:i:s',$content["order_addtime"])); ?></td>
								<td>
									<a href="<?php echo U('liveorder/delliveorder',array('order_id'=>$content['order_id'],'live_id'=>$content['live_ids']));?>" onclick="{if(confirm('确认删除?')){return true;}return false;}"  class="but chongzhi">
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