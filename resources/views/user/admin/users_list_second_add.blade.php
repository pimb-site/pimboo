@foreach($users as $user)
	<?php
	$photo = (strlen($user->photo) > 0) ? '/uploads/'.$user->photo : '/img/header_default_photo.png';
	?>
	<div class="table_row" data-id="{{ $user->id }}">
		<div class="table_row" data-id="{{ $user->id }}">
			<div class="row_cell cell_user_us"><?php if (empty($user->first_name)) { echo $user->name; } else { echo $user->first_name; } ?></a></div>
			<div class="row_cell cell_user_us">{{ $user->last_name }}</a></div>
			<div class="row_cell cell_email_us" ><?php if (empty($user->social_type)) { echo $user->email; } else { echo $user->email_for_news; } ?></div>
			<div class="row_cell cell_new">{{ $user->last_ip }}</div>
		</div>
	</div>
@endforeach
