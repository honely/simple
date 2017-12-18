<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>工具下载</title>
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
		<link rel="stylesheet" href="/Public/home/css/download.css" />
		<link rel="stylesheet" type="text/css" href="/Public/home/css/html5.css"/>
		<script src="/Public/home/js/jquery-1.10.2.min.js" type="text/javascript" charset="utf-8"></script>
		<style type="text/css">
			body{background: #fff;}
			.title{line-height: 4rem; width: 26.16rem;margin: 0 auto; margin-top: 0.6rem; height: 4rem;border-bottom: 1px solid #fafafa;padding: 0 0.72rem; font-size: 1.28rem; color: #363636; font-weight: bold;}
			.cont li button{width: 6.12rem;}
			.cont li i{display: block; float: right; line-height: 4rem; font-style: normal; color: #787878; font-size:0.64rem; margin-right: 0.5rem;}
		</style>
	</head>

	<body>

		<h4 class="title"><?php echo ($subtype["subtype_name"]); ?></h4>
		<ul class="cont">
			<?php if(is_array($downInfo)): $i = 0; $__LIST__ = $downInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><li>
				<p><?php echo ($data["down_title"]); ?></p>
				<?php if($subtype["type_id"] == 1): ?><button onclick="xksxShow();">立即下载</button>
				<?php else: ?>
					<?php if($userinfo["vip"] > 0): ?><button onclick="window.open('<?php echo (WEB_HOST); ?>index.php?m=home&c=myinfo&a=down&down_id=<?php echo ($data["down_id"]); ?>'); ">立即下载</button>
					<?php else: ?>
						<button onclick="location.href='<?php echo U('school/index');?>'">立即下载</button><?php endif; endif; ?>
				<i><?php echo ($data["down_count"]); ?>人下载</i>
			</li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>

		<style type="text/css">
			.tjwx_box{ width: 100%; height: 100%; background: rgba(0,0,0,0.5); position: fixed; top: 0; left: 0; display: none;}
			.tjwx_bg{ width: 100%; height: 24rem;  position: absolute; top: 50%; margin-top: -12rem;padding: 0 1rem;}
			.tjwx{background: #fff; width: 100%; height: 100%; position: relative; border-radius: 10px; text-align: center;}
			.tjwx_box .tjwx_bg .span{display: block; width: 2.5rem; height: 2.5rem; line-height: 2.5rem; font-size:2.5rem; text-align: center; color: #fff; border: 1px solid #fff ; border-radius: 100%; margin: 0 auto; margin-top:1.5rem;}
			.tjwx h4{font-size: 1.2rem; color: #363636; font-weight: bold; padding-top: 2.2rem;}
			.tjwx span{display: block; font-size: 1.04rem; color: #ff5411; padding-top: 1rem;}
			.tjwx i{display: block; font-size: 1.04rem; color: #363636; padding-top: 1rem;}
			.tjwx strong{ display: block; width: 9.6rem; height: 9.4rem; overflow: hidden; margin: 1rem auto 0;}
			.tjwx strong img{display: block; width: 100%;}
			.tjwx em{ display: block; font-size: 0.8rem; color: #797979; padding-top: 1.2rem;}
	
		</style>
		<div class="tjwx_box">
			<div class="tjwx_bg">
				<div class="tjwx">
					<h4>请添加微信好友</h4>
					<span>[微小宝]　18192071569</span>
					<i>即可免费获得价值3800元大礼包</i>
					<strong><img src="/Public/home/images/erweim.jpg"/></strong>
					<em>长按识别二维码</em>
				</div>
				<span class="span" onclick="xksxHide()">×</span>
			</div>
		</div>
		<script type="text/javascript" src="/Public/home/js/screenSize.js"></script>
	</body>

</html>
<script>
	function xiazai(down_id){	
	   location.href="<?php echo (WEB_HOST); ?>index.php?m=home&c=myinfo&a=down&down_id="+down_id;    
	}
  	function xksxShow(){
    	$('.tjwx_box').fadeTo(200, 1);
    }

    function xksxHide(){
    	$('.tjwx_box').fadeOut(300);
    }
</script>