<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>研习班席位管理</title>
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
            <li><a href="javascript:void(0);">其他设置</a></li>
            <li> > </li>
            <li><a href="<?php echo U('workinfo/workoper');?>">研习班管理</a></li>
            <li> > </li>
            <li><a href="javascript:void(0);"><?php echo ($work_title); ?>席位管理</a></li>
        </ul>
    </div>
    <div class="min">
        <div class="tianjia">
            <a class="tianjia_but" href="<?php echo U('Workinfo/addseat',array('work_id'=>$workId));?>">
                <i class="fa fa-plus"></i>
                添加席位
            </a>
        </div>
        <div class="table_box">
            <input type="hidden" value="<?php echo ($workId); ?>"/>
            <table class="table" border="" cellspacing="" cellpadding="">
                <thead>
                <tr>
                    <th>席位编号</th>
                    <th>班级名称</th>
                    <th>席位名称</th>
                    <th>席位价格（元）</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php if(is_array($seatInfo)): $i = 0; $__LIST__ = $seatInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$seat): $mod = ($i % 2 );++$i;?><tr>
                        <td><?php echo ($seat["seat_id"]); ?></td>
                        <td><?php echo ($seat["work_title"]); ?></td>
                        <td><?php echo ($seat["seat_name"]); ?></td>
                        <td><?php echo ($seat["seat_money"]); ?></td>
                        <td >
                            <a title="编辑" href="<?php echo U('Workinfo/editseat',array('seat_id'=>$seat['seat_id']));?>" class="but chaxun" ><i class="fa fa-edit"></i>编辑</a>
                            <a title="删除" href="<?php echo U('Workinfo/delseatinfo',array('seat_id'=>$seat['seat_id'],'work_title'=>$seat['work_title']));?>" onclick="{if(confirm('确定要删除吗?')){return true;}return false;}" class="but chongzhi" > <i class="fa fa-trash-o"></i>删除</a>

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
<script src="/Public/admin/js/laydate/laydate.js"></script>
<script type="text/javascript">
    $(function(){
        $(".right_min").height($(window).height());
    });
    }
</script>
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