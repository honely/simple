<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
	<meta charset="UTF-8">
	<title></title>
	<link rel="stylesheet" type="text/css" href="/Public/admin/css/html5.css"/>
	<link rel="stylesheet" type="text/css"  href="/Public/admin/font/iconfont.css">
	<link rel="stylesheet" type="text/css"  href="/Public/admin/font/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="/Public/admin/css/index.css"/>
	<link rel="stylesheet" href="/Public/kindeditor/themes/default/default.css" />
	<script type="text/javascript" src="/Public/kindeditor/kindeditor-min.js"></script>
	<script type="text/javascript" src="/Public/kindeditor/lang/zh-CN.js"></script>
	<script src="/Public/admin/js/jquery-1.10.2.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="/Public/admin/js/icheck/icheck.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" type="text/css" href="/Public/admin/js/icheck/square/green.css">
	
		<script type="text/javascript" src="/Public/admin/js/jquery.idTabs.min.js"></script>
		<script type="text/javascript" src="/Public/admin/js/stringOperate.js"></script>
		<style>
		.form-button .ke-inline-block.but{margin-top:0;}
		.form-button .ke-button-common{display:block;width:100%; height:100%; line-height:38px; background:none;}
		.form-button .ke-button-common.ke-button{color:#fff; font-size:16px;}
		.form-button .ke-upload-area.ke-form .ke-upload-file{display:block;width:100% !important; height:100%;     cursor: pointer;}
	    </style>
	<script type="text/javascript">
		var editor;
		KindEditor.ready(function(K) {
			editor = K.create('textarea[id="down_remarks"]', {
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
			editor = K.create('textarea[id="speaker_remarks"]', {
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
			 var uploadbutton1 = K.uploadbutton({
				button : K('#uploadButton')[0],
				fieldName : 'imgFile',
				url : '<?php echo U('kindeditor/upload_json',array('dir'=>image));?>',
				afterUpload : function(data) {
					if (data.error === 0) {
						var url = K.formatUrl(data.url, 'domain');
						K('#down_image').val(url);
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
				//单图
			 var uploadbutton2 = K.uploadbutton({
				button : K('#uploadButton1')[0],
				fieldName : 'imgFile',
				url : '<?php echo U('kindeditor/upload_json',array('dir'=>image));?>',
				afterUpload : function(data) {
					if (data.error === 0) {
						var url = K.formatUrl(data.url, 'domain');
						K('#column_pic').val(url);
					} else {
						alert(data.message);
					}
				},
				afterError : function(str) {
					alert('自定义错误信息: ' + str);
				}
				});
				uploadbutton2.fileBox.change(function(e) {
				uploadbutton2.submit();
				}); 
				//多图
			var uploadbutton4 = K.uploadbutton({
					button : K('#uploadButton3')[0],
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
				uploadbutton4.fileBox.change(function(e) {
					uploadbutton4.submit();
				});
				});
			//图片插件
			function add_album_img(imgurl) {
				
				var val = StringOperate.add($("#column_images").val(), imgurl);
				$("#column_images").val(val);
				$(".toollist_pic").append("<li onclick=\"del_album_img(\'" + imgurl +"\',this);\"><a><img src='" + imgurl + "'><i class=\"fa fa-times-circle\"></i></a></li>");
				$('#imagemore').val("");
			}
			function del_album_img(imgurl,obj) {  
				var val = StringOperate.remove($("#column_images").val(), imgurl); 
				$("#column_images").val(val);
				$(obj).remove();//删除元素
			}
    </script>
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
					<li><a href="<?php echo U('downinfo/downinfo');?>">工具下载管理</a></li>
					<li> > </li>
					<li><a href="<?php echo U('downinfo/upd');?>">修改工具</a></li>
				</ul>
			</div>
			<div class="min">
				<div class="form_box">
					<form action="<?php echo U('Admin/Downinfo/upd');?>" method="post" onsubmit="return checkform();">
						<div class="form-item">
							<label class="form-label">工具名称</label>
							<div class="form-text form-input-block">
								<input type="hidden" name="down_id" value="<?php echo ($data["down_id"]); ?>">
								<input type="text" name="down_title" id="down_title" value="<?php echo ($data["down_title"]); ?>" maxlength="15" />
                                <i class="ss2" style="display:none;color:red;">工具名称不能为空</i>
							</div>
						</div>
						<div class="form-item">
							<label class="form-label"> 工具图片</label>
							<div class="form-text form-input-inline w40">
								<input  style="width:595px" type="text" name="down_image" id="down_image" value="<?php echo ($data["down_image"]); ?>" maxlength="255" readonly/>
							</div>
							<div class="form-button form-input-inline" style="text-indent:146px;"  >	
								<input  class="but shenhe mg_t0"   type="button" id="uploadButton"  value="上传" />
								<i class="ss3" style="display:none;color:red;">请上传工具图片</i>
							</div>	
						</div>

						<div class="form-item">
							<label class="form-label">下载URL地址</label>
							<div class="form-text form-input-block">
								<input type="text" name="down_file" id="down_file" value="<?php echo ($data["down_file"]); ?>" placeholder="请输入URL地址" maxlength="50" />
								<i class="ss22" style="display:none;color:red;">下载URL地址不能为空</i>
							</div>
						</div>
						<div class="form-item">
							<label class="form-label">工具简介</label>
							<div class="form-textarea form-input-block">
								<textarea name="down_remarks" style="width: 100%;height: 80px;"  id="down_remarks" maxlength="1000" ><?php echo ($data["down_remarks"]); ?></textarea>
								<i class="ss6" style="display:none;color:red;">请输入工具简介</i>
							</div>
						</div>
						<div class="form-item">
							<div class="form-button form-input-block">
								<input class="chaxun but" type="submit" value="修改"/>
                                
								<button class="but chongzhi" type="button" onclick="location.href='<?php echo U('downinfo/downinfo');?>'">返回</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
	<script>
	   function checkform(){	   
			var down_title = $('#down_title').val();
				if(down_title==''){
				    $(".ss2").show();
					$('#down_title').focus();
					return false;
				}
				$(".ss2").hide();
			var down_file = $('#down_file').val();
				if(down_file==''){
				    $(".ss22").show();
					$('#down_file').focus();
					return false;
				}
				$(".ss22").hide();
			var down_image = $('#down_image').val();
				if(down_image==''){
				    $(".ss3").show();
					$('#down_image').focus();
					return false;
				}
				$(".ss3").hide();				
            var down_remarks = $('#down_remarks').val();
				if(down_remarks==''){
					$(".ss6").show();
					$('#down_remarks').focus();
					return false;
				}
				$(".ss6").hide();				
	   }

	</script>
</html>