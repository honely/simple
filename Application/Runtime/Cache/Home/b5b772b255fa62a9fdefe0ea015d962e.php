<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta http-equiv="Cache-Control" content="no-transform" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<title>我的收藏</title>
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
					<a href="<?php echo U('collect/mycollect');?>">
						专题收藏
					</a>
				</li>
				<li>
					<a href="<?php echo U('bookinfo/mycollect');?>">
						课程收藏
					</a>
				</li>
			</ul>
		</div>
		<div class="twlb_box pd_lr06">
			<div class="ct">
			<?php if(is_array($collect)): $i = 0; $__LIST__ = $collect;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$collect): $mod = ($i % 2 );++$i;?><dl class="twlb c">
					<dt>
						<a href="#">
						<?php $images=explode("|",$collect['lesson_image']) ?>
							<img src="<?php echo ($images[0]); ?>"/>
						</a>
					</dt>
					<dd>
						<div class="top">
							<a href="#">
								<h4><!--此处文字请限制长度-->
									<?php if($collect["lesson_ishot"] == 2): ?><span>热播</span><?php endif; ?>
									<strong><?= $collect['lesson_name']?></strong>
								</h4>
								<p><?= $collect['lesson_remarks']?></p>
							</a>
						</div>
						<div class="ct_1">
							<div class="left">
								<span>
									<a href="<?php echo U('course/video',array('course_id'=>$collect['course_id'],'lesson_id'=>$collect['lesson_id']));?>">
										<i class="iconfont icon-shipin1"></i>
										<em>看视频</em>
									</a>
									<a href="<?php echo U('course/audio',array('course_id'=>$collect['course_id'],'lesson_id'=>$collect['lesson_id']));?>"">
										<i class="iconfont icon-headset"></i>
										<em>听音频</em>
									</a>
								</span>
							</div>
							<!--<div class="right">
								<a href="<?php echo U('collect/delcollect',array('collect_id'=>$collect['collect_id']));?>" onclick="{if(confirm('确认删除?')){return true;}return false;}" >
								<strong>删除</strong>
								</a>
							</div>-->
							<input type="hidden"  value="<?php echo ($collect['collect_id']); ?>" />
							<div class="bottom"  onclick="del(<?php echo ($collect['collect_id']); ?>,this)">
								<strong>删除</strong>
							</div>
						</div>
					</dd>
				</dl><?php endforeach; endif; else: echo "" ;endif; ?>
			</div>
			
			

			<?php if($count >= 5): ?><div id="gundong"></div>
			<div onclick="getmore()" id="morebtn" data='1' class="btn00">加载更多</div><?php endif; ?>
		</div>
		<div class="jilu">
			<i><img src="/Public/home/images/jilu_img.png"/></i>
			<p>你还没有任何收藏</p>
		</div>
	</body>
</html>
<script type="text/javascript">
		var _length= $('.ct .twlb').length;
		//alert(_length);
		if(_length>=1){
			$('.jilu').hide();
		}else{
		    $('#morebtn').hide();
		}
	
function getmore(){
		var page=parseInt($('#morebtn').attr("data"))+1;
		$('#morebtn').attr("data",page);//重置当前页数
		$.getJSON("<?php echo U('collect/mycollect');?>&p="+page,function(result){
			var data=result.collect;
			if(data.length>0){
				var html="";
				var str="";
				for(var i=0;i<data.length;i++){
					html+="<div class=\"ct\">";
					html+="<dl  class=\"twlb c\">";
					html+="<dt>";
					html+="<a>";
					html+="<img src="+data[i].lesson_image.split("|")[0]+">";
					html+="</a>";
					html+="</dt>";
					html+="<dd>";
					html+="<div class=\"top\">";
					html+="<a href='#'>";
					html+="<h4>";
					if(data[i].lesson_ishot==2){
						html+="<span>热播</span>";
					}
					html+="<strong>"+data[i].lesson_name.substr(0,10)+"</strong></h4>";
					html+="</a>";
					html+="</div>";
					html+="<div class=\"ct_1\">";
					html+="<div class=\"left\">";
					html+="<span>";
					html+="<a href=\"<?php echo U('course/video');?>&course_id="+data[i].course_id+
					"&lesson_id="+data[i].lesson_id+" \"> ";
					html+="<i class=\"iconfont icon-shipin1\"></i>";	
					html+="<em>看视频</em>";	
					html+="</a>";	
					html+="<a href=\"<?php echo U('course/audio');?>&course_id="+data[i].course_id+
					"&lesson_id="+data[i].lesson_id+" \"> ";
					html+="<i class=\"iconfont icon-headset\"></i>";	
					html+="<em>听音频</em>";	
					html+="</a>";		
					html+="</span>";
					html+="</div>";
					/*html+="<div class=\"right\">";
					html+="<a href=\"<?php echo U('collect/delcollect');?>&collect_id="+data[i].collect_id+"\" onclick=\"{if(confirm('确认删除?')){return true;}return false;}\" >";
					html+="<strong >"+"删除"+"</strong>";
					html+="	</a>";
					html+="</div>";*/
					html+="<input type=\"hidden\" value="+data[i].collect_id+" >";
					html+="<div class=\"bottom\"  onclick=\"del("+data[i].collect_id+",this);\">";
					html+="<strong >"+"删除"+"</strong>";
					html+="</div>";
					
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
		
	 //删除
	function del(id ,obj){
		 if(confirm("确定要删除数据吗？"))
		 {
			$.ajax({
				type: 'post',
				url: "<?php echo U('collect/del');?>",
				data: {collect_id:id},
				success:function(msg){
					}
				})
			$(obj).parents('.twlb').remove();	
		 }
		
	}
</script>