<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta http-equiv="Cache-Control" content="no-transform" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<title>申请分社</title>
		<link rel="stylesheet" type="text/css" href="/Public/home/font/iconfont.css">
		<link rel="stylesheet" href="/Public/home/css/ziliaowanshan.css" />
		<link rel="stylesheet" type="text/css" href="/Public/home/css/html5.css"/>
		<link rel="stylesheet" href="/Public/home/css/district.css" />
		<script src="/Public/home/js/jquery-1.10.2.min.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript" src="/Public/home/js/layer/layer.js"></script>		
		
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
		
			.cont{padding-bottom: 5rem;}
			.popuo-login h3{height: 40px; font-size: 16px; line-height: 40px; background:#ff7811; color: #fff;}
			.popuo-login .layui-m-layercont{padding: 15px 15px 30px; text-align: left;}
			.popuo-login_1 .layui-m-layercont{font-size: 16px; line-height: 25px;padding: 30px 15px;}
			.grxx_box,.cont{border-radius: 0;}
			.cont{width: 100%; }
		</style>
		<div class="">
			<div class="grxx_box c">
				<div class="right">
					<!--不是会员的显示“升级会员按钮”，是会员的显示“排名、学分、签到”按钮-->
					<!--<a class="shengjihuiyuan" href="shengjihuiyuan.html">升级会员</a>-->
					<?php if($user['vip'] != 0): ?><!--<a class="paimimg" href="<?php echo U('personal/xuexipaihangbang');?>">
						<i class="iconfont icon-paiming"></i>
						<p>排名</p>
					</a>-->
					<span class="qiandao" href="" onclick="qiandao()" >
						<i class="iconfont icon-qiandao"></i>
						<?php if($counts >= 1): ?><p >已签</p>
						<?php else: ?>
						<p >签到</p><?php endif; ?>
					</span>
					<a class="xuefen" href="<?php echo U('personal/xuexipaihangbang');?>">
						<i class="iconfont icon-30xuefenpingjiatixi"></i>
						<p>学分</p>
					</a>
					<?php else: ?>
					<a class="shengjihuiyuan" href="<?php echo U('personal/shengjihuiyuan');?>">升级会员</a><?php endif; ?>
				</div>
				<dl class="left">
					<dt>
						<span>
						<?php if($user['vip'] != 0): ?><i class="iconfont icon-vip1"></i><?php endif; ?>
							<img src="<?php echo ($user["avatar"]); ?>"/>
						</span>
					</dt>
					<dd>
						<div class="top">
							<span style=" max-width: 7rem;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"><?php echo ($user["nickname"]); ?></span>
							<em style=" vertical-align: top;" >|</em>
							<i style=" vertical-align: top;"><?php echo ($user['level_name']); ?></i>
						</div>
					</dd>
				</dl>
			</div>
		</div>
		<form name="form1" id="form1" action="<?php echo U('collect/applyforbranch');?>" method="post"  onsubmit=" return check()">
			<div class="cont">
				<ul>
					<li>
						<i>昵称：</i>
						<span><input type="text" value="<?php echo ($user["nickname"]); ?>"  readonly/></span>
					</li>
					<li>
						<i>姓名：</i>
						<span><input name="info[fullname]" id="fullname"type="text" value="<?php echo ($applay["fullname"]); ?>" placeholder="请输入姓名" maxlength="15"/>
						</span>
					</li>
					<li>
						<i>手机：</i>
						<span><input name="info[phone]" id="phone" type="text" value="<?php echo ($applay["phone"]); ?>" placeholder="请输入手机号" onkeyup='this.value=this.value.replace(/\D/gi,"")' maxlength="11"/>
						</span>
					</li>
					<li>
						<i>城市：</i>
						<span><input  type="text" class="select-value" name="info[city]"  id="city" value="<?php echo ($applay["city"]); ?>"    readonly="readonly"/>
						</span>
					</li>
					<li>
						<i>级别：</i>
						<span class="jibie">
							<input name="info[apply_type]" id="jibie" type="hidden" value="<?php echo ($applay["apply_type"]); ?>"/>
							<?php if($applay != 0): if($applay["apply_type"] == 1): ?><strong class="but link" >城市分社</strong>
									<strong class="but " >事业合伙人</strong>
								<?php else: ?>
								    <strong class="but " >城市分社</strong>
								    <strong class="but link" >事业合伙人</strong><?php endif; ?>
							<?php else: ?>
								<strong class="but" date="1">城市分社</strong>
								<strong class="but" date="2">事业合伙人</strong><?php endif; ?>
						</span>
					</li>
				</ul>
				<!--<p onclick="tk_but();" class="tk_but">报名即默认同意相关条款<em>（阅读详情）</em></p>-->
			</div>
			<?php if($applay == 0): ?><input type="submit" name="btn" id="btn" class="btn" value="立即申请" style="display: block;position:relative;"><?php endif; ?>			
		</form>
		<div class="content" style="display:none;"><?php echo ($content['content']); ?></div>
		<div class="title" style="display:none;"><?php echo ($content['title']); ?></div>
<?php if($applay["apply_type"] == 1): if($applay['apply_flag'] == 2): ?><div  style="color:#939393; font-size:1rem; text-align:center;">申请已通过</div><?php endif; ?>
		<?php if($applay['apply_flag'] == 3): ?><div  style="color:#939393; font-size:1rem; text-align:center;">申请被驳回，请联系客服</div><?php endif; ?>
		<?php if($applay['apply_flag'] == 1): ?><div  style="color:#939393; font-size:1rem; text-align:center;">你已经提交申请城市分社，正在审核，请等待。</div><?php endif; ?>	
<?php else: ?>		
		<?php if($applay['apply_flag'] == 2): ?><div  style="color:#939393; font-size:1rem; text-align:center;">申请已通过</div><?php endif; ?>
		<?php if($applay['apply_flag'] == 3): ?><div  style="color:#939393; font-size:1rem; text-align:center;">申请被驳回，请联系客服</div><?php endif; ?>
		<?php if($applay['apply_flag'] == 1): ?><div  style="color:#939393; font-size:1rem; text-align:center;">你已经提交申请事业合伙人，正在审核，请等待。</div><?php endif; endif; ?>
	</body>
</html>
<script src="/Public/home/js/district.js" type="text/javascript" charset="utf-8"></script>	
<script type="text/javascript">


	$(function(){
		$('.jibie .but').click(function(){
			$(this).addClass('link').siblings().removeClass('link');
			var _val=$(this).attr('date');
			$('#jibie').val(_val);
		});
	})
	//分社条款
	function tk_but(){
	
		var content=$(".content").html();
		var title1=$(".title").text();
		layer.open({
		    title: title1,
		    className: 'popuo-login', 
		    content: content
		  });
	}
	
	function check(){
        //姓名
        var fullname = document.getElementById("fullname").value;
        if(fullname==''){
            layer.open({
				content: '姓名不能为空！'
				,skin: 'msg'
				,time: 2 //2秒后自动关闭
			});
            $('#fullname').focus();
            return false;
        }
	    //手机号
		var phone=$("#phone").val();//手机号
		var preg3=/^1[3|4|5|7|8]\d{9}$/;
			if(phone==''){
			 layer.open({
				content: '手机号不能为空！'
				,skin: 'msg'
				,time: 2 //2秒后自动关闭
			});
			  return false;
			}else if(!preg3.test(phone)){
			 layer.open({
				content: '无效手机号码！'
				,skin: 'msg'
				,time: 2 //2秒后自动关闭
			});
				$('#phone').focus();
				return false;
			}
				
		//城市
		var city = document.getElementById("city").value;
        if(city==''){
			layer.open({
				content: '城市不能为空！'
				,skin: 'msg'
				,time: 2 //2秒后自动关闭
			});
            $('#city').focus();
            return false;
        }
		
		//分社级别
		var jibie = document.getElementById("jibie").value;
        if(jibie==''){
			layer.open({
				content: '请选择分社级别！'
				,skin: 'msg'
				,time: 2 //2秒后自动关闭
			});
            $('#jibie').focus();
            return false;
        }
	
    }
	
</script>
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
<?php if($state == 2): ?><script type="text/javascript">
		var tishi='恭喜你报名成功<br/>1-3个工作日内，我们的工作人员会与你联系，谢谢你的支持'
		layer.open({
		    className: 'popuo-login_1', 
		    content: tishi,
		    shadeClose:false,
		    btn: '我知道了'
		  });		
</script><?php endif; ?>