@extends('page')

@section('content')
		<div class="body">
			<div class="wrap">
				@include('user.header')
				<div class="top_title">EARNING STATUS</div>
				<div class="ref-link">
					<span>Your Referral Link is:</span><input value="{!! url('/ref/') !!}/{{ $user->name }}" readonly />
				</div>
				<div class="scrollbar-inner scroll-bar_center">
					<div class="centering" id='scroll-center' style="width: <?php  if($i != 0) { echo $i*120; } else { echo 116; } ?>px;">
						<div id="ref-tree">
							<div id="ref-tree-me" style="width: 100%">
								<table cellpadding="0" cellspacing="0" border="0" style="width: {{ $i*120 }}px">
									<tr>

										<td height="116" align="middle">
											<div class="user">
												@if (empty($user->photo))
													<img width="116px" height="116px" src="/img/header_default_photo.png" />
												@else
													<img width="116px" height="116px" src="/uploads/{{ $user->photo }}" />
												@endif
												<div class="hide">
													<a>{{ $user->id }}</a>
												</div>
											</div>
										</td>

									</tr>
									<tr style="width: 100%;height: 20px;" align="middle">
										<td style="width: 20px;height: 20px;" align="middle">
											<div class="line" style="border: 1px solid #b6c6e4; height: 100%; width: 0px;"></div>
										</td>
									</tr>
								</table> 
							</div>
							<div class="centering">
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
									$i = $i*120-60*($f+$l);
									if ($i == 0) {
										$i = 1;
									}
									?>
									width: <?php echo $i; ?>px;
									margin-right: <?php echo 60*$l; ?>px;
									margin-left: <?php echo 60*$f; ?>px;
									border: 1px solid #b6c6e4;
									"
								"></div>
							</div> 
							<div id="ref-tree-first" >
								<?php foreach($my_org_users_first_level as $user_f_l) : ?>
								<?php $content = 	'<div class="user-pop">
														<div class="user-info">
															<div class="full-name">'.$user_f_l->name.'</div>
															<div class="line"></div>
															<div class="id">#'.sprintf("%'.09d\n",$user_f_l->id).'</div>
															<div class="birthday">'.$user_f_l->created_at.'</div>
															<div class="line"></div>
															<div class="balance">Total balance: $28</div>
														</div>
													</div>'; ?>
									<table cellpadding="0" cellspacing="0" border="0" style="width: <?php  if(count($my_org_users_second_level[$user_f_l->id]) != 0) { echo count($my_org_users_second_level[$user_f_l->id])*120; } else { echo 120; } ?>px; float: left;">
										<tr >
											<td style="width: 20px;height: 20px;" align="middle">
												<div class="line" style="border: 1px solid #b6c6e4; height: 100%; width: 0px;"></div>
											</td>
										</tr>
										<tr>
											<td height="67" align="middle">
												<div class="user-first" data-trigger="hover" data-content='<?php echo $content; ?>' data-html="true" data-placement="right" id="user-<?php echo $user_f_l->id; ?>" style='z-index: 1000;'>
													@if (empty($user_f_l->photo))
													<img width="67px" height="67px" src="/img/header_default_photo.png" />
												@else
													<img width="67px" height="67px" src="/uploads/{{ $user_f_l->photo }}" />
												@endif
													<div class="hide">
														<a ">{{ $user_f_l->user_nicename }}</a>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td style="width: 250px;height: 20px;" align="middle">
												@if (count($my_org_users_second_level[$user_f_l->id]))
													<div class="line" style="border: 1px solid #b6c6e4; height: 100%; width: 0px;"></div>
												@endif
											</td>
										</tr>
									</table> 
								<?php endforeach; ?>
							</div>
							<div id="ref-tree-second" >
								
								<?php foreach($my_org_users_first_level as $user_f_l) : ?>
									<div class="user-group" style="width: <?php  if(count($my_org_users_second_level[$user_f_l->id]) != 0) { echo count($my_org_users_second_level[$user_f_l->id])*120; } else { echo 120; } ?>px; float: left;">
										<div class="vertical-ref-line"
											style="
											<?php $c = count($my_org_users_second_level[$user_f_l->id]); 
											if ($c*120-120 <= 0) {
												$c = 1;
												$k = 37;
											} else {
												$c = $c*120-120;
												$k = 60;
											}
											?>
											
											width: <?php echo $c; ?>px;
											margin-left: <?php echo $k;?>px;
											margin-right: <?php echo 60; ?>px;
											border: 1px solid #b6c6e4;
											" ></div>

										<table cellpadding="0" cellspacing="0" border="0" style="width: <?php  if(count($my_org_users_second_level[$user_f_l->id]) != 0) { echo count($my_org_users_second_level[$user_f_l->id])*120; } else { echo 120; } ?>px">
											<?php foreach($my_org_users_second_level[$user_f_l->id] as $user_s_l) : ?>
											<?php $content = 	'<div class="user-pop">
																	<div class="user-info">
																		<div class="full-name">'.$user_s_l->name.'</div>
																		<div class="line"></div>
																		<div class="id">#'.sprintf("%'.09d\n",$user_s_l->id).'</div>
																		<div class="birthday">'.$user_s_l->created_at.'</div>
																		<div class="line"></div>
																		<div class="balance">Total balance: $0</div>
																	</div>
																</div>'; ?>
											<table cellpadding="0" cellspacing="0" border="0" style="width: 120px;float: left;">
											<tr>
												<td style="height:  20px; width: 120px" align="middle">
													<div class="line" style="border: 1px solid #b6c6e4; height: 100%; width: 0px;"></div>
												</td>
											</tr>
											<tr>
												<td height="54" align="middle">
													<div class="user-second" data-trigger="hover" data-content='<?php echo $content; ?>' data-html="true" data-placement="right" id="user-<?php echo $user_s_l->id; ?>" style='z-index: 1000;'>
														@if (empty($user_s_l->photo))
															<img width="54px" height="54px" src="/img/header_default_photo.png" />
														@else
															<img width="54px" height="54px" src="/uploads/{{ $user_f_l->photo }}" />
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

		</div>

@endsection
@section('script')
<script type="text/javascript">
	// var ScreenWidth = screen.width; 
	// var maxSizeW;
	// if (ScreenWidth >= 768) {
	// 	ScreenWidth = '50%';
	// 	maxSizeW    = 500;
	// } else if (ScreenWidth <= 479){
	// 	ScreenWidth = '50%';
	// 	maxSizeW    = 300;
	// }
	// else {
	// 	ScreenWidth = '50%';
	// 	maxSizeW    = 400;
	// }
	
	// if (ScreenWidth >= 768) {
	// 	$('.member-my-org #ref-tree-me [id*="user-"], .member-my-org #ref-tree-first [id*="user-"], .member-my-org #ref-tree-second [id*="user-"]').popover({delay: { show: 500, hide: 500}});
	// } else {
	// 	$('.member-my-org #ref-tree-me [id*="user-"], .member-my-org #ref-tree-first [id*="user-"]').popover({delay: {show: 500, hide: 500}, placement: 'top'});
	// 	$('.member-my-org #ref-tree-second [id*="user-"]').popover({delay: {show: 500, hide: 500}, placement: 'top'});
	// }

	// $('.member-my-org [id*="user-"]').popover('show');

	// $('.member-my-org [id*="user-"]').popover('hide');

	$('.member-my-org [id*="user-"]').popover();
</script>
@endsection