<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>我的预约</title>
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
		<link rel="stylesheet" href="/Public/home/css/wodeyuyue.css" />
		<script src="/Public/home/js/jquery-1.10.2.min.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript" src="/Public/home/js/screenSize.js"></script>
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
			.cont{width: 100%; margin-bottom: 1rem; margin-top: 0; border-radius: 0;}
		</style>
	</head>
	<body>
		<?php if(is_array($bookinfo)): $i = 0; $__LIST__ = $bookinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$book): $mod = ($i % 2 );++$i;?><div class="cont">
				<p>预约事项：<?php echo ($book["work_title"]); ?></p>
				<p>预约时间：<?php echo ($book["work_time"]); ?></p>
				<p>预约地点：<span><?php echo ($book["work_address"]); ?></span></p>
				<p>到场人员：<?php echo ($book["num"]); ?>人</p>
			</div><?php endforeach; endif; else: echo "" ;endif; ?>
		<?php if($count > 4): ?><div id="gundong"></div>
			<div onclick="getmore()" id="morebtn" data='1' class="btn00">加载更多</div><?php endif; ?>
		<div class="jilu">
			<img class="imgwu" src="/Public/home/images/wuwu.png" />
			<p class="pp">你还没有任何预约</p>
		</div>
	</body>
</html>
<script type="text/javascript">
    var _length= $('.cont').length;
    if(_length>=1){
        $('.jilu').hide();
    }
</script>
<script>
    function getmore(){
        var page=parseInt($('#morebtn').attr("data"))+1;
        $.getJSON("<?php echo U('Bookinfo/wodeyuyue');?>&p="+page,function(result){
            $('#morebtn').attr("data",page);//重置当前页数
            var data=result.bookinfo;
            if(data.length>0){
                var html="";
                var str="";
                for(var i=0;i<data.length;i++){
                    html+="<div class=\"cont\">";
                    html+="<p>预约事项1："+data[i].work_title+"</p>";
                    html+="<p>预约时间："+data[i].work_time+"</p>";
                    html+="<p>预约地点：<span>"+data[i].work_address+"</span></p>";
                    html+="<p>到场人员："+data[i].num+"人</p>";
                    html+="</div>";
                }
                $("#gundong").append(html);
            }else{
                $("#morebtn").html('亲，没有数据了！');
            }
        });
    }
</script>