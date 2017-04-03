<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pimboo - Create a new Flip Cards</title>
	<link href="css/style.min.css" rel="stylesheet">
	<link href="css/flip_new.css" rel="stylesheet">
	<link href="test/jcrop/jquery.Jcrop.min.css" rel="stylesheet" type="text/css"/>
</head>
	<body class="add_flip_cards">
		@include('header')
		<div class="body">
		<form action="/upload_end" method="post" id="form_upload_cards">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="left">
				<div class="title">FLIP CARD CREATION</div>
				<div class="sub_title">Add all necessary information to create new flip cards article</div>
				<div class="card_info">
					<div class="top">
						<div class="photo">CLICK<br>TO ADD PHOTO</div>
						<div class="text_info">
							<input type="text" name="form_flip[form_flip_cards_title]" placeholder="Flip cards title" autocomplete="off">
							<input type="text" name="form_flip[form_description]" placeholder="Flip cards description" autocomplete="off">
							<input type="text" name="flip_cards[1][form_item_title]" placeholder="Enter item title (45 symbols max)" maxlength="45" autocomplete="off">
						</div>
					</div>
					<textarea name="form_flip[form_footer]" placeholder="Footer text (1500 symbols max)" maxlength="1500" autocomplete="off"></textarea>
				</div>
				<div class="buttons">
					<button type="button" class="front_card" data-id="1">FRONT CARD</button>
					<button type="button" class="back_card" data-id="1">BACK CARD</button>
				</div>
				<div class="editor" data-id="1">
					<div class="front-card" data-id="1">
						<div class="title">CLICK TO ADD PHOTO OR TEXT</div>
						<div class="butts">
							<div class="add_image" data-id="1" data-side="1"></div>
							<div class="add_text" data-id="1" data-side="1"></div>
						</div>
					</div>
					<div class="back-card" data-id="1">
						<div class="title">CLICK TO ADD PHOTO OR TEXT</div>
						<div class="butts">
							<div class="add_image" data-id="1" data-side="2"></div>
							<div class="add_text" data-id="1" data-side="2"></div>
						</div>
					</div>	
				</div>
				<button type="button" id="add_card">ADD CARD</button>
				<div class="down_butts">
					<button type="button" id="preview">PREVIEW</button>
					<button type="button" id="save_draft" class="btn-save">SAVE DRAFT</button>
					<button type="button" id="publish">PUBLISH</button>
				</div>
				<input name="isDraft" type="hidden" value="publish" class="isDraft" autocomplete="off">
				<input name="postID" type="hidden" value="" class="postID" autocomplete="off">
				<input name="form_flip[form_photo]" type="hidden" value="" class="input-form-photo" autocomplete="off">
				<input name="form_flip[form_photo_facebook]" type="hidden" value="" class="input-form-photo-facebook" autocomplete="off">
				<input name="flip_cards[1][type_front]" type="hidden" value="image" class="input-type-front" autocomplete="off" data-id="1">
				<input name="flip_cards[1][type_back]" type="hidden" value="image" class="input-type-back" autocomplete="off" data-id="1">
				<input name="flip_cards[1][img_src1]" type="hidden" value="" class="input-form-img1" autocomplete="off" data-id="1">
				<input name="flip_cards[1][img_src2]" type="hidden" value="" class="input-form-img2" autocomplete="off" data-id="1">
				<input name="flip_cards[1][theme1]" type="hidden" value="blue" class="input-form-theme1" autocomplete="off" data-id="1">
				<input name="flip_cards[1][theme2]" type="hidden" value="blue" class="input-form-theme2" autocomplete="off" data-id="1">
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
				<div class="display_item_numbers">
					<div class="title">DISPLAY ITEM NUMBERS</div>
					<div class="sub_title">Choose whether or not to display the item numbers. The numbers will still appear in the creator</div>
					<div class="radio">
						<label><input class="checkbox" type="radio" name="display_item_numbers" value="yes"><span class="checkbox-custom"></span><span class="label">Yes</span></label>
						<label><input class="checkbox" type="radio" name="display_item_numbers" value="no" checked><span class="checkbox-custom"></span><span class="label">No</span></label>
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
		
		
		<div id="preview-modal" class="preview-modal" style="display: none;">
			<div class="main-preview">
				<div class="title">FLIP CARD PREVIEW</div>
				<div class="flipcard_main">
					<div class="flipcard_main_all">
						<div class="flipcard_main_title"></div>
						<div class="flipcard_main_description">
						</div>
						<div class="flipcard_main_tags">Tags: <b></b></div>
						<div class="flipcard_main_author">
							<img src="img/author.png">
							<div class="flipcard_main_author_by"> Create by <b>Author...</b><br/>
							on (Waiting for Publish) </div>
						</div>
					</div>
				</div>
				
				<div class="flipcard_main_footer">
				</div>
				
				<div class="flipcard_main_buttons">
					<button type="button" class="btn-save" id="save_draft">SAVE DRAFT</button>
					<button type="button" class="btn-publish" id="publish">PUBLISH</button>
				</div>
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
						<input type="text" class="upload-img-url" placeholder="Enter URL">	
						<button type="button" class="upload-img-url-btn">GO</button>
					</div>
				</div>
			</div>
		</div>
	<script>
	var token = '{!! csrf_token() !!}';
	tinymce_init = 0;
	</script>
	<script src="/js/footer.min.js"></script>
	<script src="http://cloud.tinymce.com/stable/tinymce.min.js?apiKey=me1xx87jvui3cahvnslljl2cp1xb1ivawta8z8je4iesro99"></script>
	<script>
	tinymce.init({
	  selector: 'textarea#content_textarea',
	  height: 500,
	  theme: 'modern',
	  plugins: [
	    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
	    'searchreplace wordcount visualblocks visualchars code fullscreen',
	    'insertdatetime media nonbreaking save table contextmenu directionality',
	    'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
	  ],
	  toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
	  toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
	  image_advtab: true,
	  templates: [
	    { title: 'Test template 1', content: 'Test 1' },
	    { title: 'Test template 2', content: 'Test 2' }
	  ],
	  content_css: [
	    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
	    '//www.tinymce.com/css/codepen.min.css'
	  ]
	 });
	</script>
	<script src="/js/script3.js"></script>
	</body>
</html>