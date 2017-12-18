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
	</head>
	<style>
	/*多图上传样式*/
	.toollist_pic{clear: both;width: 100%;text-align: center;margin-right: 10px; margin-top:10px;}
	.toollist_pic li{float: left;list-style:none; clear: initial; width:100px;height:100px; overflow:hidden;position: relative;}
	.toollist_pic li a{display:block; width:100%; height:100%;}
	.toollist_pic li img{width:100px;height:100px;}
	.toollist_pic li i{display:block; position:absolute; top:0; right:0; width:20px; height:20px; background:#2cb184; z-index:888; margin:0;}
	.toollist_pic li .fa-times-circle{ font-size:20px; color:#fff;}
	.span{display:inline-block; height:34px; line-height:34px;color: #ff0000;font-size:1.8rem;vertical-align: middle;}
	</style>
	<style>
		.form-button .ke-inline-block.but{margin-top:0;}
		.form-button .ke-button-common{display:block;width:100%; height:100%; line-height:38px; background:none;}
		.form-button .ke-button-common.ke-button{color:#fff; font-size:16px;}
		.form-button .ke-upload-area.ke-form .ke-upload-file{display:block;width:100% !important; height:100%;     cursor: pointer;}
	</style>
	
    <script type="text/javascript">
    var editor;
	KindEditor.ready(function(K) {
		editor = K.create('textarea[id="level_remark"]', {
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
		//单图
		var uploadbutton = K.uploadbutton({
			button : K('#uploadbutton')[0],
			fieldName : 'imgFile',
			url : '<?php echo U('kindeditor/upload_json',array('dir'=>image));?>',
			afterUpload : function(data) {
				if (data.error === 0) {
					var url = K.formatUrl(data.url, 'domain');
					$("#level_image").val(url);
				} else {
					alert(data.message);
				}
			},
			afterError : function(str) {
				alert('自定义错误信息: ' + str);
			}
		});
		uploadbutton.fileBox.change(function(e) {
			uploadbutton.submit();
		});
		
		//多图
		var uploadbutton1 = K.uploadbutton({
			button : K('#uploadbutton1')[0],
			fieldName : 'imgFile',
			url : '<?php echo U('kindeditor/upload_json',array('dir'=>image));?>',
			afterUpload : function(data) {
				if (data.error === 0) {
					var url = K.formatUrl(data.url, 'domain');
					K('#imagemore').val(url);
					add_album_img(url);
				} else {
					alert(data.message);
				}
			},
			afterError : function(str) {
				alert('自定义错误信息: ' + str);
			}
		});
		uploadbutton1.fileBox.change(function(e) {
			uploadbutton1.submit();
		});
	});

    //图片插件
	function add_album_img(imgurl) {
		var val = StringOperate.add($("#imagemoreall").val(), imgurl);
		$("#imagemoreall").val(val);
		$(".toollist_pic").append("<li onclick=\"del_album_img(\'" + imgurl +"\',this);\"><a><img src='" + imgurl + "'><i class=\"fa fa-times-circle\"></i></a></li>");
		$('#imagemore').val("");
	}
	function del_album_img(imgurl,obj) {  
		var val = StringOperate.remove($("#imagemoreall").val(), imgurl); 
		$("#imagemoreall").val(val);
		$(obj).remove();//删除元素
	}
	</script>
	
	<body>
		<div class="right_min">
			<div class="crumbs_nav">
				<i class="iconfont icon-shouye"></i>
					<ul>
				    <li><a href="<?php echo U('index/welcome');?>">首页</a></li>
					<li> > </li>
					<li><a href="#">课程管理</a></li>
					<li> > </li>
					<li><a href="<?php echo U('level/levellist');?>">等级列表</a></li>
					<li> > </li>
					<li><a href="#">添加等级</a></li>
				</ul>
			</div>
			<div class="min">
				<div class="form_box">
					<form name="myform" id="myform" action="<?php echo U('level/addlevel');?>" method="post" onsubmit="return check()">
						<div class="form-item">
							<label class="form-label">等级名称</label>
							<div class="form-text form-input-block w50">
								<input type="text" name="info[level_name]" id="level_name" value="" placeholder="请输入等级名称" maxlength="20"/>
								<i class="aa1" style="display:none;color:red;">等级名称不能为空</i>
							</div>
						</div>
                        <div class="form-item">
							<label class="form-label">学习时长（秒）</label>
							<div class="form-text form-input-block w50">
								<input type="text" name="info[level_learntime]" id="level_learntime" value=""  onkeyup="value=value.replace(/[^\d.]/g,'')"  placeholder="请输入要求学习时长" maxlength="10"/>
								<i class="aa2" style="display:none;color:red;">学习时长不能为空</i>
							</div>
						</div>
						<div class="form-item">
							<label class="form-label">学习学分（分）</label>
							<div class="form-text form-input-block w50">
								<input type="text" name="info[level_score]" id="level_score" value=""  onkeyup="value=value.replace(/[^\d.]/g,'')"  placeholder="请输入奖励学习学分" maxlength="10"/>
								<i class="aa3" style="display:none;color:red;">学习学分不能为空</i>
							</div>
						</div>
						<div class="form-item">
						        <label class="form-label">等级图标</label>
								<div class="form-text form-input-inline w50">
									<input type="text" class="form-control" name="info[level_image]" id="level_image"  maxlength="150" readonly />
								</div>
								<div class="form-button form-input-inline">
									<input type="button" id="uploadbutton" class="but shenhe mg_t0" value="上传" />
								    <i class="aa4" style="display:none;color:red;">等级图标不能为空</i>
								</div>
						</div>
						<!--<div class="form-item">
						        <label class="form-label">多图</label>
								<div class="form-text form-input-inline w50">
									<input type="text" class="form-control" name="info[level_image1]" id="imagemoreall"  maxlength="150" readonly />
								</div>
								<div class="form-text form-input-inline">
									<input class="but shenhe mg_t0" type="button" id="uploadbutton1"  class="chaxun but" value="上传" />
									<input name="forum_images" id="imagemore" type="hidden" class="dfinput" value="" readonly />
								</div>
							    <div class="form-text form-input-block w50">
									<ul class="toollist_pic c">
					                </ul>
								</div>
						</div>-->
                        <div class="form-item">
							<label class="form-label">简介</label>
							<div class="form-textarea form-input-block">
								<textarea name="info[level_remark]" placeholder="请输入简介内容" id="level_remark"></textarea>
								<i class="aa5" style="display:none;color:red;">简介不能为空</i>
							</div>
						</div>
						<div class="form-item">
							<div class="form-button form-input-block">
								<input class="chaxun but" type="submit" value="提交"/>
								
								<button class="but chongzhi" type="button" onclick="location.href='<?php echo U('level/levellist');?>'">返回</button>
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
		var level_name = document.getElementById("level_name").value;
				if(level_name==''){
				    $(".aa1").show();
					$('#level_name').focus();
					return false;
				}
				$(".aa1").hide();
		var level_learntime = document.getElementById("level_learntime").value;
				if(level_learntime==''){
				    $(".aa2").show();
					$('#level_learntime').focus();
					return false;
				}
				$(".aa2").hide();
		var level_score = document.getElementById("level_score").value;
				if(level_score==''){
				    $(".aa3").show();
					$('#level_score').focus();
					return false;
				}
				$(".aa3").hide();
        var level_image = document.getElementById("level_image").value;
				if(level_image==''){
				    $(".aa4").show();
					$('#level_image').focus();
					return false;
				}
				$(".aa4").hide();
		var level_remark = document.getElementById("level_remark").value;
				if(level_remark==''){
				    $(".aa5").show();
					$('#level_remark').focus();
					return false;
				}
				$(".aa5").hide();
	   }

</script>