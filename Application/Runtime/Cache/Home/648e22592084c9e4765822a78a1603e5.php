<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>推荐</title>
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
		<script src="/Public/home/js/jquery-1.10.2.min.js" type="text/javascript" charset="utf-8"></script>
		<style>
			body{
				background: #0d0f25 url(/Public/home/images/bg2.png) no-repeat;
				width: 28.8rem;
				min-height: 49.76rem;
				background-size: 100% 100%;
				position: relative;
			}
			
			.btnl{
				width: 8.24rem;
				display: block;
				margin: 0.5rem auto;
				height: 2.64rem;
				border: none;
				background: #FCE460;
				color: #D86C41;
				border-radius: 0.3rem;
				font-size: 1.2rem;
				position: absolute;
				bottom:2rem;
				left: 3.2rem;
			}
			
			.btnr{
				width: 8.24rem;
				display: block;
				margin: 0.5rem auto;
				height: 2.64rem;
				border: none;
				background: #FCE460;
				color: #D86C41;
				border-radius: 0.3rem;
				font-size: 1.2rem;
				position: absolute;
				right: 3.2rem;
				bottom: 2rem;
			}
			.tanchu{position: fixed; top: 0; left: 0; background: url(/Public/home/images/tanchuang.png); background-size: cover; width: 100%; height: 100%; display: none;}
		</style>
	</head>
	<body>
		<button onclick="show();" class="btnl">链接邀请</button>
		<button onClick="location.href='<?php echo U("personal/tupianlianjie");?>'" class="btnr">图片邀请</button>
		<span onclick="hide();" class="tanchu"></span>
		<script type="text/javascript" src="/Public/home/js/screenSize.js"></script>
	</body>
</html>
<script type="text/javascript">
	function show(){
		$('.tanchu').fadeTo(200,1);
	}
	function hide(){
		$('.tanchu').fadeOut(300);
	}
</script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
/*
* 注意：
* 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
* 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
* 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
*
* 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
* 邮箱地址：weixin-open@qq.com
* 邮件主题：【微信JS-SDK反馈】具体问题
* 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
*/	

  wx.config({
    debug: false,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
      // 所有要调用的 API 都要加到这个列表中
	  'onMenuShareTimeline',
	  'onMenuShareAppMessage',
	  'onMenuShareQQ',
	  'onMenuShareWeibo',
	  'onMenuShareQZone'
    ]
  });
  

  wx.ready(function () {
	   // 在这里调用 API
		wx.onMenuShareTimeline({
			title: '简异思维  互联型企业创新大学', // 分享标题
			link: '<?php echo (WEB_HOST); ?>index.php/home/index/index/referee/<?php  echo $_SESSION['user_id']?>', // 分享链接
			imgUrl: '<?php echo (WEB_HOST); ?>Public/home/images/share_logo.jpg', // 分享图标
			success: function () { 
				alert("分享成功");
			},
			cancel: function () { 
				// 用户取消分享后执行的回调函数
			}
		});
  

	wx.onMenuShareAppMessage({
		title: '简异思维  互联型企业创新大学', // 分享标题
		desc: '简异思维是一所互联型企业创新大学，由史斌老师发起，为中国中小企业提供最专业、最落地、最实用的互联型企业创新系统。', // 分享描述
		link: '<?php echo (WEB_HOST); ?>index.php/home/index/index/referee/<?php  echo $_SESSION['user_id']?>',  // 分享链接
		imgUrl: '<?php echo (WEB_HOST); ?>Public/home/images/share_logo.jpg', // 分享图标
		type: 'link', // 分享类型,music、video或link，不填默认为link
		dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
		success: function () { 
			alert("分享成功");
		},
		cancel: function () { 
			// 用户取消分享后执行的回调函数
		}
	});
	wx.onMenuShareQQ({
		title: '简异思维  互联型企业创新大学', // 分享标题
		desc: '简异思维是一所互联型企业创新大学，由史斌老师发起，为中国中小企业提供最专业、最落地、最实用的互联型企业创新系统。', // 分享描述
		link: '<?php echo (WEB_HOST); ?>index.php/home/index/index/referee/<?php  echo $_SESSION['user_id']?>',  // 分享链接
		imgUrl: '<?php echo (WEB_HOST); ?>Public/home/images/share_logo.jpg', // 分享图标
		success: function () { 
		   alert("分享成功");
		},
		cancel: function () { 
		   // 用户取消分享后执行的回调函数
		}
	});
	wx.onMenuShareWeibo({
		title: '<?php echo $forum_title; ?>', // 分享标题
		desc: '简异思维是一所互联型企业创新大学，由史斌老师发起，为中国中小企业提供最专业、最落地、最实用的互联型企业创新系统。', // 分享描述
		link: '<?php echo (WEB_HOST); ?>index.php/home/index/index/referee/<?php  echo $_SESSION['user_id']?>',  // 分享链接
		imgUrl: '<?php echo (WEB_HOST); ?>Public/home/images/share_logo.jpg', // 分享图标
		success: function () { 
		   alert("分享成功");
		},
		cancel: function () { 
			// 用户取消分享后执行的回调函数
		}
	});
	wx.onMenuShareQZone({
		title: '简异思维  互联型企业创新大学', // 分享标题
		desc: '简异思维是一所互联型企业创新大学，由史斌老师发起，为中国中小企业提供最专业、最落地、最实用的互联型企业创新系统。', // 分享描述
		link: '<?php echo (WEB_HOST); ?>index.php/home/index/index/referee/<?php  echo $_SESSION['user_id']?>',  // 分享链接
		imgUrl: '<?php echo (WEB_HOST); ?>Public/home/images/share_logo.jpg', // 分享图标
		success: function () { 
		   alert("分享成功");
		},
		cancel: function () { 
			// 用户取消分享后执行的回调函数
		}
	});
  });
</script>