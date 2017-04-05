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

<?php
$current_id = 1;
$flipcards  = unserialize($content->content);
$themes = [
	'green' => '#8dc63f',
	'purple' => '#605ca8',
	'blue'  => '#009cff',
	'turquoise' => '#00a99d'
];
?>
<div class="content">
	<div class="content-flipcard">
		<div class="description">{{ $content->description_text }} </div>
		@foreach($flipcards as $key => $value)
		<div class="card">
			<div class="info-card">
				<div class="id-card">{{ $current_id++ }}</div>
				<div class="title-card">{{ $value['item_title'] }}</div>
			</div>
			<div class="flipcard">
				<div class="sides">
					@if ($value['text_front'] == "")
						<div class="front"><img src="/uploads/{{ $value['front_card'] }}"/></div>
					@else

					@endif
					@if ($value['text_back'] == "")
						<div class="back"><img src="/uploads/{{ $value['back_card'] }}"/></div>
					@else
					
					@endif
				</div>
				<div class="click-text">Click to flip</div>
			</div>
		</div>
		@endforeach
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $('.wraper').on('click', function(){
        current_id = $(this).data('id');
        var wrap = $('.wraper[data-id="'+current_id+'"]');
        if($(wrap).css('-webkit-transform') == 'matrix(1, 0, 0, 1, 0, 0)') {
            $(wrap).css({'-webkit-transform':'rotateY(180deg)'});
        } else {
            $(wrap).css({'-webkit-transform':'rotateY(0deg)'});
        }
    });
</script>
@endsection