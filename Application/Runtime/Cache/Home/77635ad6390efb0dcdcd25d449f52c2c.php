<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta http-equiv="Cache-Control" content="no-transform" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<title>选择支付</title>
		<link rel="stylesheet" type="text/css" href="/Public/home/css/html5.css"/>
		<link rel="stylesheet" type="text/css" href="/Public/home/css/mian.css"/>
		<script src="/Public/home/js/jquery-1.10.2.min.js" type="text/javascript" charset="utf-8"></script>
		<script>
			(function(doc, win) {
				var docEl = doc.documentElement,
					resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
					recalc = function() {
						var clientWidth = docEl.clientWidth;
						if(!clientWidth) return;
						docEl.style.fontSize = 25 * (clientWidth / 720) + 'px';
					};
				if(!doc.addEventListener) return;
				win.addEventListener(resizeEvt, recalc, false);
				doc.addEventListener('DOMContentLoaded', recalc, false);
			})(document, window);
		</script>
	</head>
	<body>
		<style type="text/css">
			body{background: #fff;}
		</style>
		<div class="zf_head">
			<h4>简异思维</h4>
			<h5>¥<?php echo ($course_money); ?></h5>
			<p class="c">
				<i>购买内容：</i>
				<span><?php echo ($courseinfo['course_name']); ?>(<?php echo ($courseinfo['course_allparts']); ?>集)</span>
			</p>
		</div>
		<div class="zf_ct">
				<div class="form_radio">
					<i></i>
					<p>奖学金支付</p>
					<?php if($userinfo['money'] < $course_money): ?><em>（余额不足，¥<?php echo ($userinfo['money']); ?>）</em>
					<?php else: ?>
					<em>（现有金额：¥<?php echo ($userinfo['money']); ?>）</em>
					<strong><input type="radio" name="pay" value='3' /></strong><?php endif; ?>
				</div>
				<div class="form_radio">
					<i></i>
					<p>微信支付</p>
					<strong><input type="radio" name="pay" value='1' /></strong>
				</div>
				<div class="form_but">
					<input class="but" type="button" value="确定支付" onclick="zhifu('<?php echo ($courseinfo['course_id']); ?>','<?php echo ($course_money); ?>');"/>
				</div>
		</div>
	</body>
	<script>
	    function zhifu(course_id,course_money){ 
			//获取单选框的值
			var pay_type=$('input:radio:checked').val(); 
            if(pay_type=='1'){
				//微信支付
				location.href="<?php echo U('course/weixinpayorder');?>&course_id="+course_id;
			}else if(pay_type=='3'){
                //奖学金支付,验证余额是否充足  
				var jiangxuejin = "<?php echo ($userinfo['money']); ?>";
				//alert(jiangxuejin);  //1000000.00
				//alert(jiangxuejin.length);//10   0-9
				var money_1 = parseInt(jiangxuejin.substring(0, jiangxuejin.length - 1)); 
				//购买费用
				var course_money = "<?php echo ($course_money); ?>";
				var money_2 = parseInt(course_money.substring(0, course_money.length - 1));  
				if((money_1 < money_2) || (money_1 <= 0)) {
					alert("余额不足，请使用其他支付方式");
					return false;
				} else {
					$.ajax({
						type: "post",
						url: "<?php echo U('course/paycourse');?>",
						data: {
							"course_id": course_id,"money_2":money_2
						},
						success: function(data) { 
							if(data.flag==1){
								alert("购买专题成功");
								window.location.href="<?php echo U('course/video');?>&course_id="+course_id;
							}else{
								alert("购买专题失败");
								window.location.href="<?php echo U('course/video');?>&course_id="+course_id;
							}
						},
						error: function(data) {
							//console.log(data)
							alert("网络请求失败");
							window.location.href="<?php echo U('course/video');?>&course_id="+course_id;
						}
					})	
				}
			}else{
                alert('请选择支付方式');		
				return false;				
			}
		}
	</script>
	
</html>