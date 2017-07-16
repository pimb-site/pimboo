@extends('page', ['body_class' => $body_class])
@section('title')
Admin
@endsection
@section('content')
	<div class="body">
		<div class="wrap">
			@include('user.admin.header')

			<div class="top_title">Current page: Posts <a href="/admin/users/"> List of users</a></div>
			<div class="filter">
				<div class="entries">
					<select>
					  <option data-entries="100">100 Entries(defalult)</option>
					  <option data-entries="10">10 Entries</option>
					  <option data-entries="50">50 Entries</option>
					  <option data-entries="200">200 Entries</option>
					  <option data-entries="300">300 Entries</option>
					  <option data-entries="400">400 Entries</option>
					  <option data-entries="500">500 Entries</option>
					  <option data-entries="1000">1000 Entries</option>
					</select>
				</div>
				<div class="types"> 
					<select>
					  <option data-type="all">All types posts</option>
					  <option data-type="rankedlist">Ranked List</option>
					  <option data-type="flipcards">Flip Cards</option>
					  <option data-type="story">Story</option>
					  <option data-type="snip">Snip</option>
					  <option data-type="gif">GIF</option>
					</select>
				</div>
				<div class="time">
					<select>
					  <option data-starttime="<?php echo date('Y-m-d H:i:s', mktime(0, 0, 0, 0, 0, 0)); ?>" data-endtime="<?php echo date('Y-m-d H:i:s', mktime(24, 0, 0, date("m")  , date("d"), date("Y"))); ?>">All time</option>
					  <option data-starttime="<?php echo date('Y-m-d H:i:s', mktime(0, 0, 0, date("m")  , date("d"), date("Y"))); ?>" data-endtime="<?php echo date('Y-m-d H:i:s', mktime(24, 0, 0, date("m")  , date("d"), date("Y"))); ?>">Today</option>
					  <option data-starttime="<?php echo date('Y-m-d H:i:s', mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"))); ?>" data-endtime="<?php echo date('Y-m-d H:i:s', mktime(24, 0, 0, date("m")  , date("d")-1, date("Y"))); ?>">Yesterday</option>
					  <option data-starttime="<?php echo date('Y-m-d H:i:s', mktime(0, 0, 0, date("m")  , date("d")-7, date("Y"))); ?>" data-endtime="<?php echo date('Y-m-d H:i:s', mktime(24, 0, 0, date("m")  , date("d"), date("Y"))); ?>">Last 7 days</option>
					  <option data-starttime="<?php echo date('Y-m-d H:i:s', mktime(0, 0, 0, date("m")  , date("d")-14, date("Y"))); ?>" data-endtime="<?php echo date('Y-m-d H:i:s', mktime(24, 0, 0, date("m")  , date("d"), date("Y"))); ?>">Last 14 days</option>
					  <option data-starttime="<?php echo date('Y-m-d H:i:s', mktime(0, 0, 0, date("m")  , date("d")-30, date("Y"))); ?>" data-endtime="<?php echo date('Y-m-d H:i:s', mktime(24, 0, 0, date("m")  , date("d"), date("Y"))); ?>">Last 30 days</option>
					</select>
				</div>
				<div class="rights">
					<select>
					  <option data-right="-1">All(with+without additional rights)</option>
					  <option data-right="0">Only without additional rights</option>
					  <option data-right="1">Only with additional rights</option>
					</select>
				</div>
				<div class="username"><input type="text" name="user" placeholder="All users..."></div>
			</div>
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
								<div class="buttons editPost" data-id="{{ $post-> id}}" data-type="{{ $post->type }}">
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
					<button class='show_more' type="button">SHOW MORE</button>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('script')
<script>

	var entries = 100;
	var type    = "all";
	var starttime = '<?php echo date('Y-m-d H:i:s', mktime(0, 0, 0, 0, 0, 0)); ?>';
	var endtime   = '<?php echo date('Y-m-d H:i:s', mktime(24, 0, 0, date("m")  , date("d"), date("Y"))); ?>';
	var right   = -1;
	var name    = "";
	var multiply = 1;

	$('.entries select').on('change', function() {
		multiply = 0;
		entries = $('.entries select option:selected').data('entries');
		sortEntries(starttime, endtime, entries, type, right, name, multiply);
	});

	$('.types select').on('change', function() {
		multiply = 0;
		type = $('.types select option:selected').data('type');
		sortEntries(starttime, endtime, entries, type, right, name, multiply);
	});

	$('.time select').on('change', function() {
		multiply = 0;
		starttime = $('.time select option:selected').data('starttime');
		endtime = $('.time select option:selected').data('endtime');
		sortEntries(starttime, endtime, entries, type, right, name, multiply);
	});

	$('.rights select').on('change', function() {
		multiply = 0;
		right = $('.rights select option:selected').data('right');
		sortEntries(starttime, endtime, entries, type, right, name, multiply);
	});

	$('.username input').on('change', function() {
		multiply = 0;
		name  = $(this).val();
		sortEntries(starttime, endtime, entries, type, right, name, multiply);
	});

	$('.show_more').click(function() {
		multiply = (multiply == 0) ? 1 : multiply;
		sortEntries(starttime, endtime, entries, type, right, name, multiply);
		multiply++;
	});

	function sortEntries(starttime, endtime, entries, type, right, name, multiply) {
		var token  = "{{ csrf_token() }}";
		$.ajax({
		    url: '/admin/action/sortentries',
		    data: {'_token': token, 'entries': entries, 'type': type, 'right': right, 'name': name, 'multiply': multiply, 'starttime': starttime, 'endtime': endtime},
		    dataType : "json",
		    type: 'POST',
		    success: function (data, textStatus) {
		    	if(data.success == true) {
		    		var html = '';
		    		$.each(data.posts, function (i, value) {
		    			var checked_left = (value.home_left == 1) ? 'checked' : '';
		    			var checked_right = (value.home_right == 1) ? 'checked' : '';
		    			var checked_latest = (value.home_latest == 1) ? 'checked' : '';
		    			html += '<div class="table_row" data-id="'+value.id+'">';
		    			html += '<div class="row_cell cell_image"><a href="/'+value.author_name+'/'+value.url+'" class="img"><img width="75px" src="/uploads/'+value.description_image+'" /></a></div>';
		    			html += '<div class="row_cell cell_type" >'+value.type+'</div>';
		    			html += '<div class="row_cell cell_user"><a class="title" title="'+value.author_name+'" href="/'+value.author_name+'">'+value.author_name+'</a></div>';
		    			html += '<div class="row_cell cell_title"><a href="/'+value.author_name+'/'+value.url+'" title="'+value.description_title+'" class="text">'+value.description_title+'</a></div>';
		    			html += '<div class="row_cell cell_created">'+value.created_at+'</div>';
		    			html += '<div class="row_cell cell_checkbox">';
		    			html += '<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="" data-id="'+value.id+'" data-action="set_left" '+checked_left+'><span class="checkbox-custom"></span></label></div></div>';
		    			html += '<div class="row_cell cell_checkbox">';
		    			html += '<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="" data-id="'+value.id+'" data-action="set_right" '+checked_right+'><span class="checkbox-custom"></span></label></div></div>';
		    			html += '<div class="row_cell cell_checkbox">';
		    			html += '<div class="tag"><label><input class="checkbox" type="checkbox" name="tags[]" value="" data-id="'+value.id+'" data-action="set_latest" '+checked_latest+'><span class="checkbox-custom"></span></label></div></div>';
		    			html += '<div class="row_cell cell_edit"> <div class="buttons editPost" data-id="'+value.id+'" data-type="'+value.type+'">';
		    			html += '<button ><span class="glyphicon glyphicon-pencil"></span></button> </div> </div>';
		    			html += '<div class="row_cell cell_del"><div class="buttons deletePost" data-id="'+value.id+'">';
		    			html += '<button ><span class="glyphicon glyphicon-remove"></span></button> </div> </div> </div>';
		    		});

			    	$('.admin_table').fadeToggle(500, function() {
			    		$('.admin_table').html('');
			    		$('.admin_table').html(html);
			    	});

			    	$('.admin_table').fadeToggle(500, function(){});
		    	}
		    } 
		});
	}

	$('.admin_table').on('change', 'input[type="checkbox"]', function() {
		var token  = "{{ csrf_token() }}";
		var action = $(this).data('action');
		var post_id = $(this).data('id');
		var checked = ($(this).is(':checked')) ? 1 : 0;

		$.ajax({
		    url: '/admin/action/postposition',
		    data: {'post_id' : post_id, '_token': token, 'checked': checked, 'action': action},
		    dataType : "json",
		    type: 'POST',
		    success: function (data, textStatus) {
		    } 
		});
	});

	$('.admin_table').on('click', '.editPost', function() {
		var post_id = $(this).data('id');
		var post_type = $(this).data('type');
		window.location = '/admin/editing/'+post_type+'/'+post_id;
	});

	$('.admin_table').on('click', '.deletePost', function() {
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

	(function(){  // анонимная функция (function(){ })(), чтобы переменные "a" и "b" не стали глобальными
	var a = document.querySelector('#aside1'), b = null;  // селектор блока, который нужно закрепить
	window.addEventListener('scroll', Ascroll, false);
	document.body.addEventListener('scroll', Ascroll, false);  // если у html и body высота равна 100%
	function Ascroll() {
	  if (b == null) {  // добавить потомка-обёртку, чтобы убрать зависимость с соседями
	    var Sa = getComputedStyle(a, ''), s = '';
	    for (var i = 0; i < Sa.length; i++) {  // перечислить стили CSS, которые нужно скопировать с родителя
	      if (Sa[i].indexOf('overflow') == 0 || Sa[i].indexOf('padding') == 0 || Sa[i].indexOf('border') == 0 || Sa[i].indexOf('outline') == 0 || Sa[i].indexOf('box-shadow') == 0 || Sa[i].indexOf('background') == 0) {
	        s += Sa[i] + ': ' +Sa.getPropertyValue(Sa[i]) + '; '
	      }
	    }
	    b = document.createElement('div');  // создать потомка
	    b.style.cssText = s + ' box-sizing: border-box; width: ' + a.offsetWidth + 'px;';
	    a.insertBefore(b, a.firstChild);  // поместить потомка в цепляющийся блок
	    var l = a.childNodes.length;
	    for (var i = 1; i < l; i++) {  // переместить во вновь созданного потомка всех остальных потомков плавающего блока (итого: создан потомок-обёртка)
	      b.appendChild(a.childNodes[1]);
	    }
	    a.style.height = b.getBoundingClientRect().height + 'px';  // если под скользящим элементом есть другие блоки, можно своё значение
	    a.style.padding = '0';
	    a.style.border = '0';  // если элементу присвоен padding или border
	  }
	  if (a.getBoundingClientRect().top <= 0) { // elem.getBoundingClientRect() возвращает в px координаты элемента относительно верхнего левого угла области просмотра окна браузера
	    b.className = 'sticky';
	  } else {
	    b.className = '';
	  }
	  window.addEventListener('resize', function() {
	    a.children[0].style.width = getComputedStyle(a, '').width
	  }, false);  // если изменить размер окна браузера, измениться ширина элемента
	}
	})()

</script>
@endsection