<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pimboo @yield('title')</title>
	<link href="/css/style.min.css" rel="stylesheet">
	@if(\Request::is('view_flip_cards') or Request::is('viewID') or Request::is('view_trivia_quiz'))
		<link href="/css/view_flipcards.css" rel="stylesheet">
	@endif
	@yield('css')
</head>
	<body class="{!! $body_class or 'home' !!}">
		@include('header')

		@yield('content')
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
		<script src="/js/register.js" type="text/javascript"></script>
		@yield('script')
	</body>
</html>
