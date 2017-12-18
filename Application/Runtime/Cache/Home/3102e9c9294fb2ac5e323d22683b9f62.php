<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>升级会员</title>
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
		<link rel="stylesheet" href="/Public/home/css/shengjihuiyuan.css" />
		<link rel="stylesheet" type="text/css" href="/Public/home/font/iconfont.css">
		<link rel="stylesheet" type="text/css" href="/Public/home/css/html5.css"/>
		<script src="/Public/home/js/jquery-1.10.2.min.js" type="text/javascript" charset="utf-8"></script>
	</head>

	<body>
		<style type="text/css">
			.zdy_box{margin-bottom:4rem; background: #fff; padding:1rem 0;}
			.imgs{display: none;}
			.but_box{position: fixed; bottom:0; background: #fff; width: 100%;}
			.grxx_box .left dd .top {height: 2rem; line-height: initial;}
			.list{width: 27rem;}
			.grxx_box{padding: 10px 1.2rem;}
			.grxx_box .left dd .bottom{font-size: 0.9rem;line-height: 1.35rem;}
		</style>
		<div class="pd_lr06 mg_t10">
			<div class="mingpian">
				<div class="top_text">
					<span>简异思维</span>
					<span>互联型企业创新大学</span>
				</div>
				<div class="grxx_box c">
					<dl class="left">
						<dt>
							<span>
								<img src="<?php echo ($userinfo['avatar']); ?>" />
								<?php if($userinfo['vip_image'] != ''): ?><img src="<?php echo ($userinfo['vip_image']); ?>" /><?php endif; ?>
							</span>
						</dt>
						<dd>
							<div class="top">
								<span style=" max-width: 7rem;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"><?php echo ($userinfo['nickname']); ?></span>
								<em style=" vertical-align: top;">|</em>
								<i style=" vertical-align: top;"><?php echo ($user_level[$userinfo['level']]); ?></i>
							</div>
							<span class="ct">学分：<em><?php echo ($userinfo['score']); ?>分</em></span>
							<p class="bottom">每天2元，全年仅投850元，碎片化时间，系统学习简异思维方法<br/>
每周2节，全年更新100节，音视频大课，全面掌握业绩倍增工具</p>
						</dd>
					</dl>
				</div>
			</div>
		</div>
		<div class="list">
			<ul>
				<?php if(is_array($viplevel)): foreach($viplevel as $key=>$vo): ?><li>
						<input class="cost" type="radio" name="money" value="<?php echo ($vo["vip_id"]); ?>" <?php if($key == 0): ?>checked<?php endif; ?> />
						<p><?php echo ($vo["vip_title"]); ?></p>
					</li><?php endforeach; endif; ?>
			</ul>
		</div>
		<div class="zdy_box">
		    <?php if(is_array($viplevel)): foreach($viplevel as $key=>$vo1): ?><div class="imgs">
					<?php echo ($vo1["vip_remark"]); ?>
				</div><?php endforeach; endif; ?>
		</div>
		<!--注：底下可以添加图片介绍，底下按钮固定在最上边。-->
		<div class="but_box">
		    <?php if($userinfo['vip'] < 1 ): ?><button class="btn" onclick="buyvip();" >立即订购</button><?php endif; ?>
		</div>
	<script type="text/javascript" src="/Public/home/js/screenSize.js"></script>
	</body>
	<script>
		function buyvip(){
			//获取单选框的值
			var vip_id=$('input:radio:checked').val();
			if(vip_id=='' ||  typeof(vip_id)=="undefined"){
			   alert('请选择vip等级');
			   return false;
			}else{
				//location.href="<?php echo (WEB_HOST); ?>index.php?m=home&c=personal&a=xuanzezhifu&vip_id="+vip_id; 
				location.href="<?php echo (WEB_HOST); ?>index.php?m=home&c=personal&a=proxuanzezhifu&vip_id="+vip_id; 
            }			
		}
    </script>
</html>
<script type="text/javascript">
	$(function(){
		$('.zdy_box .imgs').eq(0).show();
		$('.list ul li input').click(function(){
			var _index=$(this).parent().index();
			$('.zdy_box .imgs').eq(_index).show().siblings().hide();
		})
	})
	$(function () {
			var needRefresh = sessionStorage.getItem("need-refresh1");
			if(needRefresh){
				sessionStorage.removeItem("need-refresh1");
				location.reload();
			}
    });
</script>