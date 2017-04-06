$(document).ready(function () {
	
	score         = 0;
	answer        = 0;
	questions     = 0;
	side_fc       = 1;
	count_fc      = 1;
	current_id    = 1;
	image_type_fc = 1;
	min_sizeh_fc  = 10;
	min_sizew_fc  = 10;
	questions_result_img = [];
	questions_result_title = [];
	
	active_elements = [false];
	
	
	$('.left').on('click', '.btn-img', function() {
		current_id = $(this).data('id');
		
		if(active_elements[current_id - 1] == false) {
			$('.answer-photo[data-id="'+current_id+'"]').css({'display': 'block'});
			$('.btn-img[data-id="'+current_id+'"]').css({'background-color': '#99afd9'});
			active_elements[current_id - 1] = true;
			$('.input-valtype[data-id="'+current_id+'"]').val('multi');
		} else {
			$('.answer-photo[data-id="'+current_id+'"]').css({'display': 'none'});
			$('.btn-img[data-id="'+current_id+'"]').css({'background-color': '#c2cfe8'});
			active_elements[current_id - 1] = false;
			$('.input-valtype[data-id="'+current_id+'"]').val('text');
		}
		
	});
	
	$('.upl-image-valid').click(function() {
		value_url = $('.upl-input-image-url').val();
		$.modal().close();
		if(value_url != '') {
			$.ajax({
                url: 'upload/img_url',
				data: {'image_url': value_url, '_token': token},
                type: 'POST',
            }).success(function (result) {
				if(result.success == true) {
					if(image_type_fc == 1) {
						$('.photo').empty();
						$('.photo').css({'padding-top': '0px'});
						$('.photo').prepend("<img class='main-photo' src='temp/" + result.file + "'  />");
						$('.input-form-photo').val(result.file); 
					} else if (image_type_fc == 2) {
					   $('.add_fb_img').empty();
					   $('.add_fb_img').css({'padding-top': '0px'});
					   $('.add_fb_img').prepend("<img class='facebook-photo' src='temp/" + result.file + "'  />");
					   $('.input-form-photo-facebook').val(result.file);
					} else if(image_type_fc == 3) {
						if(side_fc == 1) {
							$('.main-remove-front[data-id="'+current_id+'"]').empty();
							if(current_id == 1) $('.type-caption[data-id="'+current_id+'"][data-side="1"]').css({'margin-top': '317px'});
							$('.front-card[data-id="'+current_id+'"]').prepend("<img style='position:absolute;' class='image-card' src='temp/" + result.file + "'  />");
							$('.input-form-img1[data-id="'+current_id+'"]').val(result.file);
							$('.input-type-card[data-id="'+current_id+'"][data-side="1"]').val('image');
						} else {
							$('.main-remove-back[data-id="'+current_id+'"]').empty();
							if(current_id == 1) $('.type-caption[data-id="'+current_id+'"][data-side="2"]').css({'margin-top': '317px'});		
							$('.back-card[data-id="'+current_id+'"]').prepend("<img style='position:absolute;' class='image-card' src='temp/" + result.file + "'  />");
							$('.input-form-img2[data-id="'+current_id+'"]').val(result.file);
							$('.input-type-card[data-id="'+current_id+'"][data-side="2"]').val('image');
						}
					} else if(image_type_fc == 4) {
						$('.answer-photo[data-id="'+current_id+'"][data-side="'+side_fc+'"]').empty();
						$('.answer-photo[data-id="'+current_id+'"][data-side="'+side_fc+'"]').css({'padding-top': '0px'});
						$('.answer-photo[data-id="'+current_id+'"][data-side="'+side_fc+'"]').prepend("<img style='width: 199px; height:157px;' src='temp/" + result.file + "'  />");
						$('.answer_img[data-id="'+current_id+'"][data-side="'+side_fc+'"]').val(result.file)
					} else if(image_type_fc == 5) {
						$('.result-photo[data-id="'+current_id+'"]').empty();
						$('.result-photo[data-id="'+current_id+'"]').css({'padding-top': '0px'});
						$('.result-photo[data-id="'+current_id+'"]').prepend("<img style='width: 199px; height: 158px;' src='temp/" + result.file + "'  />");
						$('.result-photo-inp[data-id="'+current_id+'"]').val(result.file);
					}
				}
		    });
		}
	});
	
	$('.modal-url-icon').click(function() {
		$('#modal-input-image').modal({
			closeOnEsc: true,
			closeOnOverlayClick: true,
			onOpen: function (overlay){
				$(overlay).on('click', '.js-upload', function (){
				});
			}
	   }).open();
	});
	
	$('.upl-video-valid').click(function() {
		value_url = $('.upl-input-video-url').val();
		
		if(value_url != '') {
			$.ajax({
                url: 'upload/valid_url',
				data: {'video_url': value_url, '_token': token},
                type: 'POST',
            }).success(function (response) {
				$.modal().close();
				if(response.success == true) {
					if(side_fc == 1) {
					   $('.main-remove-front[data-id="'+current_id+'"]').empty();
					   $('.front-card[data-id="'+current_id+'"]').prepend("<img style='position:relative; margin-top:157px; margin-left: 324px; opacity: 0.5' src='/img/movie_icon.png'  />");
					   $('.front-card[data-id="'+current_id+'"]').prepend("<img style='position:absolute;' class='image-card' src='"+response.thumbnail_url+"'  />");
					   $('.type-caption[data-id="'+current_id+'"][data-side="1"]').css({'margin-top': '60px'})
					   $('.input-form-clip[data-id="'+current_id+'"][data-side="1"]').val(value_url);
					   $('.input-type-card[data-id="'+current_id+'"][data-side="1"]').val('video');
					   if(current_id != 1) $('textarea[data-id="'+current_id+'"][data-side="1"]').css({'top': '-177px'});
				   } else {
					   $('.main-remove-back[data-id="'+current_id+'"]').empty();
					   $('.back-card[data-id="'+current_id+'"]').prepend("<img style='position:relative; margin-top:157px; margin-left: 324px; opacity: 0.5' src='/img/movie_icon.png'  />");
					   $('.back-card[data-id="'+current_id+'"]').prepend("<img style='position:absolute;' class='image-card' src='"+response.thumbnail_url+"'  />");
					   $('.type-caption[data-id="'+current_id+'"][data-side="2"]').css({'margin-top': '60px'})
					   $('.input-form-clip[data-id="'+current_id+'"][data-side="2"]').val(value_url);
					   $('.input-type-card[data-id="'+current_id+'"][data-side="2"]').val('video');
					   if(current_id != 1) $('textarea[data-id="'+current_id+'"][data-side="2"]').css({'top': '-177px'});
					   
					}
				}
				else 
				{
					// code...
				}
			});
		}
		
	});
	
	$('.modal-youtube-icon').click(function() {
		$('#modal-input-youtube').modal({
			closeOnEsc: true,
			closeOnOverlayClick: true,
			onOpen: function (overlay){
				$(overlay).on('click', '.js-upload', function (){
				});
			}
	   }).open();
	});
	
	$('.btn-publish').click(function() {
		$('.isDraft').val('publish');
		var alertHtml = '<div class="warning-text"><b>Warning!</b></div> <ul>';
        $('#form_upload_cards').ajaxSubmit({
            dataType: "json",
            success: function (data) {
                if (data.success == true) {
					url = "/success/"+data.id;
					$( location ).attr("href", url);
                } else {
                    $.each(data.errors, function (i, value) {
                        alertHtml += '<li>' + value + '</li>';
                    });
                    alertHtml += '</ul>';
					$('.modal-alert').html(alertHtml);
					$('.modal-alert').modal().open();
                }
            }
        });
	});
	
	$('.btn-save').click(function() {
		$('.isDraft').val('save');
		
		$('#form_upload_cards').ajaxSubmit({
			dataType: "json",
			success: function (data) {
				if (data.success == true) {
					$('.postID').val(data.id);
					var alertHtml = '<div class="success-save"><center>Trivia Quiz successfully saved!</center></div>';
						$('.modal-alert').html(alertHtml);
						$('.modal-alert').modal().open();
				} else {
					var alertHtml = '<div class="warning-text"><b>Warning!</b></div> <ul>';
					$.each(data.errors, function (i, value) {
                        alertHtml += '<li>' + value + '</li>';
                    });
                    alertHtml += '</ul>';
					$('.modal-alert').html(alertHtml);
					$('.modal-alert').modal().open();
				}
			}
		});
	});
	
	$('#preview').click(function() {
		score = 0;
		answer = 0;
		questions = 0;
		$('.isDraft').val('preview');
		$('.trivia_main_results').css({'display': 'none'});
		$('.photo_res').empty();
		$('.trivia_main_cards').remove();
		$('.trivia_main_answers').remove();
		$('.trivia_main_tags b').empty();
		$('#form_upload_cards').ajaxSubmit({
			dataType: "json",
			success: function (data) {
				$('#preview-modal').modal({
					closeOnEsc: true,
					closeOnOverlayClick: true,
					onOpen: function (overlay){
						
						question_check = [];
						
						$('.trivia_main_title').html(data.content.title);
						$('.trivia_main_description').html(data.content.description);
						$('.trivia_main_author_by b').html(data.content.author);
						$('.trivia_main_footer').html(data.content.footer);
						
							
						// TAGS
						$('.trivia_main_tags b').append(data.tags.join());
						
						$.each(data.cards, function (i, value) {
							
							question_check.push([value.answer_check1, value.answer_check2]);
							
							var html_trivia = '<div class="trivia_main_cards" data-id="'+i+'">';
							html_trivia += '<div class="trivia_item_title">QUESTION</div>';
							html_trivia += '<div class="trivia_main_wrap" data-id="'+i+'">';
							
							if(value.caption1 == null) value.caption1 = "";
							if(value.caption2 == null) value.caption2 = "";

							if(value.type_card_front == "image") {
								if(value.front_card == null) value.front_card = "../img/no-img.jpg";
								html_trivia += '<div class="trivia_main_front" data-id="'+i+'"><img class="image-card" style="position:absolute;" src="temp/'+value.front_card+'" />';
								html_trivia += '<div class="trivia_main_caption">'+value.caption1+'</div></div>';
							} else {
								html_trivia += '<div class="trivia_main_front" data-id="'+i+'">'+value.youtube_clip1;
								html_trivia += '<div class="trivia_main_caption">'+value.caption1+'</div></div>';
							}
							
							if(value.type_card_back == "image") {
								if(value.back_card == null) value.back_card = "../img/no-img.jpg";
								html_trivia += '<div class="trivia_main_back" data-id="'+i+'"><img class="image-card" style="position:absolute;" src="temp/'+value.back_card+'" />';
								html_trivia += '<div class="trivia_main_caption">'+value.caption2+'</div></div>';
							} else {
								html_trivia += '<div class="trivia_main_back" data-id="'+i+'">'+value.youtube_clip2;
								html_trivia += '<div class="trivia_main_caption">'+value.caption2+'</div></div>';
								
							}
							
							
							
							html_trivia += '</div>';
							$(".trivia_main_footer").before(html_trivia);
							
							if(value.answer1 == null) value.answer1 = 'button #1';
							if(value.answer2 == null) value.answer2 = 'button #2';
							
							if(value.answers_type == "multi" ) {
								
								if(value.answer_img1 != '') {
									html_button = '<div class="trivia_main_answers"><button style="width: 310px; height: 280px;" class="answer-button button-type1" type="button" data-id="'+i+'"><img width="300" height="250" src="temp/'+value.answer_img1+'"/><br/>'+value.answer1+'</button>';
								} else {
									html_button = '<div class="trivia_main_answers"><button style="width: 310px; height: 70px;" class="answer-button button-type1" type="button" data-id="'+i+'">'+value.answer1+'</button>';
								}
								
								if(value.answer_img2 != '') {
									html_button += '<button style="width: 310px; height: 280px;" class="answer-button button-type2" type="button" data-id="'+i+'"><img width="300" height="250" src="temp/'+value.answer_img2+'"/><br/>'+value.answer2+'</button></div>';
								} else {
									html_button += '<button style="width: 310px; height: 70px;" class="answer-button button-type2" type="button" data-id="'+i+'">'+value.answer2+'</button></div>';
								}
								
								
							} else {
								html_button = '<div class="trivia_main_answers"><button style="width: 310px; height: 70px;" class="answer-button button-type1" type="button" data-id="'+i+'">'+value.answer1+'</button>';
								html_button += '<button style="width: 310px; height: 70px;" class="answer-button button-type2" type="button" data-id="'+i+'">'+value.answer2+'</button></div>';
							}
							
							$(".trivia_main_footer").before(html_button);
							
							if(value.result_photo_img != '') questions_result_img[i] = value.result_photo_img;
							if(value.result_photo_title != '') questions_result_title[i] = value.result_photo_title;
							
							questions++;
						});
						
					}
				}).open();
			}
		});
	});
	
	
	$('.quiz-add-result button').click(function() {
		
		if($('.editor').length < $('.result-photo').length) return false;
		
		if($('.editor').length == ($('.result-photo').length + 1)) $('.quiz-add-result button').css({'display': 'none'});
		
		// add new block quiz result
		$(".blocks-quiz:last").after('<div class="blocks-quiz"><div class="left-block-quiz">'
			+'<div class="description">Results should be added once your quiz is finished. <br/>A different result will appear based on the number <br/>'
			+'of correct answers made by the user. Each result <br/>you add will be relevant to a range of correct </br>answers.</div></div>'
			+'<div class="right-block-quiz"><div class="result-photo" data-id="'+($('.result-photo').length + 1 )+'"><b>CLICK</br> TO ADD PHOTO</b></div>'
			+'<div class="result-photo-desc">Correct answers range: '+($('.result-photo').length + 1 )+'</div>'
			+'<div class="quiz-title"><input name="flip_cards['+($('.result-photo').length + 1 )+'][result_photo_title]" placeholder="Title (80 characters max)" maxlength="80">'
			+'<input name="flip_cards['+($('.result-photo').length + 1 )+'][result_photo_img]" type="hidden" value="text" class="result-photo-inp" autocomplete="off" data-id="'+($('.result-photo').length + 1 )+'"></div></div></div>');
		// end
		
		
		
	});
	
	
	$(".add-question").click(function() {
		count_fc++;
		$(".edit-answers:last").after('<div class="buttons" style="float:left;"><button type="button" class="front_card_question" style="background-color: #99afd9;" data-id="'+count_fc+'">QUESTION</button>'
		+'<button type="button" class="back_card_question" data-id="'+count_fc+'">RESULT</button></div>'
		+'<div class="editor" style="float:left;" data-id="'+count_fc+'"><div class="front-card" data-id="'+count_fc+'">'
		+'<div class="title">CLICK TO ADD PHOTO OR VIDEO</div><div class="butts"><div class="add_plus" data-id="'+count_fc+'" data-side="1"></div></div>'
		+'<div class="block-type-caption"><textarea name="flip_cards['+count_fc+'][caption1]" style="position:relative;" class="type-caption" placeholder="Type your caption" data-id="'+count_fc+'" data-side="1"></textarea></div></div>'
		+'<div class="back-card" data-id="'+count_fc+'"><div class="title">CLICK TO ADD PHOTO OR VIDEO</div><div class="butts">'
		+'<div class="add_plus" data-id="'+count_fc+'" data-side="2"></div></div>'
		+'<div class="block-type-caption"><textarea name="flip_cards['+count_fc+'][caption2]" class="type-caption" style="position:relative;" placeholder="Type your caption" data-id="'+count_fc+'" data-side="2"></textarea></div></div></div>'
		+'<div class="edit-answers"><div class="media-answer"><div class="title">CHOOSE ANSWER MEDIA</div><div class="buttons-answer">'
		+'<div class="btn-text"></div><div class="btn-img" data-id="'+count_fc+'"></div></div></div><div class="add-answer"><div class="answer-photo" data-id="'+count_fc+'" data-side="1"><b>CLICK<br/> TO ADD PHOTO</b></div>'
		+'<div class="answer-text"> <textarea placeholder="Enter text" name="flip_cards['+count_fc+'][answer1]"></textarea></div><div class="answer-checkbox"><label> <input type="checkbox" name="flip_cards['+count_fc+'][answer_check1]">Correct answer</label>'
		+'</div></div><div class="add-answer"><div class="answer-photo" data-id="'+count_fc+'" data-side="2"><b>CLICK<br/> TO ADD PHOTO</b></div>'
		+'<div class="answer-text"> <textarea placeholder="Enter text" name="flip_cards['+count_fc+'][answer2]"></textarea></div>'
		+'<div class="answer-checkbox"><label> <input type="checkbox" name="flip_cards['+count_fc+'][answer_check2]">Correct answer</label></div></div></div>'
		+'<input name="flip_cards['+count_fc+'][img_src1]" type="hidden" value="" class="input-form-img1" autocomplete="off" data-id="'+count_fc+'">'
		+'<input name="flip_cards['+count_fc+'][img_src2]" type="hidden" value="" class="input-form-img2" autocomplete="off" data-id="'+count_fc+'">'
		+'<input name="flip_cards['+count_fc+'][type_card1]" type="hidden" value="image" class="input-type-card" autocomplete="off" data-id="'+count_fc+'" data-side="1">'
		+'<input name="flip_cards['+count_fc+'][type_card2]" type="hidden" value="image" class="input-type-card" autocomplete="off" data-id="'+count_fc+'" data-side="2">'
		+'<input name="flip_cards['+count_fc+'][youtube_clip1]" type="hidden" value="" class="input-form-clip" autocomplete="off" data-id="'+count_fc+'" data-side="1">'
		+'<input name="flip_cards['+count_fc+'][youtube_clip2]" type="hidden" value="" class="input-form-clip" autocomplete="off" data-id="'+count_fc+'" data-side="2">'
		+'<input name="flip_cards['+count_fc+'][answer_img1]" type="hidden" value="" class="answer_img" autocomplete="off" data-id="'+count_fc+'" data-side="1">'
		+'<input name="flip_cards['+count_fc+'][answer_img2]" type="hidden" value="" class="answer_img" autocomplete="off" data-id="'+count_fc+'" data-side="2">'
		+'<input name="flip_cards['+count_fc+'][answers_type]" type="hidden" value="text" class="input-valtype" autocomplete="off" data-id="'+count_fc+'">');
		
		$('.quiz-add-result button').css({'display': 'block'});
		active_elements.push(false);
	});
	
	
	$('.left').on('click', '.add_plus', function() {
		current_id = $(this).data('id');
		side_fc = $(this).data('side');	
		min_sizeh_fc = 11;
		min_sizew_fc = 19;
		image_type_fc = 3;
		$('#choose-upload').modal({
			closeOnEsc: true,
			closeOnOverlayClick: true,
			onOpen: function (overlay){
				$(overlay).on('click', '.js-upload', function (){
				});
			}
	   }).open();
	});
	
	$('.left').on('click', '.front_card_question', function() {
		side_fc = 1;
		min_sizeh_fc = 11;
		min_sizew_fc = 19;
		current_id = $(this).data('id');
		var wrap = $('.editor[data-id="'+current_id+'"]');
		$(wrap).css({'-webkit-transform':'rotateY(0deg)'});
		$('.front_card_question[data-id="'+current_id+'"]').css({'background-color': '#99afd9'});
		$('.back_card_question[data-id="'+current_id+'"]').css({'background-color': '#c2cfe8'});
	});
	
	$('.left').on('click', '.back_card_question', function() {
		side_fc = 2;
		min_sizeh_fc = 11;
		min_sizew_fc = 19;
		current_id = $(this).data('id');
		var wrap = $('.editor[data-id="'+current_id+'"]');
		$(wrap).css({'-webkit-transform':'rotateY(180deg)'});
		$('.back_card_question[data-id="'+current_id+'"]').css({'background-color': '#99afd9'});
		$('.front_card_question[data-id="'+current_id+'"]').css({'background-color': '#c2cfe8'});
	});
	
	$('.photo').click(function() {
		image_type_fc = 1;
		min_sizeh_fc = 10;
		min_sizew_fc = 10;
		$('#modal-test').modal({
			closeOnEsc: true,
			closeOnOverlayClick: true,
			onOpen: function (overlay){
				$(overlay).on('click', '.js-upload', function (){
				});
			}
	   }).open();
	});
	
	
	$('.left').on('click', '.result-photo', function() {
		current_id = $(this).data('id');
		side_fc = $(this).data('side');
		min_sizeh_fc = 10;
		min_sizew_fc = 10;
		image_type_fc = 5;
		$('#modal-test').modal({
			closeOnEsc: true,
			closeOnOverlayClick: true,
			onOpen: function (overlay){
				$(overlay).on('click', '.js-upload', function (){
				});
			}
	    }).open();
	});
	
	
	$('.left').on('click', '.answer-photo', function() {
		current_id = $(this).data('id');
		side_fc = $(this).data('side');	
		min_sizeh_fc = 10;
		min_sizew_fc = 10;
		image_type_fc = 4;
		$('#modal-test').modal({
			closeOnEsc: true,
			closeOnOverlayClick: true,
			onOpen: function (overlay){
				$(overlay).on('click', '.js-upload', function (){
				});
			}
	   }).open();
	});
	
	$('.add_fb_img').click(function() {
		image_type_fc = 2;
		min_sizeh_fc = 10;
		min_sizew_fc = 10;
		$('#modal-test').modal({
			closeOnEsc: true,
			closeOnOverlayClick: true,
			onOpen: function (overlay){
				$(overlay).on('click', '.js-upload', function (){
				});
			}
	   }).open();
	});
	
	$('.left').on('click', '.add_image', function() {
		side_fc = $(this).data('side');
		current_id = $(this).data('id');
		image_type_fc = 3;
		min_sizew_fc = 19;
		min_sizeh_fc = 11;
		$('#modal-test').modal({
			closeOnEsc: true,
			closeOnOverlayClick: true,
			onOpen: function (overlay){
				$(overlay).on('click', '.js-upload', function (){
				});
			}
	   }).open();
	});
	

	token = $('input[name="_token"]').val();
	$('.select-file').fileapi({
	   url: 'test_upload_end',
	   autoUpload: false,
	   accept: 'image/*',
	   data: {'_token': token},
	   onFileComplete: function (evt, uiEvt){
		   var result = uiEvt.result; // server response
		   
		   // image_type_fc 1-4 | 1 - main photo | 2 - facebook photo | 3 - front card | 4 - back card 
		   
		   if(image_type_fc == 1) {
			   $('.photo').empty();
			   $('.photo').css({'padding-top': '0px'});
			   $('.photo').prepend("<img class='main-photo' src='temp/" + result.file + "'  />");
			   $('.input-form-photo').val(result.file);
			   
		   } else if (image_type_fc == 2) {
			   $('.add_fb_img').empty();
			   $('.add_fb_img').css({'padding-top': '0px'});
			   $('.add_fb_img').prepend("<img class='facebook-photo' src='temp/" + result.file + "'  />");
			   $('.input-form-photo-facebook').val(result.file);
		   } else if(image_type_fc == 3) {
			   if(side_fc == 1) {
				   $('.main-remove-front[data-id="'+current_id+'"]').empty();
				   if(current_id == 1) $('.type-caption[data-id="'+current_id+'"][data-side="1"]').css({'margin-top': '317px'})
				   $('.front-card[data-id="'+current_id+'"]').prepend("<img style='position:absolute;' class='image-card' src='temp/" + result.file + "'  />");
				   $('.input-form-img1[data-id="'+current_id+'"]').val(result.file);
				   $('.input-type-card[data-id="'+current_id+'"][data-side="1"]').val('image');
			   } else {
				   $('.main-remove-back[data-id="'+current_id+'"]').empty();
				   if(current_id == 1) $('.type-caption[data-id="'+current_id+'"][data-side="2"]').css({'margin-top': '317px'})
				   $('.back-card[data-id="'+current_id+'"]').prepend("<img style='position:absolute;' class='image-card' src='temp/" + result.file + "'  />");
				   $('.input-form-img2[data-id="'+current_id+'"]').val(result.file);
				   $('.input-type-card[data-id="'+current_id+'"][data-side="2"]').val('image');
			   }
		   } else if(image_type_fc == 4) {
			   $('.answer-photo[data-id="'+current_id+'"][data-side="'+side_fc+'"]').empty();
			   $('.answer-photo[data-id="'+current_id+'"][data-side="'+side_fc+'"]').css({'padding-top': '0px'});
			   $('.answer-photo[data-id="'+current_id+'"][data-side="'+side_fc+'"]').prepend("<img style='width: 199px; height:157px;' src='temp/" + result.file + "'  />");
			   $('.answer_img[data-id="'+current_id+'"][data-side="'+side_fc+'"]').val(result.file)
		   } else if(image_type_fc == 5) {
			   $('.result-photo[data-id="'+current_id+'"]').empty();
			   $('.result-photo[data-id="'+current_id+'"]').css({'padding-top': '0px'});
			   $('.result-photo[data-id="'+current_id+'"]').prepend("<img style='width: 199px; height: 158px;' src='temp/" + result.file + "'  />");
			   $('.result-photo-inp[data-id="'+current_id+'"]').val(result.file);
		   }
	   },
	   imageSize: { minWidth: 200, minHeight: 160, maxWidth: 3840, maxHeight: 2160},
	   
	   onSelect: function (evt, ui){
		  var file = ui.files[0];
		  if( ui.other.length ){
			var errors = ui.other[0].errors;
			var alertHtml = '<div class="warning-text"><b>Warning!</b></div><div class="warning-text-other"><b> The image you are trying to upload is too small / big. </br> Minimum dimensions: 200x160 </br> Maximum dimensions: 3840x2160</b></div>';
			$('.modal-alert').html(alertHtml);
			$('.modal-alert').modal().open();
		  }
		  
			
		  if( !FileAPI.support.transform ) {
			 alert('Your browser does not support Flash :(');
		  }
		  else if( file ){
			 $('#popup').modal({
				closeOnEsc: true,
				closeOnOverlayClick: true,
				onOpen: function (overlay){
				   $(overlay).on('click', '.js-upload', function (){
					  $.modal().close();
					  $('.select-file').fileapi('upload');
				   });
				   $('.js-img', overlay).cropper({
					  file: file,
					  bgColor: '#fff',
					  maxSize: [500, 500],
					  minSize: [min_sizew_fc, min_sizeh_fc],
					  selection: '50%',
					  onSelect: function (coords){
						 $('.select-file').fileapi('crop', file, coords);
					  }
				   });
				}
			 }).open();
		  }
	    },
    });
	
	$('.preview-modal').on('click', '.button-type1', function() {
		current_question = $(this).data('id');
		if(question_check[current_question][0] == 'true') {
			$('.button-type1[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type2[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type1[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type2[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type1[data-id="'+current_question+'"]').addClass('true-answer');
			$('.button-type2[data-id="'+current_question+'"]').addClass('answer-button-inactive');
			answer++;
			score++;
		} else {
			$('.button-type1[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type2[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type1[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type2[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type1[data-id="'+current_question+'"]').addClass('wrong-answer');

			if(question_check[current_question][1] == 'true') {
				$('.button-type2[data-id="'+current_question+'"]').addClass('true-answer');
				$('.button-type2[data-id="'+current_question+'"]').css({'opacity': '0.3'});
			} else $('.button-type2[data-id="'+current_question+'"]').addClass('answer-button-inactive');
			answer++;
		}
		if(answer == questions) {
						
			$('.trivia_main_results .score').html('Your result: '+score+'/'+answer);
			
			if(score > 1) {
				
				if(typeof questions_result_img[score - 1] != 'undefined') {
					if(questions_result_img[score - 1] != '') $('.trivia_main_results .photo_res').append('<img style="width:100%; height:339px;" src="temp/'+questions_result_img[score - 1]+'" />');
				}
				
				if(typeof questions_result_title[score - 1] != 'undefined') {
					$('.trivia_main_results .title b').html(questions_result_title[score - 1]);
				}
			} else {
				if(typeof questions_result_img[0] != 'undefined') {
					if(questions_result_img[0] != '') $('.trivia_main_results .photo_res').append('<img style="width:100%; height:339px;" src="temp/'+questions_result_img[0]+'" />');
				}
				
				if(typeof questions_result_title[0] != 'undefined') {
					$('.trivia_main_results .title b').html(questions_result_title[0]);
				}
			}
			
			$('.trivia_main_results').css({'display': 'block'});
		}
		$('.trivia_main_wrap[data-id="'+current_question+'"]').css({'-webkit-transform':'rotateY(180deg)'});
	});
	
	$('.preview-modal').on('click', '.button-type2', function() {
		current_question = $(this).data('id');
		if(question_check[current_question][1] == 'true') {
			$('.button-type1[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type2[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type1[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type2[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type2[data-id="'+current_question+'"]').addClass('true-answer');
			$('.button-type1[data-id="'+current_question+'"]').addClass('answer-button-inactive');
			answer++;
			score++;
		} else {
			$('.button-type1[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type2[data-id="'+current_question+'"]').prop( 'disabled', true );
			$('.button-type1[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type2[data-id="'+current_question+'"]').removeClass("answer-button");
			$('.button-type2[data-id="'+current_question+'"]').addClass('wrong-answer');
			
			if(question_check[current_question][0] == 'true') {
				$('.button-type1[data-id="'+current_question+'"]').addClass('true-answer');
				$('.button-type1[data-id="'+current_question+'"]').css({'opacity': '0.3'});
			} else $('.button-type1[data-id="'+current_question+'"]').addClass('answer-button-inactive');
			
			answer++;
			
		}

		if(answer == questions) {
						
			$('.trivia_main_results .score').html('Your result: '+score+'/'+answer);
			
			if(score > 1) {
				
				if(typeof questions_result_img[score - 1] != 'undefined') {
					if(questions_result_img[score - 1] != '') $('.trivia_main_results .photo_res').append('<img style="width:100%; height:339px;" src="temp/'+questions_result_img[score - 1]+'" />');
				}
				
				if(typeof questions_result_title[score - 1] != 'undefined') {
					$('.trivia_main_results .title b').html(questions_result_title[score - 1]);
				}
			} else {
				if(typeof questions_result_img[0] != 'undefined') {
					if(questions_result_img[0] != '') $('.trivia_main_results .photo_res').append('<img style="width:100%; height:339px;" src="temp/'+questions_result_img[0]+'" />');
				}
				
				if(typeof questions_result_title[0] != 'undefined') {
					$('.trivia_main_results .title b').html(questions_result_title[0]);
				}
			}
			
			$('.trivia_main_results').css({'display': 'block'});
		}
		
		$('.trivia_main_wrap[data-id="'+current_question+'"]').css({'-webkit-transform':'rotateY(180deg)'});
	});
  
});