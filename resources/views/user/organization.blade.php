@extends('page')

@section('content')
		<div class="body">
			<div class="wrap">
				@include('user.header')
				<div class="top_title">EARNING STATUS</div>
				<div class="ref-link">
					<span>Your Referral Link is:</span><input value="{!! url('/ref/') !!}/{{ $user->name }}" readonly />
				</div>
				<div class="scrollbar-inner">
					<div id="ref-tree">
						<div id="ref-tree-me" style="width:{{ $i*100 }}px">
							<table cellpadding="0" cellspacing="0" border="0" style="width: {{ $i*100 }}px">
								<tr>

									<td height="84" align="middle">
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

								</tr>
								<tr style="width: 100%;height: 32px;" align="middle">
									<td style="width: 32px;height: 32px;" align="middle">
										<div class="line" style="border-left: 1px solid black; height: 100%; width: 0px;"></div>
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
							width: <?php echo $i; ?>px;
							margin-right: <?php echo 50*$l; ?>px;
							margin-left: <?php echo 50*$f; ?>px;
							border-top: 1px solid black;
							"
						"></div>
						<div id="ref-tree-first" style="width: 100%;">
							<?php foreach($my_org_users_first_level as $user_f_l) : ?>
							<?php $content = '<div class="user-pop"><div class="user-info"><div class="full-name">'.$user_f_l->name.'</div><div class="line"></div><div class="birthday">'.$user_f_l->created_at.'</div><div class="line"></div></div></div>'; ?>
								<table cellpadding="0" cellspacing="0" border="0" style="width: <?php  if(count($my_org_users_second_level[$user_f_l->id]) != 0) { echo count($my_org_users_second_level[$user_f_l->id])*100; } else { echo 100; } ?>px; float: left;">
									<tr >
										<td style="width: 32px;height: 32px;" align="middle">
											<div class="line" style="border-left: 1px solid black; height: 100%; width: 0px;"></div>
										</td>
									</tr>
									<tr>
										<td height="84" align="middle">
											<div class="user" data-trigger="hover" data-content='<?php echo $content; ?>' data-html="true" data-placement="right" id="user-<?php echo $user_f_l->id; ?>" style='z-index: 1000; width: 100px'>
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
									</tr>
									<tr>
										<td style="width: 250px;height: 100px;" align="middle">
											@if (count($my_org_users_second_level[$user_f_l->id]))
												<div class="line" style="border-left: 1px solid black; height: 100%; width: 0px;"></div>
											@endif
										</td>
									</tr>
								</table> 
							<?php endforeach; ?>
						</div>
						<div id="ref-tree-second" style="width: 100%">
							
							<?php foreach($my_org_users_first_level as $user_f_l) : ?>
								<div class="user-group" style="width: <?php  if(count($my_org_users_second_level[$user_f_l->id]) != 0) { echo count($my_org_users_second_level[$user_f_l->id])*100; } else { echo 100; } ?>px; float: left;">
									<div class="vertical-ref-line"
										style="
										<?php $c = count($my_org_users_second_level[$user_f_l->id]); 
										if ($c*100-100 <= 0) {
											$c = 1;
										} else {
											$c = $c*100-100;
										}
										?>
										
										width: <?php echo $c; ?>px;
										margin-left: <?php echo 50;?>px;
										margin-right: <?php echo 50; ?>px;
										border-top: 1px solid black;
										" ></div>

									<table cellpadding="0" cellspacing="0" border="0" style="width: <?php  if(count($my_org_users_second_level[$user_f_l->id]) != 0) { echo count($my_org_users_second_level[$user_f_l->id])*100; } else { echo 100; } ?>px">
										<?php foreach($my_org_users_second_level[$user_f_l->id] as $user_s_l) : ?>
										<?php $content = '<div class="user-pop"><div class="user-info"><div class="full-name">'.$user_s_l->name.'</div><div class="line"></div><div class="birthday">'.$user_s_l->created_at.'</div><div class="line"></div></div></div>'; ?>
										<table cellpadding="0" cellspacing="0" border="0" style="width: 100px;float: left;">
										<tr>
											<td style="height:  32px; width: 100px" align="middle">
												<div class="line" style="border-left: 1px solid black; height: 100%; width: 0px;"></div>
											</td>
										</tr>
										<tr>
											<td height="84" align="middle">
												<div class="user" data-trigger="hover" data-content='<?php echo $content; ?>' data-html="true" data-placement="right" id="user-<?php echo $user_s_l->id; ?>" style='z-index: 1000;'>
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
										</table> 
										<?php endforeach; ?>
									</table> 
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>

		</div>
@endsection
