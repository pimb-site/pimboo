@extends('page')

@section('content')
<div class="body">
	<div class="wrap">
		<div class="title">Select format and share with the world</div>
		<div class="table">
			<div class="creations">
				<div class="creation story">
					<div class="left">
						<div class="name">Pimboo Story</div>
						<div class="text">Create Stories That Everyone Loves to Read & Share!</div>
					</div>
					<div class="right">
						<a class="butt" href="/add_story">CREATE</a>
						<a class="butt more_info">MORE INFO</a>
					</div>
				</div>
				<div class="creation gifmaker">
					<div class="left">
						<div class="name">Pimboo GIF Maker</div>
						<div class="text">Create Your Own Fun GIF's & Share!</div>
					</div>
					<div class="right">
						<a class="butt" href="/video_to_gif">CREATE</a>
						<a class="butt more_info">MORE INFO</a>
					</div>
				</div>
				<div class="creation trivia">
					<div class="left">
						<div class="name">Pimboo Snip</div>
						<div class="text">Overlay ads on your social shares and profit!</div>
					</div>
					<div class="right">
						<a class="butt" href="/create-snip">CREATE</a>
						<a class="butt more_info">MORE INFO</a>
					</div>
				</div>
				<div class="creation rankedlist">
					<div class="left">
						<div class="name">Pimboo Ranked List</div>
						<div class="text">Create Fun "Top Ten" Lists That Everyone Loves to Read & Share!</div>
					</div>
					<div class="right">
						<a class="butt" href="/add_ranked_list">CREATE</a>
						<a class="butt more_info">MORE INFO</a>
					</div>
				</div>
				<div class="creation flip_cards">
					<div class="left">
						<div class="name">Pimboo Flip Cards</div>
						<div class="text">What is hiding on the other side? Click to reveal.</div>
					</div>
					<div class="right">
						<a class="butt" href="/add_flip_cards">CREATE</a>
						<a class="butt more_info">MORE INFO</a>
					</div>
				</div>
				
			</div>
			<div class="side">
				<img src="/img/create_step_1.png" />
				<div class="text">SELECT A FORMAT</div>
				<div class="vline"></div>
				<img src="/img/create_step_2.png" />
				<div class="text">CREATE CARD</div>
				<div class="vline"></div>
				<img src="/img/create_step_3.png" />
				<div class="text">PUBLISH & SHARE</div>
			</div>
		</div>
	</div>
</div>
@endsection
