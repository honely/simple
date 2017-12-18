<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>研习班报名</title>
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
			<?php if($state == 1): ?><li><a href="javascript:void(0);">其他设置</a></li>
				<li> > </li>
				<li><a href="javascript:void(0);">研习班管理</a></li>
				<li> > </li>
				<li><a href="javascript:void(0);"><?php echo ($wordTitle); ?>报名表</a></li>
				<?php else: ?>
				<li><a href="javascript:void(0);">学员管理</a></li>
				<li> > </li>
				<li><a href="javascript:void(0);">线下大课报名</a></li><?php endif; ?>

		</ul>
	</div>
	<div class="min">
		<!--查询-->
		<div class="query">
			<form  name="seachform" id="seachform"  action="<?php echo U('buxiyanfa/buxiyanfa',array('work_id'=>$workId,'work_title'=>$wordTitle));?>"  method="post" class="form"  onsubmit="return checkkwd()">
				<input type="hidden" name="info[status]" value="<?php echo ($state); ?>"/>
				<input type="hidden" name="info[wordTitle]" value="<?php echo ($wordTitle); ?>" />
				<input type="hidden" name="info[wordId]" value="<?php echo ($workId); ?>" />
				<div class="form_input mg_trb">
					<label class="text">快速查询</label>
					<input type="text" name="info[keyword]" id="keyword" value="<?php echo ($keyword); ?>"  placeholder="请输入姓名,手机号或研发班"  maxlength="11"/>
				</div>
				<div class="form_input mg_trb form-date">
					<label class="text">添加时间</label>
					<input type="text" class="laydate-icon layer-date" name="info[starttime]"  value="<?php echo ($starttime); ?>"  id="start" placeholder="开始时间" readonly/>
					<span>--</span>
					<input type="text" class="laydate-icon layer-date" name="info[endtime]"  value="<?php echo ($endtime); ?>"  id="end" placeholder="结束时间" readonly/>
				</div>
				<div class="select mg_trb">
					<span class="text">支付状态</span>
					<select name="info[pay_flag]">
						<option value="">--请选择--</option>
						<?php if(is_array($pay_flag)): $i = 0; $__LIST__ = $pay_flag;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($key == $pay_flag_): ?>selected<?php endif; ?>><?php echo ($data); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
				</div>
				<div class="button mg_trb">
					<i class="fa fa-refresh ico"></i>
					<input type="button" value="重置" class="but chongzhi" onclick="location.href='<?php echo U('buxiyanfa/buxiyanfa',array('work_id'=>$workId,'work_title'=>$wordTitle));?>'"/>
				</div>
				<div class="button mg_trb">
					<i class="fa fa-search ico"></i>
					<input type="submit" value="查询" class="but chaxun"/>
				</div>
			</form>
		</div>
		<!-- 学员列表 -->
		<div class="table_box">
			<table class="table" border="" cellspacing="" cellpadding="">

				<thead>
				<tr>
					<th>编号</th>
					<th>用户姓名</th>

					<th>学员姓名</th>
					<!--<th>学员电话</th>-->
					<th>研习班名</th>
					<th>用户电话</th>
					<th>报名人数(人)</th>
					<th>报名时间</th>
					<th>本人</th>
					<th>支付状态</th>
					<th>支付方式</th>
					<th>支付金额</th>
					<th>操作</th>
				</tr>
				</thead>
				<tbody>
				<?php if($count != 0): if(is_array($infolist)): foreach($infolist as $key=>$v): ?><tr>
							<td><?php echo ($v["sign_id"]); ?></td>
							<td><?php echo ($v["nickname"]); ?></td>
							<td><?php echo ($v["fullname"]); ?></td>
							<td><?php echo ($v["work_title"]); ?></td>
							<td><?php echo ($v["mobile"]); ?></td>
							<td><?php echo ($v["num"]); ?></td>
							<td><?php echo (date("Y-m-d H:i:s",$v["sign_addtime"])); ?></td>
							<td><?php echo ($isself[$v[isself]]); ?></td>
							<td><?php echo ($pay_flag[$v[pay_flag]]); ?></td>
							<td><?php echo ($pay_type[$v[pay_type]]); ?></td>
							<td><?php echo ($v["pay_money"]); ?></td>
							<td>
								<a onclick="shou(<?php echo ($v["sign_id"]); ?>)" class="but chaxun">
									<i class="fa fa-eye"></i>
									查看内容
								</a>
								<a href="<?php echo U('buxiyanfa/delet',array('sign_id'=>$v['sign_id']));?>" onclick="{if(confirm('确认删除?')){return true;}return false;}" class="but chongzhi">
									<i class="fa fa-trash-o"></i>
									删除
								</a>
							</td>
						</tr><?php endforeach; endif; ?>
					<?php else: ?>
					<tr>
						<td colspan="13"><?php echo ($content); ?></td></tr><?php endif; ?>
				</tbody>
			</table>
		</div>
		<?php echo ($pageshow); ?>
	</div>
</div>
</body>
</html>
<script src="/Public/admin/js/laydate/laydate.js"></script>
<script src="/Public/admin/js/layer/layer.js"></script>
<script type="text/javascript">
    $(".right_min").height($(window).height());
    var body_w=$(".right_min").width()-200;
    var body_h=$(".right_min").height()-300;
    function shou(b){
        layer.open({
            type:2,
            title: false,
            skin:"layui-layer-molv",
            shade: [0.5, '#000000'],
            scrollbar:false,
            maxmin: false,
            shadeClose: false, //点击遮罩关闭层
            area : [body_w+"px",body_h+"px"],
            content: "<?php echo U('buxiyanfa/yanfaxq');?>&sign_id="+b
        });
    }

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