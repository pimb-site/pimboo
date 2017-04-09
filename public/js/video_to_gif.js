$(document).ready(function () {

	count_video_gifs = 1;

	$('.add-to-this').click(function() {
		if(count_video_gifs == 5) return false;
		count_video_gifs++;
		$('.add-to-this').before('<div>Start Time(seconds) <input name="options['+(count_video_gifs - 1)+'][start_time]" type="number" value="'+(count_video_gifs*2)+'" class="start-time-yb">'
								+' End Time(seconds)   <input name="options['+(count_video_gifs - 1)+'][end_time]" type="number" value="'+(count_video_gifs*2 + 2)+'" class="end-time-yb"></div>');

		if(count_video_gifs == 5) $('.add-to-this').css({'display' : 'none'});
	});

	$('.url-youtube-button').click(function() {
		var value_yb = $('.url-youtube-clip').val();

		if(value_yb == "") return false;


		$.ajax({
		  url: 'upload/valid_url',
		  dataType: "json",
		  type: "POST",
		  data: {
		  	video_url: value_yb,
		  	_token: token
		  },
		  success: function(response){
		    if(response.success == true) {
		    	$('.url-youtube').val(value_yb);
		    	$(".youtube-iframe").html(response.html);
		    	$(".add-youtube-gif").modal().open();
		    }
		  }
		});
	});

	$(".create-yb-gif").click(function() {
		$('#create-gif-youtube').ajaxSubmit({
			dataType: "json",
			success: function (data) {
				$('.gif-input').val(data.file);
				$('.gif-input-yb').val(data.file);
				$('#image').attr('src', '/temp/'+response.file);
			}
		});
	});

	// $(".create-yb-gif").click(function() {
	// 	clip_yb    = $('.url-youtube-clip').val();
	// 	gif_main   = $('.gif-input').val();
	// 	start_time = $('.start-time-yb').val();

	// 	$.ajax({
	// 	  url: 'upload_yb_gif',
	// 	  dataType: "json",
	// 	  type: "POST",
	// 	  data: {
	// 	  	gif_main: gif_main,
	// 	  	video_url: clip_yb,
	// 	  	start_time: start_time,
	// 	  	_token: token
	// 	  },
	// 	  success: function(response){
	// 	  	if(response.success == true) {
	// 	  		$('.gif-input').val(response.file);
	// 			$('#image').attr('src', '/temp/'+response.file);
	// 	  	}
	// 	  }
	// 	});
	// });

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
	
	
	
	
	var worker = new Worker('/js/mainGIF.js');

	var URL = window.URL || window.webkitURL;
	if (!URL) {
		document.getElementById("output").innerHTML = 'Your browser is not <a href="http://caniuse.com/bloburls">supported</a>!';
	} else {



	worker.addEventListener('message', function(e) {
		document.getElementById("output").innerHTML = "Done. Look below.";
	
		//image.src = e.data;
		
		gif_main = $('.gif-input').val();
		
		$.post(
		  "/upload_gif",
		  {
			gif: e.data,
			gif_main: gif_main,
			_token: token
		  },
		  onSuccessUploadGIF
		);
	}, false);
	
	function onSuccessUploadGIF(data) {
		if(data.success == true) {
			
			$('.gif-input').val(data.file);
			$('#image').attr('src', '/temp/'+data.file);
		}
	}

	var start = document.getElementById("start-button");
	var end = document.getElementById("end-button");
	var sample = document.getElementById("sample-button");
	var image = document.getElementById('image');
	var speed = document.getElementById("speed");
	var speedrate = document.getElementById("speedrate");

	var flag = false;
	var delay = 100; //default speed

	//control play speed
	speed.addEventListener('change', function(){
		var s = this.value;
		delay = s;
		speedrate.innerHTML = s;
	}, false);


	var v = document.getElementById("v");
	var canvas = document.getElementById('c');
	var context = canvas.getContext('2d');
	var cw,ch;

	v.addEventListener('play', function(){
		cw = v.clientWidth;
		ch = v.clientHeight;
		canvas.width = cw;
		canvas.height = ch;
		draw(v,context,cw,ch);
	},false);

	function draw(v,c,w,h) {
		if(v.paused || v.ended)	return false;
		c.drawImage(v,0,0,w,h);
		if(flag == true){
			var imdata = c.getImageData(0,0,w,h);
			worker.postMessage({frame: imdata});
		}
		setTimeout(draw,delay,v,c,w,h);
	}

	sample.addEventListener('click', function(){
		v.src = 'small.webm';
	},false);

	start.addEventListener('click', function(){
		flag = true;
		worker.postMessage({delay:delay,w:cw,h:ch});
		document.getElementById("output").innerHTML = "Capturing video frames.";
	},false);

	end.addEventListener('click', function(){
		flag = false;
		worker.postMessage({});
		document.getElementById("output").innerHTML = "Processing the GIF.";
	},false);


		/* Drag drop stuff */
		window.ondragover = function(e) {e.preventDefault()}
		window.ondrop = function(e) {
			e.preventDefault();
			document.getElementById("output").innerHTML = "Reading...";
			var length = e.dataTransfer.items.length;
			if(length > 1){
				document.getElementById("output").innerHTML = "Please only drop 1 file.";
			} else {
				upload(e.dataTransfer.files[0]);
			}
		}

		/* main upload function */
		function upload(file) {

			//check if its a video file
			if(file.type.match(/video\/*/)){
				/*
				oFReader = new FileReader();
				oFReader.onloadend = function() {

					document.getElementById("output").innerHTML = "";

					var blob = new Blob([this.result], {type: file.type});
					var url = URL.createObjectURL(blob);

					v.src = url;
				};
				//oFReader.readAsBinaryString(file);
				oFReader.readAsArrayBuffer(file);
				*/

				//why read the whole video into memory when you can stream!!
				document.getElementById("output").innerHTML = "";
				var url = URL.createObjectURL(file);
				v.src = url;

			} else {
				document.getElementById("output").innerHTML = "This file does not seem to be a video.";
			}
		}
	}