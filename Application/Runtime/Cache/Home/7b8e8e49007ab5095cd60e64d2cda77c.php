<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>完善资料</title>
		<!--说明文字编码-->
		<meta http-equiv="Content-type" content="text/html" charset="utf-8">
		<!--针对 IE8 版本的一个特殊文件头标记，用于为 IE8 指定不同的页面渲染模式-->
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!--设备物理宽度等于等于页面宽度,页面初始缩放1:1,禁止用户调整缩放-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no" />
		<!--控制状态栏显示样式-->
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<!--解决uc字体变大问题-->
		<meta name="wap-font-scale" content="no">
		<!--手机号码不被显示为拨号链接-->
		<meta content="telephone=no" name="format-detection" />
		<!--页面缓存时间的最大值是0秒，目的是不让页面缓存，每次访问必须到服务器读取-->
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Cache-Control" content="no-cache">
		<meta http-equiv="Expires" content="0">
		<link rel="stylesheet" href="/Public/home/css/public.css" />
		<link rel="stylesheet" href="/Public/home/css/ziliaowanshan.css" />
		<link rel="stylesheet" href="/Public/home/css/district.css" />
	</head>

	<body>
		<style type="text/css">
			.cont{width: 100%; margin-top: 0; border-radius: 0;}
			.btn{position: inherit; margin: 0 auto;display: block;}
		</style>
		<form action="<?php echo U('myinfo/ziliaowanshan');?>" method="post" onsubmit="return check()">
			<div class="cont">
				<ul>
					<li>
						<i>姓名：</i>
						<span><input type="text" name="info[realname]" value="<?php echo ($list['realname']); ?>" id="realname" maxlength="15"/></span>
					</li>
					<li>
						<i>性别：</i>
						<span>
							<input type="text" value="<?php echo ($list['sex']); ?>" readonly="readonly"/>
						</span>
					</li>
					<li>
						<i>昵称：</i>
						<span><input type="text" value="<?php echo ($list['nickname']); ?>" /></span>
					</li>
					<li>
						<i>出生：</i>
						<span><input id="demo1" type="text" readonly="readonly" value="<?php echo ($list['birthday']); ?>" name="info[birthday]" /></span>
					</li>
					<li>
						<i>公司：</i>
						<span><input type="text" name="info[firm]" id="firm"   value="<?php echo ($list['firm']); ?>"  maxlength="30"/></span>
					</li>
					<li>
						<i>职务：</i>
						<span><input type="text" name="info[job]" id="job" value="<?php echo ($list['job']); ?>" maxlength="15"/></span>
					</li>
					<li>
						<i>电话：</i>
						<span><input type="text" name="info[phone]" id="phone" value="<?php echo ($list['phone']); ?>"  maxlength="11"/></span>
					</li>
					<li>
						<i>城市：</i>
						<span><input type="text" class="select-value" name="info[cheng]" value="<?php echo ($list['province']); ?>-<?php echo ($list['city']); ?>"   id="cheng" readonly="readonly"/></span>
					</li>
				</ul>
			</div>
			<button class="btn" type="submit">保存</button>			
		</form>
		<script type="text/javascript" src="/Public/home/js/screenSize.js"></script>
	</body>
</html>

<script src="/Public/home/js/jquery-1.10.2.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/home/js/datePicker.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/home/js/district.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/home/js/layer/layer.js" type="text/javascript" charset="utf-8"></script>
<script>
	var calendar = new datePicker();
	calendar.init({
		'trigger': '#demo1', /*按钮选择器，用于触发弹出插件*/
		'type': 'date',/*模式：date日期；datetime日期时间；time时间；ym年月；*/
		'minDate':'1900-1-1',/*最小日期*/
		'maxDate':'2050-12-31',/*最大日期*/
		'onSubmit':function(){/*确认时触发事件*/
			var theSelectData = calendar.value;
			$('#demo1').val(theSelectData);
		},
		'onClose':function(){
		/*取消时触发事件*/
		}
	});	
    function check(){
	   var phone=$("#phone").val();//手机号
		 if(phone!=''){
		  var preg3=/^1[3|4|5|7|8]\d{9}$/;
			 if(!preg3.test(phone)){
				 layer.open({
					content: '无效手机号码！'
					,skin: 'msg'
					,time: 2 //2秒后自动关闭
				});
					$('#phone').focus();
					return false;
				}
        }
	}
	
</script>