@extends('page', ['body_class' => $body_class])
@section('title')
Admin
@endsection
@section('content')
	<div class="body">
		<div class="wrap">
			@include('user.admin.header')
			<div class="top_title">Ads</div>
			<form action="/admin/ads/save" method="post">
				<label class="col-xs-12">1st <input class="form-control" type="text" class="ads" name="links[1]"></label>
				<label class="col-xs-12">2nd <input class="form-control" type="text" class="ads" name="links[2]"></label>
				<label class="col-xs-12">3rd <input class="form-control" type="text" class="ads" name="links[3]"></label>
				<label class="col-xs-12">4th <input class="form-control" type="text" class="ads" name="links[4]"></label>
				<label class="col-xs-12">5th <input class="form-control" type="text" class="ads" name="links[5]"></label>
				<label class="col-xs-12">6th <input class="form-control" type="text" class="ads" name="links[6]"></label>
				<button class="btn btn-default" type="submit">Save</button>
			</form>
		</div>
	</div>
@endsection