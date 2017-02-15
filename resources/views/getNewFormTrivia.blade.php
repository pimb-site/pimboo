<div class="form-style">
	<div class="set-number">
		<div class="number-id"> {!! $id !!} </div>
	</div>
	<input name="flip_cards[{!! $id !!}][form_item_title]" type="text" class="input-card-item" placeholder="Enter Item Title">
	<div class="form-set-card" data-id="{!! $id !!}">
		<div class="card-one" data-id="{!! $id !!}">
			<div type="button" class="set-front-card" data-id="{!! $id !!}">
				<div class="text-front-card" data-id="{!! $id !!}">Click to add photo</div>
				<div class="input-front-card"><textarea name="flip_cards[{!! $id !!}][caption]" class="textarea-front-card" placeholder="Type your caption" data-id="{!! $id !!}"></textarea></div>
			</div>
		</div>
		<div class="card-two" data-id="{!! $id !!}">
			<button type="button" class="set-back-card" data-id="{!! $id !!}">Set Back Card</button>
		</div>
	</div>
	<div class="block-type"> 
		<img data-id="{!! $id !!}" class="block-type-text" style="background: white;" src="/img/text_icon.png"><img data-id="{!! $id !!}" class="block-type-image" src="/img/image-icon.png">
	</div>
	<div class="block-answer" data-id="{!! $id !!}">
		<div class="answer" data-id="{!! $id !!}" data-type="1">
			<button data-type="1" style="display:none" data-id="{!! $id !!}" type="button" class="answer-img-add">click to add photo</button>
			<textarea name="flip_cards[{!! $id !!}][answer1]" class="textarea-answer" placeholder="Enter text"></textarea>
			<label class="label-text"><input name="flip_cards[{!! $id !!}][answer_check1]" type="checkbox" value="value" checked>correct answer</label>
		</div>
		<div class="answer" data-id="{!! $id !!}" data-type="2">
			<button data-type="2" style="display:none" data-id="{!! $id !!}" type="button" class="answer-img-add">click to add photo</button>
			<textarea name="flip_cards[{!! $id !!}][answer2]" class="textarea-answer" placeholder="Enter text"></textarea>
			<label class="label-text"><input name="flip_cards[{!! $id !!}][answer_check2]" type="checkbox" value="value">correct answer</label>
		</div>
	</div>

	<input name="flip_cards[{!! $id !!}][img_src1]" type="hidden" value="" class="input-form-img1" autocomplete="off" data-id="{!! $id !!}">
	<input name="flip_cards[{!! $id !!}][img_src2]" type="hidden" value="" class="input-form-img2" autocomplete="off" data-id="{!! $id !!}">
	
	<input name="flip_cards[{!! $id !!}][type]" type="hidden" value="1" class="input-valtype" autocomplete="off" data-id="1">
	<input name="flip_cards[{!! $id !!}][answer_img1]" type="hidden" value="" class="answer_img" autocomplete="off" data-id="1" data-type="1">
	<input name="flip_cards[{!! $id !!}][answer_img2]" type="hidden" value="" class="answer_img" autocomplete="off" data-id="1" data-type="2">
	<input name="flip_cards[{!! $id !!}][answer_img3]" type="hidden" value="" class="answer_img" autocomplete="off" data-id="1" data-type="3">
	<input name="flip_cards[{!! $id !!}][answer_img4]" type="hidden" value="" class="answer_img" autocomplete="off" data-id="1" data-type="4">
	
	<button type="button" class="add-answer" data-id="{!! $id !!}">Add Answer</button>
</div>