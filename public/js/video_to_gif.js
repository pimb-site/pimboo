$(document).ready(function () {

	video_loaded = false;

	$('.caption-gif input').on("change", function(){
		var text = $(this).val();

		if(text.length != 0) {
			$('.txt-caption').text(text);
			if(video_loaded == true) {
				$('.txt-caption').css({'display': 'block'});
			}
		} else {
			$('.txt-caption').css({'display': 'none'});
		}
	});

	$('.start-time').on("change", function() {
		var value = $(this).val();
		var data  = value.split(":", 2);
		var seconds = parseInt(data[0]) * 60 + parseInt(data[1]);

		if(isNaN(seconds)) {
			$(".nstSlider[data-id='1']").nstSlider("set_position", 0);
			$(this).val('0:0');
		} else {
			$(".nstSlider[data-id='1']").nstSlider("set_position", seconds);
		}
	});

	$('.duration-time').on("change", function() {
		var value = $(this).val();
		var data  = value.split(":", 2);
		var seconds  = parseInt(data[0]) * 60 + parseInt(data[1]);

		if(!isNaN(seconds)) {
			if(seconds <= 0 || seconds > 5) {
				$(this).val('0:1');
				$(".nstSlider[data-id='2']").nstSlider("set_position", 1);
			} else { 
				$(".nstSlider[data-id='2']").nstSlider("set_position", seconds);
			}
		} else {
			$(".nstSlider[data-id='2']").nstSlider("set_position", 1);
			$(this).val('0:1');
		}
	});

	$('#input-video').on("change", function() {
		files = this.files[0];
	    var data = new FormData();

	    data.append('_token', token);
	    data.append('file', files);

	    $.ajax({
	        url: '/upload/video',
	        type: 'POST',
	        data: data,
	        cache: false,
	        dataType: 'json',
	        processData: false,
	        contentType: false,
	        success: function( response, textStatus, jqXHR ){
	            if( typeof response.error === 'undefined' ){
	            	$('.iframe-youtube').html("<video id='player-user' src='/uploads/"+response.file+"'  autoplay muted loop></video><div class='txt-caption'> </div>");
	            	$('.un_video').val(response.file);
	            	$('.btn-create-gif button').css({'display': 'block'});

					video = document.getElementById('player-user');

					videoStartTime = 0;
					durationTime = 1;

					video.addEventListener('loadedmetadata', function() {
					  this.currentTime = videoStartTime;
					  $(".nstSlider[data-id='1']").nstSlider("set_range", 1, parseInt(video.duration));
					  $('.txt-caption').css({'display': 'block'});
					  video_loaded = true;
					}, false);

					video.addEventListener('timeupdate', function() {
					  if(this.currentTime > videoStartTime + durationTime){
					    this.currentTime = videoStartTime;
					  }
					});
	            }
	        },
	        error: function( jqXHR, textStatus, errorThrown ){
	        }
	    });
	});

	$('.select-video').click(function() {
		$('#input-video').trigger( 'click' );
	});

	$('.select select option').click(function() {
		var size = $('.select select option:selected').data('size');
		$('.un_size').val(size);

		switch(size) {
			case 0:
				$('.txt-caption').css({"font-size": '40px'});
				break;

			case 1:
				$('.txt-caption').css({"font-size": '60px'});
				break;
			
			case 2:
				$('.txt-caption').css({"font-size": '80px'});
				break;

			default:
				$('.txt-caption').css({"font-size": '40px'});
				break;
		}

	});

	$('.style-gif button').click(function() {
		last_style = $('.un_style').val();
		style = $(this).data('style');

		switch(style) {
			case 0:
				$('.txt-caption').css({"font-family": "'nexablack',sans-serif", "font-style": "normal"});
				break;

			case 1:
				$('.txt-caption').css({"font-family": "Impact,sans-serif", "font-style": "normal"});
				break;
			
			case 2:
				$('.txt-caption').css({"font-family": "Arial,sans-serif", "font-style": "italic"});
				break;

			default:
				$('.txt-caption').css({"font-family": "'nexablack',sans-serif", "font-style": "normal"});
				break;
		}


		$('.style-gif button[data-style="'+last_style+'"]').removeClass('current-style');
		$(this).addClass('current-style');
		$('.un_style').val(style);
	});


	$('.youtube-btn-upload').click(function() {
		var value_yb = $('.block-inputs input').val();

		if(value_yb == "") return false;

		if(getYouTubeIdFromURL(value_yb) != "") {
			loadYbVideoById(getYouTubeIdFromURL(value_yb));
			$('.btn-create-gif button').css({'display': 'block'});
			$('.un_video_url').val(value_yb);
			video_loaded = true;
		}
	});

	$('.color-text-gif button').click(function() {
		last_color = $('.un_color').val();
		color = $(this).data('color');

		switch(color) {
			case 0:
				$('.txt-caption').css({"color": "#fff"});
				break;

			case 1:
				$('.txt-caption').css({"color": "#000000"});
				break;
			
			case 2:
				$('.txt-caption').css({"color": "#ff6666"});
				break;

			case 3:
				$('.txt-caption').css({"color": "#fff35c"});
				break;

			case 4:
				$('.txt-caption').css({"color": "#9933ff"});
				break;

			case 5:
				$('.txt-caption').css({"color": "#00ff99"});
				break;

			case 6:
				$('.txt-caption').css({"color": "#e646b6"});
				break;

			case 7:
				$('.txt-caption').css({"color": "#00ccff"});
				break;

			default:
				$('.txt-caption').css({"color": "#fff"});
				break;
		}

		$('.color-text-gif button[data-color="'+last_color+'"]').css({'border-radius': '0px'});
		$(this).css({'border-radius': '50%'});
		$('.un_color').val(color);
	});

	$(".btn-create-gif button").click(function() {
		$('.btn-create-gif button').css({'display': 'none'});

		// Progress bar
		$('.progressbar').css({'display': 'block'});
	    var elem = document.getElementById("myBar"); 
	    var width = 1;
	    var id = setInterval(frame, 200);
	    function frame() {
	        if (width >= 90) {
	            clearInterval(id);
	            var id = setInterval(frame2, 10000);
	        } else {
	            width++; 
	            $('.percent-bar').html(width + '%');
	            elem.style.width = width + '%'; 
	        }
	    }


	    function frame2() {
	        if (width >= 97) {
	        	clearInterval(id);
	        } else {
	            width++; 
	            $('.percent-bar').html(width + '%');
	            elem.style.width = width + '%'; 
	        }
	    }

	    function frame3() {
	    	if(width > 99) clearInterval(id);
	        width++; 
	        $('.percent-bar').html(width + '%');
	        elem.style.width = width + '%'; 
	    }

		caption = $('.caption-gif input').val();
		$('.un_caption').val(caption);
		$('#create-gif-from-yb').ajaxSubmit({
			dataType: "json",
			success: function (data) {
				clearInterval(id);
				var id = setInterval(frame3, 10);
				$('.progressbar').css({'display': 'none'});
				$('.successfully-create').css({'display': 'block'});

				$('.gif-input').val(data.gif);
				$('.iframe-youtube').html("<img class='picture-gif' src='/temp/"+data.gif+"' />");
				$('.editor').css({'display': 'block'});
				$('.input-form-photo').val(data.thumbnail); 
				$('.add_fb_img').empty();
				$('.add_fb_img').css({'padding-top': '0px'});
				$('.add_fb_img').prepend("<img class='facebook-photo' src='temp/" + data.thumbnail + "'  />");
				$('.input-form-photo-facebook').val(data.thumbnail);
			}
		});
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
					}if (image_type_fc == 2) {
					   $('.add_fb_img').empty();
					   $('.add_fb_img').css({'padding-top': '0px'});
					   $('.add_fb_img').prepend("<img class='facebook-photo' src='temp/" + result.file + "'  />");
					   $('.input-form-photo-facebook').val(result.file);
					}
				}
		    });
		}
	});

	$('#save_draft').click(function() {
		$('.isDraft').val('save');
		
		$('#form_upload_cards').ajaxSubmit({
			dataType: "json",
			success: function (data) {
				if (data.success == true) {
					$('.postID').val(data.id);
					var alertHtml = '<div class="success-save"><center>GIF successfully saved!</center></div>';
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
	
	$('#publish').click(function() {
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

	token = $('input[name="_token"]').val();
	$('.select-file').fileapi({
	   url: 'test_upload_end',
	   autoUpload: false,
	   accept: 'image/*',
	   data: {'_token': token},
	   onFileComplete: function (evt, uiEvt){
		   var result = uiEvt.result; // server response
		   
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