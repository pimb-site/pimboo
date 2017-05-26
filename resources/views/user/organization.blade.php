@extends('page')

@section('content')
		<div class="body">
			<div class="wrap">
				@include('user.header')
				<div class="top_title">EARNING STATUS</div>
				<div class="ref-link">
					<span>Your Referral Link is:</span><input value="{!! url('/ref/') !!}/{{ $user->id }}" readonly />
				</div>
				<div id="ref-tree">
					<div id="ref-tree-me" style="height:{{ $i*100 }}px">
						<table cellpadding="0" cellspacing="0" border="0" style="height: {{ $i*100 }}px">
							<tr>
								<td style="width: 141px;">
								</td>
								<td height="100" valign="middle">
									<div class="user">
										@if (empty($user->photo))
											<img width="84px" height="84px" src="/img/header_default_photo.png" />
										@else
											<img width="84px" height="84px" src="/uploads/{{ $user->photo }}" />
										@endif
										<div class="hide">
											<a>{{ $user->id }}</a>
										</div>
									</div>
								</td>
								<td style="width: 141px;">
									<div class="line" style="border-top: 1px solid black; width: 100%;"></div>
								</td>
							</tr>
						</table> 
						
					</div>
					<div class="vertical-ref-line"
						style="
						<?php
						
						$users_tmp = $my_org_users_second_level;
						
						$f = count(current($users_tmp));
						if ($f == 0) {
							$f = 1;
						}
						$l = count(array_pop($users_tmp));
						if ($l == 0) {
							$l = 1;
						}
						$i = $i*100-50*($f+$l);
						if ($i == 0) {
							$i = 1;
						}
						?>
						height: <?=$i;?>px;
						margin-bottom: <?=50*$l?>px;
						margin-top: <?=50*$f?>px;
						"
					"></div>
					<div id="ref-tree-first">
						<?php foreach($my_org_users_first_level as $user_f_l) : ?>
						<?php $content = '<div class="user-pop"><div class="user-info"><div class="full-name">'.$user_f_l->name.'</div><div class="line"></div><div class="birthday">'.$user_f_l->created_at.'</div><div class="line"></div></div></div>'; ?>
							<table cellpadding="0" cellspacing="0" border="0" style="height: <?php  if(count($my_org_users_second_level[$user_f_l->id]) != 0) { echo count($my_org_users_second_level[$user_f_l->id])*100; } else { echo 100; } ?>px">
								<tr>
									<td style="width: 32px;">
										<div class="line" style="border-top: 1px solid black; width: 100%;"></div>
									</td>
									<td height="100" valign="middle">
										<div class="user" data-trigger="hover" data-content='<?=$content?>' data-html="true" data-placement="right" id="user-<?=$user_f_l->id?>" style='z-index: 1000;'>
											@if (empty($user_f_l->photo))
											<img width="84px" height="84px" src="/img/header_default_photo.png" />
										@else
											<img width="84px" height="84px" src="/uploads/{{ $user_f_l->photo }}" />
										@endif
											<div class="hide">
												<a ">{{ $user_f_l->user_nicename }}</a>
											</div>
										</div>
									</td>
									<td style="width: 250px;">
										@if (count($my_org_users_second_level[$user_f_l->id]))
											<div class="line" style="border-top: 1px solid black; width: 100%;"></div>
										@endif
									</td>
								</tr>
							</table> 
						<? endforeach; ?>
					</div>
					<div id="ref-tree-second">
						
						<?php foreach($my_org_users_first_level as $user_f_l) : ?>
							<div class="user-group">
								<div class="vertical-ref-line"
									style="
									<? $c = count($my_org_users_second_level[$user_f_l->id]); 
									if ($c*100-100 <= 0) {
										$c = 1;
									} else {
										$c = $c*100-100;
									}
									?>
									
									height: <?=$c;?>px;
									margin-bottom: <?=50;?>px;
									margin-top: <?=50;?>px;
									" ></div>
								<table cellpadding="0" cellspacing="0" border="0" style="height: <?php  if(count($my_org_users_second_level[$user_f_l->id]) != 0) { echo count($my_org_users_second_level[$user_f_l->id])*100; } else { echo 100; } ?>px">
									<?php foreach($my_org_users_second_level[$user_f_l->id] as $user_s_l) : ?>
									<?php $content = '<div class="user-pop"><div class="user-info"><div class="full-name">'.$user_s_l->name.'</div><div class="line"></div><div class="birthday">'.$user_s_l->created_at.'</div><div class="line"></div></div></div>'; ?>
									<tr>
										<td style="width: 32px;">
											<div class="line" style="border-top: 1px solid black; width: 100%;"></div>
										</td>
										<td height="100" valign="middle">
											<div class="user" data-trigger="hover" data-content='<?=$content?>' data-html="true" data-placement="right" id="user-<?=$user_s_l->id?>" style='z-index: 1000;'>
												@if (empty($user_s_l->photo))
													<img width="84px" height="84px" src="/img/header_default_photo.png" />
												@else
													<img width="84px" height="84px" src="/uploads/{{ $user_f_l->photo }}" />
												@endif
												<div class="hide">
													<a ">{{ $user_s_l->user_nicename }}</a>
												</div>
											</div>
										</td>
									</tr>
									<? endforeach; ?>
								</table> 
							</div>
						<? endforeach; ?>
					</div>
				</div>
			</div>
		</div>
@endsection
