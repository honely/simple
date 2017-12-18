<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta http-equiv="Cache-Control" content="no-transform" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<title>已购</title>
		<link rel="stylesheet" type="text/css" href="/Public/home/font/iconfont.css">
		<link rel="stylesheet" type="text/css" href="/Public/home/css/html5.css"/>
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
	<style>
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
			.twlb_box{background: #fff;}
			.twlb_box .ct .twlb{ margin-bottom: 0;border-bottom: 1px solid #E5E6E8;border-radius:0;}
			.twlb_box .ct .twlb:last-child{border-bottom: none;}
		</style>
		<div class="tab_list">
			
			<ul>
				<li class="link">
					<a href="<?php echo U('alreadybuy/index');?>">
						已购专题
					</a>
				</li>
				<li>
					<a href="<?php echo U('personalbuy/index');?>">
						已购课程
					</a>
				</li>
			
			</ul>

		</div>
		<div class="twlb_box pd_lr06" style="margin-bottom: 4.5rem;">
			<div class="ct">
				<?php if(is_array($listinfo)): $i = 0; $__LIST__ = $listinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$buyinfo): $mod = ($i % 2 );++$i;?><dl class="twlb c">
						<dt>
							<a href="#">
								<?php $images=explode("|",$buyinfo['course_images']) ?>
								<img src="<?php echo ($images[0]); ?>"/>
							</a>
						</dt>
						<dd>
							<div class="top">
								<a href="#">
									<h4><!--此处文字请限制长度-->
										<strong><?= $buyinfo['course_name']?></strong>
									</h4>
									<p><?= $buyinfo['course_remarks']?></p>
								</a>
							</div>
							<div class="ct">
								<div class="left">
									<span>已购</span>
								</div>
								<div class="right">
									<span>共<?php echo ($buyinfo["course_allparts"]); ?>集，
										<?php if($buyinfo['course_allparts'] != $buyinfo['course_parts'] ): ?>更新到第<?php echo ($buyinfo['course_parts']); ?>集<?php endif; ?>
										<?php if($buyinfo['course_allparts'] == $buyinfo['course_parts'] ): ?>更新完毕<?php endif; ?>
								    </span>
								</div>
							</div>
							<div class="ct_1">
								<div class="left">
									<span>
										<a href="<?php echo U('course/video',array('course_id'=>$buyinfo['course_id']));?>">
											<i class="iconfont icon-shipin1"></i><em>看视频</em>
										</a>
										<a href="<?php echo U('course/audio',array('course_id'=>$buyinfo['course_id']));?>">
											<i class="iconfont icon-headset"></i><em>听音频</em>
										</a>
									</span>
								</div>
								
								<div class="right">
									<span><?php echo ($buyinfo["course_buy"]); ?>订阅</span>
								</div>
							</div>
						</dd>
					</dl><?php endforeach; endif; else: echo "" ;endif; ?>
			</div>			
				<!--vip会员显示下面这句话-->
				<!--<div style="font-size: 1rem; color: #333; text-align: center; padding-top: 2rem;">
					你已是VIP会员，海量视频免费观看。
				</div>-->
			

				<!--加载更多-->
				 <?php if($count > 6): ?><div id="gundong"></div>
			    <div onclick="getmore()" id="morebtn" data='1' class="btn00">加载更多</div><?php endif; ?>
				
		</div>
		<div class="jilu">
			<i><img src="/Public/home/images/jilu_img.png"/></i>
			<p>你还没有购买任何视频</p>
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
				<li class="link">
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
	</body>
</html>
<script type="text/javascript">
		var _length= $('.ct .twlb').length;
		if(_length>=1){
			$('.jilu').hide();
		}else{
		    $('#morebtn').hide();
		}
		function getmore(){
		var page=parseInt($('#morebtn').attr("data"))+1;
		$('#morebtn').attr("data",page);//重置当前页数
		$.getJSON("<?php echo U('alreadybuy/index');?>&p="+page,function(result){
			var data=result.listinfo;
			if(data.length>0){
				var html="";
				var str="";
				for(var i=0;i<data.length;i++){
					html+="<div class=\"ct\">";
					html+="<dl  class=\"twlb c\">";
					html+="<dt>";
					html+="<a>";
					html+="<img src="+data[i].course_images.split("|")[0]+">";
					html+="</a>";
					html+="</dt>";
					html+="<dd>";
					html+="<div class=\"top\">";
					html+="<a href='#'>";
					html+="<h4 ><strong>"+data[i].course_name.substr(0,10)+"";
					if(data[i].course_hot==2){
						//html+="<span>热播</span>";
					}
					html+="</strong></h4>";
					html+="</a>";
					html+="</div>";
					html+="<div class=\"ct\">"
					html+="<div class=\"left\">"
					html+="<span>已购</span>"
					html+="</div>"
					html+="<div class=\"right\">"
					html+="<span>共"+data[i].course_allparts+"集，更新完毕</span>"
					html+="</div>"
					html+="</div>"
					html+="<div class=\"ct_1\">";
					html+="<div class=\"left\">";
					html+="<span>";
					html+="<a href=\"<?php echo U('course/video');?>&course_id="+data[i].course_id+" \"> ";
					html+="<i class=\"iconfont icon-shipin1\"></i>";	
					html+="<em>看视频</em>";	
					html+="</a>";	
					html+="<a href=\"<?php echo U('course/audio');?>&course_id="+data[i].course_id+" \"> ";
					html+="<i class=\"iconfont icon-headset\"></i>";	
					html+="<em>听音频</em>";	
					html+="</a>";		
					html+="</span>";
					html+="</div>";
					html+="<div class=\"right\">"
					html+="<span>"+data[i].course_buy+"订阅</span>"
					html+="</div>"
					html+="</div>";
					html+="</dd>";
					html+="</dl>";
					html+="</div>";
				}
				$("#gundong").append(html);

			}else{
				$("#morebtn").html('亲，没有数据了！');
			}
		});
	}	
	/*$(function () {
			var needRefresh = sessionStorage.getItem("need-refresh2");
			if(needRefresh){
				sessionStorage.removeItem("need-refresh2");
				location.reload();
			}
        });	 */
   
</script>