@extends('page')
@section('title')
Home
@endsection
@section('content')
        <div class="body">
            @if (Auth::guest())
                <div id="carousel-example-generic" class="carousel slide slider" data-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <div class="item flipcard active" style='background-image: url("/img/home-flipcard-banner.jpg");'>
                            <div class="wrap">
                                <div class="miniwrap">
                                    <div class="text1">Create Fun Flip cards</div>
                                    <div class="text2">SHARE & PROFIT!</div>
                                    <a class="join_now">JOIN NOW</a>
                                </div>
                            </div>
                        </div>
                        <div class="item story" style='background-image: url("/img/home-story-banner.jpg");'>
                            <div class="wrap">
                                <div class="miniwrap">
                                    <div class="text1">Create Interesting Stories</div>
                                    <div class="text2">SHARE & PROFIT!</div>
                                    <a class="join_now">JOIN NOW</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else     
                <div id="carousel-example-generic" class="carousel slide slider-in" data-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <div class="item active" style='background-image: url("/img/home_logged_slider_1.png");'>
                            <div class="wrap">
                                <div class="text-1">Check Out The Trending Content on Pimboo Below.</div>
                                <div class="text-2">Post It, Share It, and Profit!</div>
                                <img src="/img/home_logged_slider_arrow.png">
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="posts-color">
                <div class="wrap">
                    <div class="posts">
                        <div class="head">FEATURED POSTS</div>
                        <div class="left">
                        <div id="carousepostmain" class="carousel slide" data-interval="6000" data-ride="carousel">
                            <div class="carousel-inner">
                            <?php $count = 1; ?>
                            @foreach ($main_post as $post_main)
                                <div class="item <?php if($count == 1) print 'active'; ?>">
                                <div class="img"><a href="/{{  $post_main->author_name.'/'.$post_main->url }}"><img width="750px" height="445px" src="/uploads/{{  $post_main->description_image }}" /></a></div>
                                <div class="carousel_bottom">
                                    <div class="title"><a href="/{{  $post_main->author_name.'/'.$post_main->url }}">{{  $post_main->description_title }}</a></div>
                                    <div class="text">{{  $post_main->description_text }}</div>

                                    <div class="info distab">
                                        <div class="posting">
                                            <span class="buttons_share" data-id="{{ $count }}">
                                                <span class="sharing">SHARE & PROFIT:</span>
                                                <a data-title="{{  $post_main->description_title }}" data-url="{{  '/'.$post_main->author_name.'/'.$post_main->url }}" data-type="fb"  class="butt-for-sharing facebook" href=""></a>
                                                <a data-title="{{  $post_main->description_title }}" data-url="{{  '/'.$post_main->author_name.'/'.$post_main->url }}" data-type="tw"  class="butt-for-sharing twitter" href=""></a>
                                                <a data-title="{{  $post_main->description_title }}" data-url="{{  '/'.$post_main->author_name.'/'.$post_main->url }}" data-type="li"  class="butt-for-sharing linkedin" href=""></a>
                                                <button class="get_link" data-id="{{ $count }}" data-href="{{  url('/'.$post_main->author_name.'/'.$post_main->url) }}">GET LINK</button>
                                            </span>
                                            <span class="link" data-id="{{ $count }}">
                                                <span class="link_in">COPIED TO YOUR CLIPBOARD</span>
                                                <input class="link_input"  type="" name="" value="" />
                                            </span>
                                        </div>
                                        <a href="/{{  $post_main->author_name.'/'.$post_main->url }}" class="readmore">Read More >></a>
                                    </div>
                                </div>
                                </div>
                                <?php $count++; ?>
                            @endforeach
                            </div>
                        </div>
                        </div>
                        <div class="right">
                            @if(count($posts) != 0)
                            @foreach ($posts as $post)
                                <div class="post">
                                    <a class="post_name" href="{{  '/'.$post->author_name.'/'.$post->url }}">{{  $post->description_title }}</a>
                                    <a class="post_text" href="{{  '/'.$post->author_name.'/'.$post->url }}">{{  $post->description_text }}</a>
                                    <div class="posting">
                                        <span class="buttons_share" data-id="{{ $count }}">
                                            <span class="sharing">SHARE &<br>PROFIT:</span>
                                            <a data-title="{{  $post->description_title }}" data-url="{{  '/'.$post->author_name.'/'.$post->url }}" data-type="fb"  class="butt-for-sharing facebook" href=""></a>
                                            <a data-title="{{  $post->description_title }}" data-url="{{  '/'.$post->author_name.'/'.$post->url }}" data-type="tw"  class="butt-for-sharing twitter" href=""></a>
                                            <a data-title="{{  $post->description_title }}" data-url="{{  '/'.$post->author_name.'/'.$post->url }}" data-type="li"  class="butt-for-sharing linkedin" href=""></a>
                                            <button class="get_link" data-id="{{ $count }}" data-href="{{  url('/'.$post->author_name.'/'.$post->url) }}">GET LINK</button>
                                        </span>
                                        <span class="link" data-id="{{ $count }}">
                                            <span class="link_in">COPIED TO YOUR<br>CLIPBOARD</span>
                                            <input class="link_input" type="" name="" value="" />
                                        </span>
                                    </div>
                                </div>
                                <?php $count++; ?>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrap" style="position: relative;">
                <div class="headlines-title">LATEST HEADLINES</div>
                <div class="headlines" data-id="0">
                    @foreach ($latest as $post)
                    <div class="headline" data-id="{{ $count }}">
                        <div class="img">
                            <a href="{{  '/'.$post->author_name.'/'.$post->url }}" class="img"><img width="360px" height="309px" src="/uploads/{{  $post->description_image }}" /></a>
                            <div class="posting" data-id="{{ $count }}">
                                <span class="buttons_share" data-id="{{ $count }}">
                                    <span class="sharing">SHARE &<br>PROFIT:</span>
                                    <a data-title="{{  $post->description_title }}" data-url="{{  '/'.$post->author_name.'/'.$post->url }}" data-type="fb"  class="butt-for-sharing facebook" href=""></a>
                                    <a data-title="{{  $post->description_title }}" data-url="{{  '/'.$post->author_name.'/'.$post->url }}" data-type="tw"  class="butt-for-sharing twitter" href=""></a>
                                    <a data-title="{{  $post->description_title }}" data-url="{{  '/'.$post->author_name.'/'.$post->url }}" data-type="li"  class="butt-for-sharing linkedin" href=""></a>
                                    <button class="get_link" data-href="{{  url('/'.$post->author_name.'/'.$post->url) }}" data-id="{{ $count }}">GET LINK</button>
                                </span>
                                <span class="link" data-id="{{ $count }}">
                                    <span class="link_in">COPIED TO YOUR<br>CLIPBOARD</span>
                                    <input type="" name="" value="" />
                                </span>
                            </div>
                        </div>
                        <a href="{{  '/'.$post->author_name.'/'.$post->url }}" class="text">{{  $post->description_title }}</a>
                    </div>
                    <?php $count++; ?>
                    @endforeach
                </div>
                <button type="button" class="headlines_show_more" style="border: 0;">SHOW MORE</button>
                <div class="join_us">
                    <div class="header">JOIN US</div>
                    <div class="distab">
                        <div class="left"><div class="iframe-youtube"><iframe id="player" frameborder="0" allowfullscreen="1" title="YouTube video player" width="720" height="406" src="https://www.youtube.com/embed/j8nZh-aTXIg?autoplay=0&amp;controls=0&amp;disablekb=1&amp;fs=0&amp;modestbranding=1&amp;showinfo=0&amp;enablejsapi=1&amp;origin=http%3A%2F%2Fpimboobeta.com&amp;widgetid=1&amp;rel=0"></iframe></div></div>
                        <div class="right">
                            <div class="title">Why join us? </div>
                            <div class="text">You built your tribe. Likes. Views.<br>Google and Facebook made billions from your efforts. Did they send you a royalty check for your hard work in delivering value?<br>We never got ours. Until now.<br>Likes, views and followers have VALUE! YouTube, Facebook, etc would not exist without them.<br>It's time to take the power back- and it's 100% free.<br>This changes everything. Join Pimboo today.</div>
                            
                            @if (Auth::guest())
                                <a data-toggle="modal" data-target="#register-modal">JOIN NOW</a>
                            @else
                                <a href="/create">Create</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style type="text/css">
        .carousel-fade .carousel-inner .item {
          opacity: 0;
          transition-property: opacity;
        }

        .carousel-fade .carousel-inner .active {
          opacity: 1;
        }

        .carousel-fade .carousel-inner .active.left,
        .carousel-fade .carousel-inner .active.right {
          left: 0;
          opacity: 0;
          z-index: 1;
        }

        .carousel-fade .carousel-inner .next.left,
        .carousel-fade .carousel-inner .prev.right {
          opacity: 1;
        }

        .carousel-fade .carousel-control {
          z-index: 2;
        }

        /*
        WHAT IS NEW IN 3.3: "Added transforms to improve carousel performance in modern browsers."
        now override the 3.3 new styles for modern browsers & apply opacity
        */
        @media all and (transform-3d), (-webkit-transform-3d) {
            .carousel-fade .carousel-inner > .item.next,
            .carousel-fade .carousel-inner > .item.active.right {
              opacity: 0;
              -webkit-transform: translate3d(0, 0, 0);
                      transform: translate3d(0, 0, 0);
            }
            .carousel-fade .carousel-inner > .item.prev,
            .carousel-fade .carousel-inner > .item.active.left {
              opacity: 0;
              -webkit-transform: translate3d(0, 0, 0);
                      transform: translate3d(0, 0, 0);
            }
            .carousel-fade .carousel-inner > .item.next.left,
            .carousel-fade .carousel-inner > .item.prev.right,
            .carousel-fade .carousel-inner > .item.active {
              opacity: 1;
              -webkit-transform: translate3d(0, 0, 0);
                      transform: translate3d(0, 0, 0);
            }
        }
    </style>

@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        var multiply = 1;
        var data_title_id = 100;  
        var token  = "{{ csrf_token() }}";

        $('.headlines_show_more').click(function() {
            $.ajax({
                url: '/home/showmore',
                dataType : "json",
                data: {'multiply': multiply, '_token' : token},
                type: 'POST',
                success: function (data, textStatus) {
                    if(data.success == true) {
                        if(data.posts.length != 0) {
                            var html = '<div class="headlines" data-id="'+multiply+'">';
                            $.each(data.posts, function (i, value) {
                                html += '<div class="headline" data-id="'+data_title_id+'">';
                                html += '<div class="img">';
                                html += '<a href="/'+value.author_name+'/'+value.url+'" class="img"><img width="360px" height="309px" src="/uploads/'+value.description_image+'" /></a>';
                                html += '<div class="posting" data-id="'+data_title_id+'">';
                                html += '<span class="buttons_share" data-id="'+data_title_id+'">';
                                html += '<span class="sharing">SHARE &<br>PROFIT:</span>';
                                html += '<a  data-title="'+value.description_title+'" data-url="'+window.location.hostname+"/"+value.author_name+"/"+value.url+'"data-type="fb"  class="butt-for-sharing facebook" href=""></a>';
                                html += '<a  data-title="'+value.description_title+'" data-url="'+window.location.hostname+"/"+value.author_name+"/"+value.url+'" data-type="tw"  class="butt-for-sharing twitter" href=""></a>';
                                html += '<a  data-title="'+value.description_title+'" data-url="'+window.location.hostname+"/"+value.author_name+"/"+value.url+'" data-type="li"  class="butt-for-sharing linkedin" href=""></a>';
                                html += '<button class="get_link" data-href="'+window.location.hostname+"/"+value.author_name+"/"+value.url+'" data-id="'+data_title_id+'">GET LINK</button>';
                                html += '</span>';
                                html += '<span class="link" data-id="'+data_title_id+'">';
                                html += '<span class="link_in">COPIED TO YOUR<br>CLIPBOARD</span>';
                                html += '<input type="" name="" value="" />';
                                html += '</span>';
                                html += '</div>';
                                html += '</div>';
                                html += '<a href="/'+value.author_name+'/'+value.url+'" class="text">'+value.description_title+'</a>';
                                html += '</div>';
                                data_title_id++;
                            });
                            html += '</div>';
                            $('.headlines[data-id="'+(multiply-1)+'"]').fadeToggle(500, function() {
                                $('.headlines[data-id="'+(multiply-1)+'"]').remove();
                                $('.headlines-title').after(html);
                            });

                        }
                        multiply++;

                    }
                } 
            });
        });
        var ScreenWidth = window.innerWidth; 
        if (ScreenWidth >= 768) {
            var bottom_value = 0;
            if (ScreenWidth > 1199) {
                bottom_value = 70;
            } else if ((ScreenWidth > 991) && (ScreenWidth <= 1199)) {
                bottom_value = 56;
            } else {
                bottom_value = 50;
            }
            $('.body').on('mouseover', '.headline', function() { 
                var _block = $('.posting[data-id="'+$(this).data('id')+'"]');
                _block.animate({
                    'bottom': ''+bottom_value+'px'
                }, 300);
            });
            $('.body').on('mouseleave', '.headline', function() { 
                var _block = $('.posting[data-id="'+$(this).data('id')+'"]');
                _block.animate({
                    'bottom': '0px'
                }, 300);
            });
        };
        $("#carousepostmain").carousel('cycle');
    });

</script>
@endsection
