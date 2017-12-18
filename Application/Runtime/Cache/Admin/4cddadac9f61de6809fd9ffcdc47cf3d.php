<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" type="text/css" href="/Public/admin/css/html5.css"/>
		<link rel="stylesheet" type="text/css"  href="/Public/admin/font/iconfont.css">
		<link rel="stylesheet" type="text/css"  href="/Public/admin/font/css/font-awesome.css">
		<link rel="stylesheet" type="text/css" href="/Public/admin/css/index.css"/>
		<script src="/Public/admin/js/jquery-1.10.2.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/Public/admin/js/icheck/icheck.js" type="text/javascript" charset="utf-8"></script>
		<link rel="stylesheet" type="text/css" href="/Public/admin/js/icheck/square/green.css">
		<link href="/Public/validform/Validform.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="/Public/validform/Validform_v5.3.2.js"></script>
	</head>
	<body>
		<div class="right_min">
			<div class="crumbs_nav">
				<i class="iconfont icon-shouye"></i>
				<ul>
					<li><a href="<?php echo U('index/welcome');?>">首页</a></li>
					<li> > </li>
					<li><a href="javascript:void(0);">其他设置</a></li>
					<li> > </li>
					<li><a href="<?php echo U('set/index');?>">配置管理</a></li>
					<li> > </li>
					<li><a href="javascript:void(0);">修改配置</a></li>
				</ul>
			</div>
			<div class="min">
				<div class="form_box">
					<form name="myform" id="myform" action="<?php echo U('set/editinfo');?>" method="post">
						<div class="form-item">
							<label class="form-label">配置key</label>
							<div class="form-text form-input-block">
								
								<input name="info[set_key]" value="<?php echo ($setinfo["set_key"]); ?>" class="dfinput" type="text" disabled/>
								
								<i class="Validform_checktip"></i>
							</div>
						</div>
						<div class="form-item">
							<label class="form-label">配置值</label>
							<div class="form-text form-input-block">
								<input name="info[set_id]" value="<?php echo ($setinfo["set_id"]); ?>" type="hidden"/>
								<textarea name="info[set_value]" id="username" class="dftextarea" datatype="*1-500" errormsg="配置值范围在1~500位之间！" maxlength="500" style="width:100%;outline: 0;border: 1px solid #e6e6e6;"><?php echo ($setinfo["set_value"]); ?></textarea>
								 
								<i class="Validform_checktip"></i>
							</div>
						</div>
						<div class="form-item">
							<label class="form-label">配置详情</label>
							<div class="form-text form-input-block">
								<input name="info[set_remark]" value="<?php echo ($setinfo["set_remark"]); ?>" type="text" class="dfinput" datatype="*1-20" errormsg="配置详情范围在1~20位之间！" maxlength="20" />
								<i class="Validform_checktip"></i>
							</div>
						</div>
						<div class="form-item">
							<div class="form-button form-input-block">
								<input class="chaxun but" type="submit" value="提交"/>
								<button class="but chongzhi" type="button" onclick="location.href='<?php echo U('set/index');?>'">返回</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
<script src="/Public/admin/js/laydate/laydate.js"></script>
<script>
    //laydate({elem: "#hello", event: "focus"});
    var start = {
        elem: "#start",
        format: "YYYY/MM/DD",
        min: laydate.now(),
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
        format: "YYYY/MM/DD",
        min: laydate.now(),
        max: "2099-06-16",
        istime: false,
        istoday: false,
        choose: function (datas) {
            start.max = datas
        }
    };
    laydate(start);
    laydate(end);
</script>
<script type="text/javascript">
	$(function(){
		$(".right_min").height($(window).height());
		
		$('.skin-section input').iCheck({
			checkboxClass: 'icheckbox_square-green',
			radioClass: 'iradio_square-green',
		});
		$('input').on('ifChecked', function(event){
		  //alert($(this).val());
		});
	});
</script>
	<script>
	$(function(){
		$("#myform").Validform({
			//tiptype:2
			tiptype:function(msg,o,cssctl){
				var objtip=o.obj.siblings(".Validform_checktip");
				cssctl(objtip,o.type);
				objtip.text(msg);
			}
		});
	}); 
	</script>