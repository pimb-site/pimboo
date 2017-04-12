@extends('tools.view')

@section('tool_content')
<div class="content-story">
	<div class="description">{{ $content->description_text }}</div>
	{!! $content->content !!}
	<div class="footer">{{ $content->description_footer }}</div>
{{ $content->description_footer }}
@endsection

@section('script')
@endsection