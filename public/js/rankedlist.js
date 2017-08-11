$(document).ready(function () {
	side_fc       = 1;
	current_id    = 1;
	image_type_fc = 1;
	min_sizeh_fc  = 10;
	min_sizew_fc  = 10;
	var ScreenWidth = screen.width;
	var maxSizeW;
	var token = '{!! csrf_token() !!}';
	if (ScreenWidth >= 991) {
		ScreenWidth = '50%';
		maxSizeW    = 700;
	} else if (ScreenWidth <= 768 && ScreenWidth  >= 480){
		ScreenWidth = '50%';
		maxSizeW    = 500;
	} else if (ScreenWidth <= 479){
		ScreenWidth = '50%';
		maxSizeW    = 300;
	}
	else {
		ScreenWidth = '50%';
		maxSizeW    = 400;
	}

	$('.upl-image-valid').click(function() {
		value_url = $('.upl-input-image-url').val();
		$.modal().close();
		if(value_url != '') {
			$.ajax({
                url: '/create/addition/saveimageonURL',
				data: {'image_url': value_url, '_token': token},
                type: 'POST',
            }).success(function (result) {
				if(result.success == true) {
					if(image_type_fc == 1) {
						$('.photo').empty();
						$('.photo').css({'padding-top': '0px'});
						$('.photo').prepend("<img class='main-photo' src='/temp/" + result.file + "'  />");
						$('.input-form-photo').val(result.file); 
					} else if (image_type_fc == 2) {
					   $('.add_fb_img').empty();
					   $('.add_fb_img').css({'padding-top': '0px'});
					   $('.add_fb_img').prepend("<img class='facebook-photo' src='/temp/" + result.file + "'  />");
					   $('.input-form-photo-facebook').val(result.file);
					} else if(image_type_fc == 3) {
						if(side_fc == 1) {
							$('.main-remove-front[data-id="'+current_id+'"]').empty();
							$('.front-card[data-id="'+current_id+'"]').prepend("<img style='position:absolute;' class='image-card' src='/temp/" + result.file + "'  />");
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
		$('.add-question').before('<input class="post-title" type="text" name="rankedlist[cards]['+count_fc+'][post_title]" placeholder="Post title"> </input>'
			+'<div class="editor" data-id="'+count_fc+'"><div class="front-card" data-id="'+count_fc+'"><div class="main-remove-front" data-id="'+count_fc+'">'
			+'<div class="title">CLICK TO ADD PHOTO OR VIDEO</div><div class="butts"><div class="add_plus" data-id="'+count_fc+'" data-side="1"></div></div></div>'
			+'<div class="block-type-caption"><textarea name="rankedlist[cards]['+count_fc+'][caption_card]" class="type-caption" placeholder="Type your text or caption" style="position:relative;" data-id="'+count_fc+'" data-side="1" maxlength="50"></textarea>'
			+'</div></div></div>'
			+'<input name="rankedlist[cards]['+count_fc+'][type_card]" type="hidden" value="image" class="input-type-card" autocomplete="off" data-id="'+count_fc+'" data-side="1">'
			+'<input name="rankedlist[cards]['+count_fc+'][image_card]" type="hidden" value="" class="input-form-img1" autocomplete="off" data-id="'+count_fc+'">'
			+'<input name="rankedlist[cards]['+count_fc+'][youtube_clip]" type="hidden" value="" class="input-form-clip" autocomplete="off" data-id="'+count_fc+'" data-side="1">');
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
                url: '/create/addition/getInfoYoutube',
				data: {'video_url': value_url, '_token': token},
                type: 'POST',
            }).success(function (response) {
				$.modal().close();
				if(response.success == true) {
					if(side_fc == 1) {
					   $('.main-remove-front[data-id="'+current_id+'"]').empty();
					   $('.front-card[data-id="'+current_id+'"]').prepend("<img style='position:absolute; bottom:40%; left: 45%; opacity: 0.5' src='/img/movie_icon.png'  />");
					   $('.front-card[data-id="'+current_id+'"]').prepend("<img style='position:absolute;' class='image-card' src='"+response.thumbnail_url+"'  />");
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
	
	
	$('.btn-preview').click(function() {
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
						var repository = '/uploads/';
						$.each(data.cards, function (i, value) {
							
							if(value.post_title == null) value.post_title = "";

							var html_trivia = '<div class="trivia_main_cards" data-id="'+i+'">';
							html_trivia += '<div class="vote"><div class="vote-button"></div><b>+0</b></div>';
							html_trivia += '<div class="trivia_item_title">'+value.post_title+'</div>';
							html_trivia += '<div class="trivia_main_wrap" data-id="'+i+'">';
							
							if(value.caption_card == null) value.caption_card = "";

							if(value.type_card == "image") {
								if(typeof value.image_card == 'undefined' || value.image_card == null) value.image_card = "../img/no-img.jpg";
								else repository = (~value.image_card.indexOf('/')) ? '/temp/' : '/uploads/';
								html_trivia += '<div class="trivia_main_front" data-id="'+i+'"><img class="image-card" style="position:absolute;" src="'+repository+value.image_card+'" />';
								html_trivia += '<div class="trivia_main_caption">'+value.caption_card+'</div></div>';
							} else {
								html_trivia += '<div class="trivia_main_front" data-id="'+i+'">'+value.youtube_clip;
								html_trivia += '<div class="trivia_main_caption">'+value.caption_card+'</div></div>';
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
					var alertHtml = '<div class="success-img"></div><div class="success-text"><b>Ranked list successfully saved!</b></div><button type="button" onclick="window.location.href = \''+'/edit'+data.link+'\'" class="success-button btn btn_browse btn_browse_small">OK</button>';
						$('.modal-alert').html(alertHtml);
						$('.modal-alert').modal({
				            closeOnEsc: false,
				            closeOnOverlayClick: false,
						}).open();
						setTimeout(function() { window.location.href = '/edit'+data.link; }, 2000);
				} else {
					alertHtml = '<button type="button" class="close" onclick="$(\'.modal-alert\').modal().close();" data-dismiss="modal" aria-hidden="true">&times;</button><div class="warning-img"></div><div class="warning-text"><b>Something went wrong</b></div> <ul>';
                    $.each(data.errorText, function (i, value) {
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
		var alertHtml = '<button type="button" class="close" onclick="$(\'.modal-alert\').modal().close();" data-dismiss="modal" aria-hidden="true">&times;</button><div class="warning-img"></div><div class="warning-text"><b>Something went wrong</b></div> <ul>';
        $('#form_upload_cards').ajaxSubmit({
            dataType: "json",
            success: function (data) {
                if (data.success == true) {
					url = "/success"+data.link;
					$( location ).attr("href", url);
                } else {
                    $.each(data.errorText, function (i, value) {
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
	   url: '/create/addition/saveimage',
	   autoUpload: false,
	   accept: 'image/*',
	   data: {'_token': token},
	   onFileComplete: function (evt, uiEvt){
		   var result = uiEvt.result; // server response
		   
		   // image_type_fc 1-4 | 1 - main photo | 2 - facebook photo | 3 - front card | 4 - back card 
		   
		   if(image_type_fc == 1) {
			   $('.photo').empty();
			   $('.photo').css({'padding-top': '0px'});
			   $('.photo').prepend("<img class='main-photo' src='/temp/" + result.file + "'  />");
			   $('.input-form-photo').val(result.file);
			   
		   } else if (image_type_fc == 2) {
			   $('.add_fb_img').empty();
			   $('.add_fb_img').css({'padding-top': '0px'});
			   $('.add_fb_img').prepend("<img class='facebook-photo' src='/temp/" + result.file + "'  />");
			   $('.input-form-photo-facebook').val(result.file);
		   } else if(image_type_fc == 3) {
			   if(side_fc == 1) {
				   $('.main-remove-front[data-id="'+current_id+'"]').empty();
				   $('.front-card[data-id="'+current_id+'"]').prepend("<img style='position:absolute;' class='image-card' src='/temp/" + result.file + "'  />");
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
			var alertHtml = '<button type="button" class="close" onclick="$(\'.modal-alert\').modal().close();" data-dismiss="modal" aria-hidden="true">&times;</button><div class="warning-img"></div><div class="warning-text"><b>Something went wrong</b></div><div class="warning-text-other"><b> The image you are trying to upload is too small / big. </br> Minimum dimensions: 200x160 </br> Maximum dimensions: 3840x2160</b></div>';
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
					  maxSize: [maxSizeW, maxSizeW],
					  minSize: [min_sizew_fc, min_sizeh_fc],
					  selection: ScreenWidth,
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