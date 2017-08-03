@extends('page')

@section('content')
		<div class="body">
			<div class="wrap">
				@include('user.header')
				<form action="/user/profile" method="POST">
					<input type="hidden" id="register_token" name="_token" value="{{ csrf_token() }}">
					<div class="profile">
						<div class="left">
							<div class="title">PROFILE SETTINGS</div>
							<div class="top">
								<div class="left">
									<div class="sub_title">Edit profile</div>
									<input type="text" name="name" placeholder="Name" value="{{ $user->name }}">
									<?php
								    foreach ($errors->all(':message<br/>') as $message) {
						                echo $message;
						            }
									?>
									<textarea name="public_info" placeholder="Public profile info">{{ $user->public_info }}</textarea>
								</div>
								<div class="right">
									<div class="photo">
										@if (empty($user->photo))
											<img src="/img/header_default_photo.png">
										@else 
											<img src="/uploads/{{ $user->photo }}">
										@endif
									</div>
									<a class="delete-user-photo">Delete Image</a>
								</div>
							</div>
							@if(empty($user->cover_photo))
							<div class="middle">
								<div class="sub_title">ADD COVER PHOTO</div>
								<div class="plus"></div>
							</div>
							@else
							<div class="middle isset-cover" style="background-image: url(/uploads/{{ $user->cover_photo }}"> </div>
							@endif
							<div class="bottom">
								<div class="sub_title">Social links</div>
								<div class="input"><img src="/img/profile_website_icon.png"><input value="{{ $user->website_link }}" type="text" name="website_link" placeholder="http://www.MyWebsite.com"></div>
								<div class="input"><img src="/img/profile_fb_icon.png"><input value="{{ $user->fb_link }}" type="text" name="fb_link" placeholder="http://www.facebook.com/MyFacebook"></div>
								@if ($user->show_fb_link)
									<div class="checkbox"><label><input class="checkbox" type="checkbox" value="1" name="show_fb_link" checked><span class="checkbox-custom"></span><span class="label">Show Facebook plugin on my profile page (fan page only)</span></label></div>
								@else
									<div class="checkbox"><label><input class="checkbox" type="checkbox" value="1" name="show_fb_link"><span class="checkbox-custom"></span><span class="label">Show Facebook plugin on my profile page (fan page only)</span></label></div>
								@endif
								<div class="input"><img src="/img/profile_twitter_icon.png"><input value="{{ $user->twitter_link }}" type="text" name="twitter_link" placeholder="http://www.twitter.com/MyTwitter"></div>
								@if ($user->show_twitter_link)
									<div class="checkbox"><label><input class="checkbox" type="checkbox" value="1" name="show_twitter_link" checked><span class="checkbox-custom"></span><span class="label">Show Twitter feed plugin on my profile page.</span></label></div>
								@else
									<div class="checkbox"><label><input class="checkbox" type="checkbox" value="1" name="show_twitter_link"><span class="checkbox-custom"></span><span class="label">Show Twitter feed plugin on my profile page.</span></label></div>
								@endif
								<div class="input"><img src="/img/profile_google_plus_icon.png"><input value="{{ $user->google_pluse_link }}" type="text" name="google_pluse_link" placeholder="http://plus.google.com/MyGooglePlus"></div>
							</div>
							<div class="end-buttons">
								<button type="button" onclick='window.location = "/{{ Auth::user()->name }}"'>VIEW PROFILE</button>
								<button type="submit" class="save">SAVE CHANGES</button>
							</div>
						</div>
						<div class="right">
							<div class="title">NOTIFICATIONS</div>
							<div class="email">
								<div class="sub_title">Email preferences for:</div>
								<input type="text" name="email_for_news" placeholder="email" value="{{ $user->email_for_news }}">
							</div>
							<div class="digest">
								<div class="sub_title">WEEKLY DIGEST</div>
								<div class="text">A weekly newsletter from your favorite Pimboo<br>channels</div>
								@if ($user->weekly_digest)
									<div class="checkbox"><label><input class="checkbox" type="checkbox" name="weekly_digest" value="1" checked><span class="checkbox-custom"></span><span class="label">You are subscribed</span></label></div>
								@else
									<div class="checkbox"><label><input class="checkbox" type="checkbox" name="weekly_digest" value="1"><span class="checkbox-custom"></span><span class="label">You are unsubscribed</span></label></div>
								@endif
							</div>
							<div class="subscribers">
								<div class="sub_title">NEW SUBSCRIBERS UPDATE</div>
								<div class="text">Get an update for new subscribers in your<br>channels</div>
								@if ($user->new_subs_update)
									<div class="checkbox"><label><input class="checkbox" type="checkbox" name="new_subs_update"  value="1" checked><span class="checkbox-custom"></span><span class="label">You are subscribed</span></label></div>
								@else
									<div class="checkbox"><label><input class="checkbox" type="checkbox" name="new_subs_update"  value="1" ><span class="checkbox-custom"></span><span class="label">You are unsubscribed</span></label></div>
								@endif

							</div>
						</div>
					</div>
				</form>
			</div>
			<div id="popup" class="popup" style="display: none;">
			<div class="modal-text-photo">ADD PHOTO</div>
				<div class="modal-upload-column-img">
					<div class="popup__body"><div class="js-img"></div></div>
				</div>
				<div class="js-upload btn btn_browse btn_browse_small">SAVE</div>
			</div>
			
			
			<div id="modal-upload-photo" class="modal-upload-photo" data-type="cover" style="display: none;">
				<div class="popup__body"><div class="js-img"></div></div>
				<div style="margin: 0 0 5px; text-align: center;">
					<div class="modal-text-photo">ADD PHOTO</div>
					<div class="modal-upload-column">
						<p> UPLOAD IMAGE </p>
						<div class="select-file-for-cover"> <div class="modal-file-icon"></div><input type="file" name="filedata"></div>
						<div class="modal-upload-url">
							<p>or</p>
							<input type="text" class="upload-img-url" placeholder="Enter URL">	
							<button type="button" class="upload-img-url-btn">GO</button>
						</div>
					</div>
				</div>
			</div>
			<div id="modal-upload-photo" class="modal-upload-photo" data-type="photo" style="display: none;">
				<div class="popup__body"><div class="js-img"></div></div>
				<div style="margin: 0 0 5px; text-align: center;">
					<div class="modal-text-photo">ADD PHOTO</div>
					<div class="modal-upload-column">
						<p> UPLOAD IMAGE </p>
						<div class="select-file-for-photo"> <div class="modal-file-icon"></div><input type="file" name="filedata"></div>
						<div class="modal-upload-url">
							<p>or</p>
							<input type="text" class="upload-img-url" placeholder="Enter URL">	
							<button type="button" class="upload-img-url-btn">GO</button>
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection