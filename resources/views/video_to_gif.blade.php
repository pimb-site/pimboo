<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pimboo - Video to GIF</title>
	<link href="css/style.min.css" rel="stylesheet">
	<link href="css/trivia_new.css" rel="stylesheet">
	<link href="test/jcrop/jquery.Jcrop.min.css" rel="stylesheet" type="text/css"/>
</head>
	<body class="add_flip_cards">
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
				<div class="buttons-video">
					<button type="button" class="file-video" onclick="document.querySelector('.video-file').click()">SELECT VIDEO</button>
					<input accept="video/mp4" style="display: none; width: 0px;" type="file" class="video-file" onchange="upload(this.files[0])">
					<button type="button" id="start-button">start GIF frames</button>
					<button type="button" id="end-button">End GIF frames</button>
					<button style="display:none;" type="button" id="sample-button">Try Sample File</button>
					<input type="range" style="display: none;" id="speed" min="30" max="1000" step="1" value="100">
				</div>
				<canvas id="c" style="display:none;"></canvas>
				<div class="youtube-clip-block">
					<input type="text" placeholder="OR enter URL Youtube clip" class="url-youtube-clip" autocomplete="off">
					<button type="button" class="url-youtube-button">OK</button>
				</div>
				<div class="status"> STATUS: <div id="output">Video not uploaded</div></div>
				<video src="http://r1---sn-5uaezn6k.googlevideo.com/videoplayback?mm=31&mn=sn-5uaezn6k&key=yt6&id=o-AEjskpi54JYUa0AqiYYHck4Fxt-W0LpGV2VmfcZxbd_o&signature=6950DC6E57B1AD85518C4B1ED06AE171F747F313.AE3AFDF9887E41523ED809D2B451B0438BD437A3&lmt=1490574304422687&ip=173.208.91.154&ratebypass=yes&dur=0.000&expire=1490611199&source=youtube&upn=Kzwxb7245cM&sparams=dur%2Cid%2Cip%2Cipbits%2Citag%2Clmt%2Cmime%2Cmm%2Cmn%2Cms%2Cmv%2Cpl%2Cratebypass%2Csource%2Cupn%2Cexpire&ipbits=0&mt=1490589520&itag=43&pl=24&mime=video%2Fwebm&mv=u&ms=au&title=%D0%93%D1%80%D1%83%D0%BF%D0%BF%D1%8B+%D1%81%D0%BC%D0%B5%D1%80%D1%82%D0%B8+-+%D0%9A%D0%BB%D0%B0%D1%81%D1%81+%D0%BD%D0%B0%D1%80%D0%BE%D0%B4%D0%B0" id="v" controls="" loop="" autoplay="" muted ></video>
				<div class="editor" data-id="1">
					<div class="front-card" data-id="1">
						<img class="result-gif" id="image" src="" alt="" width="100%" height="100%" >
					</div>
				</div>
				<div class="down_butts">
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
			</div>
			</form>
		</div>
		<footer>
			<div class="up">
				<div class="wrap">
					<div class="left">
						Pimboo OU<br>
						Stureplan 4C, 4th floor<br>
						Stockholm, Sweden 114 35<br>
					</div>
					<div class="center">@ Pimboo.com. Allrights Reserved.</div>
					<div class="right">
						<a class="icon" id="fb_icon_footer"></a>
						<a class="icon" id="twitter_icon_footer"></a>
						<a class="icon" id="instagram_icon_footer"></a>
						<a class="icon" id="youtube_icon_footer"></a>
					</div>
				</div>
			</div>
			<div class="down">
				<a class="privacy_policy" href="#">Privacy Policy</a>
				<a class="terms_of_service" href="#">Terms of Service</a>
				<a class="disclamer" href="#">Disclamer</a>
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
				<div>Start Time(length gif 2 seconds): <input type="number" value="0" class="start-time-yb"></div>
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
	</body>
</html>