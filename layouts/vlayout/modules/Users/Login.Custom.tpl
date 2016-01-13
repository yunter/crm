{*<!--
/*********************************************************************************
**
 * The contents of this file are subject to the SHINRUN CRM
 * All Rights Reserved.
*
 ********************************************************************************/
-->*}
{strip}
<!DOCTYPE html>
<html>
	<head>
		<title>系统登录</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- for Login page we are added -->
		<link href="libraries/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="libraries/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
		<link href="libraries/bootstrap/css/jqueryBxslider.css" rel="stylesheet" />
		<script src="libraries/jquery/jquery.min.js"></script>
		<script src="libraries/jquery/boxslider/jqueryBxslider.js"></script>
		<script src="libraries/jquery/boxslider/respond.min.js"></script>
		<script>
			jQuery(document).ready(function(){
				scrollx = jQuery(window).outerWidth();
				window.scrollTo(scrollx,0);
				slider = jQuery('.bxslider').bxSlider({
				auto: true,
				pause: 3000,
				randomStart : true,
				autoHover: true
			});
			jQuery('.bx-prev, .bx-next, .bx-pager-item').live('click',function(){ slider.startAuto(); });
			}); 
		</script>
	</head>
	<body>
		<div class="container-fluid login-container">
			<div class="row-fluid">
				<div class="span4">
					<div class="logo"><img src="layouts/vlayout/skins/images/logo.png">
					<br />
					<a target="_blank" href="http://{$COMPANY_DETAILSCOMPANY_DETAILS.website}">{$COMPANY_DETAILS.name}</a>
					</div>
				</div>
				<div class="span9">
					<!--div class="helpLinks">
						< a href="https://www.shinrun.com">SHINRUN Website</a> |
						<a href="https://wiki.shinrun.com/vtiger6/">SHINRUN Wiki</a> | 
						<a href="https://www.shinrun.com/crm/videos/">SHINRUN videos </a> | 
						<a href="https://discussions.shinrun.com/">SHINRUN Forums</a>
					</div -->
				</div>
			</div>
			<div class="row-fluid">
				<div class="span12">
					<div class="content-wrapper">
						<div class="container-fluid">
							<div class="row-fluid">
								<div class="span6">
									<div class="carousal-container">
										<ul class="bxslider">
											<li>
												<div id="slide01" class="slide">
													<img src="{vimage_path('ieuper.png')}" />
												</div>
											</li>
											<li>
												<div id="slide02" class="slide">
													<img src="{vimage_path('intro01.png')}" />
												</div>
											</li>
										</ul>
									</div>
								</div>
								<div class="span6">
									<div class="login-area">
										<div class="login-box" id="loginDiv">
											<div class="">
												<h3 class="login-header">登录系统</h3>
		</div>
											<form class="form-horizontal login-form" style="margin:0;" action="index.php?module=Users&action=Login" method="POST">
			{if isset($smarty.request.error)}
			<div class="alert alert-error">
				<p>无效的用户名或密码.</p>
			</div>
			{/if}
												{if isset($smarty.request.fpError)}
													<div class="alert alert-error">
														<p>无效的用户名或邮箱</p>
													</div>
												{/if}
												{if isset($smarty.request.status)}
													<div class="alert alert-success">
														<p>邮件已送至提交的邮箱,请注意查收.</p>
													</div>
												{/if}
												{if isset($smarty.request.statusError)}
													<div class="alert alert-error">
														<p>外发邮箱服务器配置不正确.</p>
													</div>
												{/if}
												<div class="control-group">
													<label class="control-label" for="username"><b>用户名</b></label>
													<div class="controls">
														<input type="text" id="username" name="username" placeholder="请输入用户名">
													</div>
												</div>

			<div class="control-group">
													<label class="control-label" for="password"><b>密码</b></label>
				<div class="controls">
														<input type="password" id="password" name="password" placeholder="请输入密码">
													</div>
												</div>
												<div class="control-group signin-button">
													<div class="controls" id="forgotPassword">
														<button type="submit" class="btn btn-primary sbutton">登 录</button>
														&nbsp;&nbsp;&nbsp;<a>忘记密码 ?</a>
													</div>
												</div>
											</form>
											<div class="login-subscript">
												<!-- small>Powered by ShinRun.com</small -->
											</div>
				</div>
										
										<div class="login-box hide" id="forgotPasswordDiv">
											<form class="form-horizontal login-form" style="margin:0;" action="forgotPassword.php" method="POST">
												<div class="">
													<h3 class="login-header">找回密码</h3>
			</div>
			<div class="control-group">
													<label class="control-label" for="user_name"><b>用户名</b></label>
				<div class="controls">
														<input type="text" id="user_name" name="user_name" placeholder="用户名">
				</div>
			</div>
												<div class="control-group">
													<label class="control-label" for="email"><b>邮箱</b></label>
													<div class="controls">
														<input type="text" id="emailId" name="emailId"  placeholder="邮箱地址">
													</div>
		</div>
												<div class="control-group signin-button">
													<div class="controls" id="backButton">
														<input type="submit" class="btn btn-primary sbutton" value="确认" name="retrievePassword">
														&nbsp;&nbsp;&nbsp;<a>返回</a>
		</div>
	</div>
</form>
										</div>
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="navbar navbar-fixed-bottom">
			<div class="navbar-inner">
				<div class="container-fluid">
					<div class="row-fluid">
						<div class="span6 pull-left" >
							<div class="footer-content">
								<small>&#169 2004-{date('Y')}&nbsp;</small>
							</div>
						</div>
						<div class="span6 pull-right" >
							<div class="pull-right footer-icons">
								<small>{* vtranslate('LBL_CONNECT_WITH_US', $MODULE) *}&nbsp;</small>
							</div>
						</div>
					</div>   
				</div>    
			</div>   
		</div>
	</body>
	<script>
		jQuery(document).ready(function(){
			jQuery("#forgotPassword a").click(function() {
				jQuery("#loginDiv").hide();
				jQuery("#forgotPasswordDiv").show();
			});
			
			jQuery("#backButton a").click(function() {
				jQuery("#loginDiv").show();
				jQuery("#forgotPasswordDiv").hide();
			});
			
			jQuery("input[name='retrievePassword']").click(function (){
				var username = jQuery('#user_name').val();
				var email = jQuery('#emailId').val();
				
				var email1 = email.replace(/^\s+/,'').replace(/\s+$/,'');
				var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/ ;
				var illegalChars= /[\(\)\<\>\,\;\:\\\"\[\]]/ ;
				
				if(username == ''){
					alert('请输入有效用户名');
					return false;
				} else if(!emailFilter.test(email1) || email == ''){
					alert('请输入有效的邮件地址');
					return false;
				} else if(email.match(illegalChars)){
					alert( "输入的邮件地址包含有不允许的字符");
					return false;
				} else {
					return true;
				}
				
			});
		});
	</script>
</html>	
{/strip}
