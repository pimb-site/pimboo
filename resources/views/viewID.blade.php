<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pimboo - Create a new Flip Cards</title>
	<link href="/css/style.min.css" rel="stylesheet">
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
	<body class="add_flip_cards">
		<header>
			<div class="left">
				<a href="/" class="logo"></a>
				<a href="#" class="text">HOME</a>
				<a href="#" class="text">PIMBOO CHARITY</a>
			</div>
			<div class="right">
				<div class="dropdown">
					<a id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<img id="header_user_photo" src="/img/header_default_photo.png" />
						<img id="header_caret" src="/img/header_caret.png" />
					</a>
					<ul class="dropdown-menu" aria-labelledby="dLabel">
						<li class="channels"><a>Channels</a></li>
						<li class="channel"><a>{{ Auth::user()->name }}</a></li>
						<li class="divider" role="separator"></li>
						<li class="hrefs"><a>Profile Settings</a></li>
						<li class="hrefs"><a>Impact</a></li>
						<li class="divider" role="separator"></li>
						<li class="hrefs"><a id="header_logout" href="/auth/logout" >Logout</a></li>
					</ul>
				</div>
				<a id="header_create" href="/add_flip_cards" >CREATE</a>
			</div>
		</header>
		<div class="body">
		    <div class="container">
		        <div class="row">
		            <div class="col-md-10 col-md-offset-1">
		                <div class="panel panel-default">
							@if ($content->type == "flipcards")
								<div class="panel-heading"><a href="/view_flip_cards">View flip cards</a></div>
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
										<div class="front" data-id="{!! $data_id !!}" > <div style="width: 640px; height: 480px; color: #fff; background: {!! $theme_front !!}; text-align:center; font-size: 35px; padding-top: 150px; white-space: pre-line;" class="wrap-text">{!! $value['text_front'] !!}</div> </div>
									@else
										<div class="front" data-id="{!! $data_id !!}" > <img data-id='{!! $data_id !!}' src='/uploads/{!! $value['front_card'] !!}' width='640' height='480' /></div>
									@endif
									@if ($value['text_back'] != "")
										<div class="back" data-id="{!! $data_id !!}"> <div style="width: 640px; height: 480px; color: #fff; background: {!! $theme_back !!}; text-align:center; font-size: 35px; padding-top: 150px; white-space: pre-line;" class="wrap-text">{!! $value['text_back'] !!}</div></div>
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
								<div class="item_title"> {!! $value['item_title'] !!} </div>
								<div class="wrap2" data-id="{!! $data_id !!}">
									<div class="front" data-id="{!! $data_id !!}" style="background-image: url(/uploads/{!! $value['front_card'] !!}); background-size: 640px 480px;">
										<div class="text-image">{!! $value['caption'] !!}</div>
									</div>
								</div>
								@if ($value['main_type'] == 2)
									@if ($value['answer3'] != '')
										@if($value['answer4'] != '')
											@if($value['answer_img1'] != '')
												<button style="width: 160px; height: 280px;" class="answer-button button-type1" type="button" data-id="{!! $data_id !!}"><img class="test-img-answer-4" src="/uploads/{!! $value['answer_img1']!!}"><br/> {!! $value['answer1'] !!}</button>
											@else
												<button style="width: 310px; height: 70px;" class="answer-button button-type1" type="button" data-id="{!! $data_id !!}">{!! $value['answer1'] !!}</button>
											@endif
											
											@if($value['answer_img2'] != '')
												<button style="width: 160px; height: 280px;" class="answer-button button-type2" type="button" data-id="{!! $data_id !!}"><img class="test-img-answer-4" src="/uploads/{!! $value['answer_img2']!!}"><br/> {!! $value['answer1'] !!}</button>
											@else
												<button style="width: 310px; height: 70px;" class="answer-button button-type2" type="button" data-id="{!! $data_id !!}">{!! $value['answer2'] !!}</button>
											@endif
											
										@else
											
											@if($value['answer_img1'] != '')
												<button style="width: 213px; height: 230px;" class="answer-button button-type1" type="button" data-id="{!! $data_id !!}"><img class="test-img-answer-3" src="/uploads/{!! $value['answer_img1']!!}"> <br/>{!! $value['answer1'] !!}</button>
											@else
												<button style="width: 213px; height: 70px;" class="answer-button button-type1" type="button" data-id="{!! $data_id !!}">{!! $value['answer1'] !!}</button>
											@endif
										
											@if($value['answer_img2'] != '')
												<button style="width: 213px; height: 230px;" class="answer-button button-type2" type="button" data-id="{!! $data_id !!}"><img class="test-img-answer-3" src="/uploads/{!! $value['answer_img2']!!}"> <br/>{!! $value['answer2'] !!}</button></br>
											@else 
												<button style="width: 213px; height: 70px;" class="answer-button button-type2" type="button" data-id="{!! $data_id !!}">{!! $value['answer2'] !!}</button></br>
											@endif
										@endif
									@else
										<div class="buttons-test">
										@if($value['answer_img1'] != '')
											<button style="width: 310px; height: 280px;" class="answer-button button-type1" type="button" data-id="{!! $data_id !!}"><img class="test-img-answer" src="/uploads/{!! $value['answer_img1']!!}"><br/> {!! $value['answer1'] !!}</button>
										@else 
											<button style="width: 310px; height: 70px;" class="answer-button button-type1" type="button" data-id="{!! $data_id !!}">{!! $value['answer1'] !!}</button>
										@endif
										@if($value['answer_img2'] != '')
											<button style="width: 310px; height: 280px;" class="answer-button button-type2" type="button" data-id="{!! $data_id !!}"><img class="test-img-answer" src="/uploads/{!! $value['answer_img2']!!}"> <br/>{!! $value['answer2'] !!}</button>
										@else 
											<button style="width: 310px; height: 70px;" class="answer-button button-type2" type="button" data-id="{!! $data_id !!}">{!! $value['answer2'] !!}</button>
										@endif
										</div>
									@endif
									@if ($value['answer3'] != '') 
										@if($value['answer_img1'] != '' or $value['answer_img2'] != '' or $value['answer_img3'] != '')
											<button style="width: 110px; height: 70px;" class="answer-button button-type3" type="button" data-id="{!! $data_id !!}">{!! $value['answer3'] !!}</button></br>
										@else
											<button style="width: 640px; height: 38px;" class="answer-button button-type3" type="button" data-id="{!! $data_id !!}">{!! $value['answer3'] !!}</button></br>
										@endif
									@endif
									@if ($value['answer4'] != '')
										<button style="width: 640px; height: 38px;" class="answer-button button-type4" type="button" data-id="{!! $data_id !!}">{!! $value['answer4'] !!}</button></br>
									@endif
								@else
									@if ($value['answer3'] != '')
										<button style="width: 640px; height: 38px;" class="answer-button button-type1" type="button" data-id="{!! $data_id !!}">{!! $value['answer1'] !!}</button>
										<button style="width: 640px; height: 38px;" class="answer-button button-type2" type="button" data-id="{!! $data_id !!}">{!! $value['answer2'] !!}</button></br>
									@else
										<button style="width: 310px; height: 70px;" class="answer-button button-type1" type="button" data-id="{!! $data_id !!}">{!! $value['answer1'] !!}</button>
										<button style="width: 310px; height: 70px;" class="answer-button button-type2" type="button" data-id="{!! $data_id !!}">{!! $value['answer2'] !!}</button></br>
									@endif
									@if ($value['answer3'] != '') <button style="width: 640px; height: 38px;" class="answer-button button-type3" type="button" data-id="{!! $data_id !!}">{!! $value['answer3'] !!}</button></br>
									@endif
									@if ($value['answer4'] != '') <button style="width: 640px; height: 38px;" class="answer-button button-type4" type="button" data-id="{!! $data_id !!}">{!! $value['answer4'] !!}</button></br>
									@endif
								@endif
								<?php $data_id++ ?>
								@endforeach
								<div id="score" style="display: hidden"></div>
								<div class="footer">{!! $content->description_footer !!}</div>
								</div>
							@endif
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
		<footer>
			<div class="up">
				<div class="wrap">
					<div class="left">
						Pimboo OU<br>
						Stureplan 4C, 4th floor<br>
						Stockholm, Sweden 114 35<br>
					</div>
					<div class="center">@ Pimboo.com. Allrights Reserved.</div>
					<div class="right">
						<a class="icon" id="fb_icon_footer"></a>
						<a class="icon" id="twitter_icon_footer"></a>
						<a class="icon" id="instagram_icon_footer"></a>
						<a class="icon" id="youtube_icon_footer"></a>
					</div>
				</div>
			</div>
			<div class="down">
				<a class="privacy_policy" href="#">Privacy Policy</a>
				<a class="terms_of_service" href="#">Terms of Service</a>
				<a class="disclamer" href="#">Disclamer</a>
			</div>
		</footer>

		<div id="modal-alert" class="modal-alert" style="display:none;">
			<div class="popup__body"><div class="js-img"></div></div>
		</div>
		
		<div id="popup" class="popup" style="display: none;">
		<div class="modal-text-photo">ADD PHOTO</div>
			<div class="modal-upload-column-img">
				<div class="popup__body"><div class="js-img"></div></div>
			</div>
			<div class="img-credentials">
				<input type="text" placeholder="Image credentials">
				<div class="js-upload btn btn_browse btn_browse_small">DONE</div>
			</div>
		</div>
		
		
		<div id="preview-modal" class="preview-modal" style="display: none;">
			<div class="main-preview">
				<div class="title">FLIP CARD PREVIEW</div>
				<div class="flipcard_main">
					<div class="flipcard_main_all">
						<div class="flipcard_main_title"></div>
						<div class="flipcard_main_description">
						</div>
						<div class="flipcard_main_tags">Tags: <b></b></div>
						<div class="flipcard_main_author">
							<img src="img/author.png">
							<div class="flipcard_main_author_by"> Create by <b>Author...</b><br/>
							on (Waiting for Publish) </div>
						</div>
					</div>
				</div>
				
				<div class="flipcard_main_footer">
				</div>
				
				<div class="flipcard_main_buttons">
					<button type="button" class="btn-save" id="save_draft">SAVE DRAFT</button>
					<button type="button" class="btn-publish" id="publish">PUBLISH</button>
				</div>
			</div>
		</div>
		
		<div id="modal-test" class="modal-test" style="display: none;">
			<div class="popup__body"><div class="js-img"></div></div>
			<div style="margin: 0 0 5px; text-align: center;">
				<div class="modal-text-photo">ADD PHOTO</div>
				<div class="modal-upload-column">
					<p> UPLOAD IMAGE </p>
					<div class="select-file"> <div class="modal-file-icon"></div><input type="file" name="filedata"></div>
					<div class="modal-upload-url">
						<p>or</p>
						<input type="text" class="upload-img-url" placeholder="Enter URL">	
						<button type="button" class="upload-img-url-btn">GO</button>
					</div>
				</div>
			</div>
		</div>
	<script>
	var token = '{!! csrf_token() !!}';
	</script>
	<script src="/js/footer.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="test/FileAPI/FileAPI.min.js"></script>
	<script src="test/FileAPI/FileAPI.exif.js"></script>
	<script src="test/jquery.fileapi.js"></script>
	<script src="test/jcrop/jquery.Jcrop.min.js"></script>
	<script src="test/statics/jquery.modal.js"></script>
	<script src="{!! url() !!}/js/jquery.form.js"></script>
	<script src="{!! url() !!}/js/script3.js"></script>
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
	question_check.push([{!! $value['answer_check1']!!}, {!! $value['answer_check2'] !!}, {!! $value['answer_check3'] !!}, {!! $value['answer_check4'] !!}]);
	@endforeach
	
	
	$('.button-type1').click(function() {
		current_question = $(this).data('id');
		if(question_check[current_question - 1][0] == true) {
			$('.button-type1[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type2[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type3[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type4[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type1[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type2[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type3[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type4[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type1[data-id="'+current_question+'"]').addClass('true-answer');
			$('.button-type2[data-id="'+current_question+'"]').addClass('answer-button-inactive');
			$('.button-type3[data-id="'+current_question+'"]').addClass('answer-button-inactive');
			$('.button-type4[data-id="'+current_question+'"]').addClass('answer-button-inactive');
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
			$('.button-type3[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type4[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type1[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type2[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type3[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type4[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type1[data-id="'+current_question+'"]').addClass('wrong-answer');
			
			
			if(question_check[current_question - 1][2] == true) {
				$('.button-type3[data-id="'+current_question+'"]').addClass('true-answer');
				$('.button-type3[data-id="'+current_question+'"]').css({'opacity': '0.3'});
			} else $('.button-type3[data-id="'+current_question+'"]').addClass('answer-button-inactive');
			if(question_check[current_question - 1][3] == true) {
				$('.button-type4[data-id="'+current_question+'"]').addClass('true-answer');
				$('.button-type4[data-id="'+current_question+'"]').css({'opacity': '0.3'});
			} else $('.button-type4[data-id="'+current_question+'"]').addClass('answer-button-inactive');
			
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
	});
	
	$('.button-type2').click(function() {
		current_question = $(this).data('id');
		if(question_check[current_question - 1][1] == true) {
			$('.button-type1[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type2[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type3[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type4[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type1[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type2[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type3[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type4[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type2[data-id="'+current_question+'"]').addClass('true-answer');
			$('.button-type1[data-id="'+current_question+'"]').addClass('answer-button-inactive');
			$('.button-type3[data-id="'+current_question+'"]').addClass('answer-button-inactive');
			$('.button-type4[data-id="'+current_question+'"]').addClass('answer-button-inactive');
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
			$('.button-type3[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type4[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type1[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type2[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type3[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type4[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type2[data-id="'+current_question+'"]').addClass('wrong-answer');
			
			if(question_check[current_question - 1][2] == true) {
				$('.button-type3[data-id="'+current_question+'"]').addClass('true-answer');
				$('.button-type3[data-id="'+current_question+'"]').css({'opacity': '0.3'});
			} else $('.button-type3[data-id="'+current_question+'"]').addClass('answer-button-inactive');
			if(question_check[current_question - 1][3] == true) {
				$('.button-type4[data-id="'+current_question+'"]').addClass('true-answer');
				$('.button-type4[data-id="'+current_question+'"]').css({'opacity': '0.3'});
			} else $('.button-type4[data-id="'+current_question+'"]').addClass('answer-button-inactive');
			
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
	});
	
	$('.button-type3').click(function() {
		current_question = $(this).data('id');
		if(question_check[current_question - 1][2] == true) {
			$('.button-type1[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type2[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type3[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type1[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type2[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type3[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type3[data-id="'+current_question+'"]').addClass('true-answer');
			$('.button-type2[data-id="'+current_question+'"]').addClass('answer-button-inactive');
			$('.button-type1[data-id="'+current_question+'"]').addClass('answer-button-inactive');
			$('.button-type4[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type4[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type4[data-id="'+current_question+'"]').addClass('answer-button-inactive');
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
			$('.button-type3[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type4[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type1[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type2[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type3[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type4[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type3[data-id="'+current_question+'"]').addClass('wrong-answer');
			
			if(question_check[current_question - 1][3] == true) {
				$('.button-type4[data-id="'+current_question+'"]').addClass('true-answer');
				$('.button-type4[data-id="'+current_question+'"]').css({'opacity': '0.3'});
			} else $('.button-type4[data-id="'+current_question+'"]').addClass('answer-button-inactive');

			if(question_check[current_question - 1][0] == true) {
				$('.button-type1[data-id="'+current_question+'"]').addClass('true-answer');
				$('.button-type1[data-id="'+current_question+'"]').css({'opacity': '0.3'});
			} else $('.button-type1[data-id="'+current_question+'"]').addClass('answer-button-inactive');
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
	});
	
	$('.button-type4').click(function() {
		current_question = $(this).data('id');
		if(question_check[current_question - 1][3] == true) {
			$('.button-type1[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type2[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type3[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type1[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type2[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type3[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type4[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type3[data-id="'+current_question+'"]').addClass('answer-button-inactive');
			$('.button-type2[data-id="'+current_question+'"]').addClass('answer-button-inactive');
			$('.button-type1[data-id="'+current_question+'"]').addClass('answer-button-inactive');
			$('.button-type4[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type4[data-id="'+current_question+'"]').addClass('true-answer');
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
			$('.button-type3[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type4[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type1[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type2[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type3[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type4[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type4[data-id="'+current_question+'"]').addClass('wrong-answer');

			if(question_check[current_question - 1][0] == true) {
				$('.button-type1[data-id="'+current_question+'"]').addClass('true-answer');
				$('.button-type1[data-id="'+current_question+'"]').css({'opacity': '0.3'});
			} else $('.button-type1[data-id="'+current_question+'"]').addClass('answer-button-inactive');
			if(question_check[current_question - 1][1] == true) {
				$('.button-type2[data-id="'+current_question+'"]').addClass('true-answer');
				$('.button-type2[data-id="'+current_question+'"]').css({'opacity': '0.3'});
			} else $('.button-type2[data-id="'+current_question+'"]').addClass('answer-button-inactive');
			if(question_check[current_question - 1][2] == true) {
				$('.button-type3[data-id="'+current_question+'"]').addClass('true-answer');
				$('.button-type3[data-id="'+current_question+'"]').css({'opacity': '0.3'});
			} else $('.button-type3[data-id="'+current_question+'"]').addClass('answer-button-inactive');
			
			answer++;
			if(answer == questions) {
				$('#score').html('Congratulations! You got: '+score+'/'+questions);
				$('#score').css('display', 'block');
				location.href = "#score";
			}
		}
	});
	
	
	@endif;
	</script>
	</body>
</html>