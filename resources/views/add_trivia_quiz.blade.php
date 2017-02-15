<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Flip Cards</title>
	
	<link href="/css/add_trivia.css" rel="stylesheet">
	<link href="/css/jquery.modal.css" rel="stylesheet">
</head>
<body>
<div class="main">
	{!! Form::open(['action' => 'TriviaController@saveTriviaQuiz', 'id' => 'form_upload_cards']) !!}
	<div class="helpers">
		<div class="helper-left"><b> Working a new <a href="#">Trivia </a> </b></div>
		<div class="helper-right"><b>Need Help? <a href="#">Pimboo University</a></b></div>
	</div>
	<div class="left">
		<div class="left-block">
			<div class="left-content">
				<b>Social Apperance</b> <br /> 	
				<div class="info"><div class="test">How your content will appear on social media </div></div>
				<div class="global">
					<button class="photo-add" type="button"> <b> Click to add photo </b></button>
					<div class='left-text'> <b><div class="f1" >Facebook </div>  Edit Image </b></div>
				</div>
				<br /> <br /> 
				<hr>
				<div class="tags"> 
					<b> Tags </b><br /> 
					<div class='checkboxes'>
						<div class="info">
							<div class="item"><label><input type="checkbox">Celebrities</label></div>
							<div class="item"><label><input type="checkbox">Love</label></div>
							<div class="item"><label><input type="checkbox">TV</label></div>
							<div class="item"><label><input type="checkbox">Holidays</label></div>
							<div class="item"><label><input type="checkbox">Film</label></div>
							<div class="item"><label><input type="checkbox">Retro</label></div>
							<div class="item"><label><input type="checkbox">Music</label></div>
							<div class="item"><label><input type="checkbox">Tech</label></div>
							<div class="item"><label><input type="checkbox">Style</label></div>
							<div class="item"><label><input type="checkbox">Politics</label></div>
							<div class="item"><label><input type="checkbox">Sexy</label></div>
							<div class="item"><label><input type="checkbox">Internet</label></div>
							<div class="item"><label><input type="checkbox">Cute</label></div>
							<div class="item"><label><input type="checkbox">Books</label></div>
							<div class="item"><label><input type="checkbox">Food</label></div>
							<div class="item"><label><input type="checkbox">Sports</label></div>
							<div class="item"><label><input type="checkbox">Funny</label></div>
							<div class="item"><label><input type="checkbox">World</label></div>
							<div class="item"><label><input type="checkbox">Animals</label></div>
							<div class="item"><label><input type="checkbox">Arts</label></div>
							<div class="item"><label><input type="checkbox">Games</label></div>
							<div class="item"><label><input type="checkbox">News</label></div>
						</div>
					</div>	
				</div>
				<hr>
				<div class="permission"> 
					<b> Permissions </b> <br /> 
					<div class="info">
						<div class="permission-text">Who will be able to view your item </div><br /> 
						<select>
							<option>Public Recommended</option>
							<option>Private</option>
						</select>
					</div>
				</div>
				<hr>
				<div class="language"> 
					<b> Language </b> <br /> 
					<div class="info">
						<select>
							<option>English</option>
							<option>Russian</option>
						</select>
					</div>
				</div>
				<hr>
				<div class="translation"> 
					<b> Translation </b> <br /> 
					<div class="info">
						<div class="text-enable"><label><input type="checkbox" checked>Enable translation to other languages</label></div>
					</div>
				</div>
				<hr>
				<div class="item-numbers">
					<b> Display item numbers </b> <br /> 
					<div class="info">
						<div class="text-choose">Choose whether or not to display the item numbers. The numbers will still appear in the creator</div>
					</div>
				</div>
				<hr>
				<div class="radio-vote"> 
					<input type="radio" name="group1" value="Yes"> Yes
					<input type="radio" name="group1" value="No"> No
				</div>
			</div>
		</div>
		<div class="left-block-small">
			<div class="question"><b>Have a question? <a href="#">Contact us</a></b></div>
		</div>
	</div>
	<div class="center-block">
		<div class="article-new">
			<div class="text"> Create a new Trivia article</div>
		</div>
		<div class="create-flipcard"> 
			<button type="button" class="photo-add-flip"> 
				<b> Click to add photo </b>
			</button>
			<input name="form_flip[form_photo]" type="hidden" value="" class="input-form-photo" autocomplete="off">
			<input name="form_flip[form_photo_facebook]" type="hidden" value="" class="input-form-photo-facebook" autocomplete="off">
			
			<input name="form_flip[form_flip_cards_title]" type="text" class="input-card-title" placeholder="Trivia Title" autocomplete="off">
			<textarea name="form_flip[form_description]" class="input-card-description" placeholder="Description" autocomplete="off"></textarea>
			<div class="form-style">
				<div class="set-number">
					<div class="number-id"> 1 </div>
				</div>
				<input name="flip_cards[1][form_item_title]" type="text" class="input-card-item" placeholder="Enter Item Title" autocomplete="off">
				<div class="form-set-card" data-id="1">
					<div class="card-one" data-id="1">
						<div class="set-front-card" data-id="1">
							<div class="text-front-card" data-id="1">Click to add photo</div>
							<div class="input-front-card"><textarea name="flip_cards[1][caption]" class="textarea-front-card" placeholder="Type your caption" data-id="1"></textarea></div>
						</div>
					</div>
					<div class="card-two" data-id="1"><button type="button" class="set-back-card" data-id="1">Set Back Card</button></div>
				</div>
				
				<div class="block-type"> 
					<img data-id="1" class="block-type-text" style="background: white;" src="/img/text_icon.png"><img data-id="1" class="block-type-image" src="/img/image-icon.png">
				</div>
				<div class="block-answer" data-id="1">
					<div class="answer" data-id="1" data-type="1">
						<button data-type="1" style="display:none" data-id="1" type="button" class="answer-img-add">click to add photo</button>
						<textarea name="flip_cards[1][answer1]" class="textarea-answer" placeholder="Enter text"></textarea>
						<label class="label-text"><input name="flip_cards[1][answer_check1]" type="checkbox" name="checkbox" value="true" checked>correct answer</label>
					</div>
					<div class="answer" data-id="1" data-type="2">
						<button data-type="2" style="display:none" data-id="1" type="button" class="answer-img-add">click to add photo</button>
						<textarea name="flip_cards[1][answer2]" class="textarea-answer" placeholder="Enter text"></textarea>
						<label class="label-text"><input name="flip_cards[1][answer_check2]" type="checkbox" name="checkbox" value="true">correct answer</label>
					</div>
				</div>
				<input name="flip_cards[1][img_src1]" type="hidden" value="" class="input-form-img1" autocomplete="off" data-id="1">
				<input name="flip_cards[1][img_src2]" type="hidden" value="" class="input-form-img2" autocomplete="off" data-id="1">
				
				
				<input name="flip_cards[1][type]" type="hidden" value="1" class="input-valtype" autocomplete="off" data-id="1">
				<input name="flip_cards[1][answer_img1]" type="hidden" value="" class="answer_img" autocomplete="off" data-id="1" data-type="1">
				<input name="flip_cards[1][answer_img2]" type="hidden" value="" class="answer_img" autocomplete="off" data-id="1" data-type="2">
				<input name="flip_cards[1][answer_img3]" type="hidden" value="" class="answer_img" autocomplete="off" data-id="1" data-type="3">
				<input name="flip_cards[1][answer_img4]" type="hidden" value="" class="answer_img" autocomplete="off" data-id="1" data-type="4">
				
				<button type="button" class="add-answer" data-id="1">Add Answer</button>
			</div>
			<button type="button" class="button-add-card">Add Question</button>
		</div>
		<div class="create-flipcard-footer">
			<b>Footer Text</b> <br /> 
			<textarea name="form_flip[form_footer]" class="textarea-footer" placeholder="Enter Text" autocomplete="off"></textarea>
		</div>
		<div class="buttons-save">
			<button type="button" class="button-preview">Preview</button>
			<button type="button" class="button-sdraft">Save Draft</button>
			<button type="button" class="button-publish">Publish</button>
		</div>
	</div>
	<div class="modal-alert" style="display:none;">
		
    </div>
	{!! Form::close() !!}
</div>
	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script data-preload="false" src="{!! url() !!}/pixie/pixie-integrate.js"></script>
	<script src="{!! url() !!}/js/jquery.form.js"></script>
	<script src="{!! url() !!}/js/jquery.modal.js"></script>
	<script src="{!! url() !!}/js/script2.js"></script>
</body>
</html>