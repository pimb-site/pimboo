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
		<?php $options = unserialize($content->options) ?>
		<div class="panel-heading">View ranked list</div>
		<?php $data_id = 1 ?>
		<?php $uncontent = unserialize($content->content) ?>
		<div class="post">
		<div class="title">{!! $content->description_title !!}</div>
		<?php
		$element_id = 1;
		
		foreach($uncontent as $key=>$value) {
			$data[$value['votes']][] = [
				'post_title' => $value['post_title'],
				'caption'    => $value['caption1'],
				'type_card'  => $value['type_card_front'],
				'youtube'    => $value['youtube_clip1'],
				'image'      => $value['front_card'],
				'votes'      => $value['votes'],
				'element_id' => $element_id
			];
			$element_id++;
		}
		krsort($data);
		?>
		@foreach($data as $keys => $val)
		@foreach($val as $key => $value)
		<div class="rlist" data-id="{!! $data_id !!}">
			<div class="vote">
				<div class="vote-button" data-cid="{!! $content->id !!}" data-id="{{ $data_id }}" data-elemid="{!! $value['element_id'] !!}"></div>
				<b data-id="{{ $data_id }}">+{!! $value['votes'] !!}</b>
			</div>
			<div class="item_title"> {!! $value['post_title'] !!} </div>
			<div class="wraper">
			<div class="front">
			@if($value['type_card'] == 'image')
				<img src="/uploads/{!! $value['image'] !!}" style="width: 100%; height: 100%; position:absolute;" />
				<div class="text-image">{!! $value['caption'] !!}</div>
			@else
				{!! $value['youtube'] !!}
				<div class="text-image">{!! $value['caption'] !!}</div>
			@endif
			</div>
			</div>
		</div>
		<?php $data_id++ ?>
		@endforeach
		@endforeach
		{!! $content->description_footer !!}
	</div>
@endsection

@section('script')
<script type="text/javascript">
	$('.post').on('click', '.vote-button', function() {
		
		var token = '{!! csrf_token() !!}';
		
		current_id = $(this).attr('data-id');
		elem_id = $(this).data('elemid');
		cid = $(this).data('cid');
		$.post(
		  "/vote_rankedlist",
		  {
			id: elem_id,
			cid: cid,
			_token: token
		  },
		  onSuccessVote
		);
		
		function onSuccessVote(data) {
			if(data.success == true) {
				
				votes_element = data.votes;
				
				$('.vote b[data-id="'+current_id+'"]').html('+'+votes_element);
				
				if(current_id != 1) {
					
					before_current_votes = parseInt($('.vote b[data-id="'+(current_id - 1)+'"]').html());
					
					if(votes_element > before_current_votes) {
						
						$('.rlist[data-id="'+current_id+'"]').attr('data-id', (current_id - 1));
						$('.rlist[data-id="'+(current_id - 1)+'"]:first').attr('data-id', (current_id));
						
						$('.vote-button[data-id="'+current_id+'"]').attr('data-id', (current_id - 1));
						$('.vote-button[data-id="'+(current_id - 1)+'"]:first').attr('data-id', (current_id));
						
						$('.vote b[data-id="'+current_id+'"]').attr('data-id', (current_id - 1));
						$('.vote b[data-id="'+(current_id - 1)+'"]:first').attr('data-id', (current_id));
						
						b_element = $('.rlist[data-id="'+(current_id)+'"]').html();
						
						$('.rlist[data-id="'+current_id+'"]').remove();
						
						$('.rlist[data-id="'+(current_id - 1)+'"]').after('<div class="rlist" data-id="'+current_id+'">'+b_element+'</div>');
						
						
					}
				}
			}
		}
	});
</script>
@endsection
