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
		@include('header')
		<div class="body">
		<form id="form_upload_cards" action="/upload_end_gif" method="POST">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="left">
				<div class="title">GIF CREATION</div>
				<div class="sub_title">Add all necessary information to create a new GIF image</div>
				<div class="card_info">
					<div class="top">
						<div class="photo">CLICK<br>TO ADD PHOTO</div>
						<div class="text_info">
							<input type="text" name="form_flip[form_flip_cards_title]" placeholder="Title" autocomplete="off" style="color:#6e8dc9;">
							<textarea name="form_flip[form_description]" style="height:102px; margin-bottom: 0px; margin-top:0px; margin-left:0px; width:490px; resize: none; color:#6e8dc9;" placeholder="Description" autocomplete="off"></textarea>
						</div>
					</div>
				</div>

				<div class="block-for-select-video">
					<div class="title">ADD VIDEO TO CREATE NEW GIF</div>
					<div class="block-inputs">
						<button type="button" class="select-video">SELECT VIDEO</button>
						OR
						<input placeholder="Enter YouTube clip URL">
						<button type="button" class="youtube-btn-upload">UPLOAD</button>
					</div>
				</div>
				<div class="block-video-duration">
					<div class="title">CHOOSE TIME DURATION</div>
					<div class="iframe-youtube"> </div>
					<div class="duration-text">
						<div class="text1">START</div>
						<div class="text2">DURATION</div>
						<div class="text3">END</div>
					</div>
					<div class="nstSlider" data-range_min="0" data-range_max="1800" data-cur_min="0" data-cur_max="60">
					    <div class="bar"></div>
					    <div class="leftGrip"></div>
					    <div class="rightGrip"></div>
					</div>
					<!--<div class="leftLabel" > </div>
					<div class="rightLabel" > </div>-->
					<div class="duration-inputs">
						<div class="duration-input-div1"><input type="text" class="input-start-time" disabled=""></div>
						<div class="duration-input-div2"><input type="text" class="input-duration-time" disabled=""></div>
						<div class="duration-input-div3"><input type="text" class="input-end-time" disabled=""></div>
					</div>
					<div class="btn-create-gif">
						<button type="button">CREATE</button>
					</div>
				</div>

				<div class="status-gif">CREATED GIF: <span>Not created</span></div>

				<div class="editor" data-id="1">
					<div class="front-card" data-id="1">
					</div>
				</div>

				<div class="block-for-giftext">
					<div class="title">ADD TEXT AND EFFECTS TO YOUR GIF</div>
					<div class="caption-gif">
						<div class="type-title">Caption</div> 
						<input placeholder="Please enter your text here">
					</div>
					<div class="style-gif">
						<div class="type-title">Style</div>
						<button type="button">DEFAULT</button>
						<button type="button">MEME</button>
						<button type="button">SUBTITLE</button>
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
						<div class="type-title">Text style</div>
						<div class="select">
							<select>
								<option>Font</option>
							</select>
						</div>
						<div class="select">
							<select>
								<option>Size</option>
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
					<div class="add_fb_img">CLICK<br>TO ADD PHOTO</div>
					<div class="edit_image_text">
						Facebook<br>Edit Image
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
				<div class="permissions">
					<div class="title">PERMISSIONS</div>
					<div class="sub_title">Who will be able to view your item</div>
					<div class="select">
						<select>
							<option>Public (recommended)</option>
						</select>
					</div>
				</div>
				<div class="down_butts">
					<button type="button" id="preview">PREVIEW</button>
					<button type="button" id="save_draft" class="btn-save">SAVE DRAFT</button>
					<button type="button" id="publish">PUBLISH</button>
				</div>
			</div>
			</form>


			<form id="create-gif-from-yb" action="/upload_yb_gif" method="POST">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="gif_main" value="" class="un_gif_main">
				<input type="hidden" name="video_url" value="" class="un_video_url">
				<input type="hidden" name="options[0][start_time]" class="un_start_time" value="0">
				<input type="hidden" name="options[0][end_time]" class="un_end_time" value="1">
				<input type="hidden" name="color" class="un_color" value="0">
				<input type="hidden" name="caption" class="un_caption" value="">
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

		<div id="add-youtube-gif" class="add-youtube-gif" style="display: none;">
			<div class="popup__body"><div class="js-img"></div></div>
			<div style="margin: 0 0 5px; text-align: center;">
				<div class="modal-text-photo">ADD GIF FROM YOUTUBE CLIP</div>

				<div class="youtube-iframe"> </div>
				<div>Start Time(seconds) <input type="number" value="0" class="start-time-yb"> End Time(seconds)   <input type="number" value="2" class="end-time-yb"></div>
				<div><button type="button" class="add-to-this">Add to this...</button></div>
				<div><button type="button" class="create-yb-gif">Create GIF</button></div>

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
	<script src="/js/main.js"></script>
	<script src="/js/video_to_gif.js"></script>
	<script src="/js/jquery.nstSlider.min.js"></script>
	<script>
		$('.nstSlider').nstSlider({
		    "crossable_handles": false,
		    "left_grip_selector": ".leftGrip",
		    "right_grip_selector": ".rightGrip",
		    "value_bar_selector": ".bar",
		    "value_changed_callback": function(cause, leftValue, rightValue) {
		    	$('.un_start_time').val(leftValue);
		    	$('.un_end_time').val(rightValue);
		    	duration = rightValue - leftValue;
		    	duration =  Math.floor(duration / 60) + ':' + duration % 60;
		    	leftValue = Math.floor(leftValue / 60) + ':' + leftValue % 60;
		    	rightValue = Math.floor(rightValue / 60) + ':' + rightValue % 60;
		        $('.input-start-time').val(leftValue);
		        $('.input-end-time').val(rightValue);
		        $('.input-duration-time').val(duration);
		    }
		});
	</script>
	</body>
</html>