<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<title></title>
		<link rel="stylesheet" href="/css/bootstrap/bootstrap.min.css" type="text/css">
		<link rel="stylesheet" href="/css/bootstrap/bootstrap-theme.min.css" type="text/css" />
		<link rel="stylesheet" type="text/css" href="/css/style.css" />
		<script src="/js/jquery-3.2.1.min.js" type="text/javascript"></script>
		<script src="/js/bootstrap-js/bootstrap.min.js" type="text/javascript"></script>
	</head>
	<body>
	<div class="header">
		<div class="container">
			<div class="row">
				<div class="header">
					<nav class="navbar navbar-default">
						<div class="container-fluid">
							<div class="navbar-header">
								<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
							</div>
							<div class="collapse navbar-collapse" id="navbar-main">
								<ul class="nav navbar-nav">
									<li><a href="/messages">Сообщения</a></li>
									<li class="login"><a href="/">Вход</a></li>
								</ul>
							</div>
						</div>
					</nav>
				</div>
			</div>
		</div>
	</div>
	<div class="main-content">
		<div class="container">
				<div class="row">
					<div class="col-md-9 col-md-push-2 col-sm-9 col-sm-push-2">
						<?php include 'application/views/'.$content_view; ?>
					</div>
				</div>
			<div class="footer">
			</div>
		</div>
	</div>
	</body>
	<script type="text/javascript">
		window.fbAsyncInit = function() {
			FB.init({
				appId      : '1902941346633894',
				cookie     : true,
				xfbml      : true,
				version    : 'v2.8'
			});
			FB.AppEvents.logPageView();
		};

		(function(d, s, id){
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));

		if($("#currentUserId").val() != null){
			$(".login").empty();
			$(".login").append('<a href="accounts/logout">Выход</a>');
		}
	</script>
</html>