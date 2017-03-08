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

@section('content')
	<div class="wrap">
		<?php $options = unserialize($content->options) ?>
		<div class="panel-heading">View ranked list</div>
		<?php $data_id = 1 ?>
		<?php $uncontent = unserialize($content->content) ?>
		<div class="post">
		<div class="title">{!! $content->description_title !!}</div>
		@foreach($uncontent as $key => $value)
		<div>
			<div class="vote">
				<div class="vote-button" data-cid="{!! $content->id !!}" data-id="{!! $data_id !!}"></div>
				<b data-id="{!! $data_id !!}">+{!! $options[$data_id - 1]['count'] !!}</b>
			</div>
			<div class="item_title"> {!! $value['post_title'] !!} </div>
		</div>
		<div class="wraper">
		<div class="front">
			@if($value['type_card_front'] == 'image')
				<img src="/uploads/{!! $value['front_card'] !!}" style="width: 100%; height: 100%; position:absolute;" />
				<div class="text-image">{!! $value['caption1'] !!}</div>
			@else
				{!! $value['youtube_clip1'] !!}
				<div class="text-image">{!! $value['caption1'] !!}</div>
			@endif
		</div>
		</div>
		<?php $data_id++ ?>
		@endforeach
		<div class="footer">{!! $content->description_footer !!}</div>
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
	$('.vote-button').click(function() {
		
		var token = '{!! csrf_token() !!}';
		
		current_id = $(this).data('id');
		cid = $(this).data('cid');
		$.post(
		  "/vote_rankedlist",
		  {
			id: current_id,
			cid: cid,
			_token: token
		  }
		);
		
		$('b[data-id="'+current_id+'"]').html(parseInt($('b[data-id="'+current_id+'"]').html()) + 1);
	});
</script>
@endsection
