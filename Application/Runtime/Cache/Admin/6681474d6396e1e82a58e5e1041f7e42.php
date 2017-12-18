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
		<link rel="stylesheet" href="/Public/kindeditor/themes/default/default.css" />
        <script type="text/javascript" src="/Public/kindeditor/kindeditor-min.js"></script>
        <script type="text/javascript" src="/Public/kindeditor/lang/zh-CN.js"></script>
		<script src="/Public/admin/js/layer/layer.js"></script>
	</head>
	<style>
		.form-button .ke-inline-block.but{margin-top:0;}
		.form-button .ke-button-common{display:block;width:100%; height:100%; line-height:38px; background:none;}
		.form-button .ke-button-common.ke-button{color:#fff; font-size:16px;}
		.form-button .ke-upload-area.ke-form .ke-upload-file{display:block;width:100% !important; height:100%;     cursor: pointer;}
	</style>
	<script type="text/javascript">
	
    var editor;
	KindEditor.ready(function(K) {
	    
		editor = K.create('textarea[id="vip_remark"]', {
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
		//图
		var uploadbutton = K.uploadbutton({
			button : K('#uploadbutton')[0],
			fieldName : 'imgFile',
			url : '<?php echo U('kindeditor/upload_json',array('dir'=>image));?>',
			afterUpload : function(data) {
				if (data.error === 0) {
					var url = K.formatUrl(data.url, 'domain');
					$("#vip_image").val(url);
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
	<body>
		<div class="right_min">
			<div class="crumbs_nav">
				<i class="iconfont icon-shouye"></i>
					<ul>
				    <li><a href="<?php echo U('index/welcome');?>">首页</a></li>
					<li> > </li>
					<li><a href="#">课程管理</a></li>
					<li> > </li>
					<li><a href="<?php echo U('level/viplevellist');?>">vip等级列表</a></li>
					<li> > </li>
					<li><a href="#">编辑vip等级</a></li>
				</ul>
			</div>
			<div class="min">
				<div class="form_box">
					<form name="myform" id="myform" action="<?php echo U('level/edit_viplevel',array('vip_id'=>$level['vip_id']));?>" method="post" onsubmit="return check()">
						<div class="form-item">
							<label class="form-label">VIP名称</label>
							<div class="form-text form-input-block">
								<input type="text" name="info[vip_name]" id="vip_name"  placeholder="请输入VIP名称" value="<?php echo ($level["vip_name"]); ?>" maxlength="25"/>
								<i class="aa1" style="display:none;color:red;">VIP名称不能为空</i>
							</div>
						</div>
						<div class="form-item">
							<label class="form-label">VIP描述</label>
							<div class="form-text form-input-block w50">
								<input type="text" name="info[vip_title]" id="vip_title" value="<?php echo ($level["vip_title"]); ?>" placeholder="请输入VIP描述" maxlength="100"/>
								<i class="aa2" style="display:none;color:red;">VIP描述不能为空</i>
							</div>
						</div>
						<div class="form-item">
								<label class="form-label">年份</label>
								<div class="form-select form-input-block w50">
									<select name="info[vip_year]" id="vip_year">
									    <option value="" >--请选择--</option>
									    <option value="1" <?php if($level['vip_year'] == 1 ): ?>selected<?php endif; ?>>1</option>
										<option value="2" <?php if($level['vip_year'] == 2 ): ?>selected<?php endif; ?>>2</option>
										<option value="3" <?php if($level['vip_year'] == 3 ): ?>selected<?php endif; ?>>3</option>
										<option value="4" <?php if($level['vip_year'] == 4 ): ?>selected<?php endif; ?>>4</option>
										<option value="5" <?php if($level['vip_year'] == 5 ): ?>selected<?php endif; ?>>5</option>
										<option value="6" <?php if($level['vip_year'] == 6 ): ?>selected<?php endif; ?>>6</option>
										<option value="7" <?php if($level['vip_year'] == 7 ): ?>selected<?php endif; ?>>7</option>
										<option value="8" <?php if($level['vip_year'] == 8 ): ?>selected<?php endif; ?>>8</option>
										<option value="9" <?php if($level['vip_year'] == 9 ): ?>selected<?php endif; ?>>9</option>
										<option value="10" <?php if($level['vip_year'] == 10 ): ?>selected<?php endif; ?>>10</option>
								    </select>
									<i class="aa3" style="display:none;color:red;" >请选择年份</i>
						        </div>
						</div>
                        <div class="form-item">
							<label class="form-label">升级费用</label>
							<div class="form-text form-input-block">
								<input type="text" name="info[vip_money]" id="vip_money"  placeholder="请输入需要的升级费用"  onkeyup="value=value.replace(/[^\d.]/g,'')" value="<?php echo ($level["vip_money"]); ?>" maxlength="6"/>
								<i class="aa4" style="display:none;color:red;">升级费用不能为空</i>
							</div>
						</div>
						<div class="form-item">
							<label class="form-label">返现金额</label>
							<div class="form-text form-input-block w50">
								<input type="text" name="info[vip_backmoney]" id="vip_backmoney" value="<?php echo ($level["vip_backmoney"]); ?>" placeholder="请输入返现金额"    onkeyup="value=value.replace(/[^\d.]/g,'')" maxlength="6"/>
								<i class="aa5" style="display:none;color:red;">返现金额不能为空</i>
							</div>
						</div>
						<div class="form-item">
						        <label class="form-label">等级图标</label>
								<div class="form-text form-input-inline w50">
									<input type="text" class="form-control" name="info[vip_image]" id="vip_image"  maxlength="150" value="<?php echo ($level["vip_image"]); ?>" readonly />
									<i style="color:red; font-size:12px;">等级图标尺寸27*27px</i>	
								</div>
								<div class="form-button form-input-inline">
									<input type="button" id="uploadbutton" class="but shenhe mg_t0" value="上传" />
								    <i class="aa6" style="display:none;color:red;font-size:12px;">等级图标不能为空</i>
									
								</div>
								
						</div>
                        <div class="form-item">
							<label class="form-label">简介</label>
							<div class="form-textarea form-input-block">
								<textarea name="info[vip_remark]" placeholder="请输入简介内容"  id="vip_remark" ><?php echo ($level["vip_remark"]); ?></textarea>
								<i class="aa7" style="display:none;color:red;">简介不能为空</i>
							</div>
						</div>
						<div class="form-item">
							<div class="form-button form-input-block">
								<input class="chaxun but" type="submit" value="提交"/>
								
								<button class="but chongzhi" type="button" onclick="location.href='<?php echo U('level/viplevellist');?>'">返回</button>
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
		var vip_name = document.getElementById("vip_name").value;
				if(vip_name==''){
				    $(".aa1").show();
					$('#vip_name').focus();
					return false;
				}
				$(".aa1").hide();
		var vip_title = document.getElementById("vip_title").value;
				if(vip_title==''){
				    $(".aa2").show();
					$('#vip_title').focus();
					return false;
				}
				$(".aa2").hide();
		var vip_year = document.getElementById("vip_year").value;
				if(vip_year==''){
				    $(".aa3").show();
					$('#vip_year').focus();
					return false;
				}
				$(".aa3").hide();		
		var vip_money = document.getElementById("vip_money").value;
				if(vip_money==''){
				    $(".aa4").show();
					$('#vip_money').focus();
					return false;
				}
				$(".aa4").hide();
		var vip_backmoney = document.getElementById("vip_backmoney").value;
				if(vip_backmoney==''){
				    $(".aa5").show();
					$('#vip_backmoney').focus();
					return false;
				}
				$(".aa5").hide();
		var vip_image = document.getElementById("vip_image").value;
				if(vip_image==''){
				    $(".aa6").show();
					$('#vip_image').focus();
					return false;
				}
				$(".aa6").hide();		
		var vip_remark = document.getElementById("vip_remark").value;
				if(vip_remark==''){
				    $(".aa7").show();
					$('#vip_remark').focus();
					return false;
				}
				$(".aa7").hide();
		
	   }

</script>