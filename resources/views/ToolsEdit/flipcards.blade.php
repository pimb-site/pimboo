@extends('page')

@section('title') | Editing Flip Cards @endsection

@section('css')
<link href="/css/jquery.Jcrop.min.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
<div class="body">
		<form action="/create/flipcards/send" method="post" id="form_upload_cards">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="left">
				<div class="title">FLIP CARD EDITING</div>
				<?php 
				$status = $post->isDraft == 'publish' ? 'published. ' : 'not published (saved). ';
				if($isAdmin) $status .= "Author: <a style='display:inline;' href='/$post->author_name'>$post->author_name</a>";
				?>
				<div class="sub_title">Current status of the post: <font color="#123880">{!! $status !!}</font></div>
				<div class="card_info">
					<div class="top">
						<div class="photo" style="padding-top: 0px;" ><img class='main-photo' src='/uploads/{{ $post->description_image }}' /></div>
						<div class="text_info">
							<input type="text" name="flipcards[data][flipcards_title]" placeholder="Flip cards title" autocomplete="off" value="{{ $post->description_title }}">
							<textarea class="variable-description" name="flipcards[data][flipcards_description]" placeholder="Flip cards description" autocomplete="off">{{ $post->description_text }}</textarea>
						</div>
					</div>
					<textarea name="flipcards[data][flipcards_footer]" placeholder="Footer text (500 symbols max)" maxlength="500" autocomplete="off">{{ $post->description_footer }}</textarea>
				</div>
				<?php 
				$content = unserialize($post->content);
				$themes = [
					'#009cff' => 'blue',
					'#8dc63f' => 'green',
					'#00a99d' => 'turquoise',
					'#605ca8' => 'purple,'
				];
				$id = 1;
				?>

				@foreach ($content as $flipcards)
				<div class="buttons">
					<button type="button" class="front_card" data-id="{{ $id }}" style="background-color: #99afd9;">FRONT CARD</button>
					<button type="button" class="back_card" data-id="{{ $id }}">BACK CARD</button>
				</div>

				<input class="item-title-input" type="text" name="flipcards[cards][{{ $id }}][card_item_title]" placeholder="Enter item title (45 symbols max)" maxlength="45" autocomplete="off" value="{{ $flipcards['card_item_title'] }}">

				<div class="editor" data-id="{{ $id }}">
					@if($flipcards['card_type_front'] == 'image')
						<div class="front-card" data-id="{{ $id }}">
							<img class='image-card' src='/uploads/{{ $flipcards['front_card_image'] }}'/>
							<div data-id='{{ $id }}' class='delete_icon_button' data-side='1'> <img class='delete_icon' src='/img/delete_icon.png'  /></div>
							<input name="flipcards[cards][{{ $id }}][front_card_image]" type="hidden" value="{{ $flipcards['front_card_image'] }}" class="input-form-img1" autocomplete="off" data-id="{{ $id }}">
						</div>
					@else
						<div class="front-card" data-id="{{ $id }}" style="background: {{ $flipcards['front_card_theme'] }};">
							<textarea style="background-color: {{ $flipcards['front_card_theme'] }};" maxlength="100" autocomplete="off" name="flipcards[cards][{{ $id}}][front_card_text]" class="textarea-add-text" placeholder="Write something awesome" data-id="{{ $id }}" data-side="1">{{ $flipcards['front_card_text'] }}</textarea>
							<div class="set-background-buttons"><div class="item-color" data-theme="purple" style="background:#605ca8;" data-id="{{ $id }}"></div><div class="item-color" data-theme="green" style="background:#8dc63f;" data-id="{{ $id }}"></div> <div class="item-color" data-theme="blue" style="background:#009cff;" data-id="{{ $id }}"></div><div class="item-color" data-theme="turquoise" data-id="{{ $id }}" style="background: #00a99d;"> </div></div>
							<div data-side='1' data-id='{{ $id }}' class='delete_icon_button'> <img class='delete_icon' src='/img/delete_icon.png'  /></div>
							<input name="flipcards[cards][{{ $id }}][front_card_theme]" type="hidden" value="$themes[$flipcards['front_card_theme']]" class="input-form-theme1" autocomplete="off" data-id="{{ $id }}">
						</div>
					@endif

					@if($flipcards['card_type_back'] == 'image')
						<div class="back-card" data-id="{{ $id }}">
							<img class='image-card' src='/uploads/{{ $flipcards['back_card_image'] }}'/>
							<div data-id='{{ $id }}' class='delete_icon_button' data-side='2'> <img class='delete_icon' src='/img/delete_icon.png'  /></div>
							<input name="flipcards[cards][{{ $id }}][back_card_image]" type="hidden" value="{{ $flipcards['back_card_image'] }}" class="input-form-img1" autocomplete="off" data-id="{{ $id }}">
						</div>
					@else
						<div class="back-card" data-id="{{ $id }}" style="background: {{ $flipcards['back_card_theme'] }};">
							<textarea style="background-color: {{ $flipcards['back_card_theme'] }};" maxlength="100" autocomplete="off" name="flipcards[cards][{{ $id}}][back_card_text]" class="textarea-add-text" placeholder="Write something awesome" data-id="{{ $id }}" data-side="2">{{ $flipcards['back_card_text'] }}</textarea>
							<div class="set-background-buttons"><div class="item-color" data-theme="purple" style="background:#605ca8;" data-id="{{ $id }}"></div><div class="item-color" data-theme="green" style="background:#8dc63f;" data-id="{{ $id }}"></div> <div class="item-color" data-theme="blue" style="background:#009cff;" data-id="{{ $id }}"></div><div class="item-color" data-theme="turquoise" data-id="{{ $id }}" style="background: #00a99d;"> </div></div>
							<div data-side='2' data-id='{{ $id }}' class='delete_icon_button'> <img class='delete_icon' src='/img/delete_icon.png'  /></div>
							<input name="flipcards[cards][{{ $id }}][back_card_theme]" type="hidden" value="$themes[$flipcards['back_card_theme']]" class="input-form-theme2" autocomplete="off" data-id="{{ $id }}">
						</div>
					@endif

					<input name="flipcards[cards][{{ $id }}][card_type_front]" type="hidden" value="{{ $flipcards['card_type_front'] }}" class="input-type-front" autocomplete="off" data-id="{{ $id }}">
					<input name="flipcards[cards][{{ $id }}][card_type_back]" type="hidden" value="{{ $flipcards['card_type_back'] }}" class="input-type-back" autocomplete="off" data-id="{{ $id }}">

				</div>
				<?php $id++; ?>
				@endforeach

				<button type="button" id="add_card">ADD CARD</button>
				<div class="down_butts">
					<button type="button" id="preview" class="btn-preview">PREVIEW</button>
					<button type="button" id="save_draft" class="btn-save">SAVE DRAFT</button>
					<button type="button" id="publish" class="btn-publish">PUBLISH</button>
				</div>
				<input name="isDraft" type="hidden" value="publish" class="isDraft" autocomplete="off">
				<input name="flipcards[data][postID]" type="hidden" value="{{ $post->id }}" class="postID" autocomplete="off">
				<input name="flipcards[data][photo_main]" type="hidden" value="{{ $post->description_image }}" class="input-form-photo" autocomplete="off">
				<input name="flipcards[data][photo_facebook]" type="hidden" value="{{ $post->image_facebook }}" class="input-form-photo-facebook" autocomplete="off">
			</div>
			<div class="right">
				<div class="title">SOCIAL APPEARANCE</div>
				<div class="sub_title">How your content will appear on social media</div>
				<div class="facebok_block">
					<div class="add_fb_img" style="padding-top: 0px;"><img class='facebook-photo' src='/uploads/{{ $post->image_facebook }}' /></div>
					<div class="edit_image_text">
						Facebook<br>Edit Image
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
				<div class="down_butts add_flip_cards_butts">
					<button type="button" id="preview" class="btn-preview">PREVIEW</button>
					<button type="button" id="save_draft" class="btn-save">SAVE DRAFT</button>
					<button type="button" id="publish" class="btn-publish">PUBLISH</button>
				</div>
			</div>
		</form>
	</div>

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
						<img src="/img/author.png">
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
				<p>or</p>
				<div class="modal-upload-url">
					<input type="text" class="upload-img-url" placeholder="Enter URL">	
					<button type="button" class="upload-img-url-btn">GO</button>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('script')
<script> var count_fc = 1; </script>
<script src="/js/flipcards.js"></script>
@endsection