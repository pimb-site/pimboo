@extends('page')

@section('content')
		<div class="body">
			<div class="wrap">
				@include('user.header')
				<div class="referals">
					<img src="/img/referral_present.png">
					<div class="title">Invite Friends. Get Premium for <span>Free!</span></div>
					<div class="text">You’ll earn one free week of Premium for each friend who signs up and installs our<br>browser extension. They’ll get one week of Premium as well. Its a win win!</div>
					<div class="address_book">
						<div class="sub_title">Invite Your Contacts from Your Address Book</div>
						<div class="mails">
							<div class="mail gmail"></div>
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
