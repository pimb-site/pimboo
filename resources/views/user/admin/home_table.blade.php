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
  					<div class="title_cell cell_checkbox">Main(left)</div>
  					<div class="title_cell cell_checkbox">Main(right)</div>
  					<div class="title_cell cell_checkbox">LATEST</div>
  					<div class="title_cell cell_edit">Edit</div>
  					<div class="title_cell cell_del">Delete</div>
				</div>
					<div class="admin_table">
					@foreach($posts as $post)
						<div class="table_row" data-id="{{ $post->id }}">
							<div class="row_cell cell_image"><a href="/{{ $post->author_name.'/'.$post->url }}" class="img"><img width="75px" src="/uploads/{{ $post->description_image }}" /></a></div>
							<div class="row_cell cell_type" >{{ $post->type }}</div>
							<div class="row_cell cell_user"><a class="title" title="{{ $post->author_name }}" href="/{{ $post->author_name }}">{{ $post->author_name }}</a></div>
							<div class="row_cell cell_title"><a href="/{{ $post->author_name.'/'.$post->url }}" title="{{ $post->description_title }}" class="text">{{ $post->description_title }}</a></div>
							<div class="row_cell cell_created">{{ $post->created_at }}</div>
							<div class="row_cell cell_checkbox">					
								<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="" data-id="{{ $post->id }}" data-action="set_left" <?php if($post->home_left) print 'checked'; ?>><span class="checkbox-custom"></span></label></div>
							</div>
							<div class="row_cell cell_checkbox">
								<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="" data-id="{{ $post->id }}" data-action="set_right" <?php if($post->home_right) print 'checked'; ?>><span class="checkbox-custom"></span></label></div>
							</div>
							<div class="row_cell cell_checkbox">
								<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="" data-id="{{ $post->id }}" data-action="set_latest" <?php if($post->home_latest) print 'checked'; ?>><span class="checkbox-custom"></span></label></div>
							</div>
							<div class="row_cell cell_edit">
								<div class="buttons editPost">
									<button ><span class="glyphicon glyphicon-pencil"></span></button>
								</div>
							</div>
							<div class="row_cell cell_del">
								<div class="buttons deletePost" data-id="{{ $post->id }}">
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

	$('input[type="checkbox"]').on('change', function() {
		var action = $(this).data('action');
		var post_id = $(this).data('id');
		var checked = ($(this).is(':checked')) ? 1 : 0;
		var token  = "{{ csrf_token() }}";

		$.ajax({
		    url: '/admin/action/postposition',
		    data: {'post_id' : post_id, '_token': token, 'checked': checked, 'action': action},
		    dataType : "json",
		    type: 'POST',
		    success: function (data, textStatus) {
		    	// code...
		    } 
		});
	});

	$('.editPost').on('click', function() {
		alert('function not available');
	});

	$('.deletePost').on('click', function() {
		var post_id = $(this).data('id');
		var token  = "{{ csrf_token() }}";
		$.ajax({
		    url: '/admin/action/deletepost',
		    dataType : "json",
		    data: {'post_id' : post_id, '_token': token},
		    type: 'POST',
		    success: function (data, textStatus) {
		    	if(data.success == true) {
		    		$('.table_row[data-id="'+post_id+'"]').remove();
		    		alert('The post has been deleted');
		    	} else {
		    		alert('Error in request');
		    	}
		    } 
		});
	});


</script>
@endsection