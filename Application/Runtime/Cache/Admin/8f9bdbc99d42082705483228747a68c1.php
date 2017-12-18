<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>专题评论管理</title>
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
					<?php if($state == 1): ?><li><a href="javascript:void(0);">课程管理</a></li>
						<li> > </li>
						<li><a href="javascript:void(0);">课程内容管理</a></li>
						<li> > </li>
						<li><a href="javascript:void(0);"><?php echo ($courseName); ?>专题评论管理</a></li>
						<?php else: ?>
						<li><a href="javascript:void(0);">课程管理</a></li>
						<li> > </li>
						<li><a href="javascript:void(0);">专题评论管理</a></li><?php endif; ?>
				</ul>
			</div>
			<div class="min">
				<!--查询-->		
				<div class="query">
					<form  name="seachform" id="seachform"  action="<?php echo U('comment/comment',array('course_id'=>$courseID,'course_name'=>$courseName));?>"  method="post" class="form"  onsubmit="return checkkwd()">
						<input type="hidden" name="info[status]" value="<?php echo ($state); ?>"/>
						<input type="hidden" name="info[wordTitle]" value="<?php echo ($courseName); ?>" />
						<input type="hidden" name="info[wordId]" value="{courseID}" />
						<div class="form_input mg_trb">
							<label class="text">学员查询</label>
							<input type="text" name="info[keyword]" id="keyword" value="<?php echo ($keyword); ?>"  placeholder="请输入姓名或手机号"  maxlength="11"/>
						</div>
						<?php if($state == 1): else: ?>
							<div class="form_input mg_trb">
								<label class="text">专题查询</label>
								<input type="text" name="info[course]" id="course" value="<?php echo ($course); ?>"  placeholder="请输入专题名称" maxlength="50" />
							</div><?php endif; ?>
						<div class="form_input mg_trb">
								<input type="text" name="info[lesson]" id="lesson" value="<?php echo ($lesson); ?>"  placeholder="课程查询" maxlength="50" />
						</div>
						<div class="form_input mg_trb form-date">
							<label class="text">评论时间</label>
							<input type="text" class="laydate-icon layer-date" name="info[starttime]"  value="<?php echo ($starttime); ?>"  id="start" placeholder="开始时间" readonly/>
							<span>--</span>
							<input type="text" class="laydate-icon layer-date" name="info[endtime]"  value="<?php echo ($endtime); ?>"  id="end" placeholder="结束时间" readonly/>
						</div>
						<div class="select mg_trb">
							<span class="text">审核状态</span>
							<select name="info[comment_flag]">
								<option value="">--请选择状态--</option>
								<?php if(is_array($commentFlag)): $i = 0; $__LIST__ = $commentFlag;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($key == $comment_flag ): ?>selected<?php endif; ?>><?php echo ($data); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
						</div>
						<div class="button mg_trb">
							<i class="fa fa-refresh ico"></i>
							<input type="button" value="重置" class="but chongzhi" onclick="location.href='<?php echo U('comment/comment',array('course_id'=>$courseID,'course_name'=>$courseName));?>'"/>
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
						<!--<colgroup>-->
							<!--<col width="5">-->
							<!--<col width="100">-->
							<!--<col width="100">-->
							<!--<col width="100">-->
							<!--<col width="100">-->
							<!--<col width="100">-->
							<!--<col>-->
						<!--</colgroup>-->
						<thead>
							<tr>
								<th>编号</th>
								<th>学员名称</th>
								<!--<th>学员电话</th>-->
								<th>专题名称</th>
								<th>课程名称</th>
								<th>评论时间</th>
								<th>点赞数</th>
								<th>审核状态</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($infolist)): foreach($infolist as $key=>$v): ?><tr>
								<td><?php echo ($v["comment_id"]); ?></td>
								<td><?php echo ($v["nickname"]); ?></td>
								<!--<td><?php echo ($v["phone"]); ?></td>-->
								<td><?php echo ($v["course_name"]); if($v["comment_top"] == 2): ?><font color="red">[顶]</font><?php endif; ?></td>
								<td><?php echo ($v["lesson_name"]); ?></td>
								<td><?php echo (date("Y-m-d H:i:s",$v["addtime"])); ?></td>
								<?php if( $v['comment2_good'] != ''): ?><td><?php echo ($v["comment2_good"]); ?></td>
								<?php else: ?>
								<td>0</td><?php endif; ?>
								<?php if($v["comment_flag"] == 2): ?><td style="color:red;"><?php echo ($commentFlag[$v['comment_flag']]); ?></td>
								<?php else: ?>
								<td><?php echo ($commentFlag[$v['comment_flag']]); ?></td><?php endif; ?>
								<td>
								    <a onclick="shou(<?php echo ($v["comment_id"]); ?>)" class="but chaxun">
										 <i class="fa fa-eye"></i>
										查看评论内容
									</a>
                                    <a onclick="pinglun('<?php echo ($v["comment_id"]); ?>','<?php echo ($v["course_name"]); ?>')" class="but chaxun">
										 <i class="fa fa-eye"></i>
										查看回复内容
									</a>
                                    <?php if($v["comment_top"] == 1): ?><a href="<?php echo U('comment/up',array('comment_id'=>$v['comment_id']));?>" onclick="{if(confirm('确认置顶?')){return true;}return false;}" class="but chongzhi">
									<i class="fa  fa-caret-square-o-up"></i> 
									置顶</a>
									<?php else: ?>
									<a href="<?php echo U('comment/notup',array('comment_id'=>$v['comment_id']));?>" onclick="{if(confirm('确认取消置顶?')){return true;}return false;}" class="but chongzhi">
									<i class="fa  fa-caret-square-o-up"></i> 
									取消置顶</a><?php endif; ?>
									<!--审核状态，，1未审核，2已审核-->
									<?php if($v["comment_flag"] == 1): ?><a href="<?php echo U('comment/shenhe',array('comment_id'=>$v['comment_id']));?>" onclick="{if(confirm('审核通过?')){return true;}return false;}" class="but chongzhi">
											<i class="fa  fa-caret-square-o-up"></i>
											审核</a>
										<a href="<?php echo U('comment/delcollect',array('comment_id'=>$v['comment_id']));?>" onclick="{if(confirm('确认删除?')){return true;}return false;}" class="but chongzhi">
											<i class="fa fa-trash-o"></i>
											删除</a>
									<?php else: endif; ?>
								</td>
							</tr><?php endforeach; endif; ?>
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
	var body_w=$(".right_min").width()-100;
	var body_h=$(".right_min").height()-200;
	function shou(a){
		layer.open({
			type: 2,
			title: false,
			skin:"layui-layer-molv",
			shade: [0.5, '#000000'],
			scrollbar:false,
			maxmin: false,
			shadeClose: false, //点击遮罩关闭层
			area : [body_w+"px",body_h+"px"],
			content: '<?php echo U("comment/huifu");?>&comment_id='+a
		});
	}
	
	function pinglun(b,c){
		layer.open({
			type: 2,
			title: false,
			skin:"layui-layer-molv",
			shade: [0.5, '#000000'],
			scrollbar:false,
			maxmin: false,
			shadeClose: false, //点击遮罩关闭层
			area : [body_w+"px",body_h+"px"],
			content: '<?php echo U("comment/pinglun");?>&comment_id='+b+'&course_name='+c
		});
	}
</script>
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