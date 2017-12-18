<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="/Public/admin/css/html5.css"/>
    <link rel="stylesheet" type="text/css"  href="/Public/admin/font/iconfont.css">
    <link rel="stylesheet" type="text/css"  href="/Public/admin/font/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="/Public/admin/css/index.css"/>
    <script src="/Public/admin/js/jquery-1.10.2.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/admin/js/icheck/icheck.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="/Public/admin/js/icheck/square/green.css">
</head>
<body>
<div class="right_min">
    <div class="crumbs_nav">
        <i class="iconfont icon-shouye"></i>
        <ul>
            <li><a href="javascript:void(0);">充值(<?php echo ($user["nickname"]); ?>)</a></li>
        </ul>
    </div>
    <div class="min">
        <div class="form_box">
            <form name="myform" id="myform" action="<?php echo U('user/chongzhi',array('user_id'=>$user['user_id']));?>" method="post" onsubmit=" return check()">
                <div class="form-item">
                    <label class="form-label">支付金额：</label>
                    <div class="form-text form-input-block">
                        <input name="info[pay_money]" id="pay_money"    maxlength="10" onkeyup="value=value.replace(/[^\d.]/g,'')" />
                        <i class="aa1" style="display:none;color:red;">支付金额金额不能为空或为0</i>
                    </div>
                </div>
                <div class="form-item">
                    <label class="form-label">备注：</label>
                    <div class="form-text form-input-block">
                        <input name="info[pay_remarks]" id="pay_remarks"   maxlength="20"   />
                        <!--<i class="aa2" style="display:none;color:red;">备注不能为空</i>-->
                    </div>
                </div>

                <div class="form-item">
                    <div class="form-button form-input-block">
                        <input class="chaxun but" type="submit" value="提交"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
<script>
    function check(){
        //支付金额
        var pay_money = document.getElementById("pay_money").value;
        if(pay_money==''||pay_money==0){
            $(".aa1").show();
            $('#pay_money').focus();
            return false;
        }
        $(".aa1").hide();
        //备注
        /*var pay_remarks = document.getElementById("pay_remarks").value;
        if(pay_remarks==''){
            $(".aa2").show();
            $('#pay_remarks').focus();
            return false;
        }
        $(".aa2").hide();*/
    }
</script>
<script src="/Public/admin/js/laydate/laydate.js"></script>
<script>
    //laydate({elem: "#hello", event: "focus"});
    var start = {
        elem: "#start",
        format: "YYYY/MM/DD",
        min: laydate.now(),
        max: "2099-06-16",
        istime: false,
        istoday: false,
        choose: function (datas) {
            end.min = datas;
            end.start = datas
        }
    };
    var end = {
        elem: "#end",
        format: "YYYY/MM/DD",
        min: laydate.now(),
        max: "2099-06-16",
        istime: false,
        istoday: false,
        choose: function (datas) {
            start.max = datas
        }
    };
    laydate(start);
    laydate(end);
</script>
<script type="text/javascript">
    $(function(){
        $(".right_min").height($(window).height());

        $('.skin-section input').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
        $('input').on('ifChecked', function(event){
            //alert($(this).val());
        });
    });
</script>
<?php if($status == 2): ?><script type="text/javascript" src="/Public/admin/js/layer/layer.js"></script>
    <script>
        var index = parent.layer.getFrameIndex(window.name); //
        parent.layer.close(index);  // 关闭layer
        parent.location.reload();
    </script><?php endif; ?>