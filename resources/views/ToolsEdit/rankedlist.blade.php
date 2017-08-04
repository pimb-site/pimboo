@extends('page')

@section('title') | Editing Ranked List @endsection

@section('css')
<link href="/css/jquery.Jcrop.min.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
<div class="body">
		<form action="/create/rankedlist/send" id="form_upload_cards" method="POST">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="left">
				<div class="title">RANKED LIST EDITING</div>
				<?php 
				$status = $post->isDraft == 'publish' ? 'published. ' : 'not published (saved). ';
				if($isAdmin) $status .= "Author: <a style='display:inline;' href='/$post->author_name'>$post->author_name</a>";
				?>
				<div class="sub_title">Current status of the post: <font color="#123880">{!! $status !!}</font></div>
				<div class="card_info">
					<div class="top">
						<div class="photo" style="padding-top: 0px;" ><img class='main-photo' src='/uploads/{{ $post->description_image }}' /></div>
						<div class="text_info">
							<input type="text" name="rankedlist[data][rankedlist_title]" value="{{ $post->description_title }}" placeholder="Ranked list title" autocomplete="off" style="color:#6e8dc9;">
							<textarea name="rankedlist[data][rankedlist_description]" class="top_textarea_trivia" placeholder="Ranked list description" autocomplete="off">{{ $post->description_text }}</textarea>
						</div>
					</div>
					<textarea name="rankedlist[data][rankedlist_footer]" placeholder="Footer text (500 symbols max)" maxlength="500" autocomplete="off" style="color:#6e8dc9;">{{ $post->description_footer }}</textarea>
				</div>
				<?php
				$content = unserialize($post->content);
				$id = 1;
				?>
				<style type="text/css">
					.editor iframe {
						width: 100%;
						height: 100%;
						border-radius: 8px;
					}
				</style>
				@foreach ($content as $rankedlist)
				<input class="post-title" type="text" name="rankedlist[cards][{{ $id }}][post_title]" placeholder="Post title" value="{{ $rankedlist['post_title'] }}"> </input>
				<div class="editor" data-id="{{ $id }}">
					<div class="front-card" data-id="{{ $id }}">
						@if ($rankedlist['type_card'] == "image")
							<img style="position:absolute;" class="image-card" src="/uploads/{{ $rankedlist['image_card'] }}">
							<input name="rankedlist[cards][{{ $id }}][image_card]" type="hidden" value="{{ $rankedlist['image_card'] }}" class="input-form-img1" autocomplete="off" data-id="{{ $id }}">
						@else
							{!! $rankedlist['youtube_clip'] !!}
							<input name="rankedlist[cards][{{ $id }}][youtube_clip]" type="hidden" value="{{ $rankedlist['youtube_clip'] }}" class="input-form-clip" autocomplete="off" data-id="{{ $id }}" data-side="1">
						@endif
						<div class="block-type-caption">
							<textarea name="rankedlist[cards][{{ $id }}][caption_card]" class="type-caption" placeholder="Type your text or caption" style="position:relative;" data-id="1" data-side="1" maxlength="50">{{ $rankedlist['caption_card'] }}</textarea>
						</div>
					</div>
				</div>
				<input name="rankedlist[cards][{{ $id }}][type_card]" type="hidden" value="{{ $rankedlist['type_card'] }}" class="input-type-card" autocomplete="off" data-id="{{ $id }}" data-side="1">
				<?php $id++ ?>
				@endforeach
				
				<button type="button" class="add-question">ADD QUESTION</button>
				<div class="down_butts">
					<button type="button" id="preview" class="btn-preview">PREVIEW</button>
					<button type="button" id="save_draft" class="btn-save">SAVE DRAFT</button>
					<button type="button" id="publish" class="btn-publish">PUBLISH</button>
				</div>
				<input name="isDraft" type="hidden" value="publish" class="isDraft" autocomplete="off">
				<input name="rankedlist[data][postID]" type="hidden" value="{{ $post->id }}" class="postID" autocomplete="off">
				<input name="rankedlist[data][photo_main]" type="hidden" value="{{ $post->description_image }}" class="input-form-photo" autocomplete="off">
				<input name="rankedlist[data][photo_facebook]" type="hidden" value="{{ $post->image_facebook }}" class="input-form-photo-facebook" autocomplete="off">
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
				<div class="modal-upload-url">
					<p>or</p>
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