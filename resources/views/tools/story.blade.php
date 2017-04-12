@extends('tools.view')

@section('tool_content')
<div class="content-story">
	<div class="description">{{ $content->description_text }}</div>
	<div class="main-content-story"> {!! $content->content !!} </div>
	<div class="footer">{{ $content->description_footer }}</div>
</div>
@endsection

@section('script')
@endsection