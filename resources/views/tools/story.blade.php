@extends('tools.view')

@section('content')
	<div class="panel-heading">View flip cards</div>
	<?php $data_id = 1 ?>
	<?php $uncontent = unserialize($content->content) ?>
	<div class="post">
	<div class="title">{!! $content->description_title !!}</div>
	<div class="content">{{!! $uncontent }}</div>
	<div class="footer">{!! $content->description_footer !!}</div>
	</div>
@endsection

@section('script')
	
@endsection