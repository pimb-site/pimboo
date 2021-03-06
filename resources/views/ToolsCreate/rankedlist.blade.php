@extends('page')

@section('title') | Creating Ranked List @endsection

@section('css')
<link href="/css/jquery.Jcrop.min.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
<div class="body">
		<form action="/create/rankedlist/send" id="form_upload_cards" method="POST">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="left">
				<div class="title">RANKED LIST CREATION</div>
				<div class="sub_title">Add all necessary information to create a new ranked list</div>
				<div class="card_info">
					<div class="top">
						<div class="photo">CLICK<br>TO ADD PHOTO</div>
						<div class="text_info">
							<input type="text" name="rankedlist[data][rankedlist_title]" placeholder="Ranked list title" autocomplete="off" style="color:#6e8dc9;">
							<textarea name="rankedlist[data][rankedlist_description]" class="top_textarea_trivia" placeholder="Ranked list description" autocomplete="off" ></textarea>
						</div>
					</div>
					<textarea name="rankedlist[data][rankedlist_footer]" placeholder="Footer text (500 symbols max)" maxlength="500" autocomplete="off" style="color:#6e8dc9;"></textarea>
				</div>
				<input class="post-title" type="text" name="rankedlist[cards][1][post_title]" placeholder="Post title"> </input>
				<div class="editor" data-id="1">
					<div class="front-card" data-id="1">
						<div class="main-remove-front" data-id="1">
							<div class="title">CLICK TO ADD PHOTO OR VIDEO</div>
							<div class="butts">
								<div class="add_plus" data-id="1" data-side="1"></div>
							</div>
						</div>
						<div class="block-type-caption">
							<textarea name="rankedlist[cards][1][caption_card]" class="type-caption" placeholder="Type your text or caption" style="position:relative;" data-id="1" data-side="1" maxlength="50"></textarea>
						</div>
					</div>
				</div>
				
				<button type="button" class="add-question">ADD QUESTION</button>
				<div class="down_butts">
					<button type="button" id="preview" class="btn-preview">PREVIEW</button>
					<button type="button" id="save_draft" class="btn-save">SAVE DRAFT</button>
					<button type="button" id="publish" class="btn-publish">PUBLISH</button>
				</div>
				<input name="isDraft" type="hidden" value="publish" class="isDraft" autocomplete="off">
				<input name="rankedlist[data][postID]" type="hidden" value="" class="postID" autocomplete="off">
				<input name="rankedlist[data][photo_main]" type="hidden" value="" class="input-form-photo" autocomplete="off">
				<input name="rankedlist[data][photo_facebook]" type="hidden" value="" class="input-form-photo-facebook" autocomplete="off">
				<input name="rankedlist[cards][1][type_card]" type="hidden" value="image" class="input-type-card" autocomplete="off" data-id="1" data-side="1">
				<input name="rankedlist[cards][1][image_card]" type="hidden" value="" class="input-form-img1" autocomplete="off" data-id="1">
				<input name="rankedlist[cards][1][youtube_clip]" type="hidden" value="" class="input-form-clip" autocomplete="off" data-id="1" data-side="1">
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
				<div class="down_butts add_ranked_list_butts">
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
						<img src="/img/author.png">
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
				<div class="modal-file-icon" onclick="$('input[name=filedata]')[0].click();"><div class="select-file" ><input type="file" name="filedata" style="display: none"><div class="modal-text-upl">From File</div></div></div>
				<div class="modal-file-upl"><div class="modal-url-icon"></div><div class="modal-text-upl">From URL</div></div>
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
		<div style="margin: 0 0 5px; text-align: center;">
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
@endsection

@section('script')
<script> var count_fc = 1; </script>
<script src="/js/rankedlist.js"></script>
@endsection