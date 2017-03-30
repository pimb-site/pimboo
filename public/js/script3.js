$(document).ready(function () {
	
	side_fc       = 1;
	count_fc      = 1;
	current_id    = 1;
	image_type_fc = 1;
	min_sizeh_fc  = 10;
	min_sizew_fc  = 10;
	
	
	$('.upload-img-url-btn').click(function() {
		value_url = $('.upload-img-url').val();
		$.modal().close();
		
		if(value_url != "") {
			$.ajax({
                url: 'upload/img_url',
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
						   $('.front-card[data-id="'+current_id+'"]').empty();
						   $('.front-card[data-id="'+current_id+'"]').prepend("<img class='image-card' src='/temp/" + result.file + "'  />");
						   $('.front-card[data-id="'+current_id+'"]').prepend("<div data-id='"+current_id+"' class='delete_icon_button' data-side='1'> <img class='delete_icon' src='/img/delete_icon.png'  /></div>");
						   $('.input-form-img1[data-id="'+current_id+'"]').val(result.file);
					   } else {
						   $('.back-card[data-id="'+current_id+'"]').empty();
						   $('.back-card[data-id="'+current_id+'"]').prepend("<img class='image-card' src='/temp/" + result.file + "'  />");
						   $('.back-card[data-id="'+current_id+'"]').prepend("<div data-id='"+current_id+"' class='delete_icon_button' data-side='2'> <img class='delete_icon' src='/img/delete_icon.png'  /></div>");
						   $('.input-form-img2[data-id="'+current_id+'"]').val(result.file);
					   }
				   }
				}
			});
		}
	});
	
	$('#preview').click(function() {
		$('.isDraft').val('preview');
		$('.flipcard_main_tags b').empty();
		$('.flipcard_main_cards').remove();
		$('#form_upload_cards').ajaxSubmit({
			dataType: "json",
			success: function (data) {
				$('#preview-modal').modal({
					closeOnEsc: true,
					closeOnOverlayClick: true,
					onOpen: function (overlay){
						$('.flipcard_main_title').html(data.content.title);
						$('.flipcard_main_description').html(data.content.description);
						$('.flipcard_main_author_by b').html(data.content.author);
						$('.flipcard_main_footer').html(data.content.footer);
						
						// TAGS
						$('.flipcard_main_tags b').append(data.tags.join());
						
						$.each(data.cards, function (i, value) {
							$(".flipcard_main_footer").before('<div class="flipcard_main_cards">'
								+'<div class="flipcard_item_title">'+value.item_title+'</div>'
								+'<div class="flipcard_main_wrap" data-id="'+i+'">'
								+'<div class="flipcard_main_front" data-id="'+i+'"></div>'
								+'<div class="flipcard_main_back" data-id="'+i+'"></div>'
								+'</div></div></div>');
							if(value.type_front == "image") {
								if(value.front_card == '') value.front_card = "../img/no-img.jpg";
								$('.flipcard_main_front[data-id="'+i+'"]').append('<img class="image-card" src="temp/'+value.front_card+'" />');
							} else {
								switch(value.theme_front) {
									case 'blue':
										color = '#009cff';
										break;
										
									case 'green':
										color = '#8dc63f';
										break;
									
									case 'purple':
										color = '#605ca8';
										break;
									
									case 'turquoise':
										color = '#00a99d';
										break;
										
									default:
										color = '#009cff';
										break;
								}
								
								$('.flipcard_main_front[data-id="'+i+'"]').css({'background-color': color});
								$('.flipcard_main_front[data-id="'+i+'"]').append('<div class="flipcard_main_text">'+value.text_front+'</div>');
							}
							
							if(value.type_back == "image") {
								if(value.back_card == '') value.back_card = "../img/no-img.jpg";
								$('.flipcard_main_back[data-id="'+i+'"]').append('<img class="image-card" src="temp/'+value.back_card+'" />');
								
							} else {
								switch(value.theme_back) {
									case 'blue':
										color = '#009cff';
										break;
										
									case 'green':
										color = '#8dc63f';
										break;
									
									case 'purple':
										color = '#605ca8';
										break;
									
									case 'turquoise':
										color = '#00a99d';
										break;
									
									default:
										color = '#009cff';
										break;
								}
								$('.flipcard_main_back[data-id="'+i+'"]').css({'background-color': color});
								$('.flipcard_main_back[data-id="'+i+'"]').append('<div class="flipcard_main_text">'+value.text_back+'</div>');
							}
						});
						
					}
				}).open();
			}
		});
	});
	
	$('.left').on('click', '.item-color', function() {
		current_id = $(this).data('id');
		data_theme = $(this).data('theme');
		switch(data_theme) {
			case 'blue':
				
				if(side_fc == 1) {
					$('.front-card[data-id="'+current_id+'"]').css({'background': '#009cff'});
					$('textarea[data-id="'+current_id+'"]:first').css({'background': '#009cff'});
					$('.input-form-theme1[data-id="'+current_id+'"]').val('blue');
				} else if(side_fc == 2){
					$('.back-card[data-id="'+current_id+'"]').css({'background': '#009cff'});
					$('textarea[data-id="'+current_id+'"]:last').css({'background': '#009cff'});
					$('.input-form-theme2[data-id="'+current_id+'"]').val('blue');
				}
				
				break;
				
			case 'purple':
				if(side_fc == 1) {
					$('.front-card[data-id="'+current_id+'"]').css({'background': '#605ca8'});
					$('textarea[data-id="'+current_id+'"]:first').css({'background': '#605ca8'});
					$('.input-form-theme1[data-id="'+current_id+'"]').val('purple');
				} else if(side_fc == 2){
					$('.back-card[data-id="'+current_id+'"]').css({'background': '#605ca8'});
					$('textarea[data-id="'+current_id+'"]:last').css({'background': '#605ca8'});
					$('.input-form-theme2[data-id="'+current_id+'"]').val('purple');
				}
				
				break;
			
			case 'green':
				if(side_fc == 1) {
					$('.front-card[data-id="'+current_id+'"]').css({'background': '#8dc63f'});
					$('textarea[data-id="'+current_id+'"]:first').css({'background': '#8dc63f'});
					$('.input-form-theme1[data-id="'+current_id+'"]').val('green');
				} else if(side_fc == 2){
					$('.back-card[data-id="'+current_id+'"]').css({'background': '#8dc63f'});
					$('textarea[data-id="'+current_id+'"]:last').css({'background': '#8dc63f'});
					$('.input-form-theme2[data-id="'+current_id+'"]').val('green');
				}
				
				break;
				
				
			case 'turquoise':
				if(side_fc == 1) {
					$('.front-card[data-id="'+current_id+'"]').css({'background': '#00a99d'});
					$('textarea[data-id="'+current_id+'"]:first').css({'background': '#00a99d'});
					$('.input-form-theme1[data-id="'+current_id+'"]').val('turquoise');
				} else if(side_fc == 2){
					$('.back-card[data-id="'+current_id+'"]').css({'background': '#00a99d'});
					$('textarea[data-id="'+current_id+'"]:last').css({'background': '#00a99d'});
					$('.input-form-theme2[data-id="'+current_id+'"]').val('turquoise');
				}	
				break;
		}
		
	});
	
	$('.left').on('click', '.delete_icon_button', function() {
		current_id = $(this).data('id');
		side_fc = $(this).data('side');
		
		if(side_fc == 1) {
			$('.front-card[data-id="'+current_id+'"]').empty();
			$('.front-card[data-id="'+current_id+'"]').prepend('<div class="title">CLICK TO ADD PHOTO OR TEXT</div>'
			+'<div class="butts"><div class="add_image" data-id="'+current_id+'" data-side="1"></div><div class="add_text" data-id="'+current_id+'" data-side="1"></div></div>');
			$('.front-card[data-id="'+current_id+'"]').css({'background': '#fff'});
			$('.input-form-img1[data-id="'+current_id+'"]').val('');
			$('.input-type-front[data-id="'+current_id+'"]').val('image');
		} else if(side_fc == 2) {
			$('.back-card[data-id="'+current_id+'"]').empty();
			$('.back-card[data-id="'+current_id+'"]').prepend('<div class="title">CLICK TO ADD PHOTO OR TEXT</div>'
			+'<div class="butts"><div class="add_image" data-id="'+current_id+'" data-side="2"></div><div class="add_text" data-id="'+current_id+'" data-side="2"></div></div>');
			$('.back-card[data-id="'+current_id+'"]').css({'background': '#fff'});
			$('.input-form-img2[data-id="'+current_id+'"]').val('');
			$('.input-type-back[data-id="'+current_id+'"]').val('image');
		}
		
	});
	
	$('#publish').click(function() {
		$('.isDraft').val('publish');
		var alertHtml = '<div class="warning-text"><b>Warning!</b></div> <ul>';
		if (tinymce_init == 1) {
			tinyMCE.get("content_textarea").save();
		}
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
	
	$('.btn-publish').click(function() {
		$('.isDraft').val('publish');
<<<<<<< HEAD
		alertHtml = '<div class="warning-text"><b>Warning!</b></div> <ul>';
		//tinyMCE.get("content_textarea").save();
=======
		var alertHtml = '<div class="warning-text"><b>Warning!</b></div> <ul>';
		if (tinymce_init == 1) {
			tinyMCE.get("content_textarea").save();
		}
>>>>>>> origin/master
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
					alertHtml = '<div class="success-save">Flip cards successfully saved!</div>';
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
	
	
	$("#add_card").click(function() {
		count_fc++;
		$(".editor:last").after('<div class="buttons">'
			+'<button type="button" class="front_card" data-id="'+count_fc+'">FRONT CARD</button>'
			+'<button type="button" class="back_card" data-id="'+count_fc+'">BACK CARD</button>'
			+'</div>'
			+'<input class="item-title-input" type="text" name="flip_cards['+count_fc+'][form_item_title]" placeholder="Enter item title (60 symbols max)" maxlength="60">'
			+'<div class="editor" data-id="'+count_fc+'"> <div class="front-card" data-id="'+count_fc+'">'
			+'<div class="title">CLICK TO ADD PHOTO OR TEXT</div> <div class="butts">'
			+'<div class="add_image" data-id="'+count_fc+'" data-side="1"></div> <div class="add_text" data-id="'+count_fc+'" data-side="1"></div> </div> </div>'
			+'<div class="back-card" data-id="'+count_fc+'">'
			+'<div class="title">CLICK TO ADD PHOTO OR TEXT</div>'
			+'<div class="butts"><div class="add_image" data-id="'+count_fc+'" data-side="2"></div><div class="add_text" data-id="'+count_fc+'" data-side="2"></div> </div> </div> </div>'
			+'<input name="flip_cards['+count_fc+'][img_src1]" type="hidden" value="" class="input-form-img1" autocomplete="off" data-id="'+count_fc+'">'
			+'<input name="flip_cards['+count_fc+'][img_src2]" type="hidden" value="" class="input-form-img2" autocomplete="off" data-id="'+count_fc+'">'
			+'<input name="flip_cards['+count_fc+'][type_front]" type="hidden" value="image" class="input-type-front" autocomplete="off" data-id="'+count_fc+'">'
			+'<input name="flip_cards['+count_fc+'][type_back]" type="hidden" value="image" class="input-type-back" autocomplete="off" data-id="'+count_fc+'">');
	});
	
	$('.left').on('click', '.front_card', function() {
		side_fc = 1;
		min_sizeh_fc = 11;
		min_sizew_fc = 19;
		current_id = $(this).data('id');
		var wrap = $('.editor[data-id="'+current_id+'"]');
		$(wrap).css({'-webkit-transform':'rotateY(0deg)'});
	});
	
	$('.left').on('click', '.back_card', function() {
		side_fc = 2;
		min_sizeh_fc = 11;
		min_sizew_fc = 19;
		current_id = $(this).data('id');
		var wrap = $('.editor[data-id="'+current_id+'"]');
		$(wrap).css({'-webkit-transform':'rotateY(180deg)'});
	});
	
	$('.preview-modal').on('click', '.flipcard_main_front', function() {
		current_id = $(this).data('id');
		var wrap = $('.flipcard_main_wrap[data-id="'+current_id+'"]');
		$(wrap).css({'-webkit-transform':'rotateY(180deg)'});
	});
	
	$('.preview-modal').on('click', '.flipcard_main_back', function() {
		current_id = $(this).data('id');
		var wrap = $('.flipcard_main_wrap[data-id="'+current_id+'"]');
		$(wrap).css({'-webkit-transform':'rotateY(0deg)'});
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
	
	$('.left').on('click', '.add_text', function() {
		side_fc = $(this).data('side');
		current_id = $(this).data('id');
		if(side_fc == 1) {
			$('.input-type-front[data-id="'+current_id+'"]').val('text');
			$('.front-card[data-id="'+current_id+'"]').empty();
			$('.front-card[data-id="'+current_id+'"]').css({'background' : '#009cff'});
			$('.front-card[data-id="'+current_id+'"]').prepend('<textarea maxlength="100" autocomplete="off" name="flip_cards['+current_id+'][text_front]" class="textarea-add-text" placeholder="Write something awesome" data-id="'+current_id+'" data-side="1"></textarea>');
			$('.front-card[data-id="'+current_id+'"]').prepend('<div class="set-background-buttons"><div class="item-color" data-theme="purple" style="background:#605ca8;" data-id="'+current_id+'"></div><div class="item-color" data-theme="green" style="background:#8dc63f;" data-id="'+current_id+'"></div> <div class="item-color" data-theme="blue" style="background:#009cff;" data-id="'+current_id+'"></div><div class="item-color" data-theme="turquoise" data-id="'+current_id+'" style="background: #00a99d;"> </div></div>');
			$('.front-card[data-id="'+current_id+'"]').prepend("<div data-side='1' data-id='"+current_id+"' class='delete_icon_button'> <img class='delete_icon' src='/img/delete_icon.png'  /></div>");
			$('.front-card[data-id="'+current_id+'"]').prepend('<input name="flip_cards['+current_id+'][theme1]" type="hidden" value="blue" class="input-form-theme1" autocomplete="off" data-id="'+current_id+'">');
			
		} else {
			$('.input-type-back[data-id="'+current_id+'"]').val('text');
			$('.back-card[data-id="'+current_id+'"]').empty();
			$('.back-card[data-id="'+current_id+'"]').css({'background': '#009cff'});
			$('.back-card[data-id="'+current_id+'"]').prepend('<textarea maxlength="100" autocomplete="off" name="flip_cards['+current_id+'][text_back]" class="textarea-add-text" placeholder="Write something awesome" data-id="'+current_id+'" data-side="2"></textarea>');
			$('.back-card[data-id="'+current_id+'"]').prepend('<div class="set-background-buttons"><div class="item-color" data-theme="purple" style="background:#605ca8;" data-id="'+current_id+'"></div><div class="item-color" data-theme="green" style="background:#8dc63f;" data-id="'+current_id+'"></div> <div class="item-color" data-theme="blue" style="background:#009cff;" data-id="'+current_id+'"></div><div class="item-color" data-theme="turquoise" data-id="'+current_id+'" style="background: #00a99d;"> </div></div>');
			$('.back-card[data-id="'+current_id+'"]').prepend("<div data-side='2' data-id='"+current_id+"' class='delete_icon_button'> <img class='delete_icon' src='/img/delete_icon.png'  /></div>");
			$('.back-card[data-id="'+current_id+'"]').prepend('<input name="flip_cards['+current_id+'][theme2]" type="hidden" value="blue" class="input-form-theme2" autocomplete="off" data-id="'+current_id+'">');
		}
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
			   $('.photo').prepend("<img class='main-photo' src='/temp/" + result.file + "'  />");
			   $('.input-form-photo').val(result.file);
			   
		   } else if (image_type_fc == 2) {
			   $('.add_fb_img').empty();
			   $('.add_fb_img').css({'padding-top': '0px'});
			   $('.add_fb_img').prepend("<img class='facebook-photo' src='/temp/" + result.file + "'  />");
			   $('.input-form-photo-facebook').val(result.file);
		   } else if(image_type_fc == 3) {
			   if(side_fc == 1) {
				   $('.front-card[data-id="'+current_id+'"]').empty();
				   $('.front-card[data-id="'+current_id+'"]').prepend("<img class='image-card' src='/temp/" + result.file + "'  />");
				   $('.front-card[data-id="'+current_id+'"]').prepend("<div data-id='"+current_id+"' class='delete_icon_button' data-side='1'> <img class='delete_icon' src='/img/delete_icon.png'  /></div>");
				   $('.input-form-img1[data-id="'+current_id+'"]').val(result.file);
			   } else {
				   $('.back-card[data-id="'+current_id+'"]').empty();
				   $('.back-card[data-id="'+current_id+'"]').prepend("<img class='image-card' src='/temp/" + result.file + "'  />");
				   $('.back-card[data-id="'+current_id+'"]').prepend("<div data-id='"+current_id+"' class='delete_icon_button' data-side='2'> <img class='delete_icon' src='/img/delete_icon.png'  /></div>");
				   $('.input-form-img2[data-id="'+current_id+'"]').val(result.file);
			   }
		   }
	   },
	   imageSize: { minWidth: 320, minHeight: 240, maxWidth: 3840, maxHeight: 2160},
	   
	   onSelect: function (evt, ui){
		  var file = ui.files[0];
		  if( ui.other.length ){
			var errors = ui.other[0].errors;
			var alertHtml = '<div class="warning-text"><b>Warning!</b></div><div class="warning-text-other"><b> The image you are trying to upload is too small / big. </br> Minimum dimensions: 320x240 </br> Maximum dimensions: 3840x2160</b></div>';
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