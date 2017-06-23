$(document).ready(function() {
	$('button.run-filter').click(function() {
		$('input[name="multiplier"]').val('1');
		$('#channel-filter').ajaxSubmit({
			dataType: "json",
			success: function (data) {
				$('.post').remove();
				if(data.success == true) {
					html_post = "";
					json_data = JSON.parse(data.posts);
					$.each(json_data, function (i, value) {
						html_post += '<div class="post"><div class="post-left">';
						html_post += '<div class="photo"> <img src="/uploads/'+value.description_image+'"></div>';
						html_post += '<div class="date">'+value.posted+'</div> </div>';
						html_post += '<div class="post-right"><div class="title"><a href="/'+value.author_name+'/'+value.url+'">'+value.description_title+'</a></div>';
						html_post += '<div class="description">'+value.description_text+'</div>';
						html_post += '<div class="share">Share this <a href="#">'+value.type+'</a></div>';
						html_post += '<div class="share-buttons">';
						html_post += '<button class="btn-share"><img src="/img/view_fb.png"></button>';
						html_post += '<button class="btn-share"><img src="/img/view_twitter.png"></button>';
						html_post += '<button class="btn-share"><img src="/img/view_linkedin.png"></button>';
						html_post += '<button class="btn-share"><img src="/img/view_link.png"></button>';
						html_post += '<button class="get-link">GET LINK</button></div></div></div>';
					});
					$('.show-more').before(html_post);
					if(data.show_more == true) $('.show-more').css({'display': 'block'});
					else $('.show-more').css({'display': 'none'});
				}
				else {
					html_post = "";
					html_post += '<div class="post"><h1> User has no entries </h1> </div>';
					$('.show-more').before(html_post);
					$('.show-more').css({'display': 'none'});
				}
			}
		});
	});

	$('button.show-more').click(function() {
		multiplier = $('input[name="multiplier"]').val();
		multiplier = parseInt(multiplier) + 1;
		$('input[name="multiplier"]').val(multiplier);
		$('#channel-filter').ajaxSubmit({
			dataType: "json",
			success: function (data) {
				if(data.success == true) {
					html_post = "";
					json_data = JSON.parse(data.posts);
					$.each(json_data, function (i, value) {
						html_post += '<div class="post"><div class="post-left">';
						html_post += '<div class="photo"> <img src="/uploads/'+value.description_image+'"></div>';
						html_post += '<div class="date">'+value.posted+'</div> </div>';
						html_post += '<div class="post-right"><div class="title"><a href="/viewID/'+value.id+'">'+value.description_title+'</a></div>';
						html_post += '<div class="description">'+value.description_text+'</div>';
						html_post += '<div class="share">Share this <a href="#">'+value.type+'</a></div>';
						html_post += '<div class="share-buttons"><button class="btn-share"><img src="/img/view_fb.png"></button>';
						html_post += '<button class="btn-share"><img src="/img/view_twitter.png"></button><button class="btn-share"><img src="/img/view_linkedin.png"></button>';
						html_post += '<button class="btn-share"><img src="/img/view_link.png"></button><button class="get-link">GET LINK</button></div></div></div>';
					});
					$('.show-more').before(html_post);
					if(data.show_more == true) $('.show-more').css({'display': 'block'});
					else $('.show-more').css({'display': 'none'});
				}
			}
		});
	});


	$('.subscribe-me').click(function() {

		var token      = $('input[name="_token"]').val();
		var channel_id = $('input[name="channel_id"]').val();

		$.ajax({
	        url: "/channel/subscribe",
	        type: "post",
	        data: {'_token': token, 'channel_id': channel_id},
	        success: function (response) {
	        	if(response.success == true) {
	        		$('.subscribe-me').css({'display': 'none'});
	        		$('.unsubscribe-me').css({'display': 'block'});

	        		var subscribers = $('.subscribers b').html();
	        		$('.subscribers b').html(parseInt(subscribers) + 1);
	        	}
	        },
	        error: function(jqXHR, textStatus, errorThrown) {
	           console.log(textStatus, errorThrown);
	        }
	    });
	});

	$('.unsubscribe-me').click(function() {

		var token      = $('input[name="_token"]').val();
		var channel_id = $('input[name="channel_id"]').val();

		$.ajax({
	        url: "/channel/unsubscribe",
	        type: "post",
	        data: {'_token': token, 'channel_id': channel_id},
	        success: function (response) {
	        	if(response.success == true) {
	        		$('.subscribe-me').css({'display': 'block'});
	        		$('.unsubscribe-me').css({'display': 'none'});

	        		var subscribers = $('.subscribers b').html();
	        		$('.subscribers b').html(parseInt(subscribers) - 1);
	        	}
	        },
	        error: function(jqXHR, textStatus, errorThrown) {
	           console.log(textStatus, errorThrown);
	        }
	    });
	});
});