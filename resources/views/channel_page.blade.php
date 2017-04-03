
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pimboo </title>
	<link href="/css/style.min.css" rel="stylesheet">
		</head>
	<body class="channel-page">
		<header>
			<div class="left">
				<a href="/" class="logo"></a>
				<a href="/" class="text">HOME</a>
				<a href="/charity" class="text">PIMBOO CHARITY</a>
			</div>
			@if (Auth::guest())
			<div class="right">
				<button type="button" data-toggle="modal" data-target="#register-modal" id="register-button">REGISTER</button>
				<button id="login-button" onclick="window.location.href = &quot;/login&quot;">LOGIN</button>
				<div class="modal fade" id="register-modal" tabindex="-1" role="dialog" aria-labelledby="register-modalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-body">
								<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
								<div class="title">SIGN UP</div>
								<div class="sub_title">Sign up to take advantage of our advanced features and to create your own playful content!</div>
								<div class="social_connect">
									<div class="text">SOCIAL CONNECT</div>
									<a class="facebook" href="/login/facebook"></a>
									<a class="google_plus" href="/login/google"></a>
								</div>
								<div class="middle_text">OR<br>ENTER YOUR INFORMATION</div>
								<div class="form">
									<input id="register_token" name="_token" value="LsWCjTFy1wC4lVSVimXY2fYJpAoyoSRtITmi0PXE" type="hidden">
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
										<input name="register_password" id="register_password" type="password">
									</div>
									<div class="input_place">
										<div class="name">CONFIRM PASSWORD</div>
										<input id="register_confirm_password" name="register_confirm_password" type="password">
									</div>
									<div class="alerts">

									</div>
									<button id="register-submit">REGISTER</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			@else
			<div class="right">
					<div class="dropdown">
						<a id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<img id="header_user_photo" src="/img/header_default_photo.png" />
							<img id="header_caret" src="/img/header_caret.png" />
						</a>
						<ul class="dropdown-menu" aria-labelledby="dLabel">
							<li class="channels"><a>Channels</a></li>
							<li class="channel"><a>{{ Auth::user()->name }}</a></li>
							<li class="divider" role="separator"></li>
							<li class="hrefs"><a href="/user/profile">Profile Settings</a></li>
							<li class="hrefs"><a href="/user/account">Stats</a></li>
							<li class="divider" role="separator"></li>
							<li class="hrefs"><a id="header_logout" href="/logout" >Logout</a></li>
						</ul>
					</div>
					<a id="header_create" href="/create" >CREATE</a>
			</div>
			@endif
		</header>
		<div class="body-channel">
			<?php
			$user_photo = ($user_info->photo == "") ? "/img/no_ava.png" : "/uploads/".$user_info->photo;
			$aType = [
				'rankedlist' => 'RANKED LIST',
				'flipcards'  => 'FLIP CARD',
				'trivia'     => 'TRIVIA CARD',
				'story'      => 'STORY'
			];
			?>
			<div class="cover-bg"></div>
			<div class="channel-posts">
				@foreach($channel_content as $post)
				<?php 
				$post_date    = new DateTime($post->date);
				$current_date = new DateTime();
				$days = $current_date->format("d") - $post_date->format("d");
				$month = $current_date->format("m") - $post_date->format("m");
				?>
				<div class="post">
					<div class="post-left">
						<div class="photo"> <img src="/uploads/{{ $post->description_image }}"></div>
						<div class="date">
						@if($month == 0)
							@if($days == 0)
								Posted Today
							@else 
								Posted {{ $days }} days ago
							@endif
						@else
							Posted {{ $month }} month ago
						@endif
						</div>
					</div>
					<div class="post-right">
						<div class="title">{{ $post->description_title }}</div>
						<div class="description">{{ $post->description_text }}</div>
						<div class="share">Share this <a href="#">{{ $aType[$post->type] }}</a></div>
						<div class="share-buttons">
							<button><img src="/img/view_fb.png"></button>
							<button><img src="/img/view_twitter.png"></button>
							<button><img src="/img/view_linkedin.png"></button>
							<button><img src="/img/view_link.png"></button>
							<button class="get-link">GET LINK</button>
						</div>
					</div>
				</div>
				@endforeach
				@if($show_more == true)
					<button class="show-more">SHOW MORE</button>
				@else
					<button class="show-more" style="display: none;">SHOW MORE</button>
				@endif
			</div>
			<div class="right-block">
				<div class="profile">
					<div class="information">
						<div class="avatar"><img src="{{ $user_photo }}"></div>
						<div class="name">{{ $user_info->name }}</div>
						<div class="subscribers"><b>0</b> SUBSCRIBERS</div>
						<div class="description"> {{ $user_info->public_info}} </div>
						<div class="social-subscribe">
							<button><img src="/img/profile_website_icon.png"></button>
							<button><img src="/img/profile_fb_icon.png"></button>
							<button><img src="/img/profile_twitter_icon.png"></button>
							<button><img src="/img/profile_google_plus_icon.png"></button>
						</div>
						<button class="subscribe-me">SUBSCRIBE</button>
					</div>
				</div>
				<div class="filter">
					<div class="title">FILTER</div>
					<div class="text">Choose cards</div>
					<form action="/channel-filter" method="post" id="channel-filter">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="channel_id" value="{{ $user_info->id }}" />
					<input type="hidden" name="multiplier" value="1" />
					<div class="cards-left">
						<div class="item">
							<input type="checkbox" id="test1" value="trivia" name="types[]" checked autocomplete="off" />
	    					<label for="test1">Trivia card</label>
    					</div>
    					<div class="item">
							<input type="checkbox" id="test2" value="flipcards" name="types[]" checked autocomplete="off"/>
	    					<label for="test2">Flip Card</label>
    					</div>
    				</div>
    				<div class="cards-right">
    					<div class="item">
							<input type="checkbox" id="test3" value="story" name="types[]" checked autocomplete="off"/>
	    					<label for="test3">Story</label>
    					</div>
    					<div class="item">
							<input type="checkbox" id="test4" value="rankedlist" name="types[]" checked autocomplete="off"/>
	    					<label for="test4">Ranked list</label>
    					</div>
					</div>
					</form>
					<button class="run-filter">FILTER</button>
				</div>
			</div>
		</div>
		<footer>
			<div class="up">
				<div class="wrap">
					<div class="left">
						Pimboo OÜ<br>
						Laki tn 30 PK 302-3<br>
						Tallinn, Estonia 12915<br>
					</div>
					<div class="center">© Copyright Pimboo.com All Rights Reserved.</div>
					<div class="right">
						<a class="icon" target="_blank" href="https://www.facebook.com/pimboosocial" id="fb_icon_footer"></a>
						<a class="icon" target="_blank" href="https://twitter.com/pimboosocial" id="twitter_icon_footer"></a>
						<a class="icon" target="_blank" href="https://www.instagram.com/pimboosocial/" id="instagram_icon_footer"></a>
						<a class="icon" target="_blank" href="https://www.youtube.com/channel/UC6mXWfi-sXptlqRJ8Nr7qoQ" id="youtube_icon_footer"></a>
					</div>
				</div>
			</div>
			<div class="down">
				<div>
					<a class="privacy_policy" href="/privacy-policy">Privacy Policy</a>
					<a class="terms_of_service" href="/privacy-policy">Terms of Service</a>
					<a class="disclamer" href="/privacy-policy">Disclamer</a>
				</div>
			</div>
		</footer>
		<script src="/js/footer.min.js" type="text/javascript"></script>
		<script src="/js/channel.js" type="text/javascript"></script>
		</body>
</html>
