<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pimboo Home</title>
	<link href="/css/style.min.css" rel="stylesheet">
</head>
	<body class="{!! $body_class or 'home' !!}">
		<header>
			<div class="left">
				<a href="/" class="logo"></a>
				<a href="#" class="text">HOME</a>
				<a href="#" class="text">PIMBOO CHARITY</a>
			</div>
			<div class="right">
				@if (Auth::guest())
				<button type="button" data-toggle="modal" data-target="#register-modal" id="register-button">REGISTER</button>
				<button id="login-button" onclick='window.location.href = "/auth/login"'>LOGIN</button>
				<div class="modal fade" id="register-modal" tabindex="-1" role="dialog" aria-labelledby="register-modalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-body">
								<button class="close" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<div class="title">SIGN UP</div>
								<div class="sub_title">Sign up to take advantage of our advanced features and to create your own playful content!</div>
								<div class="social_connect">
									<div class="text">SOCIAL CONNECT</div>
									<div class="facebook"></div>
									<div class="google_plus"></div>
								</div>
								<div class="middle_text">OR<BR>ENTER YOUR INFORMATION</div>
								<div class="form">
									<input type="hidden" id="register_token" name="_token" value="{{ csrf_token() }}">
									<div class="input_place">
										<div class="name">NAME</div>
										<input id="register_first_name" name="register_first_name">
									</div>
									<div class="input_place">
										<div class="name">E-MAIL</div>
										<input name="register_email" id="register_email">
									</div>
									<div class="input_place">
										<div class="name">PASSWORD</div>
										<input type="password" name="register_password" id="register_password">
									</div>
									<div class="input_place">
										<div class="name">CONFIRM PASSWORD</div>
										<input type="password" id="register_confirm_password" name="register_confirm_password">
									</div>
									<div class="alerts">

									</div>
									<button id="register-submit">REGISTER</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				@else
					<div class="dropdown">
						<a id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Dropdown trigger
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" aria-labelledby="dLabel">
							<li>Channels</li>
							<li class="divider" role="separator"><a></a></li>
							<li><a>Profile Settings</a></li>
							<li>Impact</li>
							<li class="divider" role="separator"></li>
							<li><a id="header_logout" href="/auth/logout" >Logout</a></li>
						</ul>
					</div>
					<a id="header_create" href="/create" >Create</a>
				@endif

			</div>
		</header>
@yield('content')
		<footer>
			<div class="up">
				<div class="wrap">
					<div class="left">
						Pimboo OU<br>
						Stureplan 4C, 4th floor<br>
						Stockholm, Sweden 114 35<br>
					</div>
					<div class="center">@ Pimboo.com. Allrights Reserved.</div>
					<div class="right">
						<a class="icon" id="fb_icon_footer"></a>
						<a class="icon" id="twitter_icon_footer"></a>
						<a class="icon" id="instagram_icon_footer"></a>
						<a class="icon" id="youtube_icon_footer"></a>
					</div>
				</div>
			</div>
			<div class="down">
				<a class="privacy_policy" href="#">Privacy Policy</a>
				<a class="terms_of_service" href="#">Terms of Service</a>
				<a class="disclamer" href="#">Disclamer</a>
			</div>
		</footer>
		<script src="/js/footer.min.js"></script>
		<script src="/js/register.js"></script>
	</body>
</html>
