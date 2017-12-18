<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>视频直播管理</title>
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
					<li><a href="javascript:void(0);">视频直播管理</a></li>
				</ul>
			</div>
			<div class="min">
				<!--查询-->
				<!--添加角色-->
						
				<div class="query">
					<form  name="seachform" id="seachform"  action="<?php echo U('liveinfo/index');?>"  method="post" class="form"  onsubmit="return checkkwd()">
						<div class="form_input mg_trb">
							<label class="text">快速检索</label>
							<input type="text" name="info[keyword]" id="keyword" value="<?php echo ($keyword); ?>"  placeholder="请输入直播标题"  maxlength="40"/>
						</div>	
                        <div class="select mg_trb">
							<span class="text">直播状态</span>
							<select name="info[live_flag]">
								<option value="">--请选择状态--</option>
								<option value="2" <?php if(2 == $liveflag ): ?>selected<?php endif; ?>>开启</option>
								<option value="1" <?php if(1 == $liveflag ): ?>selected<?php endif; ?>>关闭</option>
                                <!--<option value="<?php echo ($data["live_id"]); ?>" <?php if($data['live_id'] == $live_flag ): ?>selected<?php endif; ?>><?php echo ($data["vip_name"]); ?></option>-->
								
							</select>
                        </div>						
						<div class="button mg_trb">
							<i class="fa fa-refresh ico"></i>
							<input type="button" value="重置" class="but chongzhi" onclick="location.href='<?php echo U('liveinfo/index');?>'"/>
						</div>
						<div class="button mg_trb">
							<i class="fa fa-search ico"></i>
							<input type="submit" value="查询" class="but chaxun"  />
						</div>
					</form>
				</div>
				<div class="tianjia">
					<a class="tianjia_but" href="<?php echo U('liveinfo/addlive');?>">
						<i class="fa fa-plus"></i>
						添加直播
					</a>
				</div>	
				<div class="table_box">
					<table class="table" border="" cellspacing="" cellpadding="">

						<thead>
							<tr>
								<th>编号</th>
								<th>直播标题</th>
								<th>主讲</th>			
								<th>直播时间</th>		                         									                         								
								<th>预约人数</th>		                         								
								<th>直播状态</th>		                         								
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($listinfo)): $i = 0; $__LIST__ = $listinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($v["live_id"]); ?></td>
								<td><?php echo ($v["live_title"]); ?></td>
								<td><?php echo ($v["live_speaker"]); ?></td>			
								<td><?php echo ($v["live_time"]); ?></td>
								<td><?php echo ($v["live_num"]); ?></td>
								<td><?php echo ($live_flag[$v['live_flag']]); ?></td>								
								<td>
								<a href="<?php echo U('liveorder/index',array('live_id'=>$v['live_id']));?>"  class="but chaxun">
								<i class="fa fa-eye"></i>
								查看预约学员</a>
                                <a href="<?php echo U('liveinfo/editlive',array('live_id'=>$v['live_id']));?>"  class="but chaxun">
								<i class="fa fa-edit"></i>
								编辑</a>																
								<?php if($v['live_flag'] == 1): ?><a href="<?php echo U('liveinfo/setlive',array('live_id'=>$v['live_id']));?>" onclick="{if(confirm('确认开启?')){return true;}return false;}" class="but chaxun">
								<i class="fa fa-toggle-on"></i>
								开启</a>
								<?php else: ?>
								<a href="<?php echo U('liveinfo/setliveclose',array('live_id'=>$v['live_id']));?>" onclick="{if(confirm('确认关闭？')){return true;}return false;}" class="but chaxun">
								<i class="fa fa-toggle-off" ></i>
								关闭</a><?php endif; ?>
								<a href="<?php echo U('liveinfo/dellive',array('live_id'=>$v['live_id']));?>" onclick="{if(confirm('确认删除?')){return true;}return false;}" class="but chongzhi">
								<i class="fa fa-trash-o"></i>
								删除</a>
								</td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				</div>				
				<?php echo ($Pageshow); ?>
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