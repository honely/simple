<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>奖学金</title>
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
		<link rel="stylesheet" type="text/css" href="/Public/home/css/html5.css"/>
		<link rel="stylesheet" href="/Public/home/css/public.css"/>
		<link rel="stylesheet" href="/Public/home/css/jiangxuejin.css" />
		<link rel="stylesheet" type="text/css" href="/Public/home/font/iconfont.css">
	</head>

	<body>
	  <style>
		  body,
		  button, input, select, textarea {
			  font: -webkit-control;
		  }
			.btn00{ text-align:center; padding:0.75rem 0; font-size:0.95rem; color:#666; width:15rem;  margin:2rem auto;}
			.chongzhijilu_ul li {
				width: 100%;
				height: 3.5rem;
				padding: 0 3rem 0 2rem;
				border-bottom: 1px solid #f0f0f0;
				font-size: 1.3rem;
				line-height: 3.5rem;
				color: #363636;
				overflow: hidden;
			}
			.grxx_box{border-radius: 0;}
			.show_tk{width:1.3rem;height: 1.3rem;border: none;background: #FF7811;color: #FFFFFF;font-size: 1rem;border-radius: 100%;position: absolute;right:6rem;top:1rem; text-align: center; line-height: 1.4rem;}
			.content{position: absolute; width: 100%; height: 150px; top:50px; left: 0;padding: 0 1rem; display: none;}
			.content .content_bg{background: #ebebeb; position: relative; padding: 0 1.25rem 2rem; border-radius: 10px;}
			.content_bg .bg_jxj{ display: block; position: absolute; top:-1rem ; right: 5.5rem; width: 1.4rem; height: 1rem; background: url('/Public/home/images/bg_jxj.png') no-repeat;background-size: cover;}
			.content_bg h4{text-align: center; height: 4rem; line-height: 4rem; font-size: 1.28rem; color: #ff7811;}
			.content_bg .text{font-size: 1rem; line-height: 1.5rem; color:#ff7811;}
			.content_bg .text span{font-size:1.2rem;}
			.content_bg .text:nth-of-type(1){ margin-bottom:1rem;}
	  </style>
		<div class="">
			<div class="grxx_box c">
				<div class="right">
					<!--不是会员的显示“升级会员按钮”，是会员的显示“排名、学分、签到”按钮-->
					<?php if($yue['vip'] == 0): ?><a class="shengjihuiyuan" href="<?php echo U('personal/shengjihuiyuan');?>">升级会员</a>
					<?php else: ?>

					<span class="qiandao" href="" onclick="qiandao()" >
						<i class="iconfont icon-qiandao"></i>
						<?php if($count_s >= 1): ?><p>已签</p>
						<?php else: ?>
						<p>签到</p><?php endif; ?>
					</span>
					<a class="xuefen" href="<?php echo U('personal/xuexipaihangbang');?>">
						<i class="iconfont icon-30xuefenpingjiatixi"></i>
						<p>学分</p>
					</a><?php endif; ?>
				</div>
				<dl class="left">
					<dt>
						<span>
						<?php if($yue['vip'] != 0): ?><i><img src="<?php echo ($yue['vip_image']); ?>"/></i><?php endif; ?>
							<img src="<?php echo ($yue['avatar']); ?>"/>
						</span>
					</dt>
					<dd>
						<div class="top">
							<span style=" max-width: 7rem;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"><?php echo ($yue['nickname']); ?></span>
							<em style=" vertical-align: top;">|</em>
							<i style=" vertical-align: top;"><?php echo ($user_level[$yue['level']]); ?></i>
						</div>
					</dd>
				</dl>
			</div>
		</div>
		<div class="cont  mg_t10" style="margin-bottom: 4.5rem;">
			<div class="money">
				<span class="show_tk" onclick="tk_but()">?</span>
				<!--注：可以吧奖学金赠送给别人-->
				<?php if($count == 0): ?><button onclick="location.href ='<?php echo U('myinfo/xiajiliebiao');?>'" disabled='true' style="background:#999999;" >赠送</button>
				<?php else: ?>
				<button onclick="location.href ='<?php echo U('myinfo/xiajiliebiao');?>'">赠送</button><?php endif; ?>
				<img src="/Public/home/images/money.png"  />
				<p><span><?php echo ($yue["money"]); ?></span>元</p>
				<p>我的奖学金</p>
				<p>成功邀请一位学员，奖励奖学金100元，<br />奖学金可以购买课程时抵用。</p>
			<div class="content">
				<div class="content_bg">
					<i class="bg_jxj"></i>
					<h4>送人玫瑰　手有余香</h4>
					<div class="text">
						<span>◆</span>
						同学，你可以将你剩余的奖学金赠送给同事、亲朋好友，分享知识友情无限，学简异思维，做互联型人才。
					</div>
					<div class="text">
						<span>◆</span>
						赠送流程：点击下方『立即邀请』→邀请同学加入→
		点击『赠送』→点击你要赠送的人→输入金额→完成
					</div>
				</div>
			</div>
			</div>
			<div class="list">
				<div class="top c">
					<span class="link" >已邀请的VIP学员：<?php echo ($counts); ?>位</span>
					<span >已邀请的普通学员：<?php echo ($countss); ?>位</span>
				</div>
				<div class="ct">
					<div class="ct_box">
						<ul>
						    <?php if(is_array($vip)): $i = 0; $__LIST__ = $vip;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vip): $mod = ($i % 2 );++$i;?><li>
								<span>
								    <i><img src="<?php echo ($vip['vip_image']); ?>"/></i>
									<img src="<?php echo ($vip["avatar"]); ?>"/>
								</span>
								<p><?php echo ($vip["nickname"]); ?><span><?php echo ($vip["level_name"]); ?></span></p>
							</li><?php endforeach; endif; else: echo "" ;endif; ?>
						</ul>
						<ul id="gundong"></ul>
						<?php if($counts >= 5): ?><div onclick="getmore()" id="morebtn" data='1' class="btn00">加载更多</div><?php endif; ?>			
					</div>
					<div class="ct_box">
						<ul>
						<?php if(is_array($huiyuan)): $i = 0; $__LIST__ = $huiyuan;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$huiyuan): $mod = ($i % 2 );++$i;?><li>
								<span>
									<img src="<?php echo ($huiyuan["avatar"]); ?>"/>
								</span>
								<p><?php echo ($huiyuan["nickname"]); ?><span><?php echo ($huiyuan["level_name"]); ?></span></p>
							</li><?php endforeach; endif; else: echo "" ;endif; ?>	
						</ul>	
						<ul id="gundongs"></ul>
						<?php if($countss >= 5): ?><div onclick="getmores()" id="morebtns" data='1' class="btn00">加载更多</div><?php endif; ?>	
					</div>
				</div>
				<?php if($count == 0): ?><p>你还未成功邀请学员</p><?php endif; ?>
				<button onClick="location.href='<?php echo U('personal/tuijian');?>'" class="btnb">立即邀请</button>
			</div>
		</div>
		<div class="foot">
			<ul>
				<li>
					<a href="<?php echo U('index/index');?>">
						<span class="iconfont icon-xuexi"></span>
						<p>学习</p>
					</a>
				</li>
				<li class="link">
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
				<li>
					<a href="<?php echo U('personal/my');?>">
						<span class="iconfont icon-wode"></span>
						<p>我的</p>
					</a>
				</li>
			</ul>
		</div>
		<script type="text/javascript" src="/Public/home/js/screenSize.js"></script>
	</body>
</html>
<script src="/Public/home/js/jquery-1.10.2.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="/Public/home/js/layer/layer.js"></script>
<script type="text/javascript" src="/Public/home/js/swiper-3.4.2.jquery.min.js"></script>
<script type="text/javascript">
    function getmore(){
		var page=parseInt($('#morebtn').attr("data"))+1;
		$('#morebtn').attr("data",page);//重置当前页数
		//alert(page);
		$.getJSON("<?php echo U('myinfo/jiangxuejin');?>&p="+page,function(result){
			var data=result.vip;
			if(data.length>0){
				var html="";
				var str="";
				for(var i=0;i<data.length;i++){
					html+="<li>";
					html+="<span>";
					html+="<i>";
					html+="<img src="+data[i].vip_image+">";
					html+="</i>";
					html+="<img src="+data[i].avatar+">";
					html+="</span>";
					html+="<p>"+data[i].nickname+" ";
					if(data[i].level_name!=null){
					html+="<span >"+data[i].level_name+"</span>";
					}else{
					html+="<span ></span>";
					}
					html+="</p>";
					html+="</li>";

				}
				$("#gundong").append(html);
			}else{
				$("#morebtn").html('亲，没有数据了！');
			}
		});
	}
	function getmores(){
		var page=parseInt($('#morebtns').attr("data"))+1;
		$('#morebtns').attr("data",page);//重置当前页数
		//alert(page);
		$.getJSON("<?php echo U('myinfo/jiangxuejin');?>&p="+page+"&state="+1,function(result){
			var data=result.huiyuan;
			if(data.length>0){
				var html="";
				var str="";
				for(var i=0;i<data.length;i++){
					html+="<li>";
					html+="<span>";
					html+="<img src="+data[i].avatar+">";
					html+="</span>";
					html+="<p>"+data[i].nickname+" ";
					if(data[i].level_name!=null){
					html+="<span >"+data[i].level_name+"</span>";
					}else{
					html+="<span ></span>";
					}
					html+="</p>";
					html+="</li>";
				}
				$("#gundongs").append(html);
			}else{
				$("#morebtns").html('亲，没有数据了！');
			}
		});
	}

	$(function(){
		$('.list .ct .ct_box').eq(0).show();
		$('.list .top span').click(function(){
			var _index=$(this).index();
			$(this).addClass('link').siblings().removeClass('link');
			$('.list .ct .ct_box').eq(_index).show().siblings().hide();
		});
	});
	
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

	function tk_but(){
		$(".content").fadeToggle();
	}
	/*$(function () {
			var needRefresh = sessionStorage.getItem("need-refresh2");
			if(needRefresh){
				sessionStorage.removeItem("need-refresh2");
				location.reload();
			}
        });	*/
  		
</script>
</script>