@extends('page')

@section('content')
<div class="body">
	<div class="wrap">
		<div class="title">Select format and share with the world</div>
		<div class="table">
			<div class="creations">
				<div class="creation story">
					<div class="left">
						<div class="name">RANKED LIST</div>
						<div class="text">Create Fun "Top Ten" Lists That Everyone Loves to Read & Share!</div>
					</div>
					<div class="right">
						<a class="butt" href="/add_ranked_list">CREATE</a>
						<a class="butt more_info">MORE INFO</a>
					</div>
				</div>
				<div class="creation flip_cards">
					<div class="left">
						<div class="name">FLIP CARDS</div>
						<div class="text">What is hiding on the other side? Click to reveal.</div>
					</div>
					<div class="right">
						<a class="butt" href="/add_flip_cards">CREATE</a>
						<a class="butt more_info">MORE INFO</a>
					</div>
				</div>
				<div class="creation trivia">
					<div class="left">
						<div class="name">TRIVIA CARDS</div>
						<div class="text">What is hiding on the other side? Click to reveal.</div>
					</div>
					<div class="right">
						<a class="butt" href="/add_trivia_quiz">CREATE</a>
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
