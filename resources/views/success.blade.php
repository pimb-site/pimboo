@extends('page', ['body_class' => 'succ'])
@section('title')
Success
@endsection
@section('content')
		<div class="body">
			<div class="wrap">
				<div class="succ">
					<img src="/img/referral_succ.png">
					<div class="row">Well done! You've successfully posted to Pimboo!</div>
					<div class="row2">Now <span>Share</span> It With The World & <span>Profit</span>!</div>
					<div class="group">
						<div class="item butt-for-sharing item-share" data-title="asd12" data-url="{!! url('/viewID/') !!}/{{ $id }}" data-type="fb"></div>
						<div class="item butt-for-sharing item-tweet" data-type="tw"></div>
						<div class="item item-embed"></div>
						<div class="item item-more"></div>
					</div>
					<input type="text" value="{!! url('/viewID/') !!}/{{ $id }}" />
					<a class="view-item" href="{!! url('/viewID/') !!}/{{ $id }}">VIEW ITEM</a>
				</div>
			</div>
		</div>
@endsection
