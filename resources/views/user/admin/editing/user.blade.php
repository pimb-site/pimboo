@extends('page')

@section('content')
		<div class="body">
			<div class="wrap">
				<form action="/admin/editing/update/user" method="POST">
					<input type="hidden" id="register_token" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="user_id" value="{{ $user->id }}">
					<input type="hidden" name="user_name" value="{{ $user->name }}">
					<div class="profile">
						<div class="left">
							<div class="title">USERNAME: <font color="green">{{ $user->name }}</font>,  CHANNEL ID: <font color="green">{{ $user->id }}</font></div>
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
									<div class="photo-user">
										@if (empty($user->photo))
											<img src="/img/header_default_photo.png" style="width: 150px; height: 150px; border-radius: 50%; border: 2px solid #afc0e1; background-color: #fff;">
										@else 
											<img src="/uploads/{{ $user->photo }}" style="width: 150px; height: 150px; border-radius: 50%; border: 2px solid #afc0e1; background-color: #fff;">
										@endif
									</div>
									<a class="adm-del-photo" data-type="photo" href="#" data-id="{{ $user->id }}">Delete user photo</a>
								</div>
							</div>
							@if(empty($user->cover_photo))
							<div class="middle-user" style="width: 750px; height: 152px; border: 1px dashed #99afd9; border-radius: 8px; margin-top: 33px;padding-top: 50px;">
								<div class="sub_title" style="text-align: center; font-size: 18px;">NO COVER PHOTO</div>
							</div>
							@else
							<div class="middle-user isset-cover" style="width: 750px; height: 152px; margin-top: 33px; border: 1px dashed #99afd9; border-radius: 8px; background-size: 100%; background-position: center;  background-image: url(/uploads/{{ $user->cover_photo }}"> </div>
							@endif
							<center> <a class="adm-del-photo" href="#" data-type="cover" data-id="{{ $user->id }}">Delete user cover photo</a> </center>
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
								<button type="button" onclick='window.location = "/{{ $user->name }}"'>VIEW THIS PROFILE</button>
								<button type="submit" class="save">UPDATE THIS PROFILE</button>
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
									<div class="checkbox"><label><input class="checkbox checkbox_sub" data-id="1" type="checkbox" name="weekly_digest" value="1" checked><span class="checkbox-custom"></span><span class="label" data-id="1">User are subscribed</span></label></div>
								@else
									<div class="checkbox"><label><input class="checkbox checkbox_sub"  data-id="1" type="checkbox" name="weekly_digest" value="1"><span class="checkbox-custom"></span><span class="label"  data-id="1">User are unsubscribed</span></label></div>
								@endif
							</div>
							<div class="subscribers">
								<div class="sub_title">NEW SUBSCRIBERS UPDATE</div>
								<div class="text">Get an update for new subscribers in your<br>channels</div>
								@if ($user->new_subs_update)
									<div class="checkbox"><label><input class="checkbox checkbox_sub" data-id="2" type="checkbox" name="new_subs_update"  value="1" checked><span class="checkbox-custom"></span><span class="label" data-id="2">User are subscribed</span></label></div>
								@else
									<div class="checkbox"><label><input class="checkbox checkbox_sub" data-id="2" type="checkbox" name="new_subs_update"  value="1" ><span class="checkbox-custom"></span><span class="label" data-id="2">User are unsubscribed</span></label></div>
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
					</div>
				</div>
			</div>
		</div>
@endsection
@section('script')
	<script>

   //      $('.checkbox_sub').click(function() {
   //      	current_id = $(this).data("id");
			// if($('.checkbox[data-id="'+current_id+'"]').prop('checked')) {
			//     $('.label[data-id="'+current_id+'"]').html("User are subscribed");
			// } else {
			//     $('.label[data-id="'+current_id+'"]').html("User are unsubscribed");
			// }
   //      });


		$('a.adm-del-photo').click(function() {
			var token = "{{ csrf_token() }}";
			var user_id = $(this).data('id');
			var type = $(this).data('type');

			$.ajax({
			    url: '/admin/action/deleteuserphoto',
			    dataType : "json",
			    data: {'user_id' : user_id, 'type': type, '_token': token},
			    type: 'POST',
			    success: function (data, textStatus) {
			    	if(data.success == true) {
			    		window.location.href = "/admin/editing/user/"+user_id;
			    	}
			    } 
			});
		});

	</script>

@endsection