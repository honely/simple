<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>专题课程管理</title>
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
                    <li><a href="javascript:void(0);">课程管理</a></li>
                    <li> > </li>
                    <li><a href="javascript:void(0);">xxx专题课程管理</a></li>
                </ul>
            </div>
            <div class="min">
                <!--查询-->
                <div class="query">
                    <form name="seachform" id="seachform" action="<?php echo U('course/datell_course',array('course_id'=>$course_id));?>"  method="post" class="form">
                        <div class="form_input mg_trb">
                            <label class="text">课程检索</label>
                            <input type="text" name="info[course_name]" id="keyword" value="<?php echo ($course_name); ?>" placeholder="请输入课程名" maxlength="50"/>
                        </div>
                        <div class="select mg_trb">
                            <span class="text">分类检索</span>
                            <select name="info[classify_id]">
                                <option value="">--请选择分类--</option>
                                <?php if(is_array($classifies)): $i = 0; $__LIST__ = $classifies;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$classify): $mod = ($i % 2 );++$i;?><option value="<?php echo ($classify["classify_id"]); ?>" <?php if($classify['classify_id'] == $classify_id ): ?>selected<?php endif; ?>><?php echo ($classify['classify_name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
              
                      
                        <div class="button mg_trb">
                            <i class="fa fa-refresh  ico"></i>
                            <input type="button" value="重置" class="but chongzhi" onclick="location.href = '<?php echo U('course/index');?>'"/>
                        </div>
                        <div class="button mg_trb">
                            <i class="fa fa-search ico"></i>
                            <input type="submit" value="查询" class="but chaxun"/>
                        </div>
                    </form>
                </div>
                <div class="tianjia">
                    <a class="tianjia_but" href="<?php echo U('course/addcourse');?>">
                        <i class="fa fa-plus"></i>
                        添加课程专题
                    </a>
                </div>
                <div class="table_box">
                    <table class="table" border="" cellspacing="" cellpadding="">
                        <colgroup>
                            <col width="80">
                            <col width="300">
                            <col width="100">
                            <col width="100">
                            <col width="80">
                            <col width="80">
                            <col width="80">
							<col width="200">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>编号</th>
                                <th>课程专题</th>
                                <th>课程名称</th>                            
                                <th>浏览数量</th>         
                                <th>播放数量</th>
                           
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($listinfo)): $i = 0; $__LIST__ = $listinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$content): $mod = ($i % 2 );++$i;?><tr>
                                <td><?php echo ($content["course_id"]); ?></td>
								<td><a style="color:#333a4d;"><?php echo ($content["course_name"]); ?></a></td>
                                <td><?php echo ($content["classify_name"]); ?></td>
                                <td><?php echo ($content["course_parts"]); ?>/<?php echo ($content["course_allparts"]); ?></td>   
                                <td><?php echo ($content["course_play"]); ?></td>                               
                                <td>
                                   <a class="but chaxun" href="<?php echo U('course/datell_course',array('id'=>$content['course_id']));?>"><i class="fa fa-refresh"></i>查看课程 </a>
                                    <a  href="<?php echo U('course/editcourse',array('id'=>$content['course_id']));?>"  class="but chaxun">
                                        <i class="fa fa-edit"></i>
                                        编辑
                                    </a>
                                    <a href="<?php echo U('course/delcourse',array('id'=>$content['course_id']));?>" onclick="{
                                                if (confirm('确认删除?')) {
                                                    return true;
                                                }
                                                return false;
                                            }"   class="but chongzhi">
                                        <i class="fa fa-trash-o"></i>
                                        删除
                                    </a>
									<a class="but chaxun" href="<?php echo U('course/sendtplmsg',array('id'=>$content['course_id']));?>"><i class="fa fa-refresh"></i>发送消息 </a>
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