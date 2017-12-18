<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<head>
	<meta charset="UTF-8">
		<title>研习班管理</title>
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
					<li><a href="javascript:void(0);">研习班管理</a></li>
				</ul>
			</div>
			<div class="min">								
				<div class="query">
					<form  name="seachform" id="seachform"  action="<?php echo U('Workinfo/workoper');?>"  method="post" class="form">
						<div class="form_input mg_trb">
		                    <label class="text">查询</label>
		                    <input type="text" name="info[focus_title]" id="focus_title" value="<?php echo ($focus_title); ?>"  placeholder="请输入地址或班级名"  maxlength="15"/>
	                	</div>		
						<div class="form_input mg_trb form-date">
							<label class="text">时间</label>
								<input type="text" class="laydate-icon layer-date" name="info[starttime]"  value="<?php echo ($starttime); ?>"  id="start" placeholder="开始时间" readonly/>
								<span>--</span>
								<input type="text" class="laydate-icon layer-date" name="info[endtime]"  value="<?php echo ($endtime); ?>"  id="end" placeholder="结束时间" readonly/>
						</div>					
			

						<div class="button mg_trb">
							<i class="fa fa-refresh ico"></i>
							<input type="button" value="重置" class="but chongzhi" onclick="location.href='<?php echo U('Workinfo/workoper');?>'"/>
						</div>
						<div class="button mg_trb">
							<i class="fa fa-search ico"></i>
							<input type="submit" value="查询" class="but chaxun"/>
						</div>
					</form>
				</div>
				<!--添加幻灯-->
		        <div class="tianjia">
		            <a class="tianjia_but" href="<?php echo U('Workinfo/addinfo');?>">
		                <i class="fa fa-plus"></i>
		                	添加研习班
		            </a>
		        </div>
				
				<div class="table_box">
					<table class="table" border="" cellspacing="" cellpadding="">
						<colgroup>
							<col width="200">
							<col width="200">
							<col width="200">
							<col width="200">
							<col width="200">
							<col width="200">
							<col width="200">
						</colgroup>
						<thead>
							<tr>
								<th>班级编号</th>
								<th>班级名称</th>
								<th>班级地址</th>
								<th>班级时间</th>
								<th>添加时间</th>
								<th>班级人数</th>	
								<th>操作</th>						
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($arr)): $i = 0; $__LIST__ = $arr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($v["work_id"]); ?></td>
								<td><?php echo ($v["work_title"]); ?></td>
								<td><?php echo ($v["work_address"]); ?></td>
								<td><?php echo ($v["work_time"]); ?></td>
								<td><?php echo (date('Y-m-d H:i:s',$v["work_addtime"])); ?></td>	
								<td><?php echo ($v["work_num"]); ?></td>											
								<td >
								     <a class="but chaxun" href="<?php echo U('buxiyanfa/buxiyanfa',array('work_id'=>$v['work_id'],'work_title'=>$v['work_title']));?>"><i class="fa fa-eye"></i>报名详情 </a>
                   					 <a title="编辑" href="<?php echo U('Workinfo/edit',array('work_id'=>$v['work_id']));?>" class="but chaxun" ><i class="fa fa-edit"></i>编辑</a>
									<a title="席位管理" href="<?php echo U('Workinfo/seat',array('work_id'=>$v['work_id'],'work_title'=>$v['work_title']));?>" class="but chaxun" ><i class="fa fa-edit"></i>席位管理</a>
                    				 <a title="删除" href="<?php echo U('Workinfo/delworkinfo',array('work_id'=>$v['work_id']));?>" onclick="{if(confirm('确定要删除吗?')){return true;}return false;}" class="but chongzhi" > <i class="fa fa-trash-o"></i>删除</a>
									 
									 <a class="but chaxun" href="<?php echo U('Workinfo/sendtplmsg',array('work_id'=>$v['work_id']));?>"><i class="fa fa-refresh"></i>发送消息 </a>
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