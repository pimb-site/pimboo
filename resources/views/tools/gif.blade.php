@extends('tools.view')

@section('css')
	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
	

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	
@endsection

@section('tool_content')

<?php
$gif = unserialize($content->content);
?>
<div class="content-gif">

	<div class="description">{{ $content->description_text }}</div>
	<div class="gif">
		<img src="/uploads/{{ $gif[0]['gif'] }}"/>
	</div>
</div>
@endsection