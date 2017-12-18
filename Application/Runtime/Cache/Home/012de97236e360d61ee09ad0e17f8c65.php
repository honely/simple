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
			<h5>¥<?php echo ($viplevel['vip_money']); ?></h5>
			<p class="c">
				<i>购买内容：</i>
				<span><?php echo ($viplevel['vip_name']); ?></span>
			</p>
		</div>
		<div class="zf_ct">
				<div class="form_radio">
					<i></i>
					<p>奖学金支付</p>
					<?php if($userinfo['money'] < $viplevel['vip_money']): ?><em>（余额不足，¥<?php echo ($userinfo['money']); ?>）</em>
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
				 <?php if($userinfo['vip'] < 1 ): ?><input class="but" type="button" value="确定支付" onclick="zhifu(<?php echo ($vip_id); ?>);"/><?php endif; ?>
				</div>
		</div>
	</body>
	<script>
	     
	    function zhifu(vip_id){

			//获取单选框的值
			var pay_type=$('input:radio:checked').val();

            if(pay_type=='1'){
                //微信支付
				location.href="<?php echo U('personal/weixinpayorder');?>&vip_id="+vip_id;
			}else if(pay_type=='3'){
			    //奖学金支付,验证余额是否充足
				//奖学金
				var jiangxuejin = "<?php echo ($userinfo['money']); ?>";
				var money_1 = parseInt(jiangxuejin.substring(0, jiangxuejin.length - 1));
				//vip费用
				var vip_money = "<?php echo ($viplevel['vip_money']); ?>";
				var money_2 = parseInt(vip_money.substring(0, vip_money.length - 1));

				if((money_1 < money_2) || (money_1 <= 0)) {
					alert("余额不足，请使用其他支付方式");
					return false;
				} else {
					$.ajax({
						type: "post",
						url: "<?php echo U('personal/shengji_jxj');?>",
						data: {
							vipid: vip_id,
						},
						success: function(data) {
	
							if(data.flag==1){
								alert("购买VIP会员成功");
								window.location.href="<?php echo U('personal/my');?>";
							}else{
								alert("购买VIP会员失败");
								window.location.href="<?php echo U('personal/shengjihuiyuan');?>";
							}
						},
						error: function(data) {
							//console.log(data)
							alert("网络请求失败");
							window.location.href="<?php echo U('personal/shengjihuiyuan');?>";
						}
					})
				}
			}else{
                alert('请选择支付方式');		
				return false;				
			}
		}
		$(function () {
			var needRefresh = sessionStorage.getItem("need-refresh");
			if(needRefresh){
				sessionStorage.removeItem("need-refresh");
				location.reload();
			}
        });
		sessionStorage.setItem("need-refresh1", true); 
	</script>
	
</html>