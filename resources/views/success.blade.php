<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Successfully upload</title>
	
	<link href="/css/success_flipcards.css" rel="stylesheet">
</head>
<body>
<div class="main">
	<div class="row1">Way to go! You've successfully published:</div>
	<div class="row2">Lorem ipsum dolor sit amet</div>
	<div class="group">
		<div class="item item-share">SHARE</div>
		<div class="item item-tweet">TWEET</div>
		<div class="item item-embed">&lt; &frasl; &gt; EMBED</div>
		<div class="item item-more">MORE SHARE OPTION</div>
	</div>
	<input class="url-id" value="{!! url('/viewID/') !!}/{{ $id }}" />
	<button class="view-item">VIEW ITEM</button>
</div>
	<!-- Scripts -->
	<script src="/js/footer.min.js"></script>
	<script> 
	$('.view-item').click(function() {
		var url = $('.url-id').val();
		$( location ).attr("href", url);
	});
	</script>
</body>
</html>