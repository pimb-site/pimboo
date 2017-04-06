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
$current_id = 1;
$trivia  = unserialize($content->content);
?>
<div class="content-trivia">
	<div class="description">{{ $content->description_text }}</div>
	<div class="choose-question-buttons">
		<div class="text">Choose a question</div>
		@for ($i = 1; $i <= count($trivia); $i++)
			<div class="item" data-id="{{ $i }}">{{ $i }}</div>
		@endfor
	</div>
	@foreach($trivia as $key => $value)
	<div class="card" id="card{{ $current_id }}">
		<div class="info-card">
			<div class="id-card">{{ $current_id }}</div>
			<div class="title-card"></div>
		</div>
		<div class="trivia">
			<div class="sides" data-id="{{ $current_id++ }}">
			@if($value['type_card_front'] == "image")
				<div class="front">
					<img src="/uploads/{{ $value['front_card'] }}"/>
					<div class="caption-text">{{ $value['caption1'] }}</div>
				</div>
			@else
				<div class="front">{!! $value['youtube_clip1'] !!} <div class="caption-text">{{ $value['caption1'] }}</div></div>
			@endif

			@if($value['type_card_back'] == "image")
				<div class="back">
					<img src="/uploads/{{ $value['back_card'] }}"/>
					<div class="caption-text">{{ $value['caption2'] }}</div>
				</div>
			@else
				<div class="back">{!! $value['youtube_clip2'] !!} <div class="caption-text">{{ $value['caption1'] }}</div></div>
			@endif
			</div>
		</div>
		<button data-id="{{ $current_id - 1 }}" data-answer="1" class="btn-answer">{{ $value['answer1'] }}</button>
		<button data-id="{{ $current_id - 1 }}" data-answer="2" class="btn-answer">{{ $value['answer2'] }}</button>
	</div>
	@endforeach
	<div class="footer">{{ $content->description_footer }}</div>
</div>
@endsection

@section('script')
<script type="text/javascript">
	// Trivia: Answer to the question

	var score = 0;
	var answer = 0;
	var questions = {!! $current_id !!} - 1;
	var question_selection = [];

	@foreach($trivia as $key => $value)
		question_selection.push([{!! $value['answer_check1']!!}, {!! $value['answer_check2'] !!} ]);
	@endforeach

	$('.btn-answer').click(function() {
		question_id = $(this).data('id');
		answer_id   = $(this).data('answer');

		if(answer_id == 1) {
			// If btn1 is true
			if(question_selection[question_id - 1][0] == true) {
				$('.btn-answer[data-id="'+question_id+'"][data-answer="1"]').prop( 'disabled', true );
				$('.btn-answer[data-id="'+question_id+'"][data-answer="2"]').prop( 'disabled', true );
				$('.btn-answer[data-id="'+question_id+'"][data-answer="1"]').addClass('true-btn');
				$('.btn-answer[data-id="'+question_id+'"][data-answer="2"]').addClass('unknown-btn');
				$('.item[data-id="'+question_id+'"]').addClass('item-true');
			}
			// else  btn1 is false
			else {
				$('.btn-answer[data-id="'+question_id+'"][data-answer="1"]').prop( 'disabled', true );
				$('.btn-answer[data-id="'+question_id+'"][data-answer="2"]').prop( 'disabled', true );
				$('.btn-answer[data-id="'+question_id+'"][data-answer="1"]').addClass('false-btn');
				$('.btn-answer[data-id="'+question_id+'"][data-answer="2"]').addClass('unknown-btn');
				$('.item[data-id="'+question_id+'"]').addClass('item-false');
			}
		}
		else {
			// If btn2 is true
			if(question_selection[question_id - 1][1] == true) {
				$('.btn-answer[data-id="'+question_id+'"][data-answer="1"]').prop( 'disabled', true );
				$('.btn-answer[data-id="'+question_id+'"][data-answer="2"]').prop( 'disabled', true );
				$('.btn-answer[data-id="'+question_id+'"][data-answer="2"]').addClass('true-btn');
				$('.btn-answer[data-id="'+question_id+'"][data-answer="1"]').addClass('unknown-btn');
				$('.item[data-id="'+question_id+'"]').addClass('item-true');

			}
			// else btn2 is false
			else {
				$('.btn-answer[data-id="'+question_id+'"][data-answer="1"]').prop( 'disabled', true );
				$('.btn-answer[data-id="'+question_id+'"][data-answer="2"]').prop( 'disabled', true );
				$('.btn-answer[data-id="'+question_id+'"][data-answer="2"]').addClass('false-btn');
				$('.btn-answer[data-id="'+question_id+'"][data-answer="1"]').addClass('unknown-btn');
				$('.item[data-id="'+question_id+'"]').addClass('item-false');
			}
		}
		$('.sides[data-id="'+question_id+'"]').css({'-webkit-transform':'rotateY(180deg)'});
	});

	$('.item').click(function() {
		item_id = $(this).data('id');
		to_element = '#card'+item_id;
		$('body').animate({
            scrollTop: $(to_element).offset().top}, 2000);
        return false; 
	});
</script>
@endsection

