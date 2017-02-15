$(document).ready(function () {
    id = 1;
    current_id = 1;
	types = [[1]];
    myPixie = Pixie.setOptions({
        replaceOriginal: true,
        onSave: function (data, img) {
            var form = $('form')[0];
            var formData = new FormData(form);

            formData.append('image', data);
            $.ajax({
                url: 'upload/image',
                data: formData,
                type: 'POST',
                // THIS MUST BE DONE FOR FILE UPLOADING
                contentType: false,
                processData: false,
                // ... Other options like success and etc
            }).success(function (response) {
                if (check == 1) {
					$('.text-front-card[data-id="'+current_id+'"]').remove();
					$('.textarea-front-card[data-id="'+current_id+'"]').attr('style', 'margin-top: 293px;');
					$('.set-front-card[data-id="'+current_id+'"]').attr('style', 'background-image: url(/temp/'+response.file+'); background-size: 853px 349px;');
					$('.input-form-img1[data-id="'+current_id+'"]').val(response.file);
                } else if (check == 2) {
					$('.set-back-card[data-id="'+current_id+'"]').remove();
					$('.card-two[data-id="'+current_id+'"]').prepend("<img class='set-back-card' src='/temp/" + response.file + "'  />");
					$('.input-form-img2[data-id="'+current_id+'"]').val(response.file);
                } else if(check == 3) {
                    $('.photo-add').remove();
                    $(".global").prepend("<img class='photo-add' src='/temp/" + response.file + "'  />");
					$('.input-form-photo-facebook').val(response.file);
                } else if(check == 4) {
					$('.photo-add-flip').remove();
                    $(".create-flipcard").prepend("<img class='photo-add-flip' src='/temp/" + response.file + "'  />");
					$('.input-form-photo').val(response.file);
				} else if(check == 5) {
					$('.answer-img-add[data-id="'+current_id+'"][data-type="'+type+'"]').remove();
					$('.answer[data-id="'+current_id+'"][data-type="'+type+'"]').prepend("<img data-id='"+current_id+"' style='margin-left: 0px;' class='answer-img-add' src='/temp/" + response.file + "'  />");
					$('.answer_img[data-id="'+current_id+'"][data-type="'+type+'"').val(response.file);
				}
            });
        }
    });
	
	$('.create-flipcard').on('click', '.textarea-front-card', function (e) {
		return false;
	});

	
	
	
	$('.center-block').on('click', '.block-type-image', function() {
		type = $(this).data('type');
		current_id = $(this).data('id');
		$('.block-type-image[data-id="'+current_id+'"]').css({'background': 'white'});
		$('.block-type-text[data-id="'+current_id+'"]').css({'background': ''});
		$('.answer[data-id="'+current_id+'"]').css({'height': '242px'});
		$('.answer-img-add[data-id="'+current_id+'"]').css({'display': 'block'});
		$('.answer-img-add[data-id="'+current_id+'"]').css({'margin-left': '26px'});
		$('.input-valtype[data-id="'+current_id+'"][data-type="'+type+'"]').val('2');
		types[current_id-1][0] = 2;
	});
	
	$('.center-block').on('click', '.block-type-text', function() {
		type = $(this).data('type');
		current_id = $(this).data('id');
		$('.block-type-image[data-id="'+current_id+'"]').css({'background': ''});
		$('.block-type-text[data-id="'+current_id+'"]').css({'background': 'white'});
		$('.answer[data-id="'+current_id+'"]').css({'height': '82px'});
		$('.answer-img-add[data-id="'+current_id+'"]').css({'display': 'none'});
		$('img.answer-img-add[data-id="'+current_id+'"]').css({'display': 'none'});
		$('.input-valtype[data-id="'+current_id+'"][data-type="'+type+'"]').val('1');
		types[current_id-1][0] = 1;
	});
	
	$('.create-flipcard').on('click', '.add-answer', function() {
		display_text = '';
		current_id = $(this).data('id');
		if($('.answer[data-id="'+current_id+'"]').length < 4) {
			if(types[current_id-1][0] == 1) display_text = 'display:none';
			else display_text = 'display:block';
			if(($('.answer[data-id="'+current_id+'"').length + 1) == 4) $('add-answer[data-id="'+current_id+'"]').css('display', 'none');
			$('.block-answer[data-id="'+current_id+'"]').append('<div class="answer" data-id="'+current_id+'" data-type="'+($('.answer[data-id="'+current_id+'"]').length+1)+'">'
			+'<button data-type="'+($('.answer[data-id="'+current_id+'"]').length+1)+'" style="'+display_text+'" data-id="'+current_id+'" type="button" class="answer-img-add">click to add photo</button>'
			+'<textarea name="flip_cards['+current_id+'][answer'+($('.answer[data-id="'+current_id+'"]').length+1)+']" class="textarea-answer" placeholder="Enter text"></textarea>'
			+'<label class="label-text"><input name="flip_cards['+current_id+'][answer_check'+($('.answer[data-id="'+current_id+'"]').length+1)+']" type="checkbox" name="checkbox" value="true">correct answer</label>'
			+'</div>'
			);
			if(types[current_id-1][0] == 2) $('.answer[data-id="'+current_id+'"]').css({'height': '242px'});
		} else console.log('count answer > 4');
	});
	
	$(".button-add-card").click(function () {
        id = id + 1;
        $.ajax({
            type: "GET",
            url: "upload/getTriviaForm/" + id,
        }).done(function (msg) {
            $(".form-style:last").after(msg);
			types.push([1]);
        });
    });
	
	$('.create-flipcard').on('click', '.answer-img-add', function(e) {
		current_id = $(this).data('id');
		type = $(this).data('type');
		check = 5;
		myPixie.open({
            url: e.target.src,
			image: e.target
        });
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
					  maxSize: [$(window).width()-100, $(window).height()-100],
					  minSize: [200, 200],
					  selection: '1%',
					  onSelect: function (coords){
						 $('.select-file').fileapi('crop', file, coords);
					  }
				   });
				}
			 }).open();
		  }
	   },
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
					$('.modal-alert').modal();
                }
            }
        });
    });
});