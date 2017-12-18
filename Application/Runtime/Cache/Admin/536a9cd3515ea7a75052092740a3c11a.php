<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>专题回复审核</title>
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
                    <li><a href="javascript:void(0);">首页</a></li>
                    <li> > </li>
                    <li><a href="javascript:void(0);">课程管理</a></li>
                    <li> > </li>
                    <li><a href="javascript:void(0);">专题回复审核</a></li>
                </ul>
            </div>
            <div class="min">
                <!--查询-->
                <div class="query">
                    <form name="seachform" id="seachform" action="<?php echo U('comment2/index');?>"  method="post" class="form">
                        <div class="form_input mg_trb">
                            <label class="text">回复人</label>
                            <input type="text" name="info[keyword]" id="keyword" value="<?php echo ($keyword); ?>" placeholder="请输入评论人" maxlength="30"/>
                        </div>
                        <div class="form_input mg_trb form-date">
                                <label class="text">回复时间</label>
                                <input type="text" class="laydate-icon layer-date" name="info[starttime]"  value="<?php echo ($starttime); ?>"  id="start" placeholder="开始时间" readonly/>
                                <input type="text" class="laydate-icon layer-date" name="info[endtime]"  value="<?php echo ($endtime); ?>"  id="end" placeholder="结束时间" readonly/>
			            </div>
                        <div class="button mg_trb">
                            <i class="fa fa-refresh ico"></i>
                            <input type="button" value="重置" class="but chongzhi" onclick="location.href = '<?php echo U('comment2/index');?>'"/>
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
							<col width="150">
							<col width="100">
							<col width="200">
							<col width="100">
							<col width="200">
							<col width="100">
							<col width="100">
						</colgroup>
                        <thead>
                            <tr>
                               <!-- <th>编号</th>
                                <th>课程评论编号</th>-->
								<th>专题名称</th>
                                <th>回复人</th>
                                <th>回复内容</th>  
                                <th>点赞数量</th>
								<th>回复时间</th>
								<th>审核状态</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($comment)): $i = 0; $__LIST__ = $comment;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$content): $mod = ($i % 2 );++$i;?><tr>
                                <!-- <td><?php echo ($content["comment2_id"]); ?></td>
                                <td><?php echo ($content["comment_id"]); ?></td>-->
								
                                <td>
								<?php  if(mb_strlen($content['course_name'],"UTF8")>10){ echo mb_substr($content['course_name'],0,10,'utf-8')."..."; }else{ echo $content['course_name']; } ?>
								</td>
                                <td><?php echo ($content["nickname"]); ?></td>						
								<td><?php echo ($content["comment2"]); ?></td>						
                                <td><?php echo ($content["comment2_good"]); ?></td> 
								<td><?php echo (date("Y-m-d H:i:s",$content["addtime2"])); ?></td>
								<td>
								<?php if($content['comment2_flag'] == 1): ?>未审核<?php endif; ?>
								</td>
								<td> 
								<a href="<?php echo U('comment2/shenhe',array('comment2_id'=>$content['comment2_id']));?>" onclick="{if(confirm('确认审核?')){return true;}return false;}" class="but chaxun">
								<i class="fa fa-edit"></i>
								审核</a>
								<a href="<?php echo U('comment2/delcomment2',array('comment2_id'=>$content['comment2_id'],'comment_id'=>$content['comment_id']));?>" onclick="{if(confirm('确认删除?')){return true;}return false;}" class="but chongzhi">
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