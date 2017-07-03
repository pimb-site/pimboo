@extends('page', ['body_class' => $body_class])
@section('title')
@endsection
@section('css')
@endsection
@section('content')
	<div class="body">
		<div class="wrap">
			@include('user.admin.header')
			<div class="top_title">Posts</div>
			<div class="all_user_table">
				<div class="table_title" id="aside1">
					<div class="title_cell cell_image_us">Image</div>
					<div class="title_cell cell_user_us">User</div>
					<div class="title_cell cell_email_us">E-mail</div>
					<div class="title_cell cell_views_us">Views</div>
					<div class="title_cell cell_channelID_us">ChannelID</div>
  					<div class="title_cell cell_edit_us">Edit</div>
  					<div class="title_cell cell_del_us">Delete</div>
				</div>
					<div class="user_table">
					@foreach($users as $user)
						<div class="table_row" data-id="{{ $user->id }}">
							<div class="row_cell cell_image_us"><a href="/{{ $user->name }}" class="img"><img width="75px" src="/uploads/{{ $user->photo }}" /></a></div>
							<div class="row_cell cell_user_us"><a class="title" title="{{ $user->name }}" href="/{{ $user->name }}">{{ $user->name }}</a></div>
							<div class="row_cell cell_email_us" >{{ $user->email }}</div>
							<div class="row_cell cell_views_us"></a></div>
							<div class="row_cell cell_channelID_us"></div>
							<div class="row_cell cell_edit_us">
								<div class="buttons editPost" >
									<button ><span class="glyphicon glyphicon-pencil"></span></button>
								</div>
							</div>
							<div class="row_cell cell_del_us">
								<div class="buttons deletePost">
									<button ><span class="glyphicon glyphicon-remove"></span></button>
								</div>
							</div>
						</div>
					@endforeach
					</div>
			</div>
			<button class='show_more' type="button">SHOW MORE</button>
			</div>
		</div>
	</div>
@endsection
