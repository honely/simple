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
		<style>
		.form-button .ke-inline-block.but{margin-top:0;}
		.form-button .ke-button-common{display:block;width:100%; height:100%; line-height:38px; background:none;}
		.form-button .ke-button-common.ke-button{color:#fff; font-size:16px;}
		.form-button .ke-upload-area.ke-form .ke-upload-file{display:block;width:100% !important; height:100%;     cursor: pointer;}
	</style>
	<script type="text/javascript">
		var editor;
		KindEditor.ready(function(K) {
			editor = K.create('textarea[id="content"]', {
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
			
		var uploadbutton = K.uploadbutton({
	button : K('#uploadButton')[0],
	fieldName : 'imgFile',
	url : '<?php echo U('kindeditor/upload_json',array('dir'=>image));?>',
	afterUpload : function(data) {
		if (data.error === 0) {
			var url = K.formatUrl(data.url, 'domain');
			K('#image').val(url);
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

			});
   
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
					<li><a href="<?php echo U('content/index');?>">文章列表</a></li>
					<li> > </li>
					<li><a href="javascript:void(0);">修改文章</a></li>
				</ul>
			</div>
			<div class="min">
				<div class="form_box">
						<form  name="myform" id="myform"  action="<?php echo U('content/editcontent',array('id'=>$content['id']));?>" method="post" onsubmit="return check()">
						<div class="form-item">
							<label class="form-label">文章标题</label>
							<div class="form-text form-input-block">
								<input type="text" name="info[title]" value="<?php echo ($content["title"]); ?>" placeholder="请输入内容" id="title" maxlength="60"/>
								<i class="aa1" style="display:none;color:red;">文章标题不能为空</i>
							</div>
						</div>
						<div class="form-item">
							<label class="form-label">文章分类</label>
							<div class="form-select form-input-block">
								<select id="classtype" name="info[classtype]" >
								 <option value="" >--请选择--</option>
									<?php if(is_array($class_type)): $i = 0; $__LIST__ = $class_type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($key == $content['classtype']): ?>selected<?php endif; ?>><?php echo ($data); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
								</select>
								<i class="aa2" style="display:none;color:red;">文章分类不能为空</i>
							</div>
						</div>
					<!--
						<div class="form-item">
							<label class="form-label"> 默认图片</label>
							<div class="form-text form-input-inline w40">
								<input type="text" name="info[image]" id="image" value="<?php echo ($content["image"]); ?>" maxlength="255" readonly/>
							</div>
							<div class="form-button form-input-inline">	
								<input  class="but shenhe mg_t0" type="button" id="uploadButton"  value="上传" />
							</div>	
						</div>
						-->
						<!--
						<div class="form-item">
							<label class="form-label">文章状态</label>
							<div class="form-radio form-input-block">
								<div class="skin-section">
									<ul>
										<li>
											<input type="radio" name="radio" value="1"  <?php if($content['content_isshow'] == 1 ): ?>checked<?php endif; ?> >
											<span>显示</span>
										</li>
										<li>
											<input type="radio" name="radio" value="2" <?php if($content['content_isshow'] == 2 ): ?>checked<?php endif; ?>>
											<span>隐藏</span>
										</li>
									</ul>
								</div>
								<input type="hidden"  name="info[content_isshow]"  id="content_isshow" value='1' >
								<i class="aa3" style="display:none;color:red;">文章状态不能为空</i>
							</div>
						</div>
						-->
						<!--
						<div class="form-item">
							<label class="form-label">视频url</label>
							<div class="form-text form-input-block">
								<input type="text" name="info[video]" value="<?php echo ($content["video"]); ?>" placeholder="请输入视频url" id="video" maxlength="150"/>
								<i style="color:red;">视频url如：http://www.xxx.com/player.php/sid/v.mp3</i>
				
							</div>
						</div>
						-->
						<div class="form-item">
							<label class="form-label">文章内容</label>
							<div class="form-textarea form-input-block">
								<textarea name="info[content]" placeholder="请输入内容" id="content" maxlength="600" style="height:300px;"><?php echo ($content["content"]); ?></textarea>
								<i class="aa4" style="display:none;color:red;">文章内容不能为空</i>
							</div>
						</div>
						<div class="form-item">
							<div class="form-button form-input-block">
								<input class="chaxun but" type="submit" value="提交"/>
								
								<button class="but chongzhi" type="button" onclick="location.href='<?php echo U('content/index');?>'">返回</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>

<script>
	function check(){
	    var title = document.getElementById("title").value;
				if(title==''){
				    $(".aa1").show();
					$('#title').focus();
					return false;
				}
				$(".aa1").hide();
		var classtype = document.getElementById("classtype").value;
				if(classtype==''){
				    $(".aa2").show();
					$('#classtype').focus();
					return false;
				}
				$(".aa2").hide();	
	
		var content = document.getElementById("content").value;
				if(content==''){
				    $(".aa4").show();
					$('#content').focus();
					return false;
				}
				$(".aa4").hide();	
		
	   }

</script>
<script type="text/javascript">
	$(function(){
		$(".right_min").height($(window).height());
		
		$('.skin-section input').iCheck({
			checkboxClass: 'icheckbox_square-green',
			radioClass: 'iradio_square-green',
		});
		$('input').on('ifChecked', function(event){
		   var a=$(this).val();
		   $("#content_isshow").val(a);
		});
	});
	
	
</script>