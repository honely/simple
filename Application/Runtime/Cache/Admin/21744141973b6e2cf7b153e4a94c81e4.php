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
                    <li><a href="javascript:void(0);"><font color=red>【<?php echo ($course_name); ?>】</font>专题课程管理</a></li>
                </ul>
            </div>
            <div class="min">
                <!--查询-->
                <div class="query">
                    <form name="seachform" id="seachform" action="<?php echo U('lesson/index',array('course_id'=>$course_id));?>"  method="post" class="form">
                        <div class="form_input mg_trb">
                            <label class="text">课程检索</label>
                            <input type="text" name="info[lesson_name]" id="keyword" value="<?php echo ($lesson_name); ?>" placeholder="请输入课程名" maxlength="20"/>
                        </div>  
						<div class="select mg_trb">
                            <span class="text">是否热播</span>
                            <select name="info[lesson_ishot]">
                                <option value="">--请选择--</option>
                                <?php if(is_array($is_course_hot)): $k = 0; $__LIST__ = $is_course_hot;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><option value="<?php echo ($k); ?>" <?php if($k == $lesson_ishot ): ?>selected<?php endif; ?>><?php echo ($v); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div> 

						<div class="button mg_trb" onclick="location.href = '<?php echo U('lesson/index',array('course_id'=>$course_id));?>'">
							<i class="fa fa-refresh ico"></i>
							<input type="button" value="重置" class="but chongzhi" />
						</div>
						<div class="button mg_trb chaxun">
							<i class="fa fa-search ico"></i>
							<input type="submit" value="查询" class="but " style="    position: absolute; background: none;z-index: 2;" />
						</div>
                    </form>
                </div>
                <div class="tianjia">
                    <a class="tianjia_but" href="<?php echo U('lesson/addlesson',array('course_id'=>$course_id));?>">
                        <i class="fa fa-plus"></i>
                        添加课程
                    </a>
                </div>
                <div class="table_box">
                    <table class="table" border="" cellspacing="" cellpadding="">
                    
                        <thead>
                            <tr>
                                <th>编号</th>
                                <th>所属专题</th>
                                <th>课程名称</th>                            
                                <th>浏览数量</th>         
                                <th>播放数量</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($listinfo)): $i = 0; $__LIST__ = $listinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lesson): $mod = ($i % 2 );++$i;?><tr>
                                <td><?php echo ($lesson["lesson_id"]); ?></td>
								<td><a href="<?php echo U('home/course/video',array('course_id'=>$lesson['course_id']));?>" style="color:#333a4d;" target="_blank"><?php echo ($lesson["course_name"]); ?></a></td>
                                <td><a href="<?php echo U('home/course/video',array('course_id'=>$lesson['course_id'],'lesson_id'=>$lesson['lesson_id']));?>" style="color:#333a4d;" target="_blank" ><?php echo ($lesson["lesson_name"]); if($lesson["lesson_ishot"] == 2): ?><b style="color:red;">【HOT】</b><?php endif; ?></a></td>
                                <td><?php echo ($lesson["lesson_view"]); ?></td>   
                                <td><?php echo ($lesson["lesson_play"]); ?></td>   							
                                <td>
                                
                                    <a  href="<?php echo U('lesson/editlesson',array('lesson_id'=>$lesson['lesson_id']));?>"  class="but chaxun">
                                        <i class="fa fa-edit"></i>
                                        编辑
                                    </a>
                                    <a href="<?php echo U('lesson/dellesson',array('lesson_id'=>$lesson['lesson_id'],'course_id'=>$lesson['course_id']));?>" onclick="{
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