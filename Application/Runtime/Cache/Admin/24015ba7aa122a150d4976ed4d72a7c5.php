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
	</head>
	<body>
		<div class="right_min">
			<div class="crumbs_nav">
				<i class="iconfont icon-shouye"></i>
				<ul>
					<li><a href="<?php echo U('index/welcome');?>">首页</a></li>
					<li> > </li>
					<li><a href="javascript:void(0);">管理员设置</a></li>
					<li> > </li>
					<li><a href="<?php echo U('adminrole/index');?>">角色列表</a></li>
					<li> > </li>
					<li><a href="javascript:void(0);">添加角色</a></li>
				</ul>
			</div>
			<div class="min">
				<div class="form_box">
					<form name="myform" id="myform" action="<?php echo U('adminrole/addadmingroup');?>" method="post">
						<div class="form-item">
							<label class="form-label">角色名</label>
							<div class="form-text form-input-block">
								<input name="info[role_name]" id="role_name" type="text" class="dfinput" value="<?php echo ($groupinfo["role_name"]); ?>" datatype="/^[\u4E00-\u9FA5\uf900-\ufa2d]{2,10}$/" errormsg="角色名范围在2~10位之间，汉字！" maxlength="10" />
								<i class="Validform_checktip"></i>
							</div>
						</div>
						<?php if(is_array($adminmenu)): $i = 0; $__LIST__ = $adminmenu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><div class="form-item">
							<label class="form-label"><?php echo ($menu["menu_name"]); ?></label>
							<div class="form-checkbox form-input-block ">
								<dl class="checkbox-title c">
									<dt>
										<input type="checkbox" name="info[menu_id][]" type="checkbox" value="<?php echo ($menu["menu_id"]); ?>"  <?php if(in_array(($menu['menu_id']), is_array($groupinfo["role_power"])?$groupinfo["role_power"]:explode(',',$groupinfo["role_power"]))): ?>checked<?php endif; ?>/>
										<span><?php echo ($menu["menu_name"]); ?></span>
									</dt>
									<dd><i class="fa fa-chevron-up fa-flip-vertical"></i></dd>
								</dl>
								<div class="skin-section pg_t10" style="border-top: none;">
									
									
								<?php if(is_array($menu['child'])): $i = 0; $__LIST__ = $menu['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$child_): $mod = ($i % 2 );++$i;?><div class="form-item">
										
										<div class="form-checkbox form-input-block form-mg_lr40">
											<dl class="checkbox-title c">
												<dt>
													<input type="checkbox" name="info[menu_id][]" type="checkbox" value="<?php echo ($child_["menu_id"]); ?>"  <?php if(in_array(($child_['menu_id']), is_array($groupinfo["role_power"])?$groupinfo["role_power"]:explode(',',$groupinfo["role_power"]))): ?>checked<?php endif; ?>/>
													<span><?php echo ($child_["menu_name"]); ?></span>
												</dt>
												<dd><i class="fa fa-chevron-up fa-flip-vertical"></i></dd>
											</dl>
											<div class="skin-section" style="border-top: none;">
												<ul>
												<?php if(is_array($child_['child'])): $i = 0; $__LIST__ = $child_['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$child__): $mod = ($i % 2 );++$i;?><li>
														<input type="checkbox" name="info[menu_id][]" type="checkbox" value="<?php echo ($child__["menu_id"]); ?>" <?php if(in_array(($child__['menu_id']), is_array($groupinfo["role_power"])?$groupinfo["role_power"]:explode(',',$groupinfo["role_power"]))): ?>checked<?php endif; ?> >
														<span><?php echo ($child__["menu_name"]); ?></span>
													</li><?php endforeach; endif; else: echo "" ;endif; ?>
												</ul>
											</div>
											<i class="Validform_checktip"></i>
										</div>
									</div><?php endforeach; endif; else: echo "" ;endif; ?>
								</div>
							</div>
						</div><?php endforeach; endif; else: echo "" ;endif; ?>
						<div class="form-item">
							<div class="form-button form-input-block">
								<input class="chaxun but" type="submit" value="提交"/>
								<button class="but chongzhi" type="button" onclick="location.href='<?php echo U('adminrole/index');?>'">返回</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
<script src="/Public/admin/js/laydate/laydate.js"></script>
<script>
    //laydate({elem: "#hello", event: "focus"});
    var start = {
        elem: "#start",
        format: "YYYY/MM/DD",
        min: laydate.now(),
        max: "2099-06-16",
        istime: false,
        istoday: false,
        choose: function (datas) {
            end.min = datas;
            end.start = datas
        }
    };
    var end = {
        elem: "#end",
        format: "YYYY/MM/DD",
        min: laydate.now(),
        max: "2099-06-16",
        istime: false,
        istoday: false,
        choose: function (datas) {
            start.max = datas
        }
    };
    laydate(start);
    laydate(end);
</script>
<script type="text/javascript">
	$(function(){
		$(".right_min").height($(window).height());
		
		$('.form-checkbox input,.form-radio input').iCheck({
			checkboxClass: 'icheckbox_square-green',
			radioClass: 'iradio_square-green',
		});
		$('input').on('ifChecked', function(event){
		  //alert($(this).val());
		});
		$(".checkbox-title dd i").click(function(){
			$(this).toggleClass("fa-flip-vertical");
			$(this).parents().siblings(".skin-section").slideToggle(500);
		})
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