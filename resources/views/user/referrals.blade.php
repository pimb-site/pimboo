@extends('page')

@section('content')
		<div class="body">
			<div class="wrap">
				@include('user.header')
				<div class="referals">
					<div class="title">Invite Friends. Get Paid For Life <span>!</span></div>
					<div class="text">Use our tools to invite your friends to join Pimboo and get a % of their posts for life!<br>It's free for them as well, and always will be! Its a win win!</div>
					<div class="address_book">
						<div class="sub_title">Invite Your Contacts from Your Address Book</div>
						<div class="mails-center-block" style="display: none;">
							<div class="answer-checkbox">

							</div>
							<button>SEND</button>
						</div>
						<div class="mails" >
							<div class="mail gmail" onclick="auth_google();"></div>
							<div class="mail hotmail"></div>
							<div class="mail yahoo"></div>
						</div>
						<div class="input">
							<input type="text" name="" placeholder="Enter friend’s email address">
							<button></button>
						</div>
					</div>
					<div class="invite_link">
						<div class="sub_title">Your Invite Link</div>
						<input type="text" name="" value="http://pimboobeta.com/ref/{{ $user->id }}" disabled="disabled">
						<div class="shares">
							<div class="fb share"></div>
							<div class="twitter share"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection
@section('script')
	<script src="https://apis.google.com/js/client.js"></script>
    <script>

    function auth_google() {
        var config = {
          'client_id': '730525283382-s95g8bgmr02ei5f81vn4ddcsq7bgdlku.apps.googleusercontent.com',
          'scope': 'https://www.google.com/m8/feeds'
        };
        gapi.auth.authorize(config, function() {
          fetch_google(gapi.auth.getToken());
        });
    }
	function fetch_google(token) {
	    $.ajax({
	        url: "https://www.google.com/m8/feeds/contacts/default/full?access_token=" + token.access_token + "&alt=json",
	        dataType: "jsonp",
	        success:function(data) {

	        	if(typeof data.feed.entry == "undefined")  {
	        		console.log('count of last contacts : 0');
	        		return false;
	        	}

	        	var html_tags = "";
	            $.each(data.feed.entry, function(index, value) {
	            	if(typeof value.gd$email == "undefined")  {
	            		console.log('count of last contacts : 0');
	            		return false;
	            	} else {
	            		html_tags += '<div class="tag"><label><input class="checkbox" type="checkbox" name="flip_cards[1][answer_check1]" value="Celebrities"><span class="checkbox-custom"></span><span class="label">'+value.gd$email[0].address+'</span></label></div>';
	            	}
	            });
	            $('.answer-checkbox').html(html_tags);
	            $('.mails').css({'display': 'none'});
	            $('.input').css({'display': 'none'});
	            $('.mails-center-block').css({'display': 'block'});
	        }
	    });
    }
    </script>
@endsection
