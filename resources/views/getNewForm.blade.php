<div class="set-number">
	<div class="number-id"> {!! $id !!} </div>
</div>
<input name="flip_cards[{!! $id !!}][form_item_title]" type="text" class="input-card-item" placeholder="Enter Item Title">
<div class="form-set-card" data-id="{!! $id !!}">
	<div class="card-one" data-id="{!! $id !!}">
		<button type="button" class="button-test1 set-front-card" data-id="{!! $id !!}">Click to add photo</button>
	</div>
	<div class="card-two" data-id="{!! $id !!}">
		<button type="button" class="button-test2 set-back-card" data-id="{!! $id !!}">Click to add photo</button>
	</div>
</div>
<input name="flip_cards[{!! $id !!}][img_src1]" type="hidden" value="" class="input-form-img1" autocomplete="off" data-id="{!! $id !!}">
<input name="flip_cards[{!! $id !!}][img_src2]" type="hidden" value="" class="input-form-img2" autocomplete="off" data-id="{!! $id !!}">