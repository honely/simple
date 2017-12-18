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
		<script type="text/javascript" src="/Public/admin/js/jquery.idTabs.min.js"></script>
		<link rel="stylesheet" href="/Public/kindeditor/themes/default/default.css" />
        <script type="text/javascript" src="/Public/kindeditor/kindeditor-min.js"></script>
        <script type="text/javascript" src="/Public/kindeditor/lang/zh-CN.js"></script>
		<script type="text/javascript" src="/Public/admin/js/stringOperate.js"></script>

		<script type="text/javascript" src="/Public/My97DatePicker/WdatePicker.js"></script>
	</head>

	<style>
		.form-button .ke-inline-block.but{margin-top:0;}
		.form-button .ke-button-common{display:block;width:100%; height:100%; line-height:38px; background:none;}
		.form-button .ke-button-common.ke-button{color:#fff; font-size:16px;}
		.form-button .ke-upload-area.ke-form .ke-upload-file{display:block;width:100% !important; height:100%;     cursor: pointer;}
	</style>
	
    <script type="text/javascript">
	//编辑框
    var editor;
	KindEditor.ready(function(K) {
		editor = K.create('textarea[id="live_remarks"]', {
			uploadJson : '<?php echo U('kindeditor/upload_json',array('dir'=>image));?>',
			fileManagerJson : '<?php echo U('kindeditor/file_manager_json');?>',
			allowFileManager : true,
			urlType : 'domain',
			afterCreate : function() {
				this.sync(); 
			},
			afterBlur:function(){ 
				this.sync(); 
			}
	  });
	});

	</script>
	
	<body>
		<div class="right_min">
			<div class="crumbs_nav">
				<i class="iconfont icon-shouye"></i>
					<ul>
				    <li><a href="<?php echo U('index/welcome');?>">首页</a></li>
					<li> > </li>
					<li><a href="#">其他设置</a></li>
					<li> > </li>
					<li><a href="<?php echo U('liveinfo/index');?>">视频直播列表</a></li>
					<li> > </li>
					<li><a href="#">编辑直播</a></li>
				</ul>
			</div>
			<div class="min">
				<div class="form_box">
					<form name="myform" id="myform" action="<?php echo U('liveinfo/editlive',array('live_id'=>$liveinfo['live_id']));?>" method="post" onsubmit="return check()">
						<div class="form-item">
							<label class="form-label">直播标题</label>
							<div class="form-text form-input-block w50">
								<input type="text" name="info[live_title]" id="live_title" value="<?php echo ($liveinfo["live_title"]); ?>" placeholder="请输入直播标题" maxlength="50"/>
								<i class="aa1" style="display:none;color:red;">直播标题不能为空</i>
							</div>
						</div>
                        <div class="form-item">
							<label class="form-label">直播地址</label>
							<div class="form-text form-input-block w50">
								<input type="text" name="info[live_url]" id="live_url" value="<?php echo ($liveinfo["live_url"]); ?>"  placeholder="请输入直播地址" maxlength="200"/>
								<i class="aa2" style="display:none;color:red;">直播地址不能为空</i>
							</div>
						</div>
						<div class="form-item">
							<label class="form-label">主讲</label>
							<div class="form-text form-input-block w50">
								<input type="text" name="info[live_speaker]" id="live_speaker" value="<?php echo ($liveinfo["live_speaker"]); ?>" placeholder="请输入直播标题" maxlength="50"/>
								<i class="aa3" style="display:none;color:red;">主讲不能为空</i>
							</div>
						</div>
						<!--
						<div class="form-item">
							<label class="form-label">直播时间</label>
							<div class="form-text form-input-block w50">
								<input type="text" name="info[live_time]" id="live_time" value="<?php echo ($liveinfo["live_time"]); ?>" placeholder="请输入直播时间" maxlength="200"/>
								<i class="aa4" style="display:none;color:red;">直播时间不能为空</i>
							</div>
						</div>
						-->
						<div class="form-item">
							<label class="form-label">直播时间</label>
							<div class="form-text form-input-block w50">
								<input name="info[live_time]" id="live_time" type="text" onfocus="WdatePicker({ dateFmt:'yyyy-MM-dd HH:mm'})" maxlength="30" readonly value="<?php echo ($liveinfo["live_time"]); ?>" placeholder="请输入直播时间" />
								<i class="aa4" style="display:none;color:red;">直播时间不能为空</i>
							</div>
						</div>
     
                        <div class="form-item">
							<label class="form-label">直播简介</label>
							<div class="form-textarea form-input-block w50">
								<textarea name="info[live_remarks]" placeholder="请输入直播简介内容" id="live_remarks"><?php echo ($liveinfo["live_remarks"]); ?></textarea>
								<i class="aa5" style="display:none;color:red;">直播简介不能为空</i>
							</div>
						</div>
						<!--<div class="form-item">
							<label class="form-label">直播状态</label>
							<div class="form-select form-input-block">
								<select name="info[live_flag]" id="live_flag">
									<option value="">--请选择--</option>
									<option value="1" <?php if($liveinfo['live_flag'] == 1 ): ?>selected<?php endif; ?>>开启</option>
									<option value="0" <?php if($liveinfo['live_flag'] == 0 ): ?>selected<?php endif; ?>>关闭</option>
								</select>
								<i class="aa6" style="display:none;color:red;">直播状态不能为空</i>
							</div>
						</div>-->
						<div class="form-item">
							<div class="form-button form-input-block">
								<input class="chaxun but" type="submit" value="提交"/>
							
								<button class="but chongzhi" type="button" onclick="location.href='<?php echo U('liveinfo/index');?>'">返回</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">
	function check(){
		var live_title = document.getElementById("live_title").value;
				if(live_title==''){
				    $(".aa1").show();
					$('#live_title').focus();
					return false;
				}
				$(".aa1").hide();
		var live_url = document.getElementById("live_url").value;
				if(live_url==''){
				    $(".aa2").show();
					$('#live_url').focus();
					return false;
				}
				$(".aa2").hide();
        var live_speaker = document.getElementById("live_speaker").value;
				if(live_speaker==''){
				    $(".aa3").show();
					$('#live_speaker').focus();
					return false;
				}
				$(".aa3").hide();
		var live_time = document.getElementById("live_time").value;
				if(live_time==''){
				    $(".aa4").show();
					$('#live_time').focus();
					return false;
				}
				$(".aa4").hide();
		 var live_remarks = document.getElementById("live_remarks").value;
				if(live_remarks==''){
				    $(".aa5").show();
					$('#live_remarks').focus();
					return false;
				}
				$(".aa5").hide();
		var live_flag = document.getElementById("live_flag").value;
				if(live_flag==''){
				    $(".aa6").show();
					$('#live_flag').focus();
					return false;
				}
				$(".aa6").hide();		
	   }

</script>