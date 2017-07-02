<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pimboo Ranked List</title>
	<link href="/css/style.min.css" rel="stylesheet">
	<link href="/css/trivia_new.css" rel="stylesheet">
	<link href="/test/jcrop/jquery.Jcrop.min.css" rel="stylesheet" type="text/css"/>
</head>
	<body class="tools_create_page">
		@include('header')
		<div class="body">
		<form id="form_upload_cards" action="/admin/editing/update/rankedlist" method="POST">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="post_id" value="{{ $post->id }}">
			<div class="left">
				<div class="title">RANKED LIST CREATION</div>
				<div class="sub_title">Add all necessary information to create a new ranked list</div>
				<div class="card_info">
					<div class="top">
						<div class="photo" style="padding-top: 0px;" ><img class='main-photo' src='/uploads/{{ $post->description_image }}' /></div>
						<div class="text_info">
							<input type="text" name="form_flip[form_flip_cards_title]" placeholder="Ranked list title" autocomplete="off" style="color:#6e8dc9;" value="{{ $post->description_title }}">
							<textarea name="form_flip[form_description]" class="top_textarea_trivia" placeholder="Ranked list description" autocomplete="off">{{ $post->description_text }}</textarea>
						</div>
					</div>
					<textarea name="form_flip[form_footer]" placeholder="Footer text (1500 symbols max)" maxlength="1500" autocomplete="off" style="color:#6e8dc9;">{{ $post->description_footer }}</textarea>
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
				<input class="post-title" type="text" name="flip_cards[{{ $id }}][post_title]" placeholder="Post title" value="{{ $rankedlist['post_title'] }}"> </input>
				<div class="editor" data-id="{{ $id }}">
					<div class="front-card" data-id="{{ $id }}">
						@if ($rankedlist['type_card_front'] == "image")
							<img style="position:absolute;" class="image-card" src="/uploads/{{ $rankedlist['front_card'] }}">
						@else
							{!! $rankedlist['youtube_clip1'] !!}
						@endif
						<div class="block-type-caption">
							<textarea name="flip_cards[{{ $id }}][caption1]" class="type-caption" placeholder="Type your text or caption" style="position:relative;" data-id="{{ $id }}" data-side="1" maxlength="50">{{ $rankedlist['caption1'] }}</textarea>
						</div>
					</div>
				</div>
				<input name="flip_cards[{{ $id }}][type_card1]" type="hidden" value="{{ $rankedlist['type_card_front'] }}" class="input-type-card" autocomplete="off" data-id="{{ $id }}" data-side="1">
				<input name="flip_cards[{{ $id }}][img_src1]" type="hidden" value="{{ $rankedlist['front_card'] }}" class="input-form-img1" autocomplete="off" data-id="{{ $id }}">
				<input name="flip_cards[{{ $id }}][youtube_clip1]" type="hidden" value="{{ $rankedlist['youtube_clip1'] }}" class="input-form-clip" autocomplete="off" data-id="{{ $id }}" data-side="1">
				<input name="flip_cards[{{ $id }}][votes]" type="hidden" value="{{ $rankedlist['votes'] }}" class="input-form-clip" autocomplete="off">
				<?php 
				$id++;
				?>
				@endforeach
				<button type="button" class="add-question">ADD QUESTION</button>
				<div class="down_butts">
					<button type="button" id="publish" class="btn-publish" style="margin-left: 250px;">UPDATE</button>
				</div>
				<input name="form_flip[form_photo]" type="hidden" class="input-form-photo" autocomplete="off" value="{{ $post->description_image }}">
				<input name="form_flip[form_photo_facebook]" type="hidden" class="input-form-photo-facebook" autocomplete="off" value="{{ $post->image_facebook }}">
			</div>
			<script> 
			var count_fc = {{ $id }};
			</script>
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
					<button type="button" id="publish" class="btn-publish">UPDATE</button>
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
	<script src="/js/footer.min.js"></script>
	<script src="/js/rankedlist.js"></script>
	<script> 
		var count_fc = 1;
		<?php
		if(isset($id)) {
			print 'count_fc = '.$id.';';
		}
		?>
	 </script>
	</body>
</html>