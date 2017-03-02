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
									<textarea name="public_info" placeholder="Public profile info">{{ $user->public_info }}</textarea>
								</div>
								<div class="right">
									<div class="photo">
										@if (empty($user->photo))
											<img src="/img/header_default_photo.png">
										@else 
											<img src="{{ $user->photo }}}">
										@endif
									</div>
									<a>Delete Image</a>
								</div>
							</div>
							<div class="middle">
								<div class="sub_title">ADD COVER PHOTO</div>
								<div class="plus"></div>
							</div>
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
								<button>VIEW PROFILE</button>
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
		</div>
@endsection