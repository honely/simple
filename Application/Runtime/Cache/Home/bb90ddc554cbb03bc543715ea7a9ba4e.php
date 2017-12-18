<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>报名预约</title>
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
		<link rel="stylesheet" type="text/css" href="/Public/home/font/iconfont.css">
		<link rel="stylesheet" href="/Public/home/css/public.css" />
		<link rel="stylesheet" href="/Public/home/css/baomingyuyue.css" />
	</head>

	<body>
		<style type="text/css">
			.grxx_box,.cont{border-radius: 0;}
			.cont{width: 100%;padding-bottom: 1rem;}
		</style>
		<!--普通贵宾席人数选择弹出层-->
		<div class="humanbg">
			<div class="human">
				<p>请选择人数</p>
				<ul>
					<li>
						<input class="nn" type="radio" name="human" />
						<p>1人</p>
					</li>
					<li>
						<input class="nn" type="radio" name="human" />
						<p>2人</p>
					</li>
					<li>
						<input class="nn" type="radio" name="human" />
						<p>3人</p>
					</li>
					<li>
						<input class="nn" type="radio" name="human" />
						<p>4人</p>
					</li>
					<li>
						<input class="nn" type="radio" name="human" />
						<p>5人</p>
					</li>
					<li>
						<input class="nn" type="radio" name="human" />
						<p>6人</p>
					</li>
					<li>
						<input class="nn" type="radio" name="human" />
						<p>7人</p>
					</li>
					<li>
						<input class="nn" type="radio" name="human" />
						<p>8人</p>
					</li>
					<li>
						<input class="nn" type="radio" name="human" />
						<p>9人</p>
					</li>
					<li>
						<input class="nn" type="radio" name="human" />
						<p>10人</p>
					</li>
					<input  type="hidden" name="code" id="code" value="1" />
				</ul>
			</div>
		</div>
		<div class="">
			<div class="grxx_box c">
				<div class="right">
					<!--不是会员的显示“升级会员按钮”，是会员的显示“排名、学分、签到”按钮-->
					<!--<a class="shengjihuiyuan" href="shengjihuiyuan.html">升级会员</a>-->
					<?php if($isVip == 0): ?><a class="shengjihuiyuan" href="<?php echo U('personal/shengjihuiyuan');?>">升级会员</a>
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
							<?php if($userInfo['vip'] != 0): ?><i><img src="<?php echo ($userInfo['vip_image']); ?>"/></i><?php endif; ?>
							<img src="<?php echo ($userInfo['avatar']); ?>"/>
						</span>
					</dt>
					<dd>
						<div class="top">
							<span style=" max-width: 7rem;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"><?php echo ($userInfo['nickname']); ?></span>
							<em style=" vertical-align: top;">|</em>
							<i style=" vertical-align: top;"><?php echo ($user_level[$userInfo['level']]); ?></i>
						</div>
					</dd>
				</dl>
			</div>
		</div>
		<div class="cont">
			<form action="<?php echo U('bookinfo/lijigoumai');?>" method="post" onsubmit="return tianjia()" id="user_form">
				<ul>
					<li>
						<input type="hidden" name="work_id" value="<?php echo ($work_id); ?>"/>
						<p>姓名： </p>
						<input class="orange" onfocus="true" type="text" id="fullname" name="info[fullname]" maxlength="8" />
					</li>
					<li>
						<p>身份证：</p>
						<input class="orange" onkeyup="value=value.replace(/\W/gi,'')" name="info[idcard]" id="idcard" type="text" maxlength="18" />
					</li>
					<li>
						<p>公司：</p>
						<input class="orange" name="info[company]" id="company" type="text" maxlength="15" />
					</li>
					<li>
						<p>职务：</p>
						<input class="orange" name="info[job]" id="job" type="text" maxlength="10" />
					</li>
					<li>
						<p>电话： </p>
						<input class="orange" name="info[phone]" id="phone" type="tel" style="width: 12rem;" maxlength="11" onkeyup='this.value=this.value.replace(/\D/gi,"")' />
						<button class="btn1" id="yzmbut" onclick=" return seed()" >发送验证码</button>
					</li>
					<li>
						<p>验证码：</p>
						<input class="orange" type="tel" maxlength="6" id="verfCode" onkeyup='this.value=this.value.replace(/\D/gi,"")' />
					</li>
					<?php if(is_array($seatInfo)): $i = 0; $__LIST__ = $seatInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$seat): $mod = ($i % 2 );++$i;?><li  onclick="checkcode('<?php echo ($seat["seat_id"]); ?>')">
							<input type="hidden" id="xiwei<?php echo ($seat["seat_id"]); ?>" name="seat[<?php echo ($seat["seat_id"]); ?>]" value="<?php echo ($seat["seat_id"]); ?>"/>
							<p><?php echo ($seat["seat_name"]); ?>：</p>
							<input type="hidden" name="money[<?php echo ($seat["seat_id"]); ?>]" value="<?php echo ($seat["seat_money"]); ?>"/>
							<input  type="text" class="orange"  id="xiwei_<?php echo ($seat["seat_id"]); ?>" name="num[<?php echo ($seat["seat_id"]); ?>]" value="" placeholder="请选择席位<?php echo ($seat["seat_money"]); ?>元/人" style="width:17rem;" />
							<img class="bottom" src="/Public/home/images/bottom.png" />
						</li><?php endforeach; endif; else: echo "" ;endif; ?>
					<li>
						<!--注：默认选择是-->
						<p>是否本人参加：<span id="zhi" class="orange">是</span></p>
						<input id="isself" class="chbox" name="info[isself]" type="checkbox" checked="checked" value="1"/>
					</li>
					<li>
						<p>留言备注：</p>
						<input class="beizhu" type="text" name="info[remarks]" placeholder="" />
					</li>
				</ul>
				<p style="padding: 0 2rem; color: #C7C7C7;">关于报名参加线下大课，如有疑问，也可致电</p>
			</form>
		</div>
		<style type="text/css">
			.banner_img{width: 100%;margin-bottom: 10px;}
			.banner_img img {display: block;width: 100%;}
		</style>
		<div class="banner_img">
			<a href="<?php echo U('personal/shengjihuiyuan');?>"><img src="/Public/home/images/youhui.png"/></a>
		</div>
		<input type="submit" class="btn2" value="立即购买" form="user_form"/>
		<!--<div class="div_hide">-->
			<!--<p>恭喜你，报名成功-->
				<!--<br />我们的工作人员会在1-3个工作日内联系你进行确认。</p>-->
		<!--</div>-->
	</body>
</html>
<script type="text/javascript" src="/Public/home/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="/Public/home/js/screenSize.js"></script>
<script>
	//是否本人参加复选框
	$(".chbox").click(function(){
		var hasChk = $('#isself').is(':checked');
		if(hasChk){
			$("#zhi").html("是");
			$('#isself').val('1');
		}else{
			$("#zhi").html("否");
			$('#isself').val('2');
		}
	});
	//点击立即购买，弹出框显示
//		$(".btn2").click(function(){
//			$(".div_hide").fadeIn(200).delay(400).fadeOut(200);
//		});
	//普通贵宾席人数选择弹出层
	$(".nn").click(function(){
		var code=$("#code").val();
		var num = $(this).next().text();
		$("#xiwei_"+code).val(num);
		$(".humanbg").hide()
	});
	function checkcode(k){
		$(".humanbg").show();
		$("#code").val(k);
	}
</script>
<script>
    var Num="";
    var countdown = 60;
    for(var i=0;i<6;i++){
        Num+=Math.floor(Math.random()*10);
    }
    var code=Num;
    var web_url="<?php echo (C("WEB_URL")); ?>index.php";
    //获取短信验证码
    function seed() {
        var phone = document.getElementById('phone').value;
        var phone1 = /^1\d{10}$/;
        if(phone.length<=0){
            alert("请输入手机号码");
            return false;
        }
        if (!phone1.test(phone)) {
            alert("手机号码格式不正确！");
            return false;
        }
		//将按钮置为不可点击
        $('#yzmbut').attr('disabled',"true");
        fasongtimer = setInterval("settime()", 1000);
        var str=$.ajax({ async:false,cache:false,url:"<?php echo U('bookinfo/smsCode');?>&tel="+phone+"&msg="+code+" ",data: "" }).responseText;
    }
    //时间倒计时60
    function settime(){
        if(countdown<=0){
            document.getElementById('yzmbut').style.color = '#ffffff';
            $('#yzmbut').removeAttr("disabled");
            $('#yzmbut').html('获取验证码');
            clearInterval(fasongtimer);
            countdown = 60; //重置时间
            return false;
        }
        countdown=countdown-1;
        document.getElementById('yzmbut').style.color = '#ffffff';
        document.getElementById('yzmbut').innerHTML="等待"+countdown+"秒";
    }
    function tianjia(){
        //姓名
        var fullname=$("#fullname").val();
        if(fullname.length==0){
            alert("请输入姓名！");
            $('#fullname').focus();
            return false;
        }
        //身份证
        var idcard=$('#idcard').val();
        if(idcard.length==0){
            alert("请输入身份证号码！");
            $('#idcard').focus();
            return false;
        }
        var card=/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
        if(!card.test(idcard)){
            alert('请输入正确的身份证号码！');
            $('#idcard').focus();
            return false;
        }
        //公司
        var company=$("#company").val();
        if(company.length==0){
            alert("请填写您公司的名称！");
            $('#company').focus();
            return false;
        }
        //职务
        var job=$("#job").val();
        if(job.length==0){
            alert("请填写您的职务！");
            $('#job').focus();
            return false;
        }
        var phone=$("#phone").val();
        var preg3=/^1[3|4|5|7|8]\d{9}$/;
        if(phone.length==0){
            alert("请填写电话号码！");
            $('#phone').focus();
            return false;
        }
        if(!preg3.test(phone)){
            alert("请填写正确的电话号码！");
            $('#phone').focus();
            return false;
        }
        var verfCode=$("#verfCode").val();
        if(verfCode.length==0){
            alert("请填写验证码！");
            $('#verfCode').focus();
            return false;
        }
        if(verfCode!=code){
            alert("输入验证码有误，请重新获取！");
            return false;
        }
    }
</script>
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