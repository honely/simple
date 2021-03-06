<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>编辑专题课程 </title>
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
        <script type="text/javascript" src="/Public/admin/js/stringOperate.js"></script>
        <script type="text/javascript" src="/Public/My97DatePicker/WdatePicker.js"></script>
        <script type="text/javascript">
            var editor;
            KindEditor.ready(function (K) {
                editor = K.create('textarea[id="lesson_content"]', {
                    uploadJson: '<?php echo U('kindeditor/upload_json',array('dir'=>image));?>',
                    fileManagerJson: '<?php echo U('kindeditor/file_manager_json');?>',
                    allowFileManager: true,
                    urlType: 'domain',
                    afterCreate: function () {
                        this.sync();
                    },
                    afterBlur: function () {
                        this.sync();
                    }
                });

                //多图
                var uploadbutton = K.uploadbutton({
                    button: K('#uploadButton')[0],
                    fieldName: 'imgFile',
                    url: '<?php echo U('kindeditor/upload_json',array('dir'=>image));?>',
                    afterUpload: function (data) {
                        if (data.error === 0) {
                            var url = K.formatUrl(data.url, 'domain');
                            K('#imagemore').val(url);
                            add_album_img(url);
                        } else {
                            alert(data.message);
                        }
                    },
                    afterError: function (str) {
                        alert('自定义错误信息: ' + str);
                    }
                });
                uploadbutton.fileBox.change(function (e) {
                    uploadbutton.submit();
                });
            });

     
             
               

            //图片插件
            function add_album_img(imgurl) {

                var val = StringOperate.add($("#course_images").val(), imgurl);
                $("#course_images").val(val);
                $("#toollist_pic").append("<li onclick=\"del_album_img(\'" + imgurl + "\',this);\"><a><img src='" + imgurl + "'><i class=\"fa fa-times-circle\"></i></a></li>");
                $('#imagemore').val("");
            }
            function del_album_img(imgurl, obj) {
                var val = StringOperate.remove($("#course_images").val(), imgurl);
                $("#course_images").val(val);
                $(obj).remove();//删除元素
            }
            //图片插件_ppt
            function add_album_img_ppt(imgurl) {

                var val = StringOperate.add($("#course_ppt").val(), imgurl);
                $("#course_ppt").val(val);
                $("#toollist_pic_ppt").append("<li onclick=\"del_album_img_ppt(\'" + imgurl + "\',this);\"><a><img src='" + imgurl + "'><i class=\"fa fa-times-circle\"></i></a></li>");
                $('#ppt_more').val("");
            }
            function del_album_img_ppt(imgurl, obj) {
                var val = StringOperate.remove($("#course_ppt").val(), imgurl);
                $("#course_ppt").val(val);
                $(obj).remove();//删除元素
            }
        </script>

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
                    <li><a href="<?php echo U('lesson/index');?>">专题课程管理</a></li>
                    <li> > </li>
                    <li><a href="###">编辑专题课程</a></li>
                </ul>
            </div>
            <div class="min">
                <div class="form_box">
                    <form  name="myform" id="myform" action="<?php echo U('lesson/editlesson',array('course_id'=>$lesson['course_id'],'lesson_id'=>$lesson['lesson_id']));?>" method="post" onsubmit="return checkfrom()">
                        <div class="form-item">
                            <label class="form-label">课程名称</label>
                            <div class="form-text form-input-block">
                                <input type="text" name="info[lesson_name]" value="<?php echo ($lesson["lesson_name"]); ?>" placeholder="请输入课程名称" id="lesson_name" maxlength="60"/>
                                <i class="lesson_name" style="display:none;color:red;">课程名称不能为空</i>
                            </div>
                        </div>
                        
                        <div class="form-item">
                            <label class="form-label">封面图</label>
                            <div class="form-text form-input-inline w40">
                                <input type="text"  name="info[lesson_image]" id="course_images"  maxlength="255" readonly value="<?php echo ($lesson["lesson_image"]); ?>"/>
                            </div>
                            <div class="form-button form-input-inline">
                                <input class="but shenhe mg_t0" type="button" id="uploadButton"  class="chaxun but" value="上传" />
                                <i class="course_images" style="display:none;color:red;">请上传封面图</i>
                                <input name="course_images" id="imagemore" type="hidden" class="dfinput" value="" readonly />
                            </div>
							<div class="form-text form-input-block w50"><i style="font-size:12px">第一张是专题封面图（图片大小203x193） ， 第二张是视频的封面图（图片大小720x376）</i></div>
                            <div class="form-text form-input-block w50">
                                <ul class="toollist_pic c" id="toollist_pic">
                                    <?php if(is_array($lesson_image)): $i = 0; $__LIST__ = $lesson_image;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$image): $mod = ($i % 2 );++$i;?><li onclick="del_album_img('<?php echo ($image); ?>',this)"><a><img src="<?php echo ($image); ?>"><i class="fa fa-times-circle"></i></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                                </ul>
                            </div>
                        </div>
						<div class="form-item">
                            <label class="form-label">课程简介</label>
                            <div class="form-text form-input-block">
                                <input type="text" name="info[lesson_remarks]" value="<?php echo ($lesson["lesson_remarks"]); ?>" placeholder="请输入课程简介" id="lesson_remarks" maxlength="100"/>
                                <i class="lesson_remarks" style="display:none;color:red;">课程简介不能为空</i>
                            </div>
                        </div>
						 <div class="form-item">
                            <label class="form-label">课程视频地址</label>
                            <div class="form-text form-input-block">
                                <input type="text" name="info[lesson_video]" value="<?php echo ($lesson["lesson_video"]); ?>" placeholder="请输入课程视频地址" id="lesson_video" maxlength="150"/>
                                <i class="lesson_video" style="display:none;color:red;">课程视频地址不能为空或输入有误</i>
                            </div>
                        </div>
						 <div class="form-item">
                            <label class="form-label">课程视频时长</label>
                            <div class="form-text form-input-block">
                                <input type="text" name="info[lesson_video_time]" value="<?php echo ($lesson["lesson_video_time"]); ?>" placeholder="请输入课程视频时长" id="lesson_video_time" maxlength="20"/>
                                <i class="lesson_video_time" style="display:none;color:red;">课程视频时长不能为空</i>
                            </div>
                        </div>
						 <div class="form-item">
                            <label class="form-label">课程音频地址</label>
                            <div class="form-text form-input-block">
                                <input type="text" name="info[lesson_audio]" value="<?php echo ($lesson["lesson_audio"]); ?>" placeholder="请输入课程音频地址" id="lesson_audio" maxlength="150"/>
                                <i class="lesson_audio" style="display:none;color:red;">课程音频地址不能为空或输入有误</i>
                            </div>
                        </div>
						
						 <div class="form-item">
                            <label class="form-label">课程音频时长</label>
                            <div class="form-text form-input-block">
                                <input type="text" name="info[lesson_audio_time]" value="<?php echo ($lesson["lesson_audio_time"]); ?>" placeholder="请输入课程音频时长" id="lesson_audio_time" maxlength="20"/>
                                <i class="lesson_audio_time" style="display:none;color:red;">课程音频时长不能为空</i>
                            </div>
                        </div>
						 <div class="form-item">
                            <label class="form-label">课程试看视频地址</label>
                            <div class="form-text form-input-block">
                                <input type="text" name="info[lesson_try_video]" value="<?php echo ($lesson["lesson_try_video"]); ?>" placeholder="请输入课程试看视频地址" id="lesson_try_video" maxlength="150"/>
                                <i class="lesson_try_video" style="display:none;color:red;">课程试看视频地址不能为空或输入有误</i>
                            </div>
                        </div>
						 <div class="form-item">
                            <label class="form-label">课程试听音频地址</label>
                            <div class="form-text form-input-block">
                                <input type="text" name="info[lesson_try_audio]" value="<?php echo ($lesson["lesson_try_audio"]); ?>" placeholder="请输入课程试听音频地址" id="lesson_try_audio" maxlength="150"/>
                                <i class="lesson_try_audio" style="display:none;color:red;">课程试听音频地址不能为空或输入有误</i>
                            </div>
                        </div>
                      
                        <div class="form-item">
                            <label class="form-label">课程介绍</label>
                            <div class="form-textarea form-input-block">
                                <textarea name="info[lesson_content]" placeholder="请输入课程介绍" id="lesson_content" maxlength="600"><?php echo ($lesson["lesson_content"]); ?></textarea>
                                <i class="lesson_content" style="display:none;color:red;">课程介绍不能为空</i>
                            </div>
                        </div>
                       
                       <div class="form-item">
                            <label class="form-label">是否热播</label>
                            <div class="form-radio form-input-block">
                                <div class="skin-section">
                                    <ul>
                                        <li>
                                            <input type="radio" name="info[lesson_ishot]" value="1"  <?php if(1 == $lesson["lesson_ishot"] ): ?>checked<?php endif; ?> >
                                            <span>非热播</span>
                                        </li>
                                        <li>
                                            <input  type="radio" name="info[lesson_ishot]" value="2" <?php if(2 == $lesson["lesson_ishot"] ): ?>checked<?php endif; ?>>
                                            <span>热播</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
						<div class="form-item">
                            <label class="form-label">是否显示价格</label>
                            <div class="form-radio form-input-block">
                                <div class="skin-section">
                                    <ul>
                                        <li>
                                            <input type="radio" name="info[lesson_showmoney]" value="1"  <?php if(1 == $lesson["lesson_showmoney"] ): ?>checked<?php endif; ?> >
                                            <span>不显示</span>
                                        </li>
                                        <li>
                                            <input  type="radio" name="info[lesson_showmoney]" value="2" <?php if(2 == $lesson["lesson_showmoney"] ): ?>checked<?php endif; ?>>
                                            <span>显示</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>                 
                        <div class="form-item">
                            <div class="form-button form-input-block">
                                <input class="chaxun but" type="submit" value="提交"/>
                             
								<button class="but chongzhi" type="button" onclick="location.href='<?php echo U('lesson/index',array('course_id'=>$lesson['course_id']));?>'">返回</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
<script>
//提交时验证
	 function checkfrom() {
		var reg=/(http|ftp|https):\/\/[\w\-_]+(\.[\w\-_]+)+([\w\-\.,@?^=%&:/~\+#]*[\w\-\@?^=%&/~\+#])?/;
        var lesson_name = document.getElementById("lesson_name").value;
        if (lesson_name == '') {
            $(".lesson_name").show();
            $('#lesson_name').focus();
            return false;
        }
        $(".lesson_name").hide();
		
		var course_images = document.getElementById("course_images").value; 
        if (course_images == '') {
            $(".course_images").show();
            $('#course_images').focus();
            return false;
        }
        $(".course_images").hide();

        var lesson_remarks = document.getElementById("lesson_remarks").value;
        if (lesson_remarks == '') {
            $(".lesson_remarks").show();
            $('#lesson_remarks').focus();
            return false;
        }
        $(".lesson_remarks").hide();
  
       
      
        var lesson_video = document.getElementById("lesson_video").value;
        if (lesson_video == '') {
            $(".lesson_video").show();
            $('#lesson_video').focus();
            return false;
        }
		
		if(!reg.test(lesson_video)){
			$(".lesson_video").show();
			$('#lesson_video').focus();
            return false;
		}
        $(".lesson_video").hide();

        var lesson_video_time = document.getElementById("lesson_video_time").value;
        if (lesson_video_time == '') {
            $(".lesson_video_time").show();
            $('#lesson_video_time').focus();
            return false;
        }
       
        $(".lesson_video_time").hide();
        
		
        var lesson_audio = document.getElementById("lesson_audio").value;
        if (lesson_audio == '') {
            $(".lesson_audio").show();
            $('#lesson_audio').focus();
            return false;
        }
		if(!reg.test(lesson_audio)){
			$(".lesson_audio").show();
			$('#lesson_audio').focus();
            return false;
		}
        $(".lesson_audio").hide();
        
        var lesson_audio_time = document.getElementById("lesson_audio_time").value;
        if (lesson_audio_time == '') {
            $(".lesson_audio_time").show();
            $('#lesson_audio_time').focus();
            return false;
        } 
        
        $(".lesson_audio_time").hide();
      
	  
        var lesson_try_video = document.getElementById("lesson_try_video").value;
        if (lesson_try_video == '') {
            $(".lesson_try_video").show();
            $('#lesson_try_video').focus();
            return false;
        }
		if(!reg.test(lesson_try_video)){
			$(".lesson_try_video").show();
			$('#lesson_try_video').focus();
            return false;
		}
        $(".lesson_try_video").hide();
		
		var lesson_try_audio = document.getElementById("lesson_try_audio").value;
        if (lesson_try_audio == '') {
            $(".lesson_try_audio").show();
            $('#lesson_try_audio').focus();
            return false;
        }
		if(!reg.test(lesson_try_audio)){
			$(".lesson_try_audio").show();
			$('#lesson_try_audio').focus();
            return false;
		}
        $(".lesson_try_audio").hide();
		
		 var lesson_content = document.getElementById("lesson_content").value;
        if (lesson_content == '') {
            $(".lesson_content").show();
            $('#lesson_content').focus();
            return false;
        }
        $(".lesson_content").hide();

      

    }
    $(function () {
        $(".right_min").height($(window).height());

        $('.skin-section input').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
        $('input').on('ifChecked', function (event) {
            var a = $(this).val();
            $("#content_isshow").val(a);
        });
    });

  
</script>