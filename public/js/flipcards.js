$(document).ready(function () {
	
	token = '{!! csrf_token() !!}';
	side_fc       = 1;
	current_id    = 1;
	image_type_fc = 1;
	min_sizeh_fc  = 10;
	min_sizew_fc  = 10;
	var ScreenWidth = screen.width;
	var maxSizeW;
	if (ScreenWidth >= 768) {
		ScreenWidth = '50%';
		maxSizeW    = 700;
	} else if (ScreenWidth <= 479){
		ScreenWidth = '50%';
		maxSizeW    = 300;
	}
	else {
		ScreenWidth = '50%';
		maxSizeW    = 400;
	}

	
	$('.upload-img-url-btn').click(function() {
		value_url = $('.upload-img-url').val();
		$.modal().close();
		var token = $('input[name="_token"]').val();
		if(value_url != "") {
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
				} else  {
					var alertHtml = '<button type="button" class="close" onclick="$(\'.modal-alert\').modal().close();" data-dismiss="modal" aria-hidden="true">&times;</button><div class="warning-img"></div><div class="warning-text"><b>Something went wrong</b></div> <ul>';
                    $.each(result.errorText, function (i, value) {
                        alertHtml += '<li>' + value + '</li>';
                    });
                    alertHtml += '</ul>';
					$('.modal-alert').html(alertHtml);
					$('.modal-alert').modal().open();
				}
			});
		}
	});
	
	$('.btn-preview').click(function() {
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
						var repository = '/uploads/';
						$.each(data.cards, function (i, value) {
							if(value.card_item_title == null) value.card_item_title = "";
							$(".flipcard_main_footer").before('<div class="flipcard_main_cards">'
								+'<div class="flipcard_item_title">'+value.card_item_title+'</div>'
								+'<div class="flipcard_main_wrap" data-id="'+i+'">'
								+'<div class="flipcard_main_front" data-id="'+i+'"></div>'
								+'<div class="flipcard_main_back" data-id="'+i+'"></div>'
								+'</div></div></div>');
							if(value.card_type_front == "image") {
								if(typeof value.front_card_image == 'undefined' || value.front_card_image == "") value.front_card_image = "../img/no-img.jpg";
								else repository = (~value.front_card_image.indexOf('/')) ? '/temp/' : '/uploads/';
								$('.flipcard_main_front[data-id="'+i+'"]').append('<img class="image-card" src="'+repository+value.front_card_image+'" />');
							} else {
								$('.flipcard_main_front[data-id="'+i+'"]').css({'background-color': value.front_card_theme});
								$('.flipcard_main_front[data-id="'+i+'"]').append('<div class="flipcard_main_text">'+value.front_card_text+'</div>');
							}
							
							if(value.card_type_back == "image") {
								if(typeof value.back_card_image == 'undefined' || value.back_card_image == "") value.back_card_image = "../img/no-img.jpg";
								else repository = (~value.back_card_image.indexOf('/')) ? '/temp/' : '/uploads/';
								$('.flipcard_main_back[data-id="'+i+'"]').append('<img class="image-card" src="'+repository+value.back_card_image+'" />');
								
							} else {
								$('.flipcard_main_back[data-id="'+i+'"]').css({'background-color': value.back_card_theme});
								$('.flipcard_main_back[data-id="'+i+'"]').append('<div class="flipcard_main_text">'+value.back_card_text+'</div>');
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

	
	$('.btn-publish').click(function() {
		$('.isDraft').val('publish');

		var alertHtml = '<button type="button" class="close" onclick="$(\'.modal-alert\').modal().close();" data-dismiss="modal" aria-hidden="true">&times;</button><div class="warning-img"></div><div class="warning-text"><b>Something went wrong</b></div> <ul>';
		if (typeof  tinymce_init != 'undefined' && tinymce_init == 1) {
			tinyMCE.get("content_textarea").save();
		}
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
	
	$('.btn-save').click(function() {
		$('.isDraft').val('save');
		if (typeof  tinymce_init != 'undefined' && tinymce_init == 1) {
			tinyMCE.get("content_textarea").save();
			var tool = 'Story';
		} else var tool = 'Flip Cards';
		$('#form_upload_cards').ajaxSubmit({
			dataType: "json",
			success: function (data) {
				if (data.success == true) {
					$('.postID').val(data.id);
					alertHtml = '<div class="success-img"></div><div class="success-text"><b>'+tool+' successfully saved!</b></div><button type="button" onclick="window.location.href = \''+'/edit'+data.link+'\'" class="success-button btn btn_browse btn_browse_small">OK</button>';
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
	
	
	$("#add_card").click(function() {
		count_fc++;
		$(".editor:last").after('<div class="buttons">'
			+'<button type="button" class="front_card" data-id="'+count_fc+'" style="background-color: #99afd9;">FRONT CARD</button>'
			+'<button type="button" class="back_card" data-id="'+count_fc+'">BACK CARD</button>'
			+'</div>'
			+'<input class="item-title-input" type="text" name="flipcards[cards]['+count_fc+'][card_item_title]" placeholder="Enter item title (45 symbols max)" maxlength="45">'
			+'<div class="editor" data-id="'+count_fc+'"> <div class="front-card" data-id="'+count_fc+'">'
			+'<div class="title">CLICK TO ADD PHOTO OR TEXT</div> <div class="butts">'
			+'<div class="add_image" data-id="'+count_fc+'" data-side="1"></div> <div class="add_text" data-id="'+count_fc+'" data-side="1"></div> </div> </div>'
			+'<div class="back-card" data-id="'+count_fc+'">'
			+'<div class="title">CLICK TO ADD PHOTO OR TEXT</div>'
			+'<div class="butts"><div class="add_image" data-id="'+count_fc+'" data-side="2"></div><div class="add_text" data-id="'+count_fc+'" data-side="2"></div> </div> </div> </div>'
			+'<input name="flipcards[cards]['+count_fc+'][front_card_image]" type="hidden" value="" class="input-form-img1" autocomplete="off" data-id="'+count_fc+'">'
			+'<input name="flipcards[cards]['+count_fc+'][back_card_image]" type="hidden" value="" class="input-form-img2" autocomplete="off" data-id="'+count_fc+'">'
			+'<input name="flipcards[cards]['+count_fc+'][card_type_front]" type="hidden" value="image" class="input-type-front" autocomplete="off" data-id="'+count_fc+'">'
			+'<input name="flipcards[cards]['+count_fc+'][card_type_back]" type="hidden" value="image" class="input-type-back" autocomplete="off" data-id="'+count_fc+'">');
	});
	
	$('.left').on('click', '.front_card', function() {
		side_fc = 1;
		min_sizeh_fc = 11;
		min_sizew_fc = 19;
		current_id = $(this).data('id');
		var wrap = $('.editor[data-id="'+current_id+'"]');
		$('.front_card[data-id="'+current_id+'"]').css({'background-color': '#99afd9'});
		$('.back_card[data-id="'+current_id+'"]').css({'background-color': '#c2cfe8'});
		$(wrap).css({'-webkit-transform':'rotateY(0deg)'});
	});
	
	$('.left').on('click', '.back_card', function() {
		side_fc = 2;
		min_sizeh_fc = 11;
		min_sizew_fc = 19;
		current_id = $(this).data('id');
		var wrap = $('.editor[data-id="'+current_id+'"]');
		$('.back_card[data-id="'+current_id+'"]').css({'background-color': '#99afd9'});
		$('.front_card[data-id="'+current_id+'"]').css({'background-color': '#c2cfe8'});
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
			$('.front-card[data-id="'+current_id+'"]').prepend('<textarea maxlength="100" autocomplete="off" name="flipcards[cards]['+current_id+'][front_card_text]" class="textarea-add-text" placeholder="Write something awesome" data-id="'+current_id+'" data-side="1"></textarea>');
			$('.front-card[data-id="'+current_id+'"]').prepend('<div class="set-background-buttons"><div class="item-color" data-theme="purple" style="background:#605ca8;" data-id="'+current_id+'"></div><div class="item-color" data-theme="green" style="background:#8dc63f;" data-id="'+current_id+'"></div> <div class="item-color" data-theme="blue" style="background:#009cff;" data-id="'+current_id+'"></div><div class="item-color" data-theme="turquoise" data-id="'+current_id+'" style="background: #00a99d;"> </div></div>');
			$('.front-card[data-id="'+current_id+'"]').prepend("<div data-side='1' data-id='"+current_id+"' class='delete_icon_button'> <img class='delete_icon' src='/img/delete_icon.png'  /></div>");
			$('.front-card[data-id="'+current_id+'"]').prepend('<input name="flipcards[cards]['+current_id+'][front_card_theme]" type="hidden" value="blue" class="input-form-theme1" autocomplete="off" data-id="'+current_id+'">');
			
		} else {
			$('.input-type-back[data-id="'+current_id+'"]').val('text');
			$('.back-card[data-id="'+current_id+'"]').empty();
			$('.back-card[data-id="'+current_id+'"]').css({'background': '#009cff'});
			$('.back-card[data-id="'+current_id+'"]').prepend('<textarea maxlength="100" autocomplete="off" name="flipcards[cards]['+current_id+'][back_card_text]" class="textarea-add-text" placeholder="Write something awesome" data-id="'+current_id+'" data-side="2"></textarea>');
			$('.back-card[data-id="'+current_id+'"]').prepend('<div class="set-background-buttons"><div class="item-color" data-theme="purple" style="background:#605ca8;" data-id="'+current_id+'"></div><div class="item-color" data-theme="green" style="background:#8dc63f;" data-id="'+current_id+'"></div> <div class="item-color" data-theme="blue" style="background:#009cff;" data-id="'+current_id+'"></div><div class="item-color" data-theme="turquoise" data-id="'+current_id+'" style="background: #00a99d;"> </div></div>');
			$('.back-card[data-id="'+current_id+'"]').prepend("<div data-side='2' data-id='"+current_id+"' class='delete_icon_button'> <img class='delete_icon' src='/img/delete_icon.png'  /></div>");
			$('.back-card[data-id="'+current_id+'"]').prepend('<input name="flipcards[cards]['+current_id+'][back_card_theme]" type="hidden" value="blue" class="input-form-theme2" autocomplete="off" data-id="'+current_id+'">');
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
			var alertHtml = '<div class="warning-img"></div><div class="warning-text"><b>Something went wrong</b></div><div class="warning-text-other"><b> The image you are trying to upload is too small / big. </br> Minimum dimensions: 320x240 </br> Maximum dimensions: 3840x2160</b></div>';
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