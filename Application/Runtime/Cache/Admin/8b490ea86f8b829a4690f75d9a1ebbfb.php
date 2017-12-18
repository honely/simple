<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>席位添加</title>
    <link rel="stylesheet" type="text/css" href="/Public/admin/css/html5.css"/>
    <link rel="stylesheet" type="text/css"  href="/Public/admin/font/iconfont.css">
    <link rel="stylesheet" type="text/css"  href="/Public/admin/font/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="/Public/admin/css/index.css"/>
    <script src="/Public/admin/js/jquery-1.10.2.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/Public/admin/js/icheck/icheck.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="/Public/admin/js/icheck/square/green.css">
    <link href="/Public/validform/Validform.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/Public/validform/Validform_v5.3.2.js"></script>
</head>
<body>
<div class="right_min">
    <div class="crumbs_nav">
        <i class="iconfont icon-shouye"></i>
        <ul>
            <li><a href="<?php echo U('index/welcome');?>">首页</a></li>
            <li> > </li>
            <li><a href="javascript:void(0);">其他设置</a></li>
            <li> > </li>
            <li><a href="<?php echo U('workinfo/workoper');?>">研习班管理</a></li>
            <li> > </li>
            <li><a href="javascript:void(0);"><?php echo ($work_title); ?>席位管理</a></li>
            <li> > </li>
            <li><a href="javascript:void(0);">席位添加</a></li>
        </ul>
    </div>
    <div class="min">
        <div class="form_box">
            <form name="myform" id="myform" action="<?php echo U('workinfo/addseat');?>" method="post">
                <div class="form-item">
                    <label class="form-label">研习班名称</label>
                    <div class="form-text form-input-block">
                        <input id="work_title" value="<?php echo ($work_title); ?>" readonly/>
                    </div>
                </div>
                <div class="form-item">
                    <input type="hidden" name="info[work_id]" value="<?php echo ($workId); ?>"/>
                    <label class="form-label">坐席名称</label>
                    <div class="form-text form-input-block">
                        <input name="info[seat_name]" id="seat_name"  datatype="*2-30" errormsg="研发班名称为2-30位！" maxlength="30" />
                        <i class="Validform_checktip"></i>
                    </div>
                </div>
                <div class="form-item">
                    <label class="form-label">坐席价格（元）</label>
                    <div class="form-text form-input-block">
                        <input name="info[seat_money]" id="seat_money"  datatype="/^\d+(\.\d{0,2})?$/"  errormsg="坐席价格应该是数字" maxlength="10" />
                        <i class="Validform_checktip"></i>
                    </div>
                </div>
                <div class="form-item">
                    <div class="form-button form-input-block">
                        <input class="chaxun but" type="submit" value="提交"/>
                        <button class="but chongzhi" type="button" onclick="location.href='<?php echo U('Workinfo/seat',array('work_id'=>$workId));?>'">返回</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
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
<script>
    $(function(){
        $("#myform").Validform({
            //tiptype:2
            tiptype:function(msg,o,cssctl){
                var objtip=o.obj.siblings(".Validform_checktip");
                cssctl(objtip,o.type);
                objtip.text(msg);
            }
        });
    });
</script>