@extends('page', ['body_class' => $body_class])
@section('title')
@endsection
@section('css')
@endsection
@section('content')
	<div class="body">
		<div class="wrap">
			@include('user.admin.header')
			<div class="top_title">Users</div>
			<div class="all_user_table">
				<div class="table_title" id="aside1">
					<div class="title_cell cell_image_us">Photo</div>
					<div class="title_cell cell_user_us">Name</div>
					<div class="title_cell cell_email_us">E-mail</div>
					<div class="title_cell cell_views_us">Num of posts</div>
					<div class="title_cell cell_channelID_us">Channel ID</div>
  					<div class="title_cell cell_edit_us">Edit account</div>
  					<div class="title_cell cell_del_us">Delete</div>
				</div>
					<div class="user_table">
					@foreach($users as $user)
						<?php
						$photo = (strlen($user->photo) > 0) ? '/uploads/'.$user->photo : '/img/header_default_photo.png';
						?>
						<div class="table_row" data-id="{{ $user->id }}">
							<div class="row_cell cell_image_us"><a href="/{{ $user->name }}" class="img"><img width="75px" src="{{ $photo }}" /></a></div>
							<div class="row_cell cell_user_us"><a class="title" title="{{ $user->name }}" href="/{{ $user->name }}">{{ $user->name }}</a></div>
							<div class="row_cell cell_email_us" >{{ $user->email }}</div>
							<div class="row_cell cell_views_us"> <a href="#"> {{ $count_posts[$user->id] }}</a></div>
							<div class="row_cell cell_channelID_us">{{ $user->id }}</div>
							<div class="row_cell cell_edit_us">
								<div class="buttons editUser" data-id="{{ $user->id }}" >
									<button ><span class="glyphicon glyphicon-pencil"></span></button>
								</div>
							</div>
							<div class="row_cell cell_del_us">
								<div class="buttons deleteUser" data-id="{{ $user->id }}">
									<button ><span class="glyphicon glyphicon-remove"></span></button>
								</div>
							</div>
						</div>
					@endforeach
					</div>
			</div>
			</div>
		</div>
	</div>
@endsection
@section('script')
<script>
	$(document).ready(function() {

		$('.editUser').click(function() {
			var user_id = $(this).data('id');
			window.location.href= '/admin/editing/user/' + user_id;	
		});

		$('.deleteUser').click(function() {
			var user_id = $(this).data('id');
			var token   = "{{ csrf_token() }}";
			$.ajax({
			    url: '/admin/action/deleteuser',
			    data: {'user_id' : user_id, '_token': token},
			    dataType : "json",
			    type: 'POST',
			    success: function (data, textStatus) {
			    	if(data.success == true) {
			    		$('.table_row[data-id="'+user_id+'"]').remove();
			    		alert('User has been deleted');
			    	}
			    } 
			});
		});
	});
</script>
@endsection
