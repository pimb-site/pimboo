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
				<input type="hidden" id="register_token" name="_token" value="{{ csrf_token() }}">
				<label class="col-xs-12">1st href <input class="form-control" value="{{ $links['1']['href'] }}" type="text" class="ads" name="links[1][href]"></label>
				<label class="col-xs-12">1st name <input class="form-control" value="{{ $links['1']['name'] }}" type="text" class="ads" name="links[1][name]"></label>
				<label class="col-xs-12">2nd href <input class="form-control" value="{{ $links['2']['href'] }}" type="text" class="ads" name="links[2][href]"></label>
				<label class="col-xs-12">2nd name <input class="form-control" value="{{ $links['2']['name'] }}" type="text" class="ads" name="links[2][name]"></label>
				<label class="col-xs-12">3rd href <input class="form-control" value="{{ $links['3']['href'] }}" type="text" class="ads" name="links[3][href]"></label>
				<label class="col-xs-12">3rd name <input class="form-control" value="{{ $links['3']['name'] }}" type="text" class="ads" name="links[3][name]"></label>
				<label class="col-xs-12">4th href <input class="form-control" value="{{ $links['4']['href'] }}" type="text" class="ads" name="links[4][href]"></label>
				<label class="col-xs-12">4th name <input class="form-control" value="{{ $links['4']['name'] }}" type="text" class="ads" name="links[4][name]"></label>
				<label class="col-xs-12">5th href <input class="form-control" value="{{ $links['5']['href'] }}" type="text" class="ads" name="links[5][href]"></label>
				<label class="col-xs-12">5th name <input class="form-control" value="{{ $links['5']['name'] }}" type="text" class="ads" name="links[5][name]"></label>
				<label class="col-xs-12">6th href <input class="form-control" value="{{ $links['6']['href'] }}" type="text" class="ads" name="links[6][href]"></label>
				<label class="col-xs-12">6th name <input class="form-control" value="{{ $links['6']['name'] }}" type="text" class="ads" name="links[6][name]"></label>
				<label class="col-xs-12">7th href <input class="form-control" value="{{ $links['7']['href'] }}" type="text" class="ads" name="links[7][href]"></label>
				<label class="col-xs-12">7th name <input class="form-control" value="{{ $links['7']['name'] }}" type="text" class="ads" name="links[7][name]"></label>
				<label class="col-xs-12">8th href <input class="form-control" value="{{ $links['8']['href'] }}" type="text" class="ads" name="links[8][href]"></label>
				<label class="col-xs-12">8th name <input class="form-control" value="{{ $links['8']['name'] }}" type="text" class="ads" name="links[8][name]"></label>
				<button class="btn btn-default" type="submit">Save</button>
			</form>
		</div>
	</div>
@endsection