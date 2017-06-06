<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pimboo Snip</title>
	<link href="/css/style.min.css" rel="stylesheet">
	<link href="/css/snip.css" rel="stylesheet">
</head>
	<body class="view_snip_page">
		@include('header')

		<?php
		$photo = ($user_info->photo == '') ? '/img/header_default_photo.png' : '/uploads/'.$user_info->photo;
		?>

		<div class="snip">
			<div class="adv">
				<div class="adv-image">
					<img src="/img/charity.jpg">
				</div>
				<div class="adv-href">
					<a href="#"> text adv... </a>
				</div>
			</div>
			<iframe src="{{ $snip->iframe_url }}"></iframe>
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
					<a class="terms_of_service" href="/terms-of-service">Terms of Service</a>
					<a class="disclamer" href="/disclaimer">Disclamer</a>
				</div>
			</div>
		</footer>

	<script src="/js/footer.min.js"></script>
	</body>
</html>