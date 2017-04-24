		<header>
			<div class="left">
				<a href="/" class="logo"></a>
				<a href="/" class="text" id="header_home">HOME</a>
				<a href="/charity" class="text" id="header_charity">PIMBOO CHARITY</a>
			</div>
			<div class="right">
				@if (Auth::guest())
				<button type="button" data-toggle="modal" data-target="#register-modal" id="register-button">REGISTER</button>
				<button id="login-button" onclick='window.location.href = "/login"'>LOGIN</button>
				<div class="modal fade" id="register-modal" tabindex="-1" role="dialog" aria-labelledby="register-modalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-body">
								<button class="close" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<div class="title">SIGN UP</div>
								<div class="sub_title">Sign up to take advantage of our advanced features and to create your own playful content!</div>
								<div class="social_connect">
									<div class="text">SOCIAL CONNECT</div>
									<a class="facebook" href="/login/facebook"></a>
									<a class="google_plus" href="/login/google"></a>
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
							<img id="header_user_photo" src="/img/header_default_photo.png" />
							<img id="header_caret" src="/img/header_caret.png" />
						</a>
						<ul class="dropdown-menu" aria-labelledby="dLabel">
							<li class="channels"><a>Channels</a></li>
							<li class="channel"><a href="/channel/{{ Auth::user()->id }}">{{ Auth::user()->name }}</a></li>
							<li class="divider" role="separator"></li>
							<li class="hrefs"><a href="/user/profile">Profile Settings</a></li>
							@if (Auth::user()->permission == 10)
								<li class="hrefs"><a href="/admin">Admin Area</a></li>
							@endif
							<li class="hrefs"><a href="/user/account">Stats</a></li>
							<li class="divider" role="separator"></li>
							<li class="hrefs"><a id="header_logout" href="/logout" >Logout</a></li>
						</ul>
					</div>
					<a id="header_create" href="/create" >CREATE</a>
				@endif

			</div>
		</header>