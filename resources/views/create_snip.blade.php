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
	<body class="create_snip_page">
		@include('header')
		<div class="body">
			<div class="create-snip">
				<h4> Create a SNIP</h4>
				<label>Enter a URL: <input class="create-main-url" value="http://example.com"></label><br>
				<label>Message:       <input class="create-message" value="Add your message..." maxlength="50"></label><br>
				<label>Button text:  <input class="create-btn-text" value="Click here" maxlength="50"></label><br>
				<label>Button URL: <input class="create-btn-url" value="http://example.com"></label><br>

				<button> SNIP</button>
			</div>
			<div class="preview-snip">
				<iframe src="http://example.com"></iframe>
				<div class="preview-snip-block">
					<div class="avatar"><img src="/img/header_default_photo.png" /></div>
					<div class="main">
						<div class="author">{{ Auth::user()->name }}</div><br>
						<div class="message">Add your message...</div>
						<a target="_blank" href="http://example.com" class="preview-button">Click here</a>
					</div>
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
					<a class="terms_of_service" href="/terms-of-service">Terms of Service</a>
					<a class="disclamer" href="/disclaimer">Disclamer</a>
				</div>
			</div>
		</footer>

	<script src="/js/footer.min.js"></script>
	<script>
		$('.create-message').on("change", function() {
			var message = $(this).val();
			$('.message').html(message);
		});

		$('.create-btn-text').on("change", function() {
			var text = $(this).val();
			$('.preview-button').html(text);
		});

		$('.create-btn-url').on("change", function() {
			var url = $(this).val();
			$('.preview-button').attr('href', url);
		});


		$('.create-main-url').on("change", function() {
			var url = $(this).val();
			if(isValidURL(url)) {
				$('.preview-snip iframe').attr('src', url);
				$('.create-main-url').css({'border': '1px solid green'});
			} else {
				$('.create-main-url').css({'border': '1px solid red'});
			}
		});

		$('.create-snip button').click(function() {
			var message = $('.create-message').val();
			var btn_text = $('.create-btn-text').val();
			var btn_url = $('.create-btn-url').val();
			var main_url = $('.create-main-url').val();
			var token = '{!! csrf_token() !!}';

			$.post("/user/create-snip-link",
			{
			    _token: token,
			    message: message,
			    btn_text: btn_text,
			    btn_url: btn_url,
			    main_url: main_url
			},
			function(data){
			    if(data.success == true) {
			    	$('.create-snip').html('<h4> Successfully! <br> Link: <a href="'+data.link+'">SNIP</a></h4>');
			    	$('.create-snip h4').css({'margin-top': '300px', 'line-height': '30px'});
			    }
			});
		});

		function isValidURL(str) {
		   var a  = document.createElement('a');
		   a.href = str;
		   return (a.host && a.host != window.location.host);
		}
	</script>
	</body>
</html>