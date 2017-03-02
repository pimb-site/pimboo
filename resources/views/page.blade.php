<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pimboo Home</title>
	<link href="/css/style.min.css" rel="stylesheet">
	@if(\Request::is('view_flip_cards') or Request::is('viewID') or Request::is('view_trivia_quiz'))
		<link href="/css/app.css" rel="stylesheet">
		<link href="/css/view_flipcards.css" rel="stylesheet">
	@endif
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
