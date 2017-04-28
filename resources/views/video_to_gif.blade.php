<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pimboo GIF Maker</title>
	<link href="css/style.min.css" rel="stylesheet">
	<link href="css/trivia_new.css" rel="stylesheet">
	<link href="test/jcrop/jquery.Jcrop.min.css" rel="stylesheet" type="text/css"/>
	<link type="text/css" rel="stylesheet" href="css/jquery.nstSlider.min.css">
</head>
	<body class="tools_create_page">
	<img id="loadImg" src="img/ajax-loader.gif" />
		@include('header')
		<div class="body">
		<input type="file" name="video" id="input-video" accept="video/mp4" style="display: none;" />
		<form id="form_upload_cards" action="/upload_end_gif" method="POST">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="left">
				<div class="title">GIF CREATION</div>
				<div class="sub_title">Add all necessary information to create a new GIF image</div>
				<div class="card_info">
					<div class="top">
						<div class="text_info" style="width: 100%;">
							<input class="top-input-video" type="text" name="form_flip[form_flip_cards_title]" placeholder="GIF Title" autocomplete="off" >
							<textarea class="top-textarea-video" name="form_flip[form_description]"  placeholder="GIF Description" autocomplete="off"></textarea>
						</div>
					</div>
				</div>

				<div class="block-for-select-video">
					<div class="title">ADD VIDEO TO CREATE NEW GIF</div>
					<div class="block-inputs">
						<button type="button" class="select-video">SELECT VIDEO</button>
						<div class="txt-or"> OR </div>
						<div class="yb-clip-upl">
							<input placeholder="Enter YouTube clip URL">
							<button type="button" class="youtube-btn-upload">UPLOAD</button>
						</div>
					</div>
				</div>
				<div class="block-video-duration">
					<div class="title">CHOOSE TIME DURATION</div>
					<div class="iframe-youtube"><div id="player"></div> <div class="txt-caption"> </div></div>

					<div class="choose-time">START TIME <input class="start-time"></div>
					<div class="nstSlider" data-id="1" data-range_min="0" data-range_max="3600"
					                       data-cur_min="0"     data-cur_max="3600">

					    <div class="bar"></div>
					    <div class="leftGrip"></div>
					</div>

					<div class="choose-time">DURATION <input class="duration-time"></div>
					<div class="nstSlider" data-id="2" data-range_min="1" data-range_max="5"
					                       data-cur_min="1"     data-cur_max="0">

					    <div class="bar"></div>
					    <div class="leftGrip"></div>
					</div>
					<div class="btn-create-gif">
						<button type="button" style="display: none;">CREATE</button>
					</div>


					<div class="progressbar" style="display: none;">
						<div class="txt-gif-creating"> GIF IS CREATING </div>
						<div id="myProgress" >
						  <div id="myBar"></div>
						</div>
						<div class="percent-bar">1%</div>
					</div>
					<div class="successfully-create">GIF WAS CREATED!</div>
				</div>


				<div class="block-for-giftext">
					<div class="title">ADD TEXT AND EFFECTS TO YOUR GIF</div>
					<div class="caption-gif">
						<div class="type-title">Caption</div> 
						<input placeholder="Please enter your text here" maxlength="12">
					</div>
					<div class="style-gif">
						<div class="type-title">Style</div>
						<button type="button" class="default current-style" data-style="0">DEFAULT</button>
						<button type="button" class="meme" data-style="1">MEME</button>
						<button type="button" class="subtitle" data-style="2">SUBTITLE</button>
					</div>
					<div class="color-text-gif">
						<div class="type-title">Color</div>
						<div class="btn-color-left">
							<button type="button" class="white"  data-color="0"></button>
							<button type="button" class="black"  data-color="1"></button>
							<button type="button" class="red"    data-color="2"></button>
							<button type="button" class="yellow" data-color="3"></button>
						</div>
						<div class="btn-color-right">
							<button type="button" class="purple" data-color="4"> </button>
							<button type="button" class="green" data-color="5"> </button>
							<button type="button" class="pink" data-color="6"> </button>
							<button type="button" class="blue" data-color="7"> </button>
						</div>
					</div>
					<div class="text-style-gif">
						<div class="type-title">Text size</div>
						<div class="select">
							<select>
								<option data-size="0">40 pixels</option>
								<option data-size="1">60 pixels</option>
								<option data-size="2">80 pixels</option>
							</select>
						</div>
					</div>
				</div>

				<div class="down_butts" style="margin-top:20px;">
					<button type="button" id="save_draft">SAVE DRAFT</button>
					<button type="button" id="publish">PUBLISH</button>
				</div>
				<input name="isDraft" type="hidden" value="publish" class="isDraft" autocomplete="off">
				<input name="postID" type="hidden" value="" class="postID" autocomplete="off">
				<input name="form_flip[form_photo]" type="hidden" value="" class="input-form-photo" autocomplete="off">
				<input name="form_flip[form_photo_facebook]" type="hidden" value="" class="input-form-photo-facebook" autocomplete="off">
				<input name="form_flip[gif]" type="hidden" value="" class="gif-input" autocomplete="off">
			</div>
			
			<div class="right">
				<div class="title">SOCIAL APPEARANCE</div>
				<div class="sub_title">How your content will appear on social media</div>
				<div class="facebok_block">
					<div class="add_fb_img" style="padding-top: 40px; font-weight: 600;">CREATED GIF</div>
					<div class="edit_image_text">
						Your GIF will be<br>in Facebook
					</div>
				</div>
				<div class="tags_block">
					<div class="title">TAGS</div>
					<div class="tags">
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Celebrities"><span class="checkbox-custom"></span><span class="label">Celebrities</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Love"><span class="checkbox-custom"></span><span class="label">Love</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="TV"><span class="checkbox-custom"></span><span class="label">TV</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Holidays"><span class="checkbox-custom"></span><span class="label">Holidays</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Film"><span class="checkbox-custom"></span><span class="label">Film</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Retro"><span class="checkbox-custom"></span><span class="label">Retro</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Music"><span class="checkbox-custom"></span><span class="label">Music</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Tech"><span class="checkbox-custom"></span><span class="label">Tech</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Style"><span class="checkbox-custom"></span><span class="label">Style</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Politics"><span class="checkbox-custom"></span><span class="label">Politics</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Sexy"><span class="checkbox-custom"></span><span class="label">Sexy</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Internet"><span class="checkbox-custom"></span><span class="label">Internet</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Cute"><span class="checkbox-custom"></span><span class="label">Cute</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Books"><span class="checkbox-custom"></span><span class="label">Books</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Food"><span class="checkbox-custom"></span><span class="label">Food</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Sports"><span class="checkbox-custom"></span><span class="label">Sports</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Funny"><span class="checkbox-custom"></span><span class="label">Funny</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="World"><span class="checkbox-custom"></span><span class="label">World</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Animals"><span class="checkbox-custom"></span><span class="label">Animals</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Arts"><span class="checkbox-custom"></span><span class="label">Arts</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Games"><span class="checkbox-custom"></span><span class="label">Games</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="News"><span class="checkbox-custom"></span><span class="label">News</span></label></div>
					</div>
				</div>
				<div class="down_butts video_to_gif_butts">
					<button type="button" id="save_draft">SAVE DRAFT</button>
					<button type="button" id="publish">PUBLISH</button>
				</div>
			</div>
			</form>


			<form id="create-gif-from-yb" action="/upload_yb_gif" method="POST">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="video_youtube" value="" class="un_video_url">
				<input type="hidden" name="options[0][start_time]" class="un_start_time" value="0">
				<input type="hidden" name="options[0][end_time]" class="un_end_time" value="1">
				<input type="hidden" name="color" class="un_color" value="0">
				<input type="hidden" name="font_family" class="un_style" value="0">
				<input type="hidden" name="font_size" class="un_size" value="0">
				<input type="hidden" name="caption" class="un_caption" value="">
				<input type="hidden" name="video_site" class="un_video" value="">
			</form>



		</div>
		<footer>
			<div class="up">
				<div class="wrap">
					<div class="left">
						Pimboo OÜ<br>
						Laki tn 30 PK 302-3<br>
						Tallinn, Estonia 12915<br>
					</div>
					<div class="center">© Copyright Pimboo.com All Rights Reserved.</div>
					<div class="right">
						<a class="icon" target="_blank" href="https://www.facebook.com/pimboosocial" id="fb_icon_footer"></a>
						<a class="icon" target="_blank" href="https://twitter.com/pimboosocial" id="twitter_icon_footer"></a>
						<a class="icon" target="_blank" href="https://www.instagram.com/pimboosocial/" id="instagram_icon_footer"></a>
						<a class="icon" target="_blank" href="https://www.youtube.com/channel/UC6mXWfi-sXptlqRJ8Nr7qoQ" id="youtube_icon_footer"></a>
					</div>
				</div>
			</div>
			<div class="down">
				<div>
					<a class="privacy_policy" href="/privacy-policy">Privacy Policy</a>
					<a class="terms_of_service" href="/terms-of-service">Terms of Service</a>
					<a class="disclamer" href="/disclaimer">Disclamer</a>
				</div>
			</div>
		</footer>
		<div id="modal-alert" class="modal-alert" style="display:none;">
			<div class="popup__body"><div class="js-img"></div></div>
		</div>
		
		<div id="popup" class="popup" style="display: none;">
		<div class="modal-text-photo">ADD PHOTO</div>
			<div class="modal-upload-column-img">
				<div class="popup__body"><div class="js-img"></div></div>
			</div>
			<div class="img-credentials">
				<input type="text" placeholder="Image credentials">
				<div class="js-upload btn btn_browse btn_browse_small">DONE</div>
			</div>
		</div>

		
		<div id="modal-test" class="modal-test" style="display: none;">
			<div class="popup__body"><div class="js-img"></div></div>
			<div style="margin: 0 0 5px; text-align: center;">
				<div class="modal-text-photo">ADD PHOTO</div>
				<div class="modal-upload-column">
					<p> UPLOAD IMAGE </p>
					<div class="select-file"> <div class="modal-file-icon"></div><input type="file" name="filedata"></div>
					<div class="modal-upload-url">
						<p>or</p>
						<input type="text" class="upload-img-url upl-input-image-url" placeholder="Enter URL">
						<button type="button" class="upload-img-url-btn upl-image-valid">GO</button>
					</div>
				</div>
			</div>
		</div>
		
	

	<script>
		var token = '{!! csrf_token() !!}';
	</script>
    <script>
      // 2. This code loads the IFrame Player API code asynchronously.
    function getYouTubeIdFromURL(url) 
	{
	    var match = url.match(/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/);
	    return (match&&match[7].length==11)? match[7]:false;
	}


	function loadYbVideoById(id_vid) {
      var tag = document.createElement('script');
      startt = 0;
      secs = 1000;
      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      // 3. This function creates an <iframe> (and YouTube player)
      //    after the API code downloads.
      var player;
      id_video = id_vid;
      video_loaded = true;
    }

    function onPlayerReady(event) {
        event.target.playVideo();
        player.seekTo(startt);
        player.mute();
        $('.txt-caption').css({'display': 'block'});
        $(".nstSlider[data-id='1']").nstSlider("set_range", 1, player.getDuration());
        timeout_id = setTimeout(loopy, secs);
      }

      function loopy(event) {
        player.seekTo(startt);
        setTimeout(loopy, secs);
      }

      function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
          videoId: id_video,
          playerVars: { 'autoplay': 1, 'controls': 0, 'disablekb': 1, 'fs': 0, 'modestbranding': 1, 'showinfo': 0, 'rel': 0},
          events: {
            'onReady': onPlayerReady,
          }
        });
      }
    </script>
	<script src="/js/main.js"></script>
	<script src="/js/video_to_gif.js"></script>
	<script src="/js/jquery.nstSlider.min.js"></script>
	<script>
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
	</script>

	</body>
</html>