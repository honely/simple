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
    <link href="/Public/validform/Validform.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/Public/validform/Validform_v5.3.2.js"></script>
    <link rel="stylesheet" href="/Public/kindeditor/themes/default/default.css" />
    <script type="text/javascript" src="/Public/kindeditor/kindeditor-min.js"></script>
    <script type="text/javascript" src="/Public/kindeditor/lang/zh-CN.js"></script>
</head>
<style>
	.form-button .ke-inline-block.but{margin-top:0;}
	.form-button .ke-button-common{display:block;width:100%; height:100%; line-height:38px; background:none;}
	.form-button .ke-button-common.ke-button{color:#fff; font-size:16px;}
	.form-button .ke-upload-area.ke-form .ke-upload-file{display:block;width:100% !important; height:100%;     cursor: pointer;}
</style>
<body>
<div class="right_min">
    <div class="crumbs_nav">
        <i class="iconfont icon-shouye"></i>
        <ul>
            <li><a href="<?php echo U('index/welcome');?>">首页</a></li>
            <li> > </li>
            <li><a href="javascript:void(0);">其他设置</a></li>
            <li> > </li>
            <li><a href="<?php echo U('focus/index');?>">幻灯宣传</a></li>
            <li> > </li>
            <li><a href="javascript:void(0);">添加幻灯</a></li>
        </ul>
    </div>
    <div class="min">
        <div class="form_box">
            <form name="myform" id="myform" action="<?php echo U('focus/add');?>" method="post">
                <div class="form-item">
                    <label class="form-label">标题</label>
                    <div class="form-text form-input-block">
                        <input name="focus_title" id="focus_title" type="text" class="dfinput" datatype="*2-20" errormsg="标题字数在2~20位之间！" maxlength="20" />
                        <i class="Validform_checktip"></i>
                    </div>
                </div>
                <div class="form-item">
                    <label class="form-label">幻灯类型</label>
                    <div class="form-select form-input-block">
                        <select name="focus_type" class="dfinput" datatype="*" errormsg="请选择幻灯类型!" >
                            <option value="">--请选择幻灯类型--</option>
                            <?php if(is_array($focusType)): $i = 0; $__LIST__ = $focusType;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($data); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                        <i class="Validform_checktip"></i>
                    </div>
                </div>
                <div class="form-item">
                    <label class="form-label">url地址</label>
                    <div class="form-text form-input-block">
                        <input name="focus_url" id="focus_url" type="url" class="dfinput" />
                        <i class="Validform_checktip"></i>
                    </div>
                </div>
				<div class="form-item">
					<label class="form-label">图片</label>
					<div class="form-text form-input-inline w40">
						<input type="text" name="focus_image" id="image" datatype="*" errormsg="请上传图片!" placeholder="请上传图片" readonly/>

						<i class="Validform_checktip"></i>
                        <span style="font-size: 12px">（注：图片大小：720px*280px）</span>
					</div>

					<div class="form-button form-input-inline">
						<input class="but shenhe mg_t0" type="button" id="uploadButton"  class="chaxun but" value="上传" />
					</div>

				</div>
                <div class="form-item">
                    <label class="form-label">排序</label>
                    <div class="form-select form-input-block">
                        <select name="focus_sort" class="dfinput" datatype="*" errormsg="请选选择排列序号!" >
                            <option value="">--请选选择排列序号--</option>
                            <?php if(is_array($focusOrder)): $i = 0; $__LIST__ = $focusOrder;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($data); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                        <i class="Validform_checktip"></i>
                    </div>
                </div>
                <div class="form-item">
                    <div class="form-button form-input-block">
                        <input class="chaxun but" type="submit" value="提交"/>
                        <button class="but chongzhi" type="button" onclick="location.href='<?php echo U('focus/index');?>'">返回</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
<script type="text/javascript">
    $(function(){
        $(".right_min").height($(window).height());

        $('.skin-section input').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
        $('input').on('ifChecked', function(event){
            //alert($(this).val());
        });
    });
</script>
<script>
    $(function(){
        $("#myform").Validform({
            //tiptype:2
            tiptype:function(msg,o,cssctl){
                var objtip=o.obj.siblings(".Validform_checktip");
                cssctl(objtip,o.type);
                objtip.text(msg);
            }
        });
    });
</script>
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
    $(document).ready(function(e) {
        $("#classtype").uedSelect({
            width : 150
        });
    });
</script>