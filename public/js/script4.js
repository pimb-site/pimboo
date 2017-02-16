$(document).ready(function () {
	
	side_fc       = 1;
	count_fc      = 1;
	current_id    = 1;
	image_type_fc = 1;
	min_sizeh_fc  = 10;
	min_sizew_fc  = 10;
	
	
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
				   } else {
					   $('.main-remove-back[data-id="'+current_id+'"]').empty();
					   $('.back-card[data-id="'+current_id+'"]').prepend("<img style='position:relative; margin-top:157px; margin-left: 324px; opacity: 0.5' src='/img/movie_icon.png'  />");
					   $('.back-card[data-id="'+current_id+'"]').prepend("<img style='position:absolute;' class='image-card' src='"+response.thumbnail_url+"'  />");
					   $('.type-caption[data-id="'+current_id+'"][data-side="2"]').css({'margin-top': '60px'})
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
	
	$('#publish').click(function() {
		var alertHtml = '<div class="warning-text"><b>Warning!</b></div> <ul>';
        $('#form_upload_cards').ajaxSubmit({
            dataType: "json",
            success: function (data) {
                if (data.success == true) {
					url = "http://bred.local/success/"+data.id;
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
	
	
	$(".add-question").click(function() {
		count_fc++;
		$(".edit-answers:last").after('<div class="buttons" style="float:left;"><button type="button" class="front_card_question" style="background-color: #99afd9;" data-id="'+count_fc+'">QUESTION</button>'
		+'<button type="button" class="back_card_question" data-id="'+count_fc+'">RESULT</button></div>'
		+'<div class="editor" style="float:left;" data-id="'+count_fc+'"><div class="front-card" data-id="'+count_fc+'">'
		+'<div class="title">CLICK TO ADD PHOTO OR VIDEO</div><div class="butts"><div class="add_plus" data-id="'+count_fc+'" data-side="1"></div></div>'
		+'<div class="block-type-caption"><textarea style="position:relative;" class="type-caption" placeholder="Type your caption"></textarea></div></div>'
		+'<div class="back-card" data-id="'+count_fc+'"><div class="title">CLICK TO ADD PHOTO OR VIDEO</div><div class="butts">'
		+'<div class="add_plus" data-id="'+count_fc+'" data-side="2"></div></div>'
		+'<div class="block-type-caption"><textarea class="type-caption" style="position:relative;" placeholder="Type your caption"></textarea></div></div></div>'
		+'<div class="edit-answers"><div class="media-answer"><div class="title">CHOOSE ANSWER MEDIA</div><div class="buttons-answer">'
		+'<div class="btn-text"></div><div class="btn-img"></div></div></div><div class="add-answer"><div class="answer-photo" data-id="'+count_fc+'" data-side="1"><b>CLICK<br/> TO ADD PHOTO</b></div>'
		+'<div class="answer-text"> <textarea placeholder="Enter text"></textarea></div><div class="answer-checkbox"><label> <input type="checkbox">Correct answer</label>'
		+'</div></div><div class="add-answer"><div class="answer-photo" data-id="'+count_fc+'" data-side="2"><b>CLICK<br/> TO ADD PHOTO</b></div>'
		+'<div class="answer-text"> <textarea placeholder="Enter text"></textarea></div>'
		+'<div class="answer-checkbox"><label> <input type="checkbox">Correct answer</label></div></div></div>');
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
				   $('.main-remove-front[data-id="'+current_id+'"]').empty();
				   $('.type-caption[data-id="'+current_id+'"][data-side="1"]').css({'margin-top': '317px'})
				   $('.front-card[data-id="'+current_id+'"]').prepend("<img style='position:absolute;' class='image-card' src='/temp/" + result.file + "'  />");
				   $('.input-form-img1[data-id="'+current_id+'"]').val(result.file);
			   } else {
				   $('.main-remove-back[data-id="'+current_id+'"]').empty();
				   $('.type-caption[data-id="'+current_id+'"][data-side="2"]').css({'margin-top': '317px'})
				   $('.back-card[data-id="'+current_id+'"]').prepend("<img style='position:absolute;' class='image-card' src='/temp/" + result.file + "'  />");
				   $('.input-form-img2[data-id="'+current_id+'"]').val(result.file);
			   }
		   } else if(image_type_fc == 4) {
			   $('.answer-photo[data-id="'+current_id+'"][data-side="'+side_fc+'"]').empty();
			   $('.type-caption[data-id="'+current_id+'"][data-side="2"]').css({'margin-top': '317px'})
			   $('.answer-photo[data-id="'+current_id+'"][data-side="'+side_fc+'"]').css({'padding-top': '0px'});
			   $('.answer-photo[data-id="'+current_id+'"][data-side="'+side_fc+'"]').prepend("<img style='width: 199px; height:157px;' src='/temp/" + result.file + "'  />");
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