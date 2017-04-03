<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pimboo - Create a new Ranked list</title>
	<link href="css/style.min.css" rel="stylesheet">
	<link href="css/trivia_new.css" rel="stylesheet">
	<link href="test/jcrop/jquery.Jcrop.min.css" rel="stylesheet" type="text/css"/>
</head>
	<body class="add_flip_cards">
		@include('header')
		<div class="body">
		<form id="form_upload_cards" action="/upload_end_rankedlist" method="POST">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="left">
				<div class="title">RANKED LIST CREATION</div>
				<div class="sub_title">Add all necessary information to create a new ranked list</div>
				<div class="card_info">
					<div class="top">
						<div class="photo">CLICK<br>TO ADD PHOTO</div>
						<div class="text_info">
							<input type="text" name="form_flip[form_flip_cards_title]" placeholder="Ranked list title" autocomplete="off" style="color:#6e8dc9;">
							<textarea name="form_flip[form_description]" style="height:102px; margin-bottom: 0px; margin-top:0px; margin-left:0px; width:490px; resize: none; color:#6e8dc9;" placeholder="Ranked list description" autocomplete="off"></textarea>
						</div>
					</div>
					<textarea name="form_flip[form_footer]" placeholder="Footer text (1500 symbols max)" maxlength="1500" autocomplete="off" style="color:#6e8dc9;"></textarea>
				</div>
				<input class="post-title" type="text" name="flip_cards[1][post_title]" placeholder="Post title"> </input>
				<div class="editor" data-id="1">
					<div class="front-card" data-id="1">
						<div class="main-remove-front" data-id="1">
							<div class="title">CLICK TO ADD PHOTO OR VIDEO</div>
							<div class="butts">
								<div class="add_plus" data-id="1" data-side="1"></div>
							</div>
						</div>
						<div class="block-type-caption">
							<textarea name="flip_cards[1][caption1]" class="type-caption" placeholder="Type your text or caption" style="position:relative;" data-id="1" data-side="1" maxlength="50"></textarea>
						</div>
					</div>
				</div>
				
				<button type="button" class="add-question">ADD QUESTION</button>
				<div class="down_butts">
					<button type="button" id="preview">PREVIEW</button>
					<button type="button" id="save_draft" class="btn-save">SAVE DRAFT</button>
					<button type="button" id="publish" class="btn-publish">PUBLISH</button>
				</div>
				<input name="isDraft" type="hidden" value="publish" class="isDraft" autocomplete="off">
				<input name="postID" type="hidden" value="" class="postID" autocomplete="off">
				<input name="form_flip[form_photo]" type="hidden" value="" class="input-form-photo" autocomplete="off">
				<input name="form_flip[form_photo_facebook]" type="hidden" value="" class="input-form-photo-facebook" autocomplete="off">
				<input name="flip_cards[1][type_card1]" type="hidden" value="image" class="input-type-card" autocomplete="off" data-id="1" data-side="1">
				<input name="flip_cards[1][img_src1]" type="hidden" value="" class="input-form-img1" autocomplete="off" data-id="1">
				<input name="flip_cards[1][youtube_clip1]" type="hidden" value="" class="input-form-clip" autocomplete="off" data-id="1" data-side="1">
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
					<a class="terms_of_service" href="/privacy-policy">Terms of Service</a>
					<a class="disclamer" href="/privacy-policy">Disclamer</a>
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
		
		<div id="preview-modal" class="preview-modal" style="display: none;">
			<div class="main-preview">
				<div class="title">RANKED LIST PREVIEW</div>
				<div class="trivia_main">
					<div class="trivia_main_all">
						<div class="trivia_main_title"></div>
						<div class="trivia_main_description">
						</div>
						<div class="trivia_main_tags">Tags: <b></b></div>
						<div class="trivia_main_author">
							<img src="img/author.png">
							<div class="trivia_main_author_by"> Create by <b></b><br/>
							on (Waiting for Publish) </div>
						</div>
					</div>
				</div>
				
				<div class="trivia_main_cards">
					<div class="vote">
						<div class="vote-button"></div>
						<b>+0</b>
					</div>
					<div class="trivia_item_title">POST TITLE</div>
					<div class="trivia_main_wrap" data-id="">
						<div class="trivia_main_front" data-id=""></div>
					</div>
				</div>
				<div class="trivia_main_footer">
				</div>
				
				<div class="trivia_main_buttons">
					<button type="button" class="btn-save" id="save_draft">SAVE DRAFT</button>
					<button type="button" class="btn-publish" id="publish">PUBLISH</button>
				</div>
			</div>
		</div>
		
		<div id="choose-upload" class="choose-upload" style="display: none;">
			<div class="modal-title">ADD PHOTO/VIDEO</div>
			<div class="modal-upload-column">
				<div class="title"> UPLOAD </div>
				<div class="buttons-img">
					<div class="modal-file-icon" style="float:left;"><div class="select-file" style="margin-left:0px; height:0px; margin-top:0px;"><input type="file" name="filedata" style="top:0px;"><div class="modal-text-upl">From File</div></div></div>
					<div class="modal-file-upl"><div class="modal-url-icon"></div><div class="modal-text-upl" style="margin-top:108px;">From URL</div></div>
					<div class="modal-file-upl"><div class="modal-youtube-icon"></div><div class="modal-text-upl" style="margin-top:108px;">YouTube Clip</div></div>
				</div>
				<div class="modal-video-url">
					<input type="text" class="upl-input-video-url" placeholder="Enter clip URL">
					<button type="button" class="upl-video-valid">UPLOAD</button>
				</div>
				<div class="size-img-alert" style="margin-top:64px;">Please make sure you upload an image at least of 200x160 for Landscape</div>
			</div>
		</div>
		
		<div id="modal-input-youtube" class="modal-input-youtube" style="display: none;">
			<div class="modal-video-url" style="margin-left: 72px;">
					<input type="text" class="upl-input-video-url" placeholder="Enter clip URL">
					<button type="button" class="upl-video-valid">UPLOAD</button>
			</div>
		</div>
		
		<div id="modal-input-image" class="modal-input-image" style="display: none;">
			<div class="modal-image-url" style="margin-left: 72px;">
					<input type="text" class="upl-input-image-url" placeholder="Enter image URL">
					<button type="button" class="upl-image-valid">UPLOAD</button>
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
	<script src="/js/script5.js"></script>
	</body>
</html>