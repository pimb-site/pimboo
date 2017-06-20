@extends('page', ['body_class' => $body_class])
@section('title')
Admin
@endsection
@section('content')
	<div class="body">
		<div class="wrap">
			@include('user.admin.header')
			<div class="top_title">Advertising Snip</div>
			<form action="/admin/snip/save" method="post">
				<input type="hidden" id="register_token" name="_token" value="{{ csrf_token() }}">
				<label class="col-xs-3">TAG - <font color="blue">Celebrities</font>. Href image: <input class="form-control" value="{{ $snips['celebrities']['href'] }}" type="text" class="ads" name="tag[celebrities][href]"></label>
				<label class="col-xs-6">Promotional text: <input class="form-control" value="{{ $snips['celebrities']['text'] }}" type="text" class="ads" name="tag[celebrities][text]"></label>
				<label class="col-xs-3">URL site: <input class="form-control" value="{{ $snips['celebrities']['url'] }}" type="text" class="ads" name="tag[celebrities][url]"></label>

				<label class="col-xs-3">TAG - <font color="blue"> TV </font>. Href image: <input class="form-control" value="{{ $snips['tv']['href'] }}" type="text" class="ads" name="tag[tv][href]"></label>
				<label class="col-xs-6">Promotional text: <input class="form-control" value="{{ $snips['tv']['text'] }}" type="text" class="ads" name="tag[tv][text]"></label>
				<label class="col-xs-3">URL site: <input class="form-control" value="{{ $snips['tv']['url'] }}" type="text" class="ads" name="tag[tv][url]"></label>

				<label class="col-xs-3">TAG - <font color="blue">Film</font>. Href image: <input class="form-control" value="{{ $snips['film']['href'] }}" type="text" class="ads" name="tag[film][href]"></label>
				<label class="col-xs-6">Promotional text: <input class="form-control" value="{{ $snips['film']['text'] }}" type="text" class="ads" name="tag[film][text]"></label>
				<label class="col-xs-3">URL site: <input class="form-control" value="{{ $snips['film']['url'] }}" type="text" class="ads" name="tag[film][url]"></label>

				<label class="col-xs-3">TAG - <font color="blue">Music</font>. Href image: <input class="form-control" value="{{ $snips['music']['href'] }}" type="text" class="ads" name="tag[music][href]"></label>
				<label class="col-xs-6">Promotional text: <input class="form-control" value="{{ $snips['music']['text'] }}" type="text" class="ads" name="tag[music][text]"></label>
				<label class="col-xs-3">URL site: <input class="form-control" value="{{ $snips['music']['url'] }}" type="text" class="ads" name="tag[music][url]"></label>

				<label class="col-xs-3">TAG - <font color="blue">Style</font>. Href image: <input class="form-control" value="{{ $snips['style']['href'] }}" type="text" class="ads" name="tag[style][href]"></label>
				<label class="col-xs-6">Promotional text: <input class="form-control" value="{{ $snips['style']['text'] }}" type="text" class="ads" name="tag[style][text]"></label>
				<label class="col-xs-3">URL site: <input class="form-control" value="{{ $snips['style']['url'] }}" type="text" class="ads" name="tag[style][url]"></label>

				<label class="col-xs-3">TAG - <font color="blue">Sexy</font>. Href image: <input class="form-control" value="{{ $snips['sexy']['href'] }}" type="text" class="ads" name="tag[sexy][href]"></label>
				<label class="col-xs-6">Promotional text: <input class="form-control" value="{{ $snips['sexy']['text'] }}" type="text" class="ads" name="tag[sexy][text]"></label>
				<label class="col-xs-3">URL site: <input class="form-control" value="{{ $snips['sexy']['url'] }}" type="text" class="ads" name="tag[sexy][url]"></label>

				<label class="col-xs-3">TAG - <font color="blue">Cute</font>. Href image: <input class="form-control" value="{{ $snips['cute']['href'] }}" type="text" class="ads" name="tag[cute][href]"></label>
				<label class="col-xs-6">Promotional text: <input class="form-control" value="{{ $snips['cute']['text'] }}" type="text" class="ads" name="tag[cute][text]"></label>
				<label class="col-xs-3">URL site: <input class="form-control" value="{{ $snips['cute']['url'] }}" type="text" class="ads" name="tag[cute][url]"></label>

				<label class="col-xs-3">TAG - <font color="blue">Food</font>. Href image: <input class="form-control" value="{{ $snips['food']['href'] }}" type="text" class="ads" name="tag[food][href]"></label>
				<label class="col-xs-6">Promotional text: <input class="form-control" value="{{ $snips['food']['text'] }}" type="text" class="ads" name="tag[food][text]"></label>
				<label class="col-xs-3">URL site: <input class="form-control" value="{{ $snips['food']['url'] }}" type="text" class="ads" name="tag[food][url]"></label>

				<label class="col-xs-3">TAG - <font color="blue">Funny</font>. Href image: <input class="form-control" value="{{ $snips['funny']['href'] }}" type="text" class="ads" name="tag[funny][href]"></label>
				<label class="col-xs-6">Promotional text: <input class="form-control" value="{{ $snips['funny']['text'] }}" type="text" class="ads" name="tag[funny][text]"></label>
				<label class="col-xs-3">URL site: <input class="form-control" value="{{ $snips['funny']['url'] }}" type="text" class="ads" name="tag[funny][url]"></label>

				<label class="col-xs-3">TAG - <font color="blue">Animals</font>. Href image: <input class="form-control" value="{{ $snips['animals']['href'] }}" type="text" class="ads" name="tag[animals][href]"></label>
				<label class="col-xs-6">Promotional text: <input class="form-control" value="{{ $snips['animals']['text'] }}" type="text" class="ads" name="tag[animals][text]"></label>
				<label class="col-xs-3">URL site: <input class="form-control" value="{{ $snips['animals']['url'] }}" type="text" class="ads" name="tag[animals][url]"></label>

				<label class="col-xs-3">TAG - <font color="blue">Games</font>. Href image: <input class="form-control" value="{{ $snips['games']['href'] }}" type="text" class="ads" name="tag[games][href]"></label>
				<label class="col-xs-6">Promotional text: <input class="form-control" value="{{ $snips['games']['text'] }}" type="text" class="ads" name="tag[games][text]"></label>
				<label class="col-xs-3">URL site: <input class="form-control" value="{{ $snips['games']['url'] }}" type="text" class="ads" name="tag[games][url]"></label>

				<label class="col-xs-3">TAG - <font color="blue">Love</font>. Href image: <input class="form-control" value="{{ $snips['love']['href'] }}" type="text" class="ads" name="tag[love][href]"></label>
				<label class="col-xs-6">Promotional text: <input class="form-control" value="{{ $snips['love']['text'] }}" type="text" class="ads" name="tag[love][text]"></label>
				<label class="col-xs-3">URL site: <input class="form-control" value="{{ $snips['love']['url'] }}" type="text" class="ads" name="tag[love][url]"></label>

				<label class="col-xs-3">TAG - <font color="blue">Holidays</font>. Href image: <input class="form-control" value="{{ $snips['holidays']['href'] }}" type="text" class="ads" name="tag[holidays][href]"></label>
				<label class="col-xs-6">Promotional text: <input class="form-control" value="{{ $snips['holidays']['text'] }}" type="text" class="ads" name="tag[holidays][text]"></label>
				<label class="col-xs-3">URL site: <input class="form-control" value="{{ $snips['holidays']['url'] }}" type="text" class="ads" name="tag[holidays][url]"></label>

				<label class="col-xs-3">TAG - <font color="blue">Retro</font>. Href image: <input class="form-control" value="{{ $snips['retro']['href'] }}" type="text" class="ads" name="tag[retro][href]"></label>
				<label class="col-xs-6">Promotional text: <input class="form-control" value="{{ $snips['retro']['text'] }}" type="text" class="ads" name="tag[retro][text]"></label>
				<label class="col-xs-3">URL site: <input class="form-control" value="{{ $snips['retro']['url'] }}" type="text" class="ads" name="tag[retro][url]"></label>

				<label class="col-xs-3">TAG - <font color="blue">Tech</font>. Href image: <input class="form-control" value="{{ $snips['tech']['href'] }}" type="text" class="ads" name="tag[tech][href]"></label>
				<label class="col-xs-6">Promotional text: <input class="form-control" value="{{ $snips['tech']['text'] }}" type="text" class="ads" name="tag[tech][text]"></label>
				<label class="col-xs-3">URL site: <input class="form-control" value="{{ $snips['tech']['url'] }}" type="text" class="ads" name="tag[tech][url]"></label>

				<label class="col-xs-3">TAG - <font color="blue">Politics</font>. Href image: <input class="form-control" value="{{ $snips['politics']['href'] }}" type="text" class="ads" name="tag[politics][href]"></label>
				<label class="col-xs-6">Promotional text: <input class="form-control" value="{{ $snips['politics']['text'] }}" type="text" class="ads" name="tag[politics][text]"></label>
				<label class="col-xs-3">URL site: <input class="form-control" value="{{ $snips['politics']['url'] }}" type="text" class="ads" name="tag[politics][url]"></label>			

				<label class="col-xs-3">TAG - <font color="blue">Internet</font>. Href image: <input class="form-control" value="{{ $snips['internet']['href'] }}" type="text" class="ads" name="tag[internet][href]"></label>
				<label class="col-xs-6">Promotional text: <input class="form-control" value="{{ $snips['internet']['text'] }}" type="text" class="ads" name="tag[internet][text]"></label>
				<label class="col-xs-3">URL site: <input class="form-control" value="{{ $snips['internet']['url'] }}" type="text" class="ads" name="tag[internet][url]"></label>

				<label class="col-xs-3">TAG - <font color="blue">Books</font>. Href image: <input class="form-control" value="{{ $snips['books']['href'] }}" type="text" class="ads" name="tag[books][href]"></label>
				<label class="col-xs-6">Promotional text: <input class="form-control" value="{{ $snips['books']['text'] }}" type="text" class="ads" name="tag[books][text]"></label>
				<label class="col-xs-3">URL site: <input class="form-control" value="{{ $snips['books']['url'] }}" type="text" class="ads" name="tag[books][url]"></label>

				<label class="col-xs-3">TAG - <font color="blue">Sports</font>. Href image: <input class="form-control" value="{{ $snips['sports']['href'] }}" type="text" class="ads" name="tag[sports][href]"></label>
				<label class="col-xs-6">Promotional text: <input class="form-control" value="{{ $snips['sports']['text'] }}" type="text" class="ads" name="tag[sports][text]"></label>
				<label class="col-xs-3">URL site: <input class="form-control" value="{{ $snips['sports']['url'] }}" type="text" class="ads" name="tag[sports][url]"></label>

				<label class="col-xs-3">TAG - <font color="blue">World</font>. Href image: <input class="form-control" value="{{ $snips['world']['href'] }}" type="text" class="ads" name="tag[world][href]"></label>
				<label class="col-xs-6">Promotional text: <input class="form-control" value="{{ $snips['world']['text'] }}" type="text" class="ads" name="tag[world][text]"></label>
				<label class="col-xs-3">URL site: <input class="form-control" value="{{ $snips['world']['url'] }}" type="text" class="ads" name="tag[world][url]"></label>

				<label class="col-xs-3">TAG - <font color="blue">Art</font>. Href image: <input class="form-control" value="{{ $snips['art']['href'] }}" type="text" class="ads" name="tag[art][href]"></label>
				<label class="col-xs-6">Promotional text: <input class="form-control" value="{{ $snips['art']['text'] }}" type="text" class="ads" name="tag[art][text]"></label>
				<label class="col-xs-3">URL site: <input class="form-control" value="{{ $snips['art']['url'] }}" type="text" class="ads" name="tag[art][url]"></label>	

				<label class="col-xs-3">TAG - <font color="blue">News</font>. Href image: <input class="form-control" value="{{ $snips['news']['href'] }}" type="text" class="ads" name="tag[news][href]"></label>
				<label class="col-xs-6">Promotional text: <input class="form-control" value="{{ $snips['news']['text'] }}" type="text" class="ads" name="tag[news][text]"></label>
				<label class="col-xs-3">URL site: <input class="form-control" value="{{ $snips['news']['url'] }}" type="text" class="ads" name="tag[news][url]"></label>

				<label class="col-xs-3">TAG - <font color="blue">NO TAG</font>. Href image: <input class="form-control" value="{{ $snips['notag']['href'] }}" type="text" class="ads" name="tag[notag][href]"></label>
				<label class="col-xs-6">Promotional text: <input class="form-control" value="{{ $snips['notag']['text'] }}" type="text" class="ads" name="tag[notag][text]"></label>
				<label class="col-xs-3">URL site: <input class="form-control" value="{{ $snips['notag']['url'] }}" type="text" class="ads" name="tag[notag][url]"></label>
				<center><button class="btn btn-default" type="submit">Save</button></center>
			</form>
		</div>
	</div>
@endsection