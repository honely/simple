<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<head>
	<meta charset="UTF-8">
		<title>支付明细</title>
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
					<li><a href="javascript:void(0);">学员管理</a></li>
					<li> > </li>
					<li><a href="javascript:void(0);">支付明细</a></li>
				</ul>
			</div>
			<div class="min">								
				<div class="query">
					<form  name="seachform" id="seachform"  action="<?php echo U('Payinfo/payoper');?>"  method="post" class="form">
						<div class="form_input mg_trb">
		                    <label class="text">查询</label>
		                    <input type="text" name="info[focus_title]" id="focus_title" value="<?php echo ($focus_title); ?>"  placeholder="输入用户名、手机号或订单号"  maxlength="15"/>
	                	</div>			
						<div class="form_input mg_trb form-date">
							<label class="text">支付时间</label>
								<input type="text" class="laydate-icon layer-date" name="info[starttime]"  value="<?php echo ($starttime); ?>"  id="start" placeholder="开始时间" readonly/>
								<span>--</span>
								<input type="text" class="laydate-icon layer-date" name="info[endtime]"  value="<?php echo ($endtime); ?>"  id="end" placeholder="结束时间" readonly/>
						</div>					
						<!--<div class="select mg_trb">		
							<span class="text">支付方式</span>
							<select name="info[pay_type]">
								<option value="">--请选择--</option>
								<?php if(is_array($paytype)): $i = 0; $__LIST__ = $paytype;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($key == $pay_type): ?>selected<?php endif; ?>><?php echo ($data); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
						</div>-->			
						<div class="select mg_trb">	
							<span class="text">支付状态</span>
							<select name="info[pay_flag]">
								<option value="">--请选择--</option>
								<?php if(is_array($payflag)): $i = 0; $__LIST__ = $payflag;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($key == $pay_flag): ?>selected<?php endif; ?>><?php echo ($data); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
						</div>

						<div class="button mg_trb">
							<i class="fa fa-refresh ico"></i>
							<input type="button" value="重置" class="but chongzhi" onclick="location.href='<?php echo U('Payinfo/payoper');?>'"/>
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
							<col width="100">
							<col width="100">
							<col width="100">
							<col width="100">
							<col width="100">
							<col width="200">
							<col width="200">
						</colgroup>
						<thead>
							<tr>
								<th>订单号</th>
								<th>用户名</th>
								<th>手机号</th>
								<th>支付方式</th>
								<th>支付状态</th>
								<th>支付金额</th>
								<th>支付备注</th>	
								<th>支付时间</th>							
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($arr)): $i = 0; $__LIST__ = $arr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($v["pay_no"]); ?></td>
								<td><?php echo ($v["nickname"]); ?></td>
								<td><?php echo ($v["phone"]); ?></td>
								<td><?php echo ($paytype[$v[pay_type]]); ?></td>
								<td><?php echo ($payflag[$v[pay_flag]]); ?></td>
								<td><?php echo ($v["pay_money"]); ?></td>
								<td><?php echo ($v["pay_remarks"]); ?></td>
								<td><?php echo (date('Y-m-d H:i:s',$v["pay_addtime"])); ?></td>
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
</script>
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