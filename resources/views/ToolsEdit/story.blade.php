@extends('page')

@section('title') | Editing Story @endsection

@section('css')
<link href="/css/jquery.Jcrop.min.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
<div class="body">
		<form action="/create/story/send" method="post" id="form_upload_cards">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="left">
				<div class="title">STORY EDITING</div>
				<?php 
				$status = $post->isDraft == 'publish' ? 'published. ' : 'not published (saved). ';
				if($isAdmin) $status .= "Author: <a style='display:inline;' href='/$post->author_name'>$post->author_name</a>";
				?>
				<div class="sub_title">Current status of the post: <font color="#123880">{!! $status !!}</font></div>
				<div class="card_info">
					<div class="top">
						<div class="photo" style="padding-top: 0px;" ><img class='main-photo' src='/uploads/{{ $post->description_image }}' /></div>
						<div class="text_info">
							<input type="text" name="story[data][story_title]" placeholder="Story title" autocomplete="off" value="{{ $post->description_title }}">
							<textarea name="story[data][story_description]" class="variable-description"  placeholder="Story description" autocomplete="off">{{ $post->description_text }}</textarea>
						</div>
					</div>
				</div>
				<textarea id="content_textarea" name="story[story_content]">{{ $post->content }}</textarea>

				<div class="down_butts">
					<button type="button" id="save_draft_story" class="btn-save">SAVE DRAFT</button>
					<button type="button" id="publish_story" class="btn-publish">PUBLISH</button>
				</div>
				<input name="isDraft" type="hidden" value="publish" class="isDraft" autocomplete="off">
				<input name="story[data][postID]" type="hidden" value="{{ $post->id }}" class="postID" autocomplete="off">
				<input name="story[data][photo_main]" type="hidden" value="{{ $post->description_image }}" class="input-form-photo" autocomplete="off">
				<input name="story[data][photo_facebook]" type="hidden" value="{{ $post->image_facebook }}" class="input-form-photo-facebook" autocomplete="off">
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
				<div class="down_butts story_butts">
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
<script src="http://cloud.tinymce.com/stable/tinymce.min.js?apiKey=me1xx87jvui3cahvnslljl2cp1xb1ivawta8z8je4iesro99"></script>
<script>
	tinymce_init = 1;
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
<script src="/js/flipcards.js"></script>
@endsection