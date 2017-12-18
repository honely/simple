<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>学员管理</title>
    <link rel="stylesheet" type="text/css" href="/Public/admin/css/html5.css"/>
    <link rel="stylesheet" type="text/css"  href="/Public/admin/font/iconfont.css">
    <link rel="stylesheet" type="text/css"  href="/Public/admin/font/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="/Public/admin/css/index.css"/>
    <script src="/Public/admin/js/jquery-1.10.2.min.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
<div class="right_min">
    <div class="crumbs_nav">
        <i class="iconfont icon-shouye"></i>
        <ul>
            <li><a href="<?php echo U('index/welcome');?>">首页</a></li>
            <li> > </li>
            <li><a href="javascript:void(0);">学员管理</a></li>
            <li> > </li>
            <li><a href="javascript:void(0);">学员列表</a></li>
        </ul>
    </div>
    <div class="min">
        <!--查询-->

        <div class="query">
            <form  name="seachform" id="seachform"  action="<?php echo U('user/index');?>"  method="post" class="form"  onsubmit="return checkkwd()">
                <div class="form_input mg_trb">
                    <label class="text">快速检索</label>
                    <input type="text" name="info[keyword]" id="keyword" value="<?php echo ($keyword); ?>"  placeholder="请输入用户昵称或手机号"  maxlength="11"/>
                </div>
                <div class="select mg_trb">
                    <span class="text">vip等级</span>
                    <select name="info[vip_level]">
                        <option value="">--请选择vip等级--</option>
                        <?php if(is_array($viplevel)): $i = 0; $__LIST__ = $viplevel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>a" <?php if($key.'a' == $vip_level.'a' ): ?>selected<?php endif; ?>><?php echo ($data); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
                <div class="select mg_trb">
                    <span class="text">用户等级</span>
                    <select name="info[user_level]">
                        <option value="">--请选择用户等级--</option>
                        <?php if(is_array($userlevel)): $i = 0; $__LIST__ = $userlevel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($key == $user_level ): ?>selected<?php endif; ?>><?php echo ($data); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
                <div class="form_input mg_trb form-date">
                    <label class="text">添加时间</label>
                    <input type="text" class="laydate-icon layer-date" name="info[starttime]"  value="<?php echo ($starttime); ?>"  id="start" placeholder="开始时间" readonly/>
                    <input type="text" class="laydate-icon layer-date" name="info[endtime]"  value="<?php echo ($endtime); ?>"  id="end" placeholder="结束时间" readonly/>
                </div>
                <div class="button mg_trb">
                    <i class="fa fa-refresh ico"></i>
                    <input type="button" value="重置" class="but chongzhi" onclick="location.href='<?php echo U('user/index');?>'"/>

                </div>

                <div class="button mg_trb">
                    <i class="fa fa-search ico"></i>
                    <input type="submit" value="查询" class="but chaxun"/>
                </div>
            </form>
        </div>

        <div class="table_box">
            <table class="table" border="" cellspacing="" cellpadding="">
                <colgroup>
                    <col width="10">
                    <col width="100">
                    <col width="100">
                    <col width="100">
                    <col width="100">
                    <col width="120">
                    <col width="150">
                    <col width="100">
                    <col width="100">
                    <col width="150">
                    <col width="200">
                    <col>
                </colgroup>
                <thead>
                <tr>
                    <th>编号</th>
                    <th>头像</th>
                    <th>昵称</th>
                    <th>vip级别</th>
                    <th>用户等级</th>
                    <th>手机号码</th>
					<th>学习总时长</th>
					<th>学分</th>
                    <th>奖学金</th>
                    <th>加入时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php if(is_array($listinfo)): $i = 0; $__LIST__ = $listinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$user): $mod = ($i % 2 );++$i;?><tr>
                        <td><?php echo ($user["user_id"]); ?></td>
                        <td>
                           <img src="<?php echo ($user["avatar"]); ?>" style="width:50px;height:50px;"/>
                        </td>
                        <td><?php echo ($user["nickname"]); ?></td>
                        <td><?php echo ($viplevel[$user['vip']]); ?></td>
                        <td><?php echo ($userlevel[$user['level']]); ?></td>
                        <td><?php echo ($user["phone"]); ?></td>
						<td><?php echo ($user["learntime"]); ?></td>
						<td><?php echo ($user["score"]); ?></td>
                        <td><?php echo ($user["money"]); ?></td>
                        <td><?php echo (date('Y-m-d H:i:s',$user["addtime"])); ?></td>
                        <td>
                            <p onclick="xiangqing(<?php echo ($user['user_id']); ?>)" class="but chaxun">
                             <i class="fa fa-eye"></i>
                                查看详情</p>
                            <p onclick="chongzhi(<?php echo ($user['user_id']); ?>)" class="but chaxun">
                                <i class="fa fa-jpy"></i>
                                充奖学金
                            </p>
                        </td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
        </div>
        <?php echo ($pageshow); ?>
    </div>
</div>
</body>
</html>
<!--弹层显示-->
<script src="/Public/admin/js/layer/layer.js"></script>

<script type="text/javascript">
    $(".right_min").height($(window).height());
    var body_w=$(".right_min").width()-200;
    var body_h=$(".right_min").height()-100;
    function xiangqing(user_id) {
        //alert(user_id);
        layer.open({
            type: 2,
            title: false,
            skin: "layui-layer-molv",
            shade: [0.8, '#000000'],
            scrollbar: false,
            maxmin: false,
            shadeClose: false, //点击遮罩关闭层
            area: [body_w + "px", body_h + "px"],
            content: "<?php echo U('user/xiangqing');?>&user_id=" + user_id
        });
    }
    function chongzhi(user_id) {
        layer.open({
            type: 2,
            title: false,
            skin: "layui-layer-molv",
            shade: [0.8, '#000000'],
            scrollbar: false,
            maxmin: false,
            shadeClose: false, //点击遮罩关闭层
            area: [body_w + "px", body_h + "px"],
            content: "<?php echo U('user/chongzhi');?>&user_id=" + user_id
        });
    }
</script>
<script src="/Public/admin/js/laydate/laydate.js"></script>
<script>
    //laydate({elem: "#hello", event: "focus"});
    var start = {
        elem: "#start",
        format: "YYYY-MM-DD",
        min: "2000-01-01",
        max: "2100-01-01",
        istime: false,
        istoday: false,
        choose: function (datas) {
            end.min = datas;
            end.start = datas
        }
    };
    var end = {
        elem: "#end",
        format: "YYYY-MM-DD",
        min: "2000-01-01",
        max: "2100-01-01",
        istime: false,
        istoday: false,
        choose: function (datas) {
            start.max = datas
        }
    };
    laydate(start);
    laydate(end);
</script>