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
		<div class="panel-heading"><a href="/view_flip_cards">View flip cards</a></div>
		<?php $data_id = 1 ?>
		<?php $uncontent = unserialize($content->content) ?>
		<div class="post">
			<div class="title">{!! $content->description_title !!}</div>
			@foreach($uncontent as $key => $value)
				<div class="set-number">{!! $data_id !!}</div>
				<div class="item_title"> {!! $value['item_title'] !!} </div>
				<div class="wraper" data-id="{!! $data_id !!}">
				
					@if($value['theme_front'] == 'green') <?php $theme_front = '#8dc63f'; ?>
					@elseif($value['theme_front'] == 'blue') <?php $theme_front = '#009cff';?>
					@elseif($value['theme_front'] == 'purple') <?php $theme_front = '#605ca8';?>
					@elseif($value['theme_front'] == 'turquoise') <?php $theme_front = '#00a99d';?>
					@endif
					
					@if($value['theme_back'] == 'green') <?php $theme_back = '#8dc63f';?>
					@elseif($value['theme_back'] == 'blue') <?php $theme_back = '#009cff';?>
					@elseif($value['theme_back'] == 'purple') <?php $theme_back = '#605ca8';?>
					@elseif($value['theme_back'] == 'turquoise') <?php $theme_back = '#00a99d'; ?>
					@endif
					
					@if ($value['text_front'] != "")
						<div class="front" data-id="{!! $data_id !!}" > <div style="width: 640px; height: 480px; color: #fff; background: {!! $theme_front !!}; text-align:center; font-size: 35px; padding-top: 150px;" class="wrap-text">{!! $value['text_front'] !!}</div> </div>
					@else
						<div class="front" data-id="{!! $data_id !!}" > <img data-id='{!! $data_id !!}' src='/uploads/{!! $value['front_card'] !!}' width='640' height='480' /></div>
					@endif
					@if ($value['text_back'] != "")
						<div class="back" data-id="{!! $data_id !!}"> <div style="width: 640px; height: 480px; color: #fff; background: {!! $theme_back !!}; text-align:center; font-size: 35px; padding-top: 150px;" class="wrap-text">{!! $value['text_back'] !!}</div></div>
					@else
						<div class="back" data-id="{!! $data_id !!}"> <img data-id='{!! $data_id !!}' src='/uploads/{!! $value['back_card'] !!}' width='640' height='480' /> </div>
					@endif
					<?php $data_id++ ?>
				</div>
			@endforeach
			<div class="footer">{!! $content->description_footer !!}</div>
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