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
                                    <div class="text1">Create Ineterstimg Stories</div>
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
                            <div class="img"><img width="750px" height="445px" src="/uploads/{{ $main_post->description_image }}" /></div>
                            <div class="title">{{ $main_post->description_title }}</div>
                            <div class="text">{{ $main_post->description_text }}</div>
                            <div class="info distab">
                                <div class="time"><?php echo date("F j, Y", strtotime($main_post->created_at));  ?></div>
                                <a href="/viewID/{{ $main_post->id }}" class="readmore">Read More >></a>
                            </div>
                        </div>
                        <div class="right">
                            @foreach ($posts as $post)
                                <div class="post">
                                    <a class="post_name" href="/viewID/{{ $post->id }}">{{ $post->description_title }}</a>
                                    <a class="post_text" href="/viewID/{{ $post->id }}">{{ $post->description_text }}</a>
                                    <div class="posting">
                                        <span class="removing">
                                            <span class="sharing">SHARE &<br>PROFIT:</span>
                                            <a class="facebook" href=""></a>
                                            <a class="twitter" href=""></a>
                                            <a class="linkedin" href=""></a>
                                            <a class="code" href=""></a>
                                            <button class="get_link">GET LINK</button>
                                        </span>
                                        <span class="link">
                                            <span class="link_in">COPIED TO YOUR<br>CLIPBOARD</span>
                                            <input type="" name="" value="" />
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrap" style="position: relative;">
                <div class="headlines-title">LATEST HEADLINES</div>
                <div class="headlines">
                    @foreach ($latest as $post)
                    <div class="headline">
                        <a href="/viewID/{{ $post->id }}" class="img"><img width="360px" height="309px" src="/uploads/{{ $post->description_image }}" /></a>
                        <a href="/viewID/{{ $post->id }}" class="text">{{ $post->description_title }}</a>
                    </div>
                    @endforeach
                </div>
                <a href="#" class="headlines_show_more">SHOW MORE</a>
            </div>
            <div class="join_us">
                <div class="wrap">
                    <div class="header">JOIN US</div>
                    <div class="distab">
                        <div class="left"><img src="/img/home_join_us.jpg" /></div>
                        <div class="right">
                            <div class="title">Why join us? </div>
                            <div class="text">Pellentesque egestas neque ac consequat finibus. Curabitur vel aliquet risus. Vivamus aliquam aliquam mauris quis hendrerit. Aliquam volutpat, eros eu<br><br>consequat mollis, Pellentesque egestas neque ac consequat finibus. Curabitur vel aliquet risus. Vivamus aliquam aliquam</div>
                            
                            @if (Auth::guest())
                                <a data-toggle="modal" data-target="#register-modal">JOIN NOW</a>
                            @else
                                <a href="/create">JOIN US!</a>
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
