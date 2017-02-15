<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pimboo - Create a new Trivia Card</title>
	<link href="css/style.min.css" rel="stylesheet">
	<link href="css/trivia_new.css" rel="stylesheet">
	<link href="test/jcrop/jquery.Jcrop.min.css" rel="stylesheet" type="text/css"/>
</head>
	<body class="add_flip_cards">
		<header>
			<div class="left">
				<a href="/" class="logo"></a>
				<a href="#" class="text">HOME</a>
				<a href="#" class="text">PIMBOO CHARITY</a>
			</div>
			<div class="right">
				<button type="button" id="nickname-button" class="nickname">{{ Auth::user()->name }}</button>
			</div>
		</header>
		<div class="body">
			<div class="left">
				<div class="title">TRIVIA CARD CREATION</div>
				<div class="sub_title">Add all necessary information to create a new trivia card</div>
				<div class="card_info">
					<div class="top">
						<div class="photo">CLICK<br>TO ADD PHOTO</div>
						<div class="text_info">
							<input type="text" name="form_flip[form_flip_cards_title]" placeholder="Trivia title" autocomplete="off">
							<input type="text" name="form_flip[form_description]" style="" placeholder="Trivia description" autocomplete="off">
						</div>
					</div>
					<textarea name="form_flip[form_footer]" placeholder="Footer text (1500 symbols max)" maxlength="1500" autocomplete="off"></textarea>
				</div>
				<div class="buttons">
					<button type="button" class="front_card_question" data-id="1">QUESTION</button>
					<button type="button" class="back_card_question" data-id="1">RESULT</button>
				</div>
				<div class="editor" data-id="1">
					<div class="front-card" data-id="1">
						<div class="title">CLICK TO ADD PHOTO OR VIDEO</div>
						<div class="butts">
							<div class="add_plus" data-id="1" data-side="1"></div>
						</div>
						<div class="block-type-caption">
							<textarea class="type-caption" placeholder="Type your caption"></textarea>
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
				
				<div class="edit-answers">
					<div class="media-answer">
						<div class="title">CHOOSE ANSWER MEDIA</div>
						<div class="buttons-answer">
							<div class="btn-text"></div>
							<div class="btn-img"></div>
						</div>
					</div>
					<div class="add-answer">
						<div class="answer-photo"><b>Click<br/> to add photo</b></div>
						<div class="answer-text"> <textarea placeholder="Enter text"></textarea></div>
						<div class="answer-checkbox">
							<label>  <input type="checkbox">Correct answer</label>
						</div>
					</div>
					<div class="add-answer">
						<div class="answer-photo"><b>Click<br/> to add photo</b></div>
						<div class="answer-text"> <textarea placeholder="Enter text"></textarea></div>
						<div class="answer-checkbox">
							<label>  <input type="checkbox">Correct answer</label>
						</div>
					</div>
				</div>
				<div class="edit-questions">
					<div class="media-questions">CHOOSE QUESTIONS MEDIA</div>
					<div class="button-add-question"><button>ADD QUESTION</button></div>
				</div>
				<div class="edit-quiz-result">
					<div class="left-block-quiz">
						<div class="title">QUIZ RESULT</div>
						<div class="description">
							Results should be added once your quiz is finished. <br/>
							A different result will appear based on the number <br/>
							of correct answers made by the user. Each result <br/>
							you add will be relevant to a range of correct </br>
							answers.
						</div>
						<div class="quiz-add-result"> <button>ADD RESULT</button></div>
					</div>
					<div class="right-block-quiz">
						<div class="result-photo"><b>CLICK</br> TO ADD PHOTO</b></div>
						<div class="result-photo-desc">Correct answers range: 0 - 1</div>
						<div class="quiz-title"><input placeholder="Title (80 characters max)"></div>
					</div>
				</div>
				
				<div class="down_butts">
					<button type="button" id="preview">PREVIEW</button>
					<button type="button" id="save_draft">SAVE DRAFT</button>
					<button type="button" id="publish">PUBLISH</button>
				</div>
				<input name="form_flip[form_photo]" type="hidden" value="" class="input-form-photo" autocomplete="off">
				<input name="form_flip[form_photo_facebook]" type="hidden" value="" class="input-form-photo-facebook" autocomplete="off">
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
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags"><span class="checkbox-custom"></span><span class="label">Celebrities</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags"><span class="checkbox-custom"></span><span class="label">Love</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags"><span class="checkbox-custom"></span><span class="label">TV</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags"><span class="checkbox-custom"></span><span class="label">Holidays</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags"><span class="checkbox-custom"></span><span class="label">Film</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags"><span class="checkbox-custom"></span><span class="label">Retro</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags"><span class="checkbox-custom"></span><span class="label">Music</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags"><span class="checkbox-custom"></span><span class="label">Tech</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags"><span class="checkbox-custom"></span><span class="label">Style</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags"><span class="checkbox-custom"></span><span class="label">Politics</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags"><span class="checkbox-custom"></span><span class="label">Sexy</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags"><span class="checkbox-custom"></span><span class="label">Internet</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags"><span class="checkbox-custom"></span><span class="label">Cute</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags"><span class="checkbox-custom"></span><span class="label">Books</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags"><span class="checkbox-custom"></span><span class="label">Food</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags"><span class="checkbox-custom"></span><span class="label">Sports</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags"><span class="checkbox-custom"></span><span class="label">Funny</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags"><span class="checkbox-custom"></span><span class="label">World</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags"><span class="checkbox-custom"></span><span class="label">Animals</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags"><span class="checkbox-custom"></span><span class="label">Arts</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags"><span class="checkbox-custom"></span><span class="label">Games</span></label></div>
						<div class="tag"><label><input class="checkbox" type="checkbox" name="tags"><span class="checkbox-custom"></span><span class="label">News</span></label></div>
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
					<div class="title">QUESTION ORDER</div>
					<div class="sub_title">Which order do you want the questions to be displayed in?</div>
					<div class="radio">
						<label><input class="checkbox" type="radio" name="display_item_numbers" checked><span class="checkbox-custom"></span><span class="label" >Random</span></label>
						<label><input class="checkbox" type="radio" name="display_item_numbers"><span class="checkbox-custom"></span><span class="label">User defined</span></label>
					</div>
				</div>
				<div class="display_item_numbers">
					<div class="title"> ANSWER ORDER</div>
					<div class="sub_title">Which order do you want the answers to be displayed in?</div>
					<div class="radio">
						<label><input class="checkbox" type="radio" name="display_answer_order" checked><span class="checkbox-custom"></span><span class="label">Random</span></label>
						<label><input class="checkbox" type="radio" name="display_answer_order"><span class="checkbox-custom"></span><span class="label">User defined</span></label>
					</div>
				</div>
			</div>
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
		
		<div id="modal-test" class="modal-test" style="display: none;">
			<div class="popup__body"><div class="js-img"></div></div>
			<div style="margin: 0 0 5px; text-align: center;">
				<div class="modal-text-photo">ADD PHOTO</div>
				<div class="modal-upload-column">
					<p> UPLOAD IMAGE </p>
					<div class="select-file"> <div class="modal-file-icon"></div><input type="file" name="filedata"></div>
					<div class="modal-upload-url">
						<p>or</p>
						<input type="text" placeholder="Enter URL">	
					</div>
				</div>
			</div>
		</div>
	<script>
	var token = '{!! csrf_token() !!}';
	</script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="test/FileAPI/FileAPI.min.js"></script>
	<script src="test/FileAPI/FileAPI.exif.js"></script>
	<script src="test/jquery.fileapi.js"></script>
	<script src="test/jcrop/jquery.Jcrop.min.js"></script>
	<script src="test/statics/jquery.modal.js"></script>
	<script src="{!! url() !!}/js/jquery.form.js"></script>
	<script src="{!! url() !!}/js/script3.js"></script>
	</body>
</html>