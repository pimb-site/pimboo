<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pimboo Trivia</title>
	<link href="/css/style.min.css" rel="stylesheet">
	<link href="/css/jquery.Jcrop.min.css" rel="stylesheet" type="text/css"/>
</head>
	<body class="tools_create_page">
		@include('header')
		<div class="body">
		<form action="/save_trivia_quiz" method="post" id="form_upload_cards">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="left">
				<div class="title">TRIVIA CARD CREATION</div>
				<div class="sub_title">Add all necessary information to create a new trivia card</div>
				<div class="card_info">
					<div class="top">
						<div class="photo">CLICK<br>TO ADD PHOTO</div>
						<div class="text_info">
							<input type="text" name="form_flip[form_flip_cards_title]" placeholder="Trivia title" autocomplete="off" style="color:#6e8dc9;">
							<textarea name="form_flip[form_description]" class="top_textarea_trivia" placeholder="Trivia description" autocomplete="off"></textarea>
						</div>
					</div>
					<textarea name="form_flip[form_footer]" placeholder="Footer text (1500 symbols max)" maxlength="1500" autocomplete="off" style="color:#6e8dc9;"></textarea>
				</div>
				<div class="buttons">
					<button type="button" class="front_card_question" data-id="1" style="background-color: #99afd9;">QUESTION</button>
					<button type="button" class="back_card_question" data-id="1">RESULT</button>
				</div>
				<div class="editor" data-id="1">
					<div class="front-card" data-id="1">
						<div class="main-remove-front" data-id="1">
							<div class="title">CLICK TO ADD PHOTO OR VIDEO</div>
							<div class="butts">
								<div class="add_plus" data-id="1" data-side="1"></div>
							</div>
						</div>
						<div class="block-type-caption">
							<textarea name="flip_cards[1][caption1]" class="type-caption" placeholder="Type your caption" data-id="1" data-side="1" maxlength="50"></textarea>
						</div>
					</div>
					<div class="back-card" data-id="1">
						<div class="main-remove-back" data-id="1">
							<div class="title">CLICK TO ADD PHOTO OR VIDEO</div>
							<div class="butts">
								<div class="add_plus" data-id="1" data-side="2"></div>
							</div>
						</div>
						<div class="block-type-caption">
							<textarea name="flip_cards[1][caption2]" class="type-caption" placeholder="Type your caption" data-id="1" data-side="2" maxlength="50"></textarea>
						</div>
					</div>	
				</div>
				
				<div class="edit-answers">
					<div class="media-answer">
						<div class="title">CHOOSE ANSWER MEDIA</div>
						<div class="buttons-answer">
							<div class="btn-text"></div>
							<div class="btn-img" data-id="1"></div>
						</div>
					</div>
					<div class="add-answer">
						<div class="answer-photo" data-id="1" data-side="1"><b>CLICK<br/> TO ADD PHOTO</b></div>
						<div class="answer-text"> <textarea placeholder="Enter text" name="flip_cards[1][answer1]"></textarea></div>
						<div class="answer-checkbox">
							<div class="tag"><label><input class="checkbox" type="checkbox" name="flip_cards[1][answer_check1]" value="Celebrities"><span class="checkbox-custom"></span><span class="label">Correct answer</span></label></div>
						</div>
					</div>
					<div class="add-answer">
						<div class="answer-photo" data-id="1" data-side="2" ><b>CLICK<br/> TO ADD PHOTO</b></div>
						<div class="answer-text"> <textarea placeholder="Enter text" name="flip_cards[1][answer2]"></textarea></div>
						<div class="answer-checkbox">
							<div class="tag"><label><input class="checkbox" type="checkbox" name="flip_cards[1][answer_check2]" value="Celebrities"><span class="checkbox-custom"></span><span class="label">Correct answer</span></label></div>
						</div>
					</div>
				</div>
				<div class="edit-questions">
					<div class="media-questions">CHOOSE QUESTIONS MEDIA</div>
					<div class="button-add-question"><button class="add-question" type="button">ADD QUESTION</button></div>
				</div>
				<div class="edit-quiz-result">
					<div class="blocks-quiz">
						<div class="left-block-quiz">
							<div class="title">QUIZ RESULT</div>
							<div class="description">
								Results should be added once your quiz is finished. <br/>
								A different result will appear based on the number <br/>
								of correct answers made by the user. Each result <br/>
								you add will be relevant to a range of correct </br>
								answers.
							</div>
						</div>
						<div class="right-block-quiz">
							<div class="result-photo" data-id="1"><b>CLICK</br> TO ADD PHOTO</b></div>
							<div class="result-photo-desc">Correct answers range: 0 - 1</div>
							<div class="quiz-title"><input name="flip_cards[1][result_photo_title]" placeholder="Title (80 characters max)" maxlength="80"></div>
						</div>
					</div>
					<div class="quiz-add-result"> <button type="button">ADD RESULT</button></div>
				</div>
				<div class="down_butts">
					<button type="button" id="preview" class="btn-preview">PREVIEW</button>
					<button type="button" id="save_draft" class="btn-save">SAVE DRAFT</button>
					<button type="button" id="publish" class="btn-publish">PUBLISH</button>
				</div>
				<input name="isDraft" type="hidden" value="publish" class="isDraft" autocomplete="off">
				<input name="postID" type="hidden" value="" class="postID" autocomplete="off">
				<input name="form_flip[form_photo]" type="hidden" value="" class="input-form-photo" autocomplete="off">
				<input name="form_flip[form_photo_facebook]" type="hidden" value="" class="input-form-photo-facebook" autocomplete="off">
				<input name="flip_cards[1][type_card1]" type="hidden" value="image" class="input-type-card" autocomplete="off" data-id="1" data-side="1">
				<input name="flip_cards[1][type_card2]" type="hidden" value="image" class="input-type-card" autocomplete="off" data-id="1" data-side="2">
				<input name="flip_cards[1][img_src1]" type="hidden" value="" class="input-form-img1" autocomplete="off" data-id="1">
				<input name="flip_cards[1][img_src2]" type="hidden" value="" class="input-form-img2" autocomplete="off" data-id="1">
				<input name="flip_cards[1][youtube_clip1]" type="hidden" value="" class="input-form-clip" autocomplete="off" data-id="1" data-side="1">
				<input name="flip_cards[1][youtube_clip2]" type="hidden" value="" class="input-form-clip" autocomplete="off" data-id="1" data-side="2">
				<input name="flip_cards[1][answer_img1]" type="hidden" value="" class="answer_img" autocomplete="off" data-id="1" data-side="1">
				<input name="flip_cards[1][answer_img2]" type="hidden" value="" class="answer_img" autocomplete="off" data-id="1" data-side="2">
				<input name="flip_cards[1][answers_type]" type="hidden" value="text" class="input-valtype" autocomplete="off" data-id="1">
				<input name="flip_cards[1][result_photo_img]" type="hidden" value="text" class="result-photo-inp" autocomplete="off" data-id="1">
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
					<div class="title">QUESTION ORDER</div>
					<div class="sub_title">Which order do you want the questions to be displayed in?</div>
					<div class="radio">
						<label><input class="checkbox" type="radio" name="question_order" value="random"><span class="checkbox-custom"></span><span class="label" >Random</span></label>
						<label><input class="checkbox" type="radio" name="question_order" value="norandom" checked><span class="checkbox-custom"></span><span class="label">User defined</span></label>
					</div>
				</div>
				<div class="display_item_numbers">
					<div class="title"> ANSWER ORDER</div>
					<div class="sub_title">Which order do you want the answers to be displayed in?</div>
					<div class="radio">
						<label><input class="checkbox" type="radio" name="answer_order" value="random"><span class="checkbox-custom"></span><span class="label">Random</span></label>
						<label><input class="checkbox" type="radio" name="answer_order" value="norandom" checked><span class="checkbox-custom"></span><span class="label">User defined</span></label>
					</div>
				</div>
				<div class="down_butts add_trivia_quiz_butts">
					<button type="button" id="preview" class="btn-preview">PREVIEW</button>
					<button type="button" id="save_draft" class="btn-save">SAVE DRAFT</button>
					<button type="button" id="publish" class="btn-publish">PUBLISH</button>
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
				<div class="js-upload btn btn_browse btn_browse_small">DONE</div>
			</div>
		</div>
		
		<div id="preview-modal" class="preview-modal" style="display: none;">
			<div class="main-preview">
				<div class="title">TRIVIA QUIZ PREVIEW</div>
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
					<div class="trivia_item_title">QUESTION</div>
					<div class="trivia_main_wrap" data-id="">
						<div class="trivia_main_front" data-id=""></div>
						<div class="trivia_main_back" data-id=""></div>
					</div>
				</div>
				<div class="trivia_main_footer">
				</div>
				
				<div class="trivia_main_results" style="display:none;">
					<div class="photo_res"> 
					</div>
					<div class="title"><b></b></div>
					<div class="score"></div>
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
					<div class="modal-file-icon" onclick="$('input[name=filedata]')[0].click();"><div class="select-file"><input type="file" name="filedata" style="display: none"><div class="modal-text-upl">From File</div></div></div>
					<div class="modal-file-upl"><div class="modal-url-icon"></div><div class="modal-text-upl" >From URL</div></div>
					<div class="modal-file-upl"><div class="modal-youtube-icon"></div><div class="modal-text-upl">YouTube Clip</div></div>
				</div>
				<div class="modal-video-url">
					<input type="text" class="upl-input-video-url" placeholder="Enter clip URL">
					<button type="button" class="upl-video-valid">UPLOAD</button>
				</div>
				<div class="size-img-alert">Please make sure you upload an image at least of 200x160 for Landscape</div>
			</div>
		</div>
		
		<div id="modal-input-youtube" class="modal-input-youtube" style="display: none;">
			<div class="modal-video-url">
					<input type="text" class="upl-input-video-url" placeholder="Enter clip URL">
					<button type="button" class="upl-video-valid">UPLOAD</button>
			</div>
		</div>
		
		<div id="modal-input-image" class="modal-input-image" style="display: none;">
			<div class="modal-image-url">
					<input type="text" class="upl-input-image-url" placeholder="Enter image URL">
					<button type="button" class="upl-image-valid">UPLOAD</button>
			</div>
		</div>
		
		
		<div id="modal-test" class="modal-test" style="display: none;">
			<div class="popup__body"><div class="js-img"></div></div>
			<div>
				<div class="modal-text-photo">ADD PHOTO</div>
				<div class="modal-upload-column">
					<p> UPLOAD IMAGE </p>
					<div class="select-file"> <div class="modal-file-icon"></div><input type="file" name="filedata"></div>
					<p>or</p>
					<div class="modal-upload-url">
						<input type="text" class="upload-img-url upl-input-image-url" placeholder="Enter URL">	
						<button type="button" class="upload-img-url-btn upl-image-valid">GO</button>
					</div>
				</div>
			</div>
		</div>
		
		
	<script>
	var token = '{!! csrf_token() !!}';
	</script>
	<script src="/js/footer.min.js"></script>
	<script src="/js/trivia.js"></script>
	</body>
</html>