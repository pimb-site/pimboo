@extends('tools.view')

@section('css')
	<link href="/css/viewID.css" rel="stylesheet">


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
<div class="wrap">
	<?php $uncontent = unserialize($content->content) ?>
		@foreach($uncontent as $key=>$value)
		<div class="post">
			<div class="wraper">
				<div class="front">
					<img src="/uploads/{!! $value['gif'] !!}" style="width: 100%; height: 100%; position:absolute;" />
				</div>
			</div>
		</div>
		@endforeach
	</div>
</div>
@endsection