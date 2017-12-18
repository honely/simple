<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>我的</title>
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
		<script src="/Public/home/js/jquery-1.10.2.min.js" type="text/javascript" charset="utf-8"></script>
		<link rel="stylesheet" type="text/css" href="/Public/home/font/iconfont.css">
		<link rel="stylesheet" type="text/css" href="/Public/home/css/html5.css"/>
		<link rel="stylesheet" href="/Public/home/css/my.css"/>
	</head>

	<body>
		<style type="text/css">
			.grxx_box,.cont ul,.list ul{border-radius: 0;}
		</style>
		<div class="">
			<div class="grxx_box c">
				<div class="right">
					<!--不是会员的显示“升级会员按钮”，是会员的显示“排名、学分、签到”按钮-->
					<?php if($userinfo['vip'] == 0): ?><a class="shengjihuiyuan" href="<?php echo U('personal/shengjihuiyuan');?>">升级会员</a>
					<?php else: ?>
					<span class="qiandao" href="" onclick="qiandao()" >
						<i class="iconfont icon-qiandao"></i>
						<?php if($counts >= 1): ?><p >已签</p>
						<?php else: ?>
						<p >签到</p><?php endif; ?>
					</span>
					<a class="xuefen" href="<?php echo U('personal/xuexipaihangbang');?>">
						<i class="iconfont icon-30xuefenpingjiatixi"></i>
						<p>学分</p>
					</a><?php endif; ?>
				</div>
				<dl class="left">
					<dt>
						<span>
						<?php if($userinfo['vip'] != 0): ?><i><img src="<?php echo ($userinfo['vip_image']); ?>"/></i><?php endif; ?>
							<img src="<?php echo ($userinfo['avatar']); ?>"/>
						</span>
					</dt>
					<dd>
						<div class="top">
							<span style=" max-width: 7rem;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"><?php echo ($userinfo['nickname']); ?></span>
							<em style=" vertical-align: top;">|</em>
							<i style=" vertical-align: top;"><?php echo ($user_level[$userinfo['level']]); ?></i>
						</div>
					</dd>
				</dl>
			</div>
		</div>
		<div class="cont mg_t10">
			<ul>
			   <a href="<?php echo U('myinfo/xuexijilu');?>">
				<li>
					<span><?php echo ($learntime); ?></span>
					<p>学习时间</p>
				</li>
			   </a>
			  <a href="<?php echo U('alreadybuy/index');?>">
				<li>
					<span><?php echo ($buyinfo); ?>个</span>
					<p>订阅专题</p>
				</li>
				</a>
				<!-- 按学分排名 -->
				<?php if($userinfo['vip'] != 0): ?><a href="<?php echo U('personal/xuexipaihangbang');?>">
				<li>								
					<span>第<?php echo ($user_order); ?>名</span>					
					<p>排名</p>					
				</li>
				</a><?php endif; ?>
				<?php if($userinfo['vip'] == 0): ?><a>
				<li>												
					<span>暂无</span>
					<p>排名</p>					
				</li>
				</a><?php endif; ?>
			</ul>
		</div>
		<div class="list mg_t10" style="margin-bottom: 4.5rem;">
			<ul>
				<li>
					<a href="<?php echo U('bookinfo/wodeyuyue');?>">
						<i class="iconfont icon-shijian"></i>
						<p>我的预约</p>
						<span class="iconfont icon-right"></span>
					</a>
				</li>
				<li>
					<a href="<?php echo U('bookinfo/yanxibanbaoming');?>">
						<i class="iconfont icon-biji"></i>
						<p>线下大课报名</p>
						<span class="iconfont icon-right"></span>
					</a>
				</li>
				<li>
					<a href="<?php echo U('myinfo/xuexijilu');?>">
						<i class="iconfont icon-jilu1"></i>
						<p>学习记录</p>
						<span class="iconfont icon-right"></span>
					</a>
				</li>
				<li>
					<a href="<?php echo U('myinfo/ziliaowanshan');?>">
						<i class="iconfont icon-ziliao2"></i>
						<p>完善资料</p>
						<span class="iconfont icon-right"></span>
					</a>
				</li>
				<li>
					<a href="<?php echo U('collect/mycollect');?>">
						<i class="iconfont icon-xing"></i>
						<p>我的收藏</p>
						<span class="iconfont icon-right"></span>
					</a>
				</li>
				<li>
					<a href="<?php echo U('collect/applyforbranch');?>">
						<i class="iconfont icon-not_submit"></i>
						<p>申请分社</p>
						<span class="iconfont icon-right"></span>
					</a>
				</li>
				<li class="mg_t20">
					<a href="<?php echo U('personal/tuijian');?>">
						<i class="iconfont icon-zan"></i>
						<p>推荐【简异思维】给朋友</p>
						<span class="iconfont icon-right"></span>
					</a>
				</li>
				<li>
					<a href="<?php echo U('collect/creditrules');?>">
						<i class="iconfont icon-30xuefenpingjiatixi"></i>
						<p>学分规则</p>
						<span class="iconfont icon-right"></span>
					</a>
				</li>
				<li>
					<a href="tel:<?php echo ($kefuphone); ?>">
						<i class="iconfont icon-service"></i>
						<p>客服电话　<?php echo ($kefuphone); ?> </p>
					</a>
				</li>
			</ul>
		</div>
		<div class="foot">
			<ul>
				<li>
					<a href="<?php echo U('index/index');?>">
						<span class="iconfont icon-xuexi"></span>
						<p>学习</p>
					</a>
				</li>
				<li>
					<a href="<?php echo U('myinfo/jiangxuejin');?>">
						<span class="iconfont icon-jiangxuejinv"></span>
						<p>奖学金</p>
					</a>
				</li>
				<li>
					<a href="<?php echo U('alreadybuy/index');?>">
						<span class="iconfont icon-gouwuche"></span>
						<p>已购</p>
					</a>
				</li>
				<li class="link">
					<a href="<?php echo U('personal/my');?>">
						<span class="iconfont icon-wode"></span>
						<p>我的</p>
					</a>
				</li>
			</ul>
		</div>
		<script type="text/javascript" src="/Public/home/js/screenSize.js"></script>
		<script type="text/javascript" src="/Public/home/js/layer/layer.js"></script>
        <script type="text/javascript" src="/Public/home/js/swiper-3.4.2.jquery.min.js"></script>
		<script>	   
		   function qiandao(){
			   var qiandaotext=$('.qiandao p').text();
				   if(qiandaotext=='已签'){
						  msgs("已签到");
					 }else{ 
						    $.ajax({
							   url: '<?php echo U("personal/qiandao");?>',
							   type: 'post',
							   data: {id:1},
							   dataType:'json',
							   success:function(data){
							   if(data>0){
									msgs("签到成功");
									$('.qiandao p').text('已签');
								 }else{
									msgs("已签到");
								 }
							   }
							});
					}
			   }
		   function msgs(content){
				layer.open({
					content: content,
					skin: 'msg',
					time: 2 //2秒后自动关闭
				});
		   }
		/* sessionStorage.setItem("need-refresh2", true); */
		</script>
	</body>
</html>