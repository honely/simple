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
					<li><a href="javascript:void(0);">学员管理</a></li>
					<li> > </li>
					<li><a href="javascript:void(0);">学习记录</a></li>
				</ul>
			</div>
			<div class="min">

			<!--查询-->

				<div class="query">
					<form  name="seachform" id="seachform"  action="<?php echo U('Learnlog/index');?>"  method="post" class="form"  onsubmit="return checkkwd()">
                 <div class="form_input mg_trb">
                    <label class="text">快速检索</label>
                    <input type="text" name="info[keyword]" id="keyword" value="<?php echo ($keyword); ?>"  placeholder="请输入昵称,手机号或课程名"  maxlength="11"/>
                </div>
				<div class="select mg_trb">
                    <span class="text">vip等级</span>
                    <select name="info[vip]">
                        <option value="0">--请选择vip等级--</option>
                        <?php if(is_array($vipLevel)): $i = 0; $__LIST__ = $vipLevel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>a" <?php if($key.'a' == $vip.'a' ): ?>selected<?php endif; ?>><?php echo ($data); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
                <div class="select mg_trb">
                    <span class="text">用户等级</span>
                    <select name="info[level]">
                        <option value="0">--请选择用户等级--</option>
                        <?php if(is_array($userLevel)): $i = 0; $__LIST__ = $userLevel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($key == $level ): ?>selected<?php endif; ?>><?php echo ($data); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
				<div class="select mg_trb">
					<span class="text">所属分类</span>
					<select name="info[classify_id]">
						<option value="0">--请选择所属分类--</option>
						<?php if(is_array($courseClass)): $i = 0; $__LIST__ = $courseClass;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($key == $classify_id ): ?>selected<?php endif; ?>><?php echo ($data); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
				</div>
					<div class="form_input mg_trb form-date">
						<label class="text">学习时间</label>
							<input type="text" class="laydate-icon layer-date" name="info[starttime]"  value="<?php echo ($starttime); ?>"  id="start" placeholder="开始时间" readonly/>
							<span>--</span>
							<input type="text" class="laydate-icon layer-date" name="info[endtime]"  value="<?php echo ($endtime); ?>"  id="end" placeholder="结束时间" readonly/>
					</div>
                <div class="button mg_trb">
                    <i class="fa fa-refresh ico"></i>
                    <input type="button" value="重置" class="but chongzhi" onclick="location.href='<?php echo U('Learnlog/index');?>'"/>
                </div>

                <div class="button mg_trb">
                    <i class="fa fa-search ico"></i>
                    <input type="submit" value="查询" class="but chaxun"/>
                </div>
					</form>
				</div>

				<div class="table_box">
					<table class="table" border="" cellspacing="" cellpadding="">
						<!--<colgroup>-->
							<!--<col width="200">-->
							<!--<col width="170">-->
							<!--<col width="170">-->
							<!--<col width="180">-->
							<!--<col width="250">-->
							<!--<col width="250">-->
							<!--<col width="300">-->
						<!--</colgroup>-->
						<thead>
							<tr>
								<th>用户名</th>
								<th>vip等级</th>
								<th>用户等级</th>
								<th>手机号码</th>
								<th>所属专题</th>
								<th>所属分类</th>
								<th>课程名称</th>
								<th>学习时间</th>
							</tr>
						</thead>
						<tbody>

							<?php if(is_array($infolist)): $i = 0; $__LIST__ = $infolist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$learn): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($learn["nickname"]); ?></td>
								<td>
									<?php if($learn["vip"] == ''): ?>非VIP会员
									<?php else: ?>
										<?php echo ($vipLevel[$learn['vip']]); endif; ?>
								</td>
								<td><?php echo ($userLevel[$learn['level']]); ?></td>
								<td><?php echo ($learn["phone"]); ?></td>
								<td><?php echo ($learn["course_name"]); ?></td>
								<td><?php echo ($courseClass[$learn['classify_id']]); ?></td>
								<td><?php echo ($learn["lesson_name"]); ?></td>
                                <td><?php echo (date("Y-m-d H:i:s",$learn["learn_addtime"])); ?></td>
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
<script type="text/javascript" src="/Public/My97DatePicker/WdatePicker.js"></script>
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


	function get_column(val) {
            $("#Scolumn").html('<option value="">--请选择专题--</option>');
        if(!val){
            return ;
        }
        $.get("<?php echo U('ajax/get_column');?>&classify_id=" + val, function (result) {
            var data = result.data
            console.log(data)
            var html = '<option value="">--请选择专题--</option>';
            if (data.length > 0) {
                for (var i = 0; i < data.length; i++) {
                    html += "<option value=" + data[i].column_id + ">" + data[i].column_name + "</option>"
                }
            }
            $("#Scolumn").html(html);
        })
    }
</script>
<script>
    //laydate({elem: "#hello", event: "focus"});
    var start = {
        elem: "#start",
        format: "YYYY-MM-DD",
        min: "2000-06-16",
        max: "2099-06-16",
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