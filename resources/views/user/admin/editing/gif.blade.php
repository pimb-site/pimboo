<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pimboo GIF Maker</title>
	<link href="/css/style.min.css" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="/css/jquery.nstSlider.min.css">
</head>
	<body class="tools_create_page">
		@include('header')
		<div class="body">
		<input type="file" name="video" id="input-video" accept="video/mp4" style="display: none;" />
		<form id="form_upload_cards" action="/admin/editing/update/gif" method="POST">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="left">
				<div class="title">GIF CREATION</div>
				<div class="sub_title">Add all necessary information to create a new GIF image</div>
				<div class="card_info">
					<div class="top">
						<div class="text_info">
							<input class="top-input-video" type="text" name="form_flip[form_flip_cards_title]" placeholder="GIF Title" autocomplete="off" value="{{ $post->description_title }}">
							<textarea class="top-textarea-video" name="form_flip[form_description]"  placeholder="GIF Description" autocomplete="off">{{ $post->description_text }}</textarea>
						</div>
					</div>
				</div>
				<?php 
				$content = unserialize($post->content);
				?>

				<div class="block-video-duration">
					<div class="title" style="display: none;">CHOOSE TIME DURATION</div>
					<div class="iframe-youtube"><img class='picture-gif' src='/uploads/{{ $content[0]['gif'] }}' /></div>

					<div class="choose-time" style="display: none;">START TIME <input class="start-time"></div>
					<div class="nstSlider" style="display: none;" data-id="1" data-range_min="0" data-range_max="3600"
					                       data-cur_min="0"     data-cur_max="3600">

					    <div class="bar"></div>
					    <div class="leftGrip"></div>
					</div>

					<div class="choose-time" style="display: none;">DURATION <input class="duration-time"></div>
					<div class="nstSlider" style="display: none;" data-id="2" data-range_min="1" data-range_max="5"
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

				<div class="down_butts">
					<button type="button" id="publish_story" class="btn-publish" style="margin-left: 250px;">UPDATE</button>
				</div>
				<input name="form_flip[form_photo]" type="hidden" value="{{ $post->description_image }}" class="input-form-photo" autocomplete="off">
				<input name="form_flip[form_photo_facebook]" type="hidden" value="{{ $post->image_facebook }}" class="input-form-photo-facebook" autocomplete="off">
				<input name="post_id" type="hidden" value="{{ $post->id }}">
			</div>
			
			<div class="right">
				<div class="title">SOCIAL APPEARANCE</div>
				<div class="sub_title">How your content will appear on social media</div>
				<div class="facebok_block">
					<div class="add_fb_img gif_img" style="padding-top: 0px;"><img class='facebook-photo' src='/uploads/{{ $post->image_facebook }}' /></div>
					<div class="edit_image_text">
						Your GIF will be<br>in Facebook
					</div>
				</div>
				<?php
				$tags = unserialize($post->tags);
				?>
				<div class="tags_block">
					<div class="title">TAGS</div>
					<div class="tags">
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Celebrities" <?php if(in_array('Celebrities', $tags)) print 'checked'; ?>><span class="checkbox-custom"></span><span class="label">Celebrities</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Love" <?php if(in_array('Love', $tags)) print 'checked'; ?>><span class="checkbox-custom"></span><span class="label">Love</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="TV" <?php if(in_array('TV', $tags)) print 'checked'; ?>><span class="checkbox-custom"></span><span class="label">TV</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Holidays" <?php if(in_array('Holidays', $tags)) print 'checked'; ?>><span class="checkbox-custom"></span><span class="label">Holidays</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Film" <?php if(in_array('Film', $tags)) print 'checked'; ?>><span class="checkbox-custom"></span><span class="label">Film</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Retro" <?php if(in_array('Retro', $tags)) print 'checked'; ?> ><span class="checkbox-custom"></span><span class="label">Retro</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Music" <?php if(in_array('Music', $tags)) print 'checked'; ?>><span class="checkbox-custom"></span><span class="label">Music</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Tech" <?php if(in_array('Tech', $tags)) print 'checked'; ?>><span class="checkbox-custom"></span><span class="label">Tech</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Style" <?php if(in_array('Style', $tags)) print 'checked'; ?>><span class="checkbox-custom"></span><span class="label">Style</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Politics" <?php if(in_array('Politics', $tags)) print 'checked'; ?>><span class="checkbox-custom"></span><span class="label">Politics</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Sexy" <?php if(in_array('Sexy', $tags)) print 'checked'; ?>><span class="checkbox-custom"></span><span class="label">Sexy</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Internet" <?php if(in_array('Internet', $tags)) print 'checked'; ?>><span class="checkbox-custom"></span><span class="label">Internet</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Cute" <?php if(in_array('Cute', $tags)) print 'checked'; ?>><span class="checkbox-custom"></span><span class="label">Cute</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Books" <?php if(in_array('Books', $tags)) print 'checked'; ?>><span class="checkbox-custom"></span><span class="label">Books</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Food" <?php if(in_array('Food', $tags)) print 'checked'; ?>><span class="checkbox-custom"></span><span class="label">Food</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Sports" <?php if(in_array('Sports', $tags)) print 'checked'; ?>><span class="checkbox-custom"></span><span class="label">Sports</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Funny" <?php if(in_array('Funny', $tags)) print 'checked'; ?>><span class="checkbox-custom"></span><span class="label">Funny</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="World" <?php if(in_array('World', $tags)) print 'checked'; ?>><span class="checkbox-custom"></span><span class="label">World</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Animals" <?php if(in_array('Animals', $tags)) print 'checked'; ?>><span class="checkbox-custom"></span><span class="label">Animals</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Arts" <?php if(in_array('Arts', $tags)) print 'checked'; ?>><span class="checkbox-custom"></span><span class="label">Arts</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="Games" <?php if(in_array('Games', $tags)) print 'checked'; ?>><span class="checkbox-custom"></span><span class="label">Games</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="News" <?php if(in_array('News', $tags)) print 'checked'; ?>><span class="checkbox-custom"></span><span class="label">News</span></label></div>
					</div>
				</div>
				<div class="down_butts video_to_gif_butts">
					<button type="button" id="publish" class="btn-publish">UPDATE</button>
				</div>
			</div>
			</form>


			<form id="create-gif-from-yb" action="/create/gifmaker/upload" method="POST">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="video_youtube" value="" class="un_video_url">
				<input type="hidden" name="id-gif" class="id-complete-gif">
				<input type="hidden" name="start_time" class="un_start_time" value="0">
				<input type="hidden" name="end_time" class="un_end_time" value="1">
				<input type="hidden" name="color" class="un_color" value="0">
				<input type="hidden" name="font_family" class="un_style" value="0">
				<input type="hidden" name="font_size" class="un_size" value="0">
				<input type="hidden" name="caption" class="un_caption" value="">
				<input type="hidden" name="variant" class="un_variant" value="0">
				<input type="hidden" name="filename_blob" class="un_filename" value="">
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
      secs = 900;
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
        $(".nstSlider[data-id='1']").nstSlider("set_range", 0, player.getDuration());
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
    <script src="/js/footer.min.js"></script>
	<script src="/js/gifmaker.js"></script>
	<script src="/js/jquery.nstSlider.min.js"></script>
	</body>
</html>