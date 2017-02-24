		<div id="ref-top">
		<div class="your-aff-link"><div>Your Referral Link is:</div><input value="http://pimboo.com/?ref=<?php echo $uid; ?>" readonly /></div>
		<?php 
				
			$users = get_users('meta_key=refferal&meta_value='.$uid);
			if (!empty($users)) { 
				$i = 0;
				foreach($users as $user) {
					// get_author_posts_url( $user->ID )
					// $user->data->user_nicename
					$users_array[$user->ID] = array();
					$users_tmp = get_users('meta_key=refferal&meta_value='.$user->ID);
					foreach ($users_tmp as $user_tmp) {
						$users_array[$user->ID][] = $user_tmp;
						$i = $i + 1;
					}
				} 
				
			?>
			<div id="ref-tree">
				<div id="ref-tree-me" style="height:<?=$i*100?>px">
					<table cellpadding="0" cellspacing="0" border="0" style="height: <?=$i*100?>px">
						<tr>
							<td style="width: 141px;">
							</td>
							<td height="100" valign="middle">
								<div class="user">
									<img src="<?=get_avatar_url($uid,array('size'=>'84','default'=>'http://pimboo.com/wp-content/themes/PricerrTheme/images/def-user.png'))?>" />
									<div class="hide">
										<a href="<?=get_author_posts_url( $uid )?>"><?=$current_user->data->user_nicename?></a>
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
					<?
					
					$users_tmp = $users_array;
					
					$f = count(current($users_tmp));
					
					$l = count(array_pop($users_tmp));
					?>
					height: <?=$i*100-50*($f+$l);?>px;
					margin-bottom: <?=50*$l?>px;
					margin-top: <?=50*$f?>px;
					"
				></div>
				<div id="ref-tree-first">
					
					<?php foreach($users as $user) : ?>
					<?php $content = '<div class="user-pop"><div class="top"><div class="user-image"><img src="'.get_avatar_url($user->ID,array('size'=>'87','default'=>'http://pimboo.com/wp-content/themes/PricerrTheme/images/ref-icon.png')).'"></div><div class="user-info"><div class="full-name-head">Full Name</div><div class="full-name"><a href="'.get_author_posts_url( $user->ID ).'">'.$user->data->user_nicename.'</a></div><div class="id">'.str_pad($user->ID, 10, "0", STR_PAD_LEFT).'</div></div></div><div class="nat"><div class="nat-head">Nationality</div><div class="nat-name">PIMBOOLAND</div></div><div class="balance"><div class="balance-head">Balance</div><div class="balance-info">$0</div></div></div>'; ?>
						<table cellpadding="0" cellspacing="0" border="0" style="height: <?php  if(count($users_array[$user->ID]) != 0) { echo count($users_array[$user->ID])*100; } else { echo 100; } ?>px">
							<tr>
								<td style="width: 32px;">
									<div class="line" style="border-top: 1px solid black; width: 100%;"></div>
								</td>
								<td height="100" valign="middle">
									<div class="user" data-trigger="hover" data-content='<?=$content?>' data-html="true" data-placement="right" id="user-<?=$user->ID?>" style='z-index: 1000;'>
										<img src="<?=get_avatar_url($user->ID,array('size'=>'80','default'=>'http://pimboo.com/wp-content/themes/PricerrTheme/images/def-user.png'))?>" />
										<div class="hide">
											<a href="<?=get_author_posts_url( $user->ID )?>"><?=$user->data->user_nicename?></a>
										</div>
									</div>
								</td>
								<td style="width: 250px;">
									<div class="line" style="border-top: 1px solid black; width: 100%;"></div>
								</td>
							</tr>
						</table> 
					<? endforeach; ?>
				</div>
				<div id="ref-tree-second">
					
					<?php foreach($users as $user) : ?>
						<div class="user-group">
							<div class="vertical-ref-line"
								style="
								<? $c = count($users_array[$user->ID]); 
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
							<table cellpadding="0" cellspacing="0" border="0" style="height: <?php  if(count($users_array[$user->ID]) != 0) { echo count($users_array[$user->ID])*100; } else { echo 100; } ?>px">
								<?php foreach($users_array[$user->ID] as $user_tmp) : ?>
								<?php $content = '<div class="user-pop"><div class="top"><div class="user-image"><img src="'.get_avatar_url($user_tmp->ID,array('size'=>'80','default'=>'http://pimboo.com/wp-content/themes/PricerrTheme/images/ref-icon.png')).'"></div><div class="user-info"><div class="full-name-head">Full Name</div><div class="full-name"><a href="'.get_author_posts_url( $user_tmp->ID ).'">'.$user_tmp->data->user_nicename.'</a></div><div class="id">'.str_pad($user_tmp->ID, 10, "0", STR_PAD_LEFT).'</div></div></div><div class="nat"><div class="nat-head">Nationality</div><div class="nat-name">PIMBOOLAND</div></div><div class="balance"><div class="balance-head">Balance</div><div class="balance-info">$0</div></div></div>'; ?>
								<tr>
									<td style="width: 32px;">
										<div class="line" style="border-top: 1px solid black; width: 100%;"></div>
									</td>
									<td height="100" valign="middle">
										<div class="user" data-trigger="hover" data-content='<?=$content?>' data-html="true" data-placement="right" id="user-<?=$user_tmp->ID?>" style='z-index: 1000;'>
											<img src="<?=get_avatar_url($user_tmp->ID,array('size'=>'80','default'=>'http://pimboo.com/wp-content/themes/PricerrTheme/images/def-user.png'))?>" />
										</div>
									</td>
								</tr>
								<? endforeach; ?>
							</table> 
						</div>
					<? endforeach; ?>
				</div>

			</div>
				
			<?php } else { ?>
			<div class='no-ref'>You have no refferals</div>
		<?php	} ?>
		
    	<?php endwhile; ?>
		</div>
		  <script type="text/javascript">
  $(document).ready(function(){
$('[id*="user-"]').popover({delay: { show: 500, hide: 500 }});
$('[id*="user-"]').popover('show');
$('[id*="user-"]').popover('hide');
});
</script>