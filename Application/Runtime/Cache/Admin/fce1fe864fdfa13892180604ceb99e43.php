<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>幻灯宣传</title>
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
            <li><a href="javascript:void(0);">幻灯宣传</a></li>
        </ul>
    </div>
    <div class="min">
        <!--查询-->

        <div class="query">
            <form  name="seachform" id="seachform"  action="<?php echo U('focus/index');?>"  method="post" class="form"  onsubmit="return checkkwd()">
                <div class="form_input mg_trb">
                    <label class="text">快速检索</label>
                    <input type="text" name="info[focus_title]" id="focus_title" value="<?php echo ($focus_title); ?>"  placeholder="请输入标题"  maxlength="15"/>
                </div>
                <div class="select mg_trb">
                    <span class="text">幻灯类型</span>
                    <select name="info[focus_type]">
                        <option value="">--请选择状态--</option>
                        <?php if(is_array($focusType)): $i = 0; $__LIST__ = $focusType;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($key == $focus_type ): ?>selected<?php endif; ?>><?php echo ($data); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
                <div class="button mg_trb">
                    <i class="fa fa-refresh ico"></i>
                    <input type="button" value="重置" class="but chongzhi" onclick="location.href='<?php echo U('focus/index');?>'"/>
                </div>

                <div class="button mg_trb">
                    <i class="fa fa-search ico"></i>
                    <input type="submit" value="查询" class="but chaxun"/>
                </div>
            </form>
        </div>
        <!--添加幻灯-->
        <div class="tianjia">
            <a class="tianjia_but" href="<?php echo U('focus/add');?>">
                <i class="fa fa-plus"></i>
                添加幻灯
            </a>
        </div>
        <div class="table_box">
            <table class="table" border="" cellspacing="" cellpadding="">
                <!--<colgroup>-->
                    <!--<col width="5">-->
                    <!--<col width="100">-->
                    <!--<col width="100">-->
                    <!--<col width="100">-->
                    <!--<col width="100">-->
                    <!--<col width="100">-->
                    <!--<col>-->
                <!--</colgroup>-->
                <thead>
                <tr>
                    <th>编号</th>
                    <th>标题</th>
                    <th>图片</th>
                    <th>幻灯类型</th>
                    <th>排序</th>
                    <th>添加时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php if(is_array($focusInfo)): $i = 0; $__LIST__ = $focusInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$focus): $mod = ($i % 2 );++$i;?><tr>
                        <td><?php echo ($focus["focus_id"]); ?></td>
                        <td><?php echo ($focus["focus_title"]); ?></td>
                        <td style="width:  200px;"><a href="<?php echo ($focus["focus_url"]); ?>"><img style="height: 80px;width:180px;"  src="<?php echo ($focus["focus_image"]); ?>"/></a></td>
                        <td><?php echo ($focusType[$focus['focus_type']]); ?></td>
                        <td><?php echo ($focus["focus_sort"]); ?></td>
                        <td><?php echo date('Y-m-d H:i:s',$focus['focus_addtime']);?></td>
                        <!--<td><?php echo ($focus["focus_addtime"]); ?></td>-->
                        <td>
                            <a href="<?php echo U('focus/edit',array('focus_id'=>$focus['focus_id']));?>" class="but chaxun">
                                <i class="fa fa-edit"></i>
                                编辑</a>
                                <a href="<?php echo U('focus/delfocus',array('focus_id'=>$focus['focus_id']));?>" onclick="{if(confirm('确认删除?')){return true;}return false;}" class="but chongzhi">
                                    <i class="fa fa-trash-o"></i>
                                    删除</a>
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
<script type="text/javascript">
    $(function(){
        $(".right_min").height($(window).height());
    });
    //搜索
    function checkkwd(){
        var keyword=$('#keyword').val();
        /*
        if(keyword==""){
            alert("请输入要检索的关键词!");
            return false;
        }
        */
    }
</script>