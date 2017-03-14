@extends('tools.view')

@section('content')
	<div class="wrap">
		<div class="post">
			<div class="title">{{ $content->description_title }}</div>
			<div class="content">{!! $content->content !!}</div>
			<div class="footer">{{ $content->description_footer }}</div>
		</div>
	</div>
@endsection

@section('script')
	
@endsection