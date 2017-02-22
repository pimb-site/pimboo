<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Laravel</title>


	<link href="/css/app.css" rel="stylesheet">
	<link href="/css/viewID.css" rel="stylesheet">


	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
	

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Laravel</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
				<li><a href="/view_flip_cards">Flip Cards</a></li>
					@if (!Auth::guest())
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Create<span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="/add_flip_cards">Flip Cards</a></li>
								<li><a href="/add_trivia_quiz">Trivia</a></li>
							</ul>
						</li>
					@endif
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="/auth/login">Login</a></li>
						<li><a href="/auth/register">Register</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="/auth/logout">Logout</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
					@if ($content->type == "flipcards")
						<div class="panel-heading">View flip cards</div>
						<?php $data_id = 1 ?>
						<?php $uncontent = unserialize($content->content) ?>
						<div class="post">
						<div class="title">{!! $content->description_title !!}</div>
						@foreach($uncontent as $key => $value)
						<div class="set-number">{!! $data_id !!}</div>
						<div class="item_title"> {!! $value['item_title'] !!} </div>
						<div class="wrap" data-id="{!! $data_id !!}">
						
						
							@if(!isset($value['theme_front'])) <?php $value['theme_front'] = 'blue' ?>
							@endif
							@if(!isset($value['theme_back'])) <?php $value['theme_back'] = 'blue' ?>
							@endif
							
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
					@else
						<?php $data_id = 1 ?>
						<?php $uncontent = unserialize($content->content) ?>
						<div class="post">
						<div class="title">{!! $content->description_title !!}</div>
						@foreach($uncontent as $key => $value)
						<div class="set-number">{!! $data_id !!}</div>
						<div class="item_title">  Question</div>
						<div class="wrap2" data-id="{!! $data_id !!}">
						
						@if($value['type_card_front'] == 'image')
							<div class="front" data-id="{!! $data_id !!}" style="background-image: url(/uploads/{!! $value['front_card'] !!}); background-size: 640px 480px;">
								<div class="text-image">{!! $value['caption1'] !!}</div>
							</div>
						@else
							<div class="front" data-id="{!! $data_id !!}">
								{!! $value['youtube_clip1'] !!}
								<div class="text-image" style="position:relative; top:-485px;">{!! $value['caption1'] !!}</div>
							</div>
						@endif
					
						@if($value['type_card_back'] == 'image')
							<div class="back" data-id="{!! $data_id !!}" style="background-image: url(/uploads/{!! $value['back_card'] !!}); background-size: 640px 480px;">
								<div class="text-image">{!! $value['caption2'] !!}</div>
							</div>
						@else
							<div class="back" data-id="{!! $data_id !!}">
								{!! $value['youtube_clip2'] !!}
								<div class="text-image" style="position:relative; top:-485px;">{!! $value['caption2'] !!}</div>
							</div>
						@endif
						</div>
						<?php $data_id++ ?>
						@if($value['answers_type'] == 'image')
							
							@if($value['answer_img1'] != "")
								<button style="width: 310px; height: 280px;" class="answer-button button-type1" type="button" data-id="{!! $data_id !!}"><img class="test-img-answer-4" src="/uploads/{!! $value['answer_img1']!!}"><br/> {!! $value['answer1'] !!}</button>
							@else
								<button style="width: 310px; height: 70px;" class="answer-button button-type1" type="button" data-id="{!! $data_id !!}">{!! $value['answer1'] !!}</button>
							@endif
							
							@if($value['answer_img2'] != "")
								<button style="width: 310px; height: 280px;" class="answer-button button-type2" type="button" data-id="{!! $data_id !!}"><img class="test-img-answer-4" src="/uploads/{!! $value['answer_img2']!!}"><br/> {!! $value['answer2'] !!}</button>
							@else
								<button style="width: 310px; height: 70px;" class="answer-button button-type2" type="button" data-id="{!! $data_id !!}">{!! $value['answer2'] !!}</button>
							@endif
						@else
							<button style="width: 310px; height: 70px;" class="answer-button button-type1" type="button" data-id="{!! $data_id - 1 !!}">{!! $value['answer1'] !!}</button>
							<button style="width: 310px; height: 70px;" class="answer-button button-type2" type="button" data-id="{!! $data_id - 1 !!}">{!! $value['answer2'] !!}</button>
						@endif
						@endforeach
						<div id="score" style="display: hidden"></div>
						<div class="footer">{!! $content->description_footer !!}</div>
						</div>
					@endif
                </div>
            </div>
        </div>
    </div>
	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script>
    $('.wrap').on('click', function(){
        current_id = $(this).data('id');
        var wrap = $('.wrap[data-id="'+current_id+'"]');
        if($(wrap).css('-webkit-transform') == 'matrix(1, 0, 0, 1, 0, 0)') {
            $(wrap).css({'-webkit-transform':'rotateY(180deg)'});
        } else {
            $(wrap).css({'-webkit-transform':'rotateY(0deg)'});
        }
    });
	
	
	@if ($content->type == "trivia")
	var score = 0;
	var answer = 0;
	var questions = {!! $data_id !!} - 1;
	var current_question;
	var question_check = [];
	
@foreach($uncontent as $key => $value)
	question_check.push([{!! $value['answer_check1']!!}, {!! $value['answer_check2'] !!}]);
	@endforeach
	
	
	$('.button-type1').click(function() {
		current_question = $(this).data('id');
		if(question_check[current_question - 1][0] == true) {
			$('.button-type1[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type2[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type1[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type2[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type1[data-id="'+current_question+'"]').addClass('true-answer');
			$('.button-type2[data-id="'+current_question+'"]').addClass('answer-button-inactive');
			answer++;
			score++;
			if(answer == questions) {
				$('#score').html('Congratulations! You got: '+score+'/'+questions);
				$('#score').css('display', 'block');
				location.href = "#score";
			}
		} else {
			$('.button-type1[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type2[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type1[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type2[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type1[data-id="'+current_question+'"]').addClass('wrong-answer');

			if(question_check[current_question - 1][1] == true) {
				$('.button-type2[data-id="'+current_question+'"]').addClass('true-answer');
				$('.button-type2[data-id="'+current_question+'"]').css({'opacity': '0.3'});
			} else $('.button-type2[data-id="'+current_question+'"]').addClass('answer-button-inactive');
			answer++;
			if(answer == questions) {
				$('#score').html('Congratulations! You got: '+score+'/'+questions);
				$('#score').css('display', 'block');
				location.href = "#score";
			}
		}
		
		$('.wrap2[data-id="'+current_question+'"]').css({'-webkit-transform':'rotateY(180deg)'});
		
	});
	
	$('.button-type2').click(function() {
		current_question = $(this).data('id');
		if(question_check[current_question - 1][1] == true) {
			$('.button-type1[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type2[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type1[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type2[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type2[data-id="'+current_question+'"]').addClass('true-answer');
			$('.button-type1[data-id="'+current_question+'"]').addClass('answer-button-inactive');
			answer++;
			score++;
			if(answer == questions) {
				$('#score').html('Congratulations! You got: '+score+'/'+questions);
				$('#score').css('display', 'block');
				location.href = "#score";
			}
		} else {
			$('.button-type1[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type2[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type1[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type2[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type2[data-id="'+current_question+'"]').addClass('wrong-answer');
			
			if(question_check[current_question - 1][0] == true) {
				$('.button-type1[data-id="'+current_question+'"]').addClass('true-answer');
				$('.button-type1[data-id="'+current_question+'"]').css({'opacity': '0.3'});
			} else $('.button-type1[data-id="'+current_question+'"]').addClass('answer-button-inactive');
			
			answer++;
			
			if(answer == questions) {
				$('#score').html('Congratulations! You got: '+score+'/'+questions);
				$('#score').css('display', 'block');
				location.href = "#score";
			}
		}
		
		$('.wrap2[data-id="'+current_question+'"]').css({'-webkit-transform':'rotateY(180deg)'});
	});
	
	
	@endif;
	</script>
</body>
</html>