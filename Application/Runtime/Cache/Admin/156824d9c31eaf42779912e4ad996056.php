<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>问答管理</title>
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
                    <li><a href="<?php echo U('forum/index');?>">问答列表</a></li>
                </ul>
            </div>
            <div class="min">
                <!--查询-->
                <div class="query">
                    <form name="seachform" id="seachform" action="<?php echo U('forum/index');?>"  method="post" class="form">
                        <div class="form_input mg_trb">
                            <label class="text">快速检索</label>
                            <input type="text" style="width:170px;" name="info[keyword]" id="keyword" value="<?php echo ($keyword); ?>" placeholder="请输入用户名或问答标题" maxlength="30"/>
                        </div>
                        <div class="select mg_trb">
                            <span class="text">置顶状态</span>
                            <select  id="forum_top" name="info[forum_top]">
                                <option value="">请选择置顶状态</option>
                                <?php if(is_array($forum_top)): $i = 0; $__LIST__ = $forum_top;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($key == $forum_top1 ): ?>selected<?php endif; ?>><?php echo ($data); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                        <div class="select mg_trb">
                            <span class="text">审核状态</span>
                            <select  id="forum_flag" name="info[forum_flag]">
                                <option value="">请选择审核状态</option>
                                <?php if(is_array($forum_flag)): $i = 0; $__LIST__ = $forum_flag;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($key == $forum_flag1 ): ?>selected<?php endif; ?>><?php echo ($data); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                        <div class="form_input mg_trb form-date">
                            <label class="text">问答时间</label>
                            <input type="text" class="laydate-icon layer-date" name="info[starttime]"  value="<?php echo ($starttime); ?>"  id="start" placeholder="开始时间" readonly/>
                            <input type="text" class="laydate-icon layer-date" name="info[endtime]"  value="<?php echo ($endtime); ?>"  id="end" placeholder="结束时间" readonly/>
                        </div>
                        <div class="button mg_trb">
                            <i class="fa fa-refresh ico"></i>
                            <input type="button" value="重置" class="but chongzhi" onclick="location.href = '<?php echo U('forum/index');?>'"/>
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
                            <col width="80">
                            <col width="300">
                            <col width="100">
                            <col width="80">
                            <col width="80">
                            <col width="80">
                            <col width="180">
                            <col>
                        </colgroup>
                        <thead>
                            <tr>
                                <th>编号</th>
				<th>问答标题 </th>  
                                <th>发帖人</th>
                                <th>浏览数</th>
                                <th>点赞数</th>
                                <th>状态</th>
				<th>问答时间</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($foruminfo)): $i = 0; $__LIST__ = $foruminfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$content): $mod = ($i % 2 );++$i;?><tr>
                                <td><?php echo ($content["forum_id"]); ?></td>
				<td><?php echo ($content["forum_title"]); if($content['forum_top']==2):?> <font style="color:red">【顶】</font>
                                <?php endif;?></td>	
                                <td><?php echo ($content["nickname"]); ?> </td>
                                <td><?php echo ($content["forum_view"]); ?></td>
                                <td><?php echo ($content["forum_good"]); ?></td>
                                <?php if($content['forum_flag']==1):?>
                                <td>未审核</td>
                                <?php endif;?>
                                <?php if($content['forum_flag']==2):?>
                                <td style="color:red">已审核</td>
                                <?php endif;?>
				<td><?php echo (date("Y-m-d H:i:s",$content["forum_addtime"])); ?></td>
                                <td>
                                    <a  href="<?php echo U('forum/forumlist',array('forum_id'=>$content['forum_id']));?>"  class="but chaxun">
                                        <i class="fa fa-eye"></i>
                                        查看内容
                                    </a>
                                    <?php if($content['forum_flag']==1):?>
                                    <a href="<?php echo U('forum/edituserforum',array('forum_id'=>$content['forum_id']));?>" onclick="{
                                                if (confirm('确认审核?')) {
                                                    return true;
                                                }
                                                return false;
                                            }" class="but chaxun"><i class="fa fa-edit"></i>审核</a>
                                    <?php endif;?> 
                                    
                                    <?php if($content['forum_top']==1):?>
                                    <a href="<?php echo U('forum/edituserforum2',array('forum_id'=>$content['forum_id']));?>" onclick="{
                                                if (confirm('确认置顶?')) {
                                                    return true;
                                                }
                                                return false;
                                            }" class="but chaxun"><i class="fa  fa-caret-square-o-up"></i>  置顶</a>
                                    <?php endif;?>
                                    
                                    <?php if($content['forum_top']==2):?>
                                    <a href="<?php echo U('forum/edituserforum3',array('forum_id'=>$content['forum_id']));?>" onclick="{
                                                if (confirm('确认取消置顶?')) {
                                                    return true;
                                                }
                                                return false;
                                            }" class="but chaxun"><i class="fa  fa-caret-square-o-up"></i>取消置顶</a>
                                    <?php endif;?> 
                                    
                                    <a href="<?php echo U('forum/delforum',array('forum_id'=>$content['forum_id']));?>" onclick="{
                                                if (confirm('确认删除?')) {
                                                    return true;
                                                }
                                                return false;
                                            }"   class="but chongzhi">
                                        <i class="fa fa-trash-o"></i>
                                        删除
                                    </a>
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
    $(function () {
        $(".right_min").height($(window).height());
    });
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