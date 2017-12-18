<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>添加专题 </title>
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
                editor = K.create('textarea[id="course_content"]', {
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

            var editor1;
            KindEditor.ready(function (K) {
                editor1 = K.create('textarea[id="course_content"]', {
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
                //多图——ppt
                var uploadbutton1 = K.uploadbutton({
                    button: K('#uploadButton_ppt')[0],
                    fieldName: 'imgFile',
                    url: '<?php echo U('kindeditor/upload_json',array('dir'=>image));?>',
                    afterUpload: function (data) {
                        if (data.error === 0) {
                            var url = K.formatUrl(data.url, 'domain');
                            K('#pptmore').val(url);
                            add_album_img_ppt(url);
                        } else {
                            alert(data.message);
                        }
                    },
                    afterError: function (str) {
                        alert('自定义错误信息: ' + str);
                    }
                });
                uploadbutton1.fileBox.change(function (e) {
                    uploadbutton1.submit();
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
                    <li><a href="<?php echo U('course/index');?>">课程专题管理</a></li>
                    <li> > </li>
                    <li><a href="###">添加课程专题</a></li>
                </ul>
            </div>
            <div class="min">
                <div class="form_box">
                    <form  name="myform" id="myform" action="<?php echo U('course/addcourse');?>" method="post" onsubmit="return check()">
                        <div class="form-item">
                            <label class="form-label">专题名称</label>
                            <div class="form-text form-input-block">
                                <input type="text" name="info[course_name]" value="" placeholder="请输入专题名称" id="course_name" maxlength="60"/>
                                <i class="course_name" style="display:none;color:red;">专题名称不能为空</i>
                            </div>
                        </div>
						<div class="form-item">
                            <label class="form-label">专题简介</label>
                            <div class="form-text form-input-block">
                                <input type="text" name="info[course_remarks]" value="" placeholder="请输入专题简介" id="course_remarks" maxlength="100"/>
                                <i class="course_remarks" style="display:none;color:red;">专题简介不能为空</i>
                            </div>
                        </div>
						
                        <div class="form-item">
                            <label class="form-label">所属分类</label>
                            <div class="form-select form-input-block">
                                <select id="classify_id" name="info[classify_id]">
                                    <option value="" >--请选择--</option>
                                    <?php if(is_array($classifies)): $i = 0; $__LIST__ = $classifies;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><option value="<?php echo ($data["classify_id"]); ?>"><?php echo ($data["classify_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                                <i class="classify_id" style="display:none;color:red;">请选择所属分类</i>
                            </div>
                        </div>  
                        <div class="form-item">
                            <label class="form-label">封面图</label>
                            <div class="form-text form-input-inline w40">
                                <input type="text"  name="info[course_images]" id="course_images"  maxlength="255" readonly />
                            </div>
                            <div class="form-button form-input-inline">
                                <input class="but shenhe mg_t0" type="button" id="uploadButton"  class="chaxun but" value="上传" />
                                <i class="course_images" style="display:none;color:red;">请上传封面图</i>
                                <input name="course_images" id="imagemore" type="hidden" class="dfinput" value="" readonly />
                            </div>
							<div class="form-text form-input-block w50"><i style="font-size:12px">第一张是专题封面图（图片大小203x193） ， 第二张是视频的封面图（图片大小720x376）</i></div>
                            <div class="form-text form-input-block w50">
                                <ul class="toollist_pic c" id="toollist_pic">
                                </ul>
                            </div>
                        </div>

                        <div class="form-item" style="display:none">
                            <label class="form-label">专题PPT</label>
                            <div class="form-text form-input-inline w40">
                                <input type="text"  name="info[course_ppt]" id="course_ppt"  maxlength="255" readonly />
                            </div>
                            <div class="form-button form-input-inline">
                                <input class="but shenhe mg_t0" type="button" id="uploadButton_ppt"  class="chaxun but" value="上传" />
                                <i class="course_ppt" style="display:none;color:red;">请上传专题PPT</i>
                                <input name="course_ppt" id="pptmore" type="hidden" class="dfinput" value="" readonly />
                            </div>
                            <div class="form-text form-input-block w50">
                                <ul class="toollist_pic c" id="toollist_pic_ppt">
                                </ul>
                            </div>
                        </div>

                        <div class="form-item">
                            <label class="form-label">年费</label>
                            <div class="form-text form-input-block w50">
                                <input type="text" name="info[course_money]" value="" placeholder="请输入年费" id="course_money" onkeyup="this.value = this.value.replace(/[^\d\.]/g, '')" maxlength="6"/>
                                <i class="course_money" style="display:none;color:red;">年费不能为空</i>
                            </div>
                        </div>
                        <div class="form-item">
                            <label class="form-label">抢购价</label>
                            <div class="form-text form-input-block w50">
                                <input type="text" name="info[course_limit]" value="0" placeholder="请输入抢购价" id="course_limit" onkeyup="this.value = this.value.replace(/[^\d\.]/g, '')" maxlength="6"/>
                                <i class="course_limit" style="display:none;color:red;">抢购价不能为空</i>
                            </div>
                        </div>
                        <div class="form-item">
                            <label class="form-label">抢购截止时间</label>
                            <div class="form-text form-input-block w50">
                                <input readonly type="text" name="info[course_limittime]" value="<?php echo (date("Y-m-d H:i:s",SYS_TIME)); ?>" placeholder="请选择截止时间" id="course_limittime"  onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"/>
                                <i class="course_limittime" style="display:none;color:red;">抢购截止时间不能为空</i>
								<i style="font-size:12px">如果不抢购，抢购时间设置一个过去时间即可</i>
                            </div>
                        </div> 

                        <div class="form-item">
                            <label class="form-label">总集数</label>
                            <div class="form-text form-input-block">
                                <input type="text" name="info[course_allparts]" value="" placeholder="请输入总集数" id="course_allparts" maxlength="5" onkeyup="this.value = this.value.replace(/[^\d]/g, '')"/>
                                <i class="course_allparts" style="display:none;color:red;">总集数不能为空</i>
                            </div>
                        </div>
						<div class="form-item">
                            <label class="form-label">集数更新说明</label>
                            <div class="form-text form-input-block">
                                <input type="text" name="info[course_partremarks]" value="" placeholder="请输入集数更新说明" id="course_partremarks" maxlength="20"/>
                                <i class="course_partremarks" style="display:none;color:red;">集数更新说明不能为空</i>
                            </div>
                        </div>
                        <div class="form-item" style="display:none">
                            <label class="form-label">主讲老师</label>
                            <div class="form-text form-input-block">
                                <input type="text" name="info[course_speaker]" value="" placeholder="请输入主讲老师" id="course_speaker" maxlength="12"/>
                                <i class="course_speaker" style="display:none;color:red;">主讲老师不能为空</i>
                            </div>
                        </div>
                        <div class="form-item" style="display:none">
                            <label class="form-label">讲师介绍</label>
                            <div class="form-textarea form-input-block">
                                <textarea name="info[speaker_remarks]" placeholder="请输入讲师介绍" id="speaker_remarks" maxlength="500"></textarea>
                                <i class="speaker_remarks" style="display:none;color:red;">讲师介绍不能为空</i>
                            </div>
                        </div>
                        <div class="form-item">
                            <label class="form-label">专题内容</label>
                            <div class="form-textarea form-input-block">
                                <textarea name="info[course_content]" placeholder="请输入专题内容" id="course_content" maxlength="600"></textarea>
                                <i class="course_content" style="display:none;color:red;">专题内容不能为空</i>
                            </div>
                        </div>
                       
						<div class="form-item">
                            <label class="form-label">是否显示价格</label>
                            <div class="form-radio form-input-block">
                                <div class="skin-section">
                                    <ul>
                                        <li>
                                            <input type="radio" name="info[course_showmoney]" value="1"  checked >
                                            <span>不显示</span>
                                        </li>
                                        <li>
                                            <input  type="radio" name="info[course_showmoney]" value="2" >
                                            <span>显示</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="form-item">
                            <label class="form-label">排序</label>
                            <div class="form-text form-input-block w50">
                                <input type="text" name="info[course_sort]" value="" placeholder="请输入排序" id="course_sort" maxlength="5" onkeyup="this.value = this.value.replace(/[^\d]/g, '')"/>
                                <i class="course_sort" style="display:none;color:red;">排序不能为空</i>
                            </div>
                        </div>
                        
                        <div class="form-item">
                            <div class="form-button form-input-block">
                                <input class="chaxun but" type="submit" value="提交"/>
                               
								<button class="but chongzhi" type="button" onclick="location.href='<?php echo U('course/index');?>'">返回</button>
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
    function check() {
        var course_name = document.getElementById("course_name").value;
        if (course_name == '') {
            $(".course_name").show();
            $('#course_name').focus();
            return false;
        }
        $(".course_name").hide();

		var course_remarks = document.getElementById("course_remarks").value;
        if (course_remarks == '') {
            $(".course_remarks").show();
            $('#course_remarks').focus();
            return false;
        }
        $(".course_remarks").hide();
		
        var classify_id = document.getElementById("classify_id").value;
        if (classify_id == '') {
            $(".classify_id").show();
            $('#classify_id').focus();
            return false;
        }
        $(".classify_id").hide();

        var course_images = document.getElementById("course_images").value;
        if (course_images == '') {
            $(".course_images").show();
            $('#course_images').focus();
            return false;
        }
        $(".course_images").hide();
/*
        var course_ppt = document.getElementById("course_ppt").value;
        if (course_ppt == '') {
            $(".course_ppt").show();
            $('#course_ppt').focus();
            return false;
        }
        $(".course_ppt").hide();
*/
        var course_money = document.getElementById("course_money").value;
        if (course_money == '') {
            $(".course_money").show();
            $('#course_money').focus();
            return false;
        }
        if (!course_money.match(/^\d+(\.\d+)?$/)) {
            alert("年费只能是整数或小数");
            $('#course_money').focus();
            return false;
        }
        $(".course_money").hide();

        var course_limit = document.getElementById("course_limit").value;
        if (course_limit == '') {
            $(".course_limit").show();
            $('#course_limit').focus();
            return false;
        }
        if (!course_limit.match(/^\d+(\.\d+)?$/)) {
            alert("抢购价只能是整数或小数");
            $('#course_limit').focus();
            return false;
        }
        $(".course_limit").hide();
        
        var course_limittime = document.getElementById("course_limittime").value;
        if (course_limittime == '') {
            $(".course_limittime").show();
            $('#course_limittime').focus();
            return false;
        }
        $(".course_limittime").hide();

        var course_allparts = document.getElementById("course_allparts").value;
        if (course_allparts == '') {
            $(".course_allparts").show();
            $('#course_allparts').focus();
            return false;
        }
        if (parseInt(course_allparts) < parseInt($("#epsdo_number").val())) {
            alert("总集数不能小于已经添加的集数");
            $('#course_allparts').focus();
            return false;
        }
        $(".course_allparts").hide();

        var course_content = document.getElementById("course_content").value;
        if (course_content == '') {
            $(".course_content").show();
            $('#course_content').focus();
            return false;
        }
        $(".course_content").hide();

        var course_sort = document.getElementById("course_sort").value;
        if (course_sort == '') {
            $(".course_sort").show();
            $('#course_sort').focus();
            return false;
        }
        $(".course_sort").hide();

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