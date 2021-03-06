@extends('page')

@section('content')
		<div class="body">
			<div class="wrap">
				@include('user.header')
				<div class="referals">
					<div class="title">Invite Friends. Get Paid For <span>Life!</span></div>
					<div class="text">Use our tools to invite your friends to join Pimboo and get a % of their posts for life!<br>It's free for them as well, and always will be! Its a win win!</div>
					<div class="address_book" style="display: none;">
						<div class="sub_title">Invite Your Contacts from Your Address Book</div>
						<div class="mails-center-block" style="display: none;">
							<form action="/referrals/mass" method="post" id="massMails">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="answer-checkbox"></div>
							</form>
							<button type="button">SEND</button>
						</div>
						<div class="mails" >
							<div class="mail gmail" onclick="auth_google();"></div>
							<div class="mail hotmail"></div>
							<div class="mail yahoo"></div>
						</div>
						<div class="input">
							<form action="/referrals/mass" method="post" id="noMassMails">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="text" name="mails[]" placeholder="Enter friend’s email address">
							<button type="button"></button>
							</form>
						</div>
					</div>
					<div class="invite_link">
						<div class="sub_title">Your Invite Link</div>
						<input type="text" name="" value="{!! url('/ref/') !!}/{{ $user->name }}" disabled="disabled">
						<div class="shares">
							<div data-title="Pimboo" data-url="{!! url('/ref/') !!}/{{ $user->name }}" data-type="fb" class="butt-for-sharing fb share"></div>
							<div data-title="Pimboo" data-url="{!! url('/ref/') !!}/{{ $user->name }}" data-type="tw" class="butt-for-sharing twitter share"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection
@section('script')
	<script src="https://apis.google.com/js/client.js"></script>
	<script src="//js.live.net/v5.0/wl.js"></script>
	<script type="text/javascript">
	WL.init({
	    client_id: '00000000441CF42B',
	    redirect_uri: '{!! url('') !!}/user/referrals',
	    scope: ["wl.basic", "wl.contacts_emails"],
	    response_type: "token"
	});
	</script>
    <script>

    $('.hotmail').click(function() {
	    WL.login({
	        scope: ["wl.basic", "wl.contacts_emails"]
	    }).then(function (response) 
	    {
			WL.api({
	            path: "me/contacts",
	            method: "GET"
	        }).then(
	            function (response) {
	            	if(response.data.length != 0) {
	            		var html_tags = "";
	            		$.each(response.data, function( index, value ) {
	            			html_tags += '<div class="tag"><label><input class="checkbox" type="checkbox" name="mails[]" value="'+value.emails.preferred+'"><span class="checkbox-custom"></span><span class="label">'+value.emails.preferred+'</span></label></div>';
	            		});
	            		$('.address_book').css({'height': 'auto'});
			            $('.answer-checkbox').html(html_tags);
			            $('.mails').css({'display': 'none'});
			            $('.input').css({'display': 'none'});
			            $('.mails-center-block').css({'display': 'block'});
	            	}
	            },
	            function (responseFailed) {
	            	//console.log(responseFailed);
	            }
	        );
	        
	    },
	    function (responseFailed) 
	    {
	        //console.log("Error signing in: " + responseFailed.error_description);
	    });
    });

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
	            		html_tags += '<div class="tag"><label><input class="checkbox" type="checkbox" name="mails[]" value="'+value.gd$email[0].address+'"><span class="checkbox-custom"></span><span class="label">'+value.gd$email[0].address+'</span></label></div>';
	            	}
	            });
	            $('.address_book').css({'height': 'auto'});
	            $('.answer-checkbox').html(html_tags);
	            $('.mails').css({'display': 'none'});
	            $('.input').css({'display': 'none'});
	            $('.mails-center-block').css({'display': 'block'});
	        }
	    });
    }

    $('.input button').click(function() {
    	$('#noMassMails').ajaxSubmit({
			dataType: "json",
			success: function (data) {
				if(data.success == true) {
					var alertHtml = '<div class="warning-text"><b>Invitation sent!</b></div>';
					$('.input').css({'display': 'none'});
				} else {
					var alertHtml = '<div class="warning-text"><b>An error has occurred, no invitation have been sent!</b></div>';
				}
				$('.mails').css({'display': 'none'});
				$('.warning-text').remove();
				$('.mails-center-block').before(alertHtml);
				$('.mails-center-block').css({'display': 'none'});
			}
		});
    });

    $('.mails-center-block button').click(function() {
		$('#massMails').ajaxSubmit({
			dataType: "json",
			success: function (data) {
				if(data.success == true) {
					var alertHtml = '<div class="warning-text"><b>Invitations sent!</b></div>';
				} else {
					var alertHtml = '<div class="warning-text"><b>An error has occurred, no invitations have been sent!</b></div>';
				}
				$('.mails-center-block').before(alertHtml);
				$('.mails-center-block').css({'display': 'none'});
			}
		});
    });
    </script>
@endsection
