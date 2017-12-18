<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta http-equiv="Cache-Control" content="no-transform" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<title>学习记录</title>
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
			.twlb_box .ct .twlb dd .top a h4 strong{margin-right: 0;}
		</style>
		<div class="tab_list">
			<ul>
				<li class="link">
					<a href="<?php echo U('myinfo/xuexijilu');?>">
						专题记录
					</a>
				</li>
				<li>
					<a href="<?php echo U('myinfo/xuexijilu_alone');?>">
						课程记录
					</a>
				</li>
			</ul>
		</div>
		<div class="twlb_box pd_lr06">
			<div class="ct">
				<?php if(is_array($learnlist)): $i = 0; $__LIST__ = $learnlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$learnlist): $mod = ($i % 2 );++$i;?><dl class="twlb c">
						<dt>
							<a href="<?php echo U('course/video',array('course_id'=>$learnlist['course_id'],'lesson_id'=>$learnlist['lesson_id']));?>">
								<?php
 $imgarr=explode("|",$learnlist['course_images']); ?>
								<img src="<?php echo $imgarr[0];?>"/>
							</a>
						</dt>
						<dd>
							<div class="top">
								<a href="<?php echo U('course/video',array('course_id'=>$learnlist['course_id'],'lesson_id'=>$learnlist['lesson_id']));?>">
									<h4><!--此处文字请限制长度-->
										<strong><?php echo ($learnlist["course_name"]); ?></strong>
									</h4>
									<p><?php echo ($learnlist["course_remarks"]); ?></p>
								</a>
							</div>
							<div class="ct_1">
								<div class="left">
									<span>第<?php echo ($learnlist['lesson_code']); ?>集/共<?php echo ($learnlist["course_allparts"]); ?>集</span>
								</div>
							</div>
							<input type="hidden"  value="<?php echo ($learnlist['learn_id']); ?>" />
							<div class="bottom"  >
								<strong onclick="del(<?php echo ($learnlist["learn_id"]); ?>,this)">删除</strong>
							</div>
						</dd>
					</dl><?php endforeach; endif; else: echo "" ;endif; ?>	 
			</div>
			    <?php if($count >= 5): ?><div id="gundong"></div>
			    <div onclick="getmore()" id="morebtn" data='1' class="btn00">加载更多</div><?php endif; ?>
		</div>
		<div class="jilu">
			<i><img src="/Public/home/images/jilu_img.png"/></i>
			<p>你还没有购买任何视频</p>
		</div>
	</body>
</html>
<script type="text/javascript">
		var _length= $('.ct .twlb').length;
		if(_length>=1){
			$('.jilu').hide();
		}
</script>
<script>
	function getmore(){
		var page=parseInt($('#morebtn').attr("data"))+1;
		$('#morebtn').attr("data",page);//重置当前页数
		//alert(page);
		$.getJSON("<?php echo U('myinfo/xuexijilu');?>&p="+page,function(result){	
			var data=result.learnlist;
			if(data.length>0){
				var html="";
				var str="";
				for(var i=0;i<data.length;i++){
					html+="<div class=\"ct\">";
					html+="<dl  class=\"twlb c\">";
					html+="<dt>";
					html+="<a href=\"<?php echo U('course/video');?>&course_id="+data[i].course_id+"&lesson_id="+data[i].lesson_id+"\">";
					html+="<img src="+data[i].course_images.split("|")[0]+">";
					html+="</a>";
					html+="</dt>";
					html+="<dd>";
					html+="<div class=\"top\">";
					html+="<a href=\"<?php echo U('course/video');?>&course_id="+data[i].course_id+"&lesson_id="+data[i].lesson_id+"\">";
					html+="<h4 >"+data[i].course_name+"</h4>";
					html+="</a>";
					html+="</div>";
					html+="<div class=\"ct_1\">";
					html+="<div class=\"left\">";
					html+="<span>"+"第"+data[i].lesson_code+"集/"+"共"+data[i].course_allparts+"集"+"</span>";
					html+="</div>";
					html+="</div>";
					html+="<input type=\"hidden\" value="+data[i].learn_id+" >";
					html+="<div class=\"bottom\" >";
					html+="<strong  onclick=\"del("+data[i].learn_id+",this);\">"+"删除"+"</strong>";
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
				url: "<?php echo U('myinfo/del');?>",
				data: {learn_id:id},
				success:function(msg){
					}
				})
			$(obj).parents('.twlb').remove();	
		 }
		
	}
</script>