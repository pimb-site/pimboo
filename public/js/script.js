$(document).ready(function () {
    id = 1;
    current_id = 1;

	$(".right-block").on("click", ".front-card-button", function() {
		current_id = $(this).data('id');
		var wrap = $('.form-set-card[data-id="'+current_id+'"]');
		$(wrap).css({'-webkit-transform':'rotateY(0deg)'});
	});
	
	$(".right-block").on("click", ".back-card-button", function() {
		current_id = $(this).data('id');
		var wrap = $('.form-set-card[data-id="'+current_id+'"]');
		$(wrap).css({'-webkit-transform':'rotateY(180deg)'});
	});
	
	$(".button-add-card").click(function () {
        id = id + 1;
        $.ajax({
            type: "GET",
            url: "upload/getForm/" + id,
        }).done(function (msg) {
            $(".form-set-card:last").after(msg);
			$(".back-card-button:last").after(
				'<button type="button" class="front-card-button" data-id="'+id+'">'
				+'<b>Front Card</b>'
				+'</button>'
				+'<button type="button" class="back-card-button" data-id="'+id+'">'
				+'<b>Back Card</b>'
				+'</button>');
        });
    });
	
    $('.button-publish').click(function () {
        var alertHtml = '<div class="alert alert-danger"><ul>';
        $('#form_upload_cards').ajaxSubmit({
            dataType: "json",
            success: function (data) {
                if (data.success == true) {
					url = "http://test.local/success/"+data.id;
					$( location ).attr("href", url);
                } else {
                    $.each(data.errors, function (i, value) {
                        alertHtml += '<li>' + value + '</li>';
                    });
                    alertHtml += '</ul> </div>';
					$('.modal-alert').html(alertHtml);
					$('.modal-alert').modal().open();
                }
            }
        });
    });
	
	$('.center-block').on('click', '.button-test1', function() {
		current_id = $(this).data('id');
		check = 1;
		$('#modal-test').modal({
			closeOnEsc: true,
			closeOnOverlayClick: true,
			onOpen: function (overlay){
				$(overlay).on('click', '.js-upload', function (){
				});
			}
	 }).open();
	});
	
	$('.photo-add').click(function() {
		check = 3;
		$('#modal-test').modal({
			closeOnEsc: true,
			closeOnOverlayClick: true,
			onOpen: function (overlay){
				$(overlay).on('click', '.js-upload', function (){
				});
			}
	   }).open();
		
	});
	
	$('.photo-add-flip').click(function() {
		check = 4;
		$('#modal-test').modal({
			closeOnEsc: true,
			closeOnOverlayClick: true,
			onOpen: function (overlay){
				$(overlay).on('click', '.js-upload', function (){
				});
			}
	   }).open();
		
	});
	
	$('.center-block').on('click', '.button-test2', function() {
		current_id = $(this).data('id');
		check = 2;
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
		   if(check == 1) {
			   	$('.set-front-card[data-id="'+current_id+'"]').remove();
				$('.card-one[data-id="'+current_id+'"]').prepend("<img class='set-front-card' src='/temp/" + result.file + "'  />");
				$('.input-form-img1[data-id="'+current_id+'"]').val(result.file);
		   } else if(check == 2){
			   $('.set-back-card[data-id="'+current_id+'"]').remove();
			   $('.card-two[data-id="'+current_id+'"]').prepend("<img class='set-back-card' src='/temp/" + result.file + "'  />");
			   $('.input-form-img2[data-id="'+current_id+'"]').val(result.file);
		   } else if(check == 3) {
			    $('.photo-add').remove();
                $(".global").prepend("<img class='photo-add' src='/temp/" + result.file + "'  />");
				$('.input-form-photo-facebook').val(result.file);
		   } else if(check == 4) {
			   	$('.photo-add-flip').remove();
                $(".create-flipcard").prepend("<img class='photo-add-flip' src='/temp/" + result.file + "'  />");
			    $('.input-form-photo').val(result.file);
		   }
		   
	   },
	   imageSize: { minWidth: 320, minHeight: 240, maxWidth: 3840, maxHeight: 2160},
	   
	   onSelect: function (evt, ui){
		  var file = ui.files[0];

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
					  maxSize: [400, 400],
					  minSize: [10, 10],
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