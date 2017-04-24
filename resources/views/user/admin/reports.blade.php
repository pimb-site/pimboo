@extends('page', ['body_class' => $body_class])
@section('title')
Admin
@endsection
@section('content')
	<div class="body">
		<div class="wrap">
			@include('user.admin.header')
			<div class="top_title">Reports</div>
			<div class="all_reports">
				<table style="width: 100%;">
					<thead>
						<tr>
							<td>Number</td>
							<td>Post</td>
							<td>User</td>
							<td>Type</td>
							<td>Status</td>
							<td>Action</td>
						</tr>
					</thead>
					<tbody>
						@foreach($reports as $report)
						<tr class="post">
							
							<td>#{{ $report->id }}</td>
							<td><a class="title" href="/viewID/{{ $report->post->id }}">{{ $report->post->description_title }}</a></td>
							<td><a class="title" href="/channel/{{ $report->post->user->id }}">{{ $report->post->user->name }}</a></td>
							<td>{{ $report->type }}</td>
							<td>{{ $report->status }}</td>
							<td>
								<div class="buttons">
									<button data-toggle="modal" data-target="#AdminModalReports" onclick="modal_on('/admin/reports/delete_user/?post_id={{ $report->post_id }}&user_id={{ $report->post->user->id }}','Delete user and all posts pass to admin?');" title="Delete user, all posts passed to admin"><span class="glyphicon glyphicon-remove-circle"></span></button>
									<button data-toggle="modal" data-target="#AdminModalReports" onclick="modal_on('/admin/reports/delete_posts_and_user/?user_id={{ $report->post->user->id }}','Delete user and all his posts?');" title="Delete user and all his posts"><span class="glyphicon glyphicon-ban-circle"></span></button>
									<button data-toggle="modal" data-target="#AdminModalReports" onclick="modal_on('/admin/reports/delete_post/?post_id={{ $report->post_id }}','Delete post?');" title="Delete post"><span class="glyphicon glyphicon-remove"></span></button>
									<button data-toggle="modal" data-target="#AdminModalReports" onclick="modal_on('/admin/reports/reject/?post_id={{ $report->post_id }}','Reject report?');" title="Reject report" class=""><span class="glyphicon glyphicon-ok-circle"></span></button>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="modal fade reports" id="AdminModalReports" tabindex="-1" role="dialog" aria-labelledby="AdminModalReportsLabel" aria-hidden="true">
			  <div class="modal-dialog">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="AdminModalReportsLabel">Confirmation</h4>
				  </div>
				  <div class="modal-body">
					
				  </div>
				  <div class="modal-footer">
					<a href="" id="report-submit-btn" class="btn btn-primary">Yes</a>
					<a type="button" class="btn btn-default" data-dismiss="modal">No</a>
				  </div>
				</div>
			  </div>
			</div>
		</div>
	</div>
@endsection