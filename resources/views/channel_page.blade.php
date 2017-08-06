@extends('page')

@section('title') | {{ $user_info->name }} - channel @endsection

@section('content')
<div class="body-channel">
	<?php
	$user_photo = ($user_info->photo == "") ? "/img/header_default_photo.png" : "/uploads/".$user_info->photo;
	$aType = [
		'rankedlist' => 'RANKED LIST',
		'flipcards'  => 'FLIP CARD',
		'trivia'     => 'TRIVIA CARD',
		'story'      => 'STORY',
		'gif'        => 'GIF',
		'snip'       => 'SNIP'
	];
	?>
	@if(empty($user_info->cover_photo))
		<div class="cover-bg"></div>
	@else
		<div class="cover-bg" style="background-image: url(/uploads/{{ $user_info->cover_photo }})"></div>
	@endif
	<div class="wrap">
		<div class="channel-posts" >
			@if(count($channel_content) == 0)
				<div class="post"><h1> User has no entries </h1> </div>
			@endif
			<?php $count = 1; ?>
			@foreach($channel_content as $post)
			<?php
			$post_date    = new DateTime($post->created_at);
			$current_date = new DateTime();
			$days = $current_date->format("d") - $post_date->format("d");
			$month = $current_date->format("m") - $post_date->format("m");
			?>
			<div class="post" data-id="{{ $count }}" >
				<div class="post-left">
					<div class="photo"> <img src="/uploads/{{ $post->description_image }}"></div>
					<div class="date">
					<?php $status = $post->isDraft == 'save' ? 'Saved' : 'Posted'; ?>
					@if($month == 0)
						@if($days == 0)
							{{ $status }} Today
						@else 
							{{ $status }} {{ $days }} days ago
						@endif
					@else
						Posted {{ $month }} month ago
					@endif
					</div>
				</div>
				<div class="post-right">
					<div class="title"><a href="{{ url('/'.$post->author_name.'/'.$post->url) }}">{{ $post->description_title }}</a></div>
					<div class="description">{{ $post->description_text }}</div>
					@if($post->isDraft == "publish")
					<div class="share">Share this <a href="#">{{ $aType[$post->type] }}</a></div>
					@else
					<div class="share">This post has been saved. You can publish this post on the post edit page.</div>
					@endif
					<div class="buttons_share" data-id="{{ $count }}">
						@if($post->isDraft != 'save')
						<button data-title="{{ $post->description_title }}" data-url="{{ url('/'.$post->author_name.'/'.$post->url) }}" data-type="fb" class="butt-for-sharing"><img src="/img/view_fb.png"></button>
						<button data-title="{{ $post->description_title }}" data-url="{{ url('/'.$post->author_name.'/'.$post->url) }}" data-type="tw" class="butt-for-sharing"><img src="/img/view_twitter.png"></button>
						<button data-title="{{ $post->description_title }}" data-url="{{ url('/'.$post->author_name.'/'.$post->url) }}" data-type="li" class="butt-for-sharing"><img src="/img/view_linkedin.png"></button>
						<button><img src="/img/view_link.png"></button>
						<button class="get_link" data-href="{{ url('/'.$post->author_name.'/'.$post->url) }}" data-id="{{ $count }}">GET LINK</button>
						@endif
						@if ($isAdmin || $isRights)
						<div class="buttons deletePost" data-id="{{ $count }}" data-pid="{{ $post->id }}" data-toggle="confirmation" data-placement="bottom">
							<button ><img src="/img/del_button.png"></button>
						</div>
						<div class="buttons editPost">
							<button onclick="window.location.href = '{{ url('/edit/'.$post->author_name.'/'.$post->url) }}';"><img src="/img/edit_button.png"></button>
						</div>
						@endif
					</div>
                    <div class="link"  data-id="{{ $count }}">
                        <span class="link_in">COPIED TO YOUR<br>CLIPBOARD</span>
                        <input type="" name="" value="" />
                    </div>
				</div>
			</div>
				<?php $count++; ?>
				@endforeach
			<div class="btn-box">
				@if($show_more == true)
					<button class="show-more">SHOW MORE</button>
				@else
					<button class="show-more" style="display: none;">SHOW MORE</button>
				@endif
			</div>
		</div>
		<div class="right-block">
			<div class="profile">
				<div class="information">
					<div class="avatar"><img src="{{ $user_photo }}"></div>
					<div class="name">{{ $user_info->name }}</div>
					<div class="subscribers"><b>{{ $subscribers }}</b> SUBSCRIBERS</div>
					<div class="description"> {{ $user_info->public_info}} </div>
					<div class="social-subscribe">
						<button><img src="/img/profile_website_icon.png"></button>
						<button><img src="/img/profile_fb_icon.png"></button>
						<button><img src="/img/profile_twitter_icon.png"></button>
						<button><img src="/img/profile_google_plus_icon.png"></button>
					</div>
					
					@if($show_btn_subscribe == true)
						@if($isSubscribe == true)
							<button class="subscribes unsubscribe-me" style="display: block;">UNSUBSCRIBE</button>
							<button class="subscribes subscribe-me" style="display: none;">SUBSCRIBE</button>
						@else
							<button class="subscribes subscribe-me">SUBSCRIBE</button>
							<button class="subscribes unsubscribe-me">UNSUBSCRIBE</button>
						@endif
					@endif
				</div>
			</div>
			<div class="filter">
				<div class="title">FILTER</div>
				<div class="text">Choose cards</div>
				<form action="/channel/filter" method="post" id="channel-filter">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="channel_id" value="{{ $user_info->id }}" />
				<input type="hidden" name="multiplier" value="1" />
				<div class="cards-left">
					<div class="item">
						<input type="checkbox" id="test1" value="trivia" name="types[]" checked autocomplete="off" />
    					<label for="test1">Trivia card</label>
					</div>
					<div class="item">
						<input type="checkbox" id="test2" value="flipcards" name="types[]" checked autocomplete="off"/>
    					<label for="test2">Flip Card</label>
					</div>
					<div class="item">
						<input type="checkbox" id="test3" value="gif" name="types[]" checked autocomplete="off"/>
    					<label for="test3">GIF</label>
					</div>
				</div>
				<div class="cards-right">
					<div class="item">
						<input type="checkbox" id="test4" value="story" name="types[]" checked autocomplete="off"/>
    					<label for="test4">Story</label>
					</div>
					<div class="item">
						<input type="checkbox" id="test5" value="rankedlist" name="types[]" checked autocomplete="off"/>
    					<label for="test5">Ranked list</label>
					</div>
					<div class="item">
						<input type="checkbox" id="test6" value="snip" name="types[]" checked autocomplete="off"/>
    					<label for="test6">Snip</label>
					</div>
				</div>
				</form>
				<button class="run-filter">FILTER</button>
			</div>
		</div>
		<div id="modal-alert" class="modal-alert" style="display:none;">
			<div class="popup__body"><div class="js-img"></div></div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script src="/js/bootstrap-confirmation.min.js" type="text/javascript"></script>
<script src="/js/channel.js" type="text/javascript"></script>
@endsection
