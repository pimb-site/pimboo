@extends('page', ['body_class' => $body_class])
@section('title')
Admin
@endsection
@section('content')
	<div class="body">
		<div class="wrap">
			@include('user.admin.header')
			<div class="top_title">Posts</div>

			<div class="all_table">
				<div class="table_title" id="aside1">
					<div class="title_cell cell_image">Image</div>
					<div class="title_cell cell_type">Type</div>
					<div class="title_cell cell_user">User</div>
					<div class="title_cell cell_title">Title</div>
					<div class="title_cell cell_created">Created</div>
  					<div class="title_cell cell_checkbox">Checkbox1</div>
  					<div class="title_cell cell_checkbox">Checkbox2</div>
  					<div class="title_cell cell_checkbox">Checkbox3</div>
  					<div class="title_cell cell_edit">Edit</div>
  					<div class="title_cell cell_del">Delete</div>
				</div>
					<div class="admin_table">
					@foreach($posts as $post)
						<div class="table_row">
							<div class="row_cell cell_image"><a href="/viewID/{{ $post->id }}" class="img"><img width="75px" src="uploads/{{ $post->description_image }}" /></a></div>
							<div class="row_cell cell_type" >{{ $post->type }}</div>
							<div class="row_cell cell_user"><a class="title" href="/channel/1">{{ $post->user_name }}</a></div>
							<div class="row_cell cell_title"><a href="/viewID/{{ $post->id }}" class="text">{{ $post->description_title }}</a></div>
							<div class="row_cell cell_created">{{ $post->created_at }}</div>
							<div class="row_cell cell_checkbox">					
								<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value=""><span class="checkbox-custom"></span></label></div>
							</div>
							<div class="row_cell cell_checkbox">
								<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value=""><span class="checkbox-custom"></span></label></div>
							</div>
							<div class="row_cell cell_checkbox">
								<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value=""><span class="checkbox-custom"></span></label></div>
							</div>
							<div class="row_cell cell_edit">
								<div class="buttons">
									<button ><span class="glyphicon glyphicon-pencil"></span></button>
								</div>
							</div>
							<div class="row_cell cell_del">
								<div class="buttons">
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