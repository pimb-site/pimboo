@extends('page', ['body_class' => $body_class])
@section('title')
Admin
@endsection
@section('content')
	<div class="body">
		<div class="wrap">
			@include('user.admin.header')
			<div class="top_title">Home Main Post</div>
			<div class="main_post">
				<div class="scrollbar-inner">
					@foreach($posts as $post)
						<div class="post <? if (strpos($post->status, 'home_') === false) {} else { echo 'active'; } ?>" data-position="{{ $post->status }}" data-postid="{{ $post->id }}">
							<img src="/img/home_headline_1.jpg" />
							<div class="text">
								<div class="title">
									{{ $post->description_title }}
								</div>
								<div class="description">
									{{ $post->description_text }}
								</div>
							</div>
							<div class="positions">
								<div class="position <? if ($post->status == "home_main") { echo "active"; } ?>" data-postid="{{ $post->id }}" data-position="home_main">M</div>
								<div class="position <? if ($post->status == "home_post1") { echo "active"; } ?>" data-postid="{{ $post->id }}" data-position="home_post1">1</div>
								<div class="position <? if ($post->status == "home_post2") { echo "active"; } ?>" data-postid="{{ $post->id }}" data-position="home_post2">2</div>
								<div class="position <? if ($post->status == "home_post3") { echo "active"; } ?>" data-postid="{{ $post->id }}" data-position="home_post3">3</div>
								<div class="position <? if ($post->status == "home_post4") { echo "active"; } ?>" data-postid="{{ $post->id }}" data-position="home_post4">4</div>
								<div class="position <? if ($post->status == "home_post5") { echo "active"; } ?>" data-postid="{{ $post->id }}" data-position="home_post5">5</div>
								<div class="position <? if ($post->status == "home_post6") { echo "active"; } ?>" data-postid="{{ $post->id }}" data-position="home_post6">6</div>
								<div class="position <? if ($post->status == "home_post7") { echo "active"; } ?>" data-postid="{{ $post->id }}" data-position="home_post7">7</div>
								<div class="position <? if ($post->status == "home_post8") { echo "active"; } ?>" data-postid="{{ $post->id }}" data-position="home_post8">8</div>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
@endsection