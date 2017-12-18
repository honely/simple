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
<body >
<div class="right_min">
    <div class="crumbs_nav">
        <i class="iconfont icon-shouye"></i>
        <ul>
            <li><a href="javascript:void(0);">查看详情(<?php echo ($user["nickname"]); ?>)</a></li>
        </ul>
    </div>
    <div class="min">
        <div class=form-item"">
                <table class="table" border="" cellspacing="" cellpadding="">
                    <tr>
                        <th style="width: 20%">头像</th>
                        <td><img style="width:50px;height:50px;"src="<?php echo ($user["avatar"]); ?>"></td>
                    </tr>
                    <tr>
                        <th>昵称</th>
                        <td><?php echo ($user["nickname"]); ?></td>
                    </tr>
                    <tr>
                        <th>微信openid</th>
                        <td><?php echo ($user["openid"]); ?> </td>
                    </tr>
                    <tr>
                        <th>vip级别</th>
                         <td><?php echo ($viplevel[$user['vip']]); ?> </td>
                    </tr>
                    <?php if($user['vip'] != 0): ?><tr>
                        <th>vip到期时间</th>
                        <td> <?php echo (date('Y-m-d ',$user["vipendtime"])); ?> </td>
                    </tr><?php endif; ?>
                    <tr>
                        <th>用户等级</th>
                        <td><?php echo ($userlevel[$user['level']]); ?></td>
                    </tr>
					<tr>
                        <th>手机号码</th>
                        <td><?php echo ($user["phone"]); ?></td>
                    </tr>
                    <tr>
                        <th>学习时长</th>
                        <td><?php echo ($user["learntime"]); ?></td>
                    </tr>
					 <tr>
                        <th>学分</th>
                        <td><?php echo ($user["score"]); ?></td>
                    </tr>
                    <tr>
                        <th>奖学金</th>
                        <td><?php echo ($user["money"]); ?></td>
                    </tr>
                    <tr>
                        <th>省份</th>
                        <td><?php echo ($user["province"]); ?></td>
                    </tr>
                    <tr>
                        <th>城市</th>
                        <td><?php echo ($user["city"]); ?></td>
                    </tr>
                    <tr>
                        <th>公司</th>
                        <td><?php echo ($user["firm"]); ?></td>
                    </tr>

                    <tr>
                        <th>职位</th>
                        <td><?php echo ($user["job"]); ?></td>
                    </tr>
                    <tr>
                        <th>推荐人</th>
                        <td><?php echo ($user["refreename"]); ?></td>
                    </tr>
                    <tr>
                        <th>加入时间</th>
                        <td><?php echo (date('Y-m-d H:i:s',$user["addtime"])); ?></td>
                    </tr>

                </table>
        </div>

    </div>
</div>
</body>
</html>
<script type="text/javascript">
    $(function(){

        $('.form-checkbox input,.form-radio input').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
        $('input').on('ifChecked', function(event){
            //alert($(this).val());
        });
        $(".checkbox-title dd i").click(function(){
            $(this).toggleClass("fa-flip-vertical");
            $(this).parents().siblings(".skin-section").slideToggle(500);
        });



    });
</script>