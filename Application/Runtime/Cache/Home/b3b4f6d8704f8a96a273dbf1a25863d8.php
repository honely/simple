<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta http-equiv="Cache-Control" content="no-transform" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<title>学员加入</title>
		<link rel="stylesheet" type="text/css" href="/Public/home/font/iconfont.css">
		<link rel="stylesheet" type="text/css" href="/Public/home/css/html5.css"/>
		<script src="/Public/home/js/jquery-1.10.2.min.js" type="text/javascript" charset="utf-8"></script>
		<link rel="stylesheet" href="http://g.alicdn.com/de/prismplayer/1.9.9/skins/default/index.css" />
		<script type="text/javascript" src="http://g.alicdn.com/de/prismplayer/1.9.9/prism-min.js"></script>
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
			.grxx_box .left dd .top{height: 2rem; line-height: initial;}
			.mingpian{padding-bottom: 5rem;}
		</style>
		<div class="vide_box">
			<div  class="prism-player" id="J_prismPlayer" style="position: absolute;left:0%; top: 0;"></div>
		</div>
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
								<?php if($user_info['vip'] != 0 ): ?><i><img src="<?php echo ($user_info['vip_image']); ?>"></i><?php endif; ?>	
								<img src="<?php echo ($user_info['avatar']); ?>"/>
							</span>
						</dt>
						<dd>
							<div class="top">
								<span style=" max-width: 7rem;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"><?php echo ($user_info['nickname']); ?></span>
								<em style=" vertical-align: top;">|</em>
								<i style=" vertical-align: top;"><?php echo ($user_info['level_name']); ?></i>
							</div>
							<span class="ct">学分：<em><?php echo ($user_info['score']); ?>分</em></span>
							<p class="bottom">　每天2元，全年仅投888元，碎片化时间，系统学习简异思维方法<br/>
　每周2节，全年更新100节，音视频大课，全面掌握业绩倍增工具</p>
						</dd>
					</dl>
				</div>
				<style type="text/css">
					.gai_jilu{background: #fff; width: 100%; border-radius:10px; padding: 5px 1.2rem; margin-top: 0.5rem;}
					.gai_jilu h4{text-align: center; font-size:1rem; color:#ff7811;}
					.gai_jilu span{display: block; font-size: 0.8rem; color: #ff7811; margin-top: 0.3rem;}
					@media (max-width: 375px){
							    .gai_jilu span{
							    	float: none;
							    	text-align: center;
							    }
							}
				</style>
				<?php if($user_info['vip'] != 0 ): ?><div class="gai_jilu c">
						<h4>本年度累计消费699元</h4>
						<span class="fl">入学时间：<?php echo (date('Y-m-d',$user_info['buy_addtime'])); ?></span>
						<span class="fr">到期时间：<?php echo (date('Y-m-d',$user_info['buy_endtime'])); ?></span>
					</div><?php endif; ?>
			</div>
		</div>
		<div class="custom">
			<?php echo ($content_info_['content']); ?>
		</div>
		<div class="button_box pd_lr06">
		<?php if($user_info['vip'] == 0 ): ?><a class="but mg_b10" href="<?php echo U('personal/shengjihuiyuan');?>">我要入学</a><?php endif; ?>
		</div>
	</body>
</html>
<script type="text/javascript">
 		var videoUrl="<?php echo ($content_info_['video']); ?>";  ////common.qupai.me/player/qupai.mp4";
	    var player = new prismplayer({
	    	 id: "J_prismPlayer",
	         autoplay: false,//播放器是否自动播放
	         isLive:false,  //播放内容是否为直播
	         playsinline:true,//H5是否内置播放
	         width:"100%",
	         height:"200px",
	         showBuffer:true,
	         showBarTime:"2000",
	         controlBarVisibility:"hover",//控制控制面板的现实
	         useH5Prism:false, //指定使用H5播放器
	         useFlashPrism:false, //指定使用Flash播放器
	         source:videoUrl,//视频播放地址url
	         cover:"<?php echo ($content_info_['image']); ?>",//播放器默认封面图片
	         skinLayout:[{"name":"bigPlayButton","align":"cc"},
	                {"name":"controlBar","align":"blabs","x":0,"y":0,"children":[{"name":"progress","align":"tlabs","x":0,"y":0},
	                {"name":"playButton","align":"tl","x":15,"y":26},
	                {"name":"fullScreenButton","align":"tr","x":20,"y":25},
	                {"name":"timeDisplay","align":"tl","x":10,"y":24},
	                {"name":"setButton","align":"tr","x":20,"y":25}]},
	                {"name":"fullControlBar","align":"tlabs","x":0,"y":0,"children":[{"name":"fullTitle","align":"tl","x":25,"y":6},
	                {"name":"fullNormalScreenButton","align":"tr","x":24,"y":13},
	                {"name":"fullTimeDisplay","align":"tr","x":10,"y":12},
	                {"name":"fullZoom","align":"cc"}
	                ]}]
		});
</script>