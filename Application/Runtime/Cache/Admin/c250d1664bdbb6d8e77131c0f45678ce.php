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
		<script type="text/javascript" src="/Public/My97DatePicker/WdatePicker.js"></script>
	</head>
	<body>
		<div class="right_min">
			<div class="crumbs_nav">
				<i class="iconfont icon-shouye"></i>
				<ul>
					<li><a href="<?php echo U('index/welcome');?>">首页</a></li>
					<li> > </li>
					<li><a href="javascript:void(0);">学员管理</a></li>
					<li> > </li>
					<li><a href="javascript:void(0);">订阅明细</a></li>
				</ul>
			</div>
			<div class="min">
				<!--查询-->

				<div class="query">



					<form  name="seachform" id="seachform"  action="<?php echo U('Buyinfo/index');?>"  method="post" class="form"  onsubmit="return checkkwd()" >
						<div class="form_input mg_trb" >
							<label class="text">快速检索</label>
							<input type="text" name="info[focus_title]" id="keyword" value="<?php echo ($focus_title); ?>"  placeholder="请输入昵称"  maxlength="11"/>
						</div>
						<div class="form_input mg_trb form-date">
							<label class="text">订阅时间</label>
							<input type="text" class="laydate-icon layer-date" name="info[starttime]"  value="<?php echo ($starttime); ?>"  id="start" placeholder="开始时间" readonly/>
							<input type="text" class="laydate-icon layer-date" name="info[endtime]"  value="<?php echo ($endtime); ?>"  id="end" placeholder="结束时间" readonly/>
						</div>
						<div class="select mg_trb">
							<span class="text">支付状态</span>
							<select name="info[buy_flag]">
								<option value="">--请选择--</option>
								<?php if(is_array($buyflag)): $i = 0; $__LIST__ = $buyflag;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($key == $buy_flag): ?>selected<?php endif; ?>><?php echo ($data); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
						</div>
						<div class="select mg_trb">
							<span class="text">支付方式</span>
							<select name="info[buy_type]">
								<option value="">--请选择--</option>
								<?php if(is_array($buytype)): $i = 0; $__LIST__ = $buytype;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($key == $buy_type): ?>selected<?php endif; ?>><?php echo ($data); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
						</div>
						<div class="button mg_trb">
							<i class="fa fa-refresh ico"></i>
							<input type="button" value="重置" class="but chongzhi" onclick="location.href='<?php echo U('Buyinfo/index');?>'"/>
						</div>

						<div class="button mg_trb">
							<i class="fa fa-search ico"></i>
							<input type="submit" value="查询" class="but chaxun" maxlength="11" />
						</div>
					</form>
				</div>
				<div class="table_box">
					<table class="table" border="" cellspacing="" cellpadding="">
						<colgroup>
							<col width="100">
							<col width="100">
							<col width="100">
							<col width="100">
							<col width="100">
							<col width="100">
							<col width="100">
							<col width="100">
							<col width="100">
							<col>
						</colgroup>
						<thead>
							<tr>
								<th>昵称</th>
								<th>电话号码</th>							
								<th>订阅内容</th>
								<th>订阅时间</th>
								<th>到期时间</th>
								<th>订阅状态</th>
								<th>支付状态</th>
								<th>支付方式</th>
								<th>支付金额</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($arr)): $i = 0; $__LIST__ = $arr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($v["nickname"]); ?></td>
								<td><?php echo ($v["phone"]); ?></td>								
								<th><?php if($v['course_id'] == 0): echo ($v["buy_remarks"]); else: ?>专题【<?php echo ($v["course_name"]); ?> 】<?php endif; ?></th>
								<td><?php echo (date('Y-m-d H:i:s',$v["buy_addtime"])); ?></td>
								<td><?php echo (date('Y-m-d H:i:s',$v["buy_endtime"])); ?></td>
								<?php if($v['course_id'] == 0): ?><td>学费</td><?php else: ?><td>专题年费</td><?php endif; ?>
								<td><?php echo ($buyflag[$v['buy_flag']]); ?></td> 
								<td><?php echo ($buytype[$v['buy_type']]); ?></td> 
								<th><?php echo ($v["buy_money"]); ?></th>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>

				</div>
				<?php echo ($pageshow); ?>
			</div>
		</div>
	</body>
</html>
<script src="/Public/admin/js/layer/layer.js"></script>

<script type="text/javascript">
    $(".right_min").height($(window).height());
    var body_w=$(".right_min").width()-200;
    var body_h=$(".right_min").height()-100;
    function xiangqing(user_id) {
        //alert(user_id);
        layer.open({
            type: 2,
            title: false,
            skin: "layui-layer-molv",
            shade: [0.8, '#000000'],
            scrollbar: false,
            maxmin: false,
            shadeClose: false, //点击遮罩关闭层
            area: [body_w + "px", body_h + "px"],
            content: "<?php echo U('user/xiangqing');?>&user_id=" + user_id
        });
    }
    function chongzhi(user_id) {
        layer.open({
            type: 2,
            title: false,
            skin: "layui-layer-molv",
            shade: [0.8, '#000000'],
            scrollbar: false,
            maxmin: false,
            shadeClose: false, //点击遮罩关闭层
            area: [body_w + "px", body_h + "px"],
            content: "<?php echo U('user/chongzhi');?>&user_id=" + user_id
        });
    }
</script>
<script src="/Public/admin/js/laydate/laydate.js"></script>
<script>
    //laydate({elem: "#hello", event: "focus"});
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