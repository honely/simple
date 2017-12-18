<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Cache-Control" content="no-transform" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>立即购买</title>
    <link rel="stylesheet" type="text/css" href="/Public/home/css/html5.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/home/css/mian.css"/>
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
<style type="text/css">
    body{background: #fff;}
</style>
<div class="zf_head">
    <h4>简异思维</h4>
    <h5>¥<?php echo ($payMoney); ?></h5>
    <p class="c">
        <i>购买内容：</i>
        <span><?php echo ($workContent['work_title']); ?></span>
    </p>
</div>
<div class="zf_ct">
    <div class="form_radio">
        <i></i>
        <p>奖学金支付</p>
        <?php if($userMoney['money'] < $payMoney): ?><em>（余额不足：¥<?php echo ($userMoney['money']); ?>）</em>
            <?php else: ?>
            <em>（现有金额：¥<?php echo ($userMoney['money']); ?>）</em>
            <strong><input type="radio" name="pay" value='2' /></strong><?php endif; ?>
    </div>
    <div class="form_radio">
        <i></i>
        <p>微信支付</p>
        <strong><input type="radio" name="pay" value='1' /></strong>
    </div>
    <div class="form_but">
        <input type="hidden" value="<?php echo ($signId); ?>"/>
        <input class="but" type="button" value="确定支付" onclick="zhiFu(<?php echo ($signId); ?>);"/>
    </div>
</div>
</body>
<script>
    function zhiFu(sign_id){
        //支付方式，1微信，2余额',
        //获取单选框的值
        var pay_type=$(':radio:checked').val();
        if(pay_type=='1'){
            //微信支付
            location.href="<?php echo U('bookinfo/weiChatPay');?>&sign_id="+sign_id;
        }else if(pay_type=='2'){
            //奖学金支付,验证余额是否充足
            var jiangxuejin =parseInt("<?php echo ($userMoney['money']); ?>");
            //购买席位所需金额
            var payMoney =parseInt("<?php echo ($payMoney); ?>");
            if((jiangxuejin < payMoney) || (jiangxuejin <= 0)) {
                alert("余额不足，请使用其他支付方式");
                return false;
            } else {
                $.ajax({
                    type: "post",
                    url: "<?php echo U('bookinfo/userMoneyPay');?>",
                    data: {
                        sign_id:sign_id,
                    },
                    success:function(data) {
                        if(data.flag==1){
                            alert("课程预约成功");
                            window.location.href="<?php echo U('bookinfo/wodeyuyue');?>";
                        }else{
                            alert("课程预约失败");
                            window.location.href="<?php echo U('bookinfo/lijigoumai');?>";
                        }
                    },
                    error:function(data) {
                        console.log(data)
                        alert("网络请求失败");
                        window.location.href="<?php echo U('bookinfo/lijigoumai');?>";
                    }
                })
            }
        }else{
            alert('请选择支付方式');
            return false;
        }
    }
</script>
</html>