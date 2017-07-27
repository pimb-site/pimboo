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
	$data_id = 1;
	?>
	<div class="content-rankedlist">
		<div class="description">{{ $content->description_text }} </div>
		@foreach($data as $keys => $val)
			@foreach($val as $key => $value)
				<div class="card" data-id="{{ $data_id }}">
					<div class="info-card">
						<div class="vote">
							<div class="vote-button" data-pid="{!! $content->id !!}" data-id="{{ $data_id }}" data-elemid="{!! $value['element_id'] !!}"></div>
							<b data-id="{{ $data_id }}">+{!! $value['votes'] !!}</b>
						</div>
						<div class="title-card">{{ $value['post_title'] }}</div>
					</div>
					<div class="rankedlist">
						<div class="sides" data-id="">
							@if($value['type_card'] == 'image')
								<div class="front"><img src="/uploads/{!! $value['image'] !!}"/></div>
							@else
								<div class="front">{!! $value['youtube'] !!}</div>
							@endif
						</div>
						<div class="click-text">{{ $value['caption'] }}</div>
					</div>
				</div>
				<?php $data_id++ ?>
			@endforeach
		@endforeach
		<div class="footer">{{ $content->description_footer }}</div>
	</div>
@endsection

@section('script')
<script>
	$(document).ready(function() {
		$('.content-rankedlist').on('click', '.vote-button', function() {
			var token = '{!! csrf_token() !!}';
			current_id = $(this).attr('data-id');
			elem_id = $(this).data('elemid');
			pid = $(this).data('pid');
			$.post(
			  "/create/rankedlist/vote",
			  {
				cid: elem_id,
				pid: pid,
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
							$('.card[data-id="'+current_id+'"]').attr('data-id', (current_id - 1));
							$('.card[data-id="'+(current_id - 1)+'"]:first').attr('data-id', (current_id));
							
							$('.vote-button[data-id="'+current_id+'"]').attr('data-id', (current_id - 1));
							$('.vote-button[data-id="'+(current_id - 1)+'"]:first').attr('data-id', (current_id));
							
							$('.vote b[data-id="'+current_id+'"]').attr('data-id', (current_id - 1));
							$('.vote b[data-id="'+(current_id - 1)+'"]:first').attr('data-id', (current_id));
							
							b_element = $('.card[data-id="'+(current_id)+'"]').html();
							
							$('.card[data-id="'+current_id+'"]').fadeToggle(500, function() {
								$('.card[data-id="'+current_id+'"]').remove();
								$('.card[data-id="'+(current_id - 1)+'"]').after('<div class="card" data-id="'+current_id+'">'+b_element+'</div>');
							});
						}
					}
				}
			}
		});
	})
</script>
@endsection
