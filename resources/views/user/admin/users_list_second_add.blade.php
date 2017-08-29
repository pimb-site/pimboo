@foreach($users as $user)
	<?php
	$photo = (strlen($user->photo) > 0) ? '/uploads/'.$user->photo : '/img/header_default_photo.png';
	?>
	<div class="table_row" data-id="{{ $user->id }}">
		<div class="table_row" data-id="{{ $user->id }}">
			<div class="row_cell cell_image_us"><a href="#" class="img"><img width="75px" src="{{ $photo }}" /></a></div>
			<div class="row_cell cell_user_us"><? if (empty($user->first_name)) { echo $user->name; } else { echo $user->first_name; } ?></a></div>
			<div class="row_cell cell_user_us">{{ $user->last_name }}</a></div>
			<div class="row_cell cell_email_us" >{{ $user->email }}</div>
			<div class="row_cell cell_views_us"> <a href="#"> {{ $count_posts[$user->id] }}</a></div>
			<div class="row_cell cell_channelID_us">{{ $user->id }}</div>
			<div class="row_cell cell_new">{{ $user->last_ip }}</div>
		</div>
	</div>
@endforeach
