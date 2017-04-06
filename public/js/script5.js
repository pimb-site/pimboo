$(document).ready(function () {
	side_fc       = 1;
	count_fc      = 1;
	current_id    = 1;
	image_type_fc = 1;
	min_sizeh_fc  = 10;
	min_sizew_fc  = 10;
	
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
							$('.type-caption[data-id="'+current_id+'"][data-side="1"]').css({'margin-top': '317px'});
							$('.front-card[data-id="'+current_id+'"]').prepend("<img style='position:absolute;' class='image-card' src='temp/" + result.file + "'  />");
							$('.input-form-img1[data-id="'+current_id+'"]').val(result.file);
							$('.input-type-card[data-id="'+current_id+'"][data-side="1"]').val('image');
						} 
					}
				}
		    });
		}
	});
	
	$('.add-question').click(function() {
		
		count_fc++;
		
		$('.add-question').before('<input class="post-title" type="text" name="flip_cards['+count_fc+'][post_title]" placeholder="Post title"> </input>'
			+'<div class="editor" data-id="'+count_fc+'"><div class="front-card" data-id="'+count_fc+'"><div class="main-remove-front" data-id="'+count_fc+'">'
			+'<div class="title">CLICK TO ADD PHOTO OR VIDEO</div><div class="butts"><div class="add_plus" data-id="'+count_fc+'" data-side="1"></div></div></div>'
			+'<div class="block-type-caption"><textarea name="flip_cards['+count_fc+'][caption1]" class="type-caption" placeholder="Type your text or caption" style="position:relative;" data-id="'+count_fc+'" data-side="1" maxlength="50"></textarea>'
			+'</div></div></div>'
			+'<input name="flip_cards['+count_fc+'][type_card1]" type="hidden" value="image" class="input-type-card" autocomplete="off" data-id="'+count_fc+'" data-side="1">'
			+'<input name="flip_cards['+count_fc+'][img_src1]" type="hidden" value="" class="input-form-img1" autocomplete="off" data-id="'+count_fc+'">'
			+'<input name="flip_cards['+count_fc+'][youtube_clip1]" type="hidden" value="" class="input-form-clip" autocomplete="off" data-id="'+count_fc+'" data-side="1">');
		
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
	
	
	$('#preview').click(function() {
		$('.isDraft').val('preview');
		$('.trivia_main_tags b').empty();
		$('.trivia_main_cards').remove();
		$('#form_upload_cards').ajaxSubmit({
			dataType: "json",
			success: function (data) {
				$('#preview-modal').modal({
					closeOnEsc: true,
					closeOnOverlayClick: true,
					onOpen: function (overlay){
						$('.trivia_main_title').html(data.content.title);
						$('.trivia_main_description').html(data.content.description);
						$('.trivia_main_author_by b').html(data.content.author);
						$('.trivia_main_footer').html(data.content.footer);
						
						// TAGS
						$('.trivia_main_tags b').append(data.tags.join());
						
						$.each(data.cards, function (i, value) {
							
							if(value.post_title == null) value.post_title = "";

							var html_trivia = '<div class="trivia_main_cards" data-id="'+i+'">';
							html_trivia += '<div class="vote"><div class="vote-button"></div><b>+0</b></div>';
							html_trivia += '<div class="trivia_item_title">'+value.post_title+'</div>';
							html_trivia += '<div class="trivia_main_wrap" data-id="'+i+'">';
							
							if(value.caption1 == null) value.caption1 = "";

							if(value.type_card_front == "image") {
								if(value.front_card == null) value.front_card = "../img/no-img.jpg";
								html_trivia += '<div class="trivia_main_front" data-id="'+i+'"><img class="image-card" style="position:absolute;" src="temp/'+value.front_card+'" />';
								html_trivia += '<div class="trivia_main_caption">'+value.caption1+'</div></div>';
							} else {
								html_trivia += '<div class="trivia_main_front" data-id="'+i+'">'+value.youtube_clip1;
								html_trivia += '<div class="trivia_main_caption">'+value.caption1+'</div></div>';
							}
							
							html_trivia += '</div>';
							$(".trivia_main_footer").before(html_trivia);
						});
						
					}
				}).open();
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
					var alertHtml = '<div class="success-save"><center>Ranked list successfully saved!</center></div>';
						$('.modal-alert').html(alertHtml);
						$('.modal-alert').modal().open();
				} else {
					alertHtml = '<div class="warning-text"><b>Warning!</b></div> <ul>';
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
				   $('.type-caption[data-id="'+current_id+'"][data-side="1"]').css({'margin-top': '317px'})
				   $('.front-card[data-id="'+current_id+'"]').prepend("<img style='position:absolute;' class='image-card' src='temp/" + result.file + "'  />");
				   $('.input-form-img1[data-id="'+current_id+'"]').val(result.file);
				   $('.input-type-card[data-id="'+current_id+'"][data-side="1"]').val('image');
			   }
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
	
	
  
});