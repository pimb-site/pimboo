@extends('page', ['body_class' => $body_class])
@section('title')
@endsection
@section('css')
@endsection
@section('content')
	<div class="body">
		<div class="wrap">
			@include('user.admin.header')
			<div class="top_title">Users</div>
			<div class="all_user_table">
				<div class="table_title" id="aside1">
					<div class="title_cell cell_image_us">Photo</div>
					<div class="title_cell cell_user_us">First Name</div>
					<div class="title_cell cell_user_us">Last Name</div>
					<div class="title_cell cell_email_us">E-mail</div>
					<div class="title_cell cell_views_us">Num of posts</div>
					<div class="title_cell cell_channelID_us">Channel ID</div>
					<div class="title_cell cell_new">Last IP</div>
				</div>
					<div class="user_table">
					@foreach($users as $user)
						<?php
						$photo = (strlen($user->photo) > 0) ? '/uploads/'.$user->photo : '/img/header_default_photo.png';
						?>
						<div class="table_row" data-id="{{ $user->id }}">
							<div class="row_cell cell_image_us"><a href="#" class="img"><img width="75px" src="{{ $photo }}" /></a></div>
							<div class="row_cell cell_user_us"><? if (empty($user->first_name)) { echo $user->name; } else { echo $user->first_name; } ?></a></div>
							<div class="row_cell cell_user_us">{{ $user->last_name }}</a></div>
							<div class="row_cell cell_email_us" >{{ $user->email }}</div>
							<div class="row_cell cell_views_us"> <a href="#"> {{ $count_posts[$user->id] }}</a></div>
							<div class="row_cell cell_channelID_us">{{ $user->id }}</div>
							<div class="row_cell cell_new">{{ $user->last_ip }}</div>
						</div>
					@endforeach
					</div>
			</div>
			<button class='show_more' type="button">SHOW MORE</button>
			</div>
		</div>
	</div>
@endsection
@section('script')
<script>
	$(document).ready(function() {

		$('.editUser').click(function() {
			var user_id = $(this).data('id');
			window.location.href= '/admin/editing/user/' + user_id;	
		});

		$('.deleteUser').click(function() {
			var user_id = $(this).data('id');
			var token   = "{{ csrf_token() }}";
			$.ajax({
			    url: '/admin/action/deleteuser',
			    data: {'user_id' : user_id, '_token': token},
			    dataType : "json",
			    type: 'POST',
			    success: function (data, textStatus) {
			    	if(data.success == true) {
			    		$('.table_row[data-id="'+user_id+'"]').remove();
			    		alert('User has been deleted');
			    	}
			    } 
			});
		});
	});
	page = 0;
	$('.show_more').click(function() {
		page = page + 1;
		$.post( "/admin/users/add", { page:page, '_token': '{{ csrf_token() }}' })
		.done(function( data ) {
			$('.user_table').append(data);
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
