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
		<div class="snip">
			<div class="adv">
				<div class="adv-image" style="background-image: url({{ $adv['href'] }})"><a href="{{ $adv['url'] }}" style="height: 87px;"></a></div>
				<div class="adv-href">
					<div class="close"><a href="{{ $snip['iframe_url'] }}"><img src="/img/close.png" /></a></div>
					<div class="text"><a href="{{ $adv['url'] }}" target="_blank"><?php print $adv['text']; ?></a></div>
					<div class="pimboo-logo"><a href="http://pimboo.com">Powered by <img src="/img/snip-pimboo-logo.png" /> </a></div>
				</div>
			</div>
			<iframe src="{{ $snip['iframe_url'] }}"></iframe>
		</div>
		

	<script src="/js/footer.min.js"></script>
	</body>
</html>