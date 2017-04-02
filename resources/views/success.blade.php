<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pimboo Home</title>
	<link href="/css/style.min.css" rel="stylesheet">
</head>
	<body class="succ">
		<header>
			<div class="left">
				<a href="/" class="logo"></a>
				<a href="#" class="text">HOME</a>
				<a href="#" class="text">PIMBOO CHARITY</a>
			</div>
			<div class="right">
				<div class="dropdown">
					<a id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<img id="header_user_photo" src="/img/header_default_photo.png" />
						<img id="header_caret" src="/img/header_caret.png" />
					</a>
					<ul class="dropdown-menu" aria-labelledby="dLabel">
						<li class="channels"><a>Channels</a></li>
						<li class="channel"><a>Julia Bondarenko</a></li>
						<li class="divider" role="separator"></li>
						<li class="hrefs"><a>Profile Settings</a></li>
						<li class="hrefs"><a>Impact</a></li>
						<li class="divider" role="separator"></li>
						<li class="hrefs"><a id="header_logout" href="/auth/logout" >Logout</a></li>
					</ul>
				</div>
				<a id="header_create" href="/add_flip_cards" >CREATE</a>
			</div>
		</header>
		<div class="body">
			<div class="wrap">
				<div class="succ">
					<img src="/img/referral_succ.png">
					<div class="row">Well done! You've successfully posted to Pimboo!</div>
					<div class="row2">Now <span>Share</span> It With The World & <span>Profit</span>!</div>
					<div class="group">
						<div class="item item-share"></div>
						<div class="item item-tweet"></div>
						<div class="item item-embed"></div>
						<div class="item item-more"></div>
					</div>
					<input type="text" value="{!! url('/viewID/') !!}/{{ $id }}" />
					<a class="view-item" href="{!! url('/viewID/') !!}/{{ $id }}">VIEW ITEM</a>
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
				<div>
					<a class="privacy_policy" href="#">Privacy Policy</a>
					<a class="terms_of_service" href="#">Terms of Service</a>
					<a class="disclamer" href="#">Disclamer</a>
				</div>
			</div>
		</footer>
		<script src="js/footer.min.js"></script>
					  <script type="text/javascript">
  $(document).ready(function(){
$('[id*="user-"]').popover({delay: { show: 500, hide: 500 }});
$('[id*="user-"]').popover('show');
$('[id*="user-"]').popover('hide');
});
</script>
	</body>
</html>