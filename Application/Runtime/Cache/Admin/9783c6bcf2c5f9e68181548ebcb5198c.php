<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>学分管理</title>
		<link rel="stylesheet" type="text/css" href="/Public/admin/css/html5.css"/>
		<link rel="stylesheet" type="text/css"  href="/Public/admin/font/iconfont.css">
		<link rel="stylesheet" type="text/css"  href="/Public/admin/font/css/font-awesome.css">
		<link rel="stylesheet" type="text/css" href="/Public/admin/css/index.css"/>
		<script src="/Public/admin/js/jquery-1.10.2.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/Public/admin/js/laydate/laydate.js"></script>
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
					<li><a href="javascript:void(0);">学分管理</a></li>
				</ul>
			</div>
			<div class="min">
				<!--查询-->

				<div class="query">
					<form  name="seachform" id="seachform"  action="<?php echo U('scoreinfo/index');?>"  method="post" class="form"  onsubmit="return checkkwd()">
						<div class="form_input mg_trb">
							<label class="text">快速检索</label>
							<input type="text" name="info[keyword]" id="keyword" value="<?php echo ($keyword); ?>"  placeholder="请搜索姓名或电话"  maxlength="11" style="width: 150px;" />
						</div>
						<div class="select mg_trb">		
							<span class="text">学分类型</span>
							<select name="info[scroe_type]">
								<option value="">--请选择--</option>
								<?php if(is_array($scroetype)): $i = 0; $__LIST__ = $scroetype;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($key == $scroe_type): ?>selected<?php endif; ?>><?php echo ($data); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
						</div>		
						<div class="form_input mg_trb form-date">
							<label class="text">变动时间</label>
							<input type="text" class="laydate-icon layer-date" name="info[starttime]"  value="<?php echo ($starttime); ?>"  id="start" placeholder="开始时间" readonly/>
							<span>--</span>
							<input type="text" class="laydate-icon layer-date" name="info[endtime]"  value="<?php echo ($endtime); ?>"  id="end" placeholder="结束时间" readonly/>
						</div>
						<div class="button mg_trb">
							<i class="fa fa-refresh ico"></i>
							<input type="button" value="重置" class="but chongzhi" onclick="location.href='<?php echo U('scoreinfo/index');?>'"/>
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
							<col width="5">
							<col width="100">
							<col width="100">
							<col width="100">
							<col width="100">
							<col width="140">
							<col width="120">
							<col width="80">
						</colgroup>
						<thead>
							<tr>
								<th>编号</th>
								<th>姓名</th>
								<th>电话</th>					
								<th>学分变动值</th>
								<th>学分类型</th>
								<th>变动时间</th>
								<th>备注信息</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($listinfo)): $i = 0; $__LIST__ = $listinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($v["score_id"]); ?></td>
								<td><?php echo ($v["nickname"]); ?></td>
								<td><?php echo ($v["phone"]); ?></td>
								<td><?php echo ($v["score_score"]); ?></td>
								<td><?php echo ($scroetype[$v[scroe_type]]); ?></td>
								<td><?php echo (date("Y-m-d H:i:s",$v["score_addtime"])); ?></td>
								<td><?php echo ($v["score_remarks"]); ?></td>
								<td>
								<a href="<?php echo U('scoreinfo/delscoreinfo',array('score_id'=>$v['score_id']));?>" onclick="{if(confirm('确认删除?')){return true;}return false;}" class="but chongzhi">
								<i class="fa fa-trash-o"></i>
								删除</a>
								</if>
								</td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				</div>
				<?php echo ($Pageshow); ?>
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