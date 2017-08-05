$(document).ready(function () {
	$('.nstSlider').nstSlider({
	    "left_grip_selector": ".leftGrip",
	    "value_bar_selector": ".bar",
	    "value_changed_callback": function(cause, leftValue, rightValue) {
	    	var id = $(this).data('id');

	    	if(id == 1) {
	    		startt = leftValue;

	    		if(typeof video != "undefined") {
	    			videoStartTime = leftValue;
	    			video.currentTime = videoStartTime;
	    		}

	    		$('.un_start_time').val(leftValue);
	    		leftValue = Math.floor(leftValue / 60) + ':' + leftValue % 60;
	    		$('.choose-time .start-time').val(leftValue);

	    	} else if (id == 2) {
	    		durationTime = leftValue;
	    		secs = parseInt(leftValue + '000');

	    		if(typeof video != "undefined") {
	    			videoStartTime = startt;
	    			video.currentTime = videoStartTime;
	    		}

	    		$('.un_end_time').val(leftValue);
	    		leftValue = Math.floor(leftValue / 60) + ':' + leftValue % 60;
	    		$('.choose-time .duration-time').val(leftValue);
	    	}
	    }
	});

	function lock_buttons() {
		$(".block-for-select-video").hide(1000);
		$('.block-for-giftext').hide(1000);
	}

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
				$(".nstSlider[data-id='2']").nstSlider("set_position", 0);
			} else { 
				$(".nstSlider[data-id='2']").nstSlider("set_position", seconds);
			}
		} else {
			$(".nstSlider[data-id='2']").nstSlider("set_position", 0);
			$(this).val('0:1');
		}
	});

	$('#input-video').on("change", function() {
		var alertHtml = '<div class="warning-img"></div><div class="warning-text"><b>Something went wrong</b></div> <ul>';
		var files = this.files[0];
		if(files.type != 'video/mp4') {
			alertHtml += '<center><li>Invalid file type! Please, upload a video with the format mp4.</li></center>';
			alertHtml += '</ul>';
			$('.modal-alert').html(alertHtml);
			$('.modal-alert').modal().open();
		}

		if(files.size/1024/1024 > 15) {
			alertHtml += '<center><li>The file size must not exceed 15 MB.</li></center>';
			alertHtml += '</ul>';
			$('.modal-alert').html(alertHtml);
			$('.modal-alert').modal().open();
		} else {
			variant_upload_video = 2;
			video_loaded = true;
			$('.btn-create-gif button').css({'display': 'block'});
			var url = URL.createObjectURL(files);

			$('.iframe-youtube').html("<video id='player-user' src='"+url+"'  autoplay muted loop></video><div class='txt-caption'> </div>");

			video = document.getElementById('player-user');
			videoStartTime = 0;
			durationTime = 1;
			video.addEventListener('loadedmetadata', function() {
				this.currentTime = videoStartTime;
				$(".nstSlider[data-id='1']").nstSlider("set_range", 0, parseInt(video.duration));
				$('.txt-caption').css({'display': 'block'});
				video_loaded = true;
			}, false);

			video.addEventListener('timeupdate', function() {
				if(this.currentTime > videoStartTime + durationTime){
					this.currentTime = videoStartTime;
				}
			});
		}
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
			variant_upload_video = 1;
		}
	});

	$('.color-text-gif button').click(function() {
		var last_color = $('.un_color').val();
		var color = $(this).data('color');

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


		if(variant_upload_video == 1) {
			$('.un_variant').val(1);
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
					$('.input-form-photo').val(data.thumbnail_main); 
					$('.add_fb_img').empty();
					$('.add_fb_img').css({'padding-top': '0px'});
					$('.add_fb_img').prepend("<img class='facebook-photo' src='/temp/" + data.thumbnail_fb + "'  />");
					$('.input-form-photo-facebook').val(data.thumbnail_fb);
					lock_buttons();
				}
			});
		} else if(variant_upload_video == 2) {
			$('.un_variant').val(2);
			var document_file = document.getElementById("input-video");
			var files = document_file.files[0];
			var data = new FormData();

		    data.append('file', files);

			$.ajax({
			    url : 'http://146.185.164.150/blob.php',
			    type : 'POST',
			    data : data,
			    processData: false,
			    dataType: "json",
			    contentType: false,
			    success : function(data) {
			    	if(data.success == true) {
			    		$(".un_filename").val(data.filename);
			    		myselfVideo();
			    	}
		        }
			});


		}
	});

	function myselfVideo() {
		$('#create-gif-from-yb').ajaxSubmit({
			dataType: "json",
			success: function (data) {
				$('.progressbar').css({'display': 'none'});
				$('.successfully-create').css({'display': 'block'});

				$('.gif-input').val(data.gif);
				$('.iframe-youtube').html("<img class='picture-gif' src='/temp/"+data.gif+"' />");
				$('.editor').css({'display': 'block'});
				$('.input-form-photo').val(data.thumbnail_main); 
				$('.add_fb_img').empty();
				$('.add_fb_img').css({'padding-top': '0px'});
				$('.add_fb_img').prepend("<img class='facebook-photo' src='/temp/" + data.thumbnail_fb + "'  />");
				$('.input-form-photo-facebook').val(data.thumbnail_fb);
				lock_buttons();
			}
		});
	}

	$('.btn-save').click(function() {
		$('.isDraft').val('save');
		
		$('#form_upload_cards').ajaxSubmit({
			dataType: "json",
			success: function (data) {
				if (data.success == true) {
					$('.postID').val(data.id);
					var alertHtml = '<div class="success-img"></div><div class="success-text"><b>GIF successfully saved!</b></div><button type="button" onclick="window.location.href = \''+'/edit'+data.link+'\'" class="success-button btn btn_browse btn_browse_small">OK</button>';
						$('.modal-alert').html(alertHtml);
						$('.modal-alert').modal({
				            closeOnEsc: false,
				            closeOnOverlayClick: false,
						}).open();
						setTimeout(function() { window.location.href = '/edit'+data.link; }, 2000);
				} else {
					alertHtml = '<div class="warning-img"></div><div class="warning-text"><b>Something went wrong</b></div> <ul>';
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
		var alertHtml = '<div class="warning-img"></div><div class="warning-text"><b>Something went wrong</b></div> <ul>';
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
});