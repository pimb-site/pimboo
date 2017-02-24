@extends('page')

@section('content')
		<div class="body">
			<div class="wrap">
				@include('user.header')
				<div class="top_title">EARNING STATUS</div>
				<div class="selectors">
					<div class="selector" id="acc_posts_select">
						<select>
							<option onclick="forma_in('all','All posts');">All posts</option>
							@foreach ($user_posts as $post)
								<option onclick="forma_in({{ $post->id }},'{{ $post->description_title }}');">{{ $post->description_title }}</option>
							@endforeach
						</select>
					</div>
					<div class="selector" id="acc_time_select">
						<select>
							<option onclick="forma(0,'Today');" value="0" start="<?php echo date('Y-m-d H:i:s', mktime(0, 0, 0, date("m")  , date("d"), date("Y"))); ?>" end="<?php echo date('Y-m-d H:i:s', mktime(24, 0, 0, date("m")  , date("d"), date("Y"))); ?>">Today</option>
							<option onclick="forma(1,'Yesterday');" value="1" start="<?php echo date('Y-m-d H:i:s', mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"))); ?>" end="<?php echo date('Y-m-d H:i:s', mktime(24, 0, 0, date("m")  , date("d")-1, date("Y"))); ?>">Yesterday</option>
							<option onclick="forma(2,'This week (Sun - Today)');" value="2" start="<?php echo date('Y-m-d H:i:s', strtotime('last Sun')); ?>" end="<?php echo date('Y-m-d H:i:s', mktime(24, 0, 0, date("m")  , date("d"), date("Y"))); ?>">This week (Sun - Today)</option>
							<option onclick="forma(3,'This week (Mon - Today)');" value="3" start="<?php echo date('Y-m-d H:i:s', strtotime('Mon this week')); ?>" end="<?php echo date('Y-m-d H:i:s', mktime(24, 0, 0, date("m")  , date("d"), date("Y"))); ?>">This week (Mon - Today)</option>
							<option onclick="forma(4,'Last 7 days');" value="4" start="<?php echo date('Y-m-d H:i:s', mktime(0, 0, 0, date("m")  , date("d")-7, date("Y"))); ?>" end="<?php echo date('Y-m-d H:i:s', mktime(24, 0, 0, date("m")  , date("d"), date("Y"))); ?>">Last 7 days</option>
							<option onclick="forma(5,'Last week (Sun - Sat)');" value="5" start="<?php echo date('Y-m-d H:i:s', strtotime('Sun -1 week')); ?>" end="<?php echo date('Y-m-d H:i:s', mktime(24, 0, 0, date("m")  , date("d"), date("Y"))); ?>">Last week (Sun - Sat)</option>
							<option onclick="forma(6,'Last week (Mon - Sun)');" value="6" start="<?php echo date('Y-m-d H:i:s', strtotime('Mon -2 week')); ?>" end="<?php echo date('Y-m-d H:i:s', strtotime('Sun -1 week')); ?>">Last week (Mon - Sun)</option>
							<option onclick="forma(7,'Last business week (Mon - Fri)');" value="7" start="<?php echo date('Y-m-d H:i:s', strtotime('Mon -2 week')); ?>" end="<?php echo date('Y-m-d H:i:s', strtotime('Fri -1 week')); ?>">Last business week (Mon - Fri)</option>
							<option onclick="forma(8,'Last 14 days');" value="8" start="<?php echo date('Y-m-d H:i:s', mktime(0, 0, 0, date("m")  , date("d")-14, date("Y"))); ?>" end="<?php echo date('Y-m-d H:i:s', mktime(24, 0, 0, date("m")  , date("d"), date("Y"))); ?>">Last 14 days</option>
							<option onclick="forma(9,'This month');" value="9" start="<?php echo date('Y-m-d H:i:s', mktime(0, 0, 0, date("m")  , 1, date("Y"))); ?>" end="<?php echo date('Y-m-d H:i:s', mktime(24, 0, 0, date("m")  , date("d"), date("Y"))); ?>">This month</option>
							<option onclick="forma(10,'Last 30 days');" value="10" start="<?php echo date('Y-m-d H:i:s', mktime(0, 0, 0, date("m")  , date("d")-30, date("Y"))); ?>" end="<?php echo date('Y-m-d H:i:s', mktime(24, 0, 0, date("m")  , date("d"), date("Y"))); ?>">Last 30 days</option>
							<option onclick="forma(11,'Last month');" value="11" start="<?php echo date('Y-m-d H:i:s', mktime(0, 0, 0, date("m")-1  , 1, date("Y"))); ?>" end="<?php echo date('Y-m-d H:i:s', mktime(0, 0, 0, date("m")  , 1, date("Y"))); ?>">Last month</option>
							<option onclick="forma(12,'All time');" value="12" start="<?php echo date('Y-m-d H:i:s', mktime(0, 0, 0, 0, 0, 0)); ?>" end="<?php echo date('Y-m-d H:i:s', mktime(24, 0, 0, date("m")  , date("d"), date("Y"))); ?>">All time</option>
						</select>
					</div>
				</div>
				<div class="traffics" id="member_page_traffic_updated">
					<div class="traffic">
						<div class="top">
							<div class="title">Your Traffic Today</div>
							<div class="stats_button">STATS</div>
						</div>
						<div class="bottom">
							<div class="left">
								<div class="views_numbers">{{ $my_today_views }}</div>
								<div class="views_text">VIEWS</div>
							</div>
							<div class="rights">
								<div class="views_money">$0</div>
								<div class="views_text">DAILY<br>PIMBOO PROFIT</div>
							</div>
						</div>
					</div>
					<div class="traffic">
						<div class="top">
							<div class="title">Organization Traffic Today</div>
							<div class="stats_button">STATS</div>
						</div>
						<div class="bottom">
							<div class="left">
								<div class="views_numbers">{{ $org_today_views }}</div>
								<div class="views_text">VIEWS</div>
							</div>
							<div class="rights">
								<div class="views_money">$0</div>
								<div class="views_text">DAILY<br>PIMBOO PROFIT</div>
							</div>
						</div>
					</div>
				</div>
				<div class="traffics">
					<div class="traffic">
						<div class="top">
							<div class="title">Your Traffic All Time</div>
							<div class="stats_button">STATS</div>
						</div>
						<div class="bottom">
							<div class="left">
								<div class="views_numbers">{{ $my_all_views }}</div>
								<div class="views_text">VIEWS</div>
							</div>
							<div class="rights">
								<div class="views_money">$0</div>
								<div class="views_text">ALL TIME<br>PIMBOO PROFIT</div>
							</div>
						</div>
					</div>
					<div class="traffic">
						<div class="top">
							<div class="title">Organization All Time</div>
							<div class="stats_button">STATS</div>
						</div>
						<div class="bottom">
							<div class="left">
								<div class="views_numbers">{{ $org_all_views }}</div>
								<div class="views_text">VIEWS</div>
							</div>
							<div class="rights">
								<div class="views_money">$0</div>
								<div class="views_text">ALL TIME<br>PIMBOO PROFIT</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
			id = 'all';
			end = '<?php echo date('Y-m-d H:i:s', mktime(24, 0, 0, date("m")  , date("d"), date("Y"))); ?>';
			start = '<?php echo date('Y-m-d H:i:s', mktime(0, 0, 0, date("m")  , date("d"), date("Y"))); ?>';
			token = '{{ csrf_token() }}';
			name_in = 'All time';
			function account_forma_in(f_id,name) {
				id = f_id;
				$.post( "/user/account", { text:name_in, post_id: id, start:start, end:end, _token:token })
				.done(function( data ) {
					$('#member_page_traffic_updated').html(data);
				});
			}
			function account_forma(f_id,name) {
				end = $("#acc_time_select option[value="+f_id+"]").attr('end');
				start = $("#acc_time_select option[value="+f_id+"]").attr('start');
				name_in = name;
				$('#reports-loading').css('display','block');
				$.post( "/user/account", { text:name_in, post_id: id, start:start, end:end, _token:token })
				.done(function( data ) {
					$('#member_page_traffic_updated').html(data);
				});
			};
		</script>
@endsection
