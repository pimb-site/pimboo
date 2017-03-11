@extends('page')
@section('title')
Home
@endsection
@section('content')
        <div class="body">
            <div id="carousel-example-generic" class="carousel carousel-fade slide slider" data-ride="carousel">
                <div class="carousel-inner" role="listbox">
                    <div class="item main active" style='background-image: url("/img/slider_pimboo_1.gif");'>
                        <div class="wrap">
                            <div class="text">With the help of Pimboo you can be<br>in the hottest regions of the country just one click away</div>
                            @if (Auth::guest())
                                <a class="join_now" data-toggle="modal" data-target="#register-modal">JOIN NOW</a>
                            @else
                                <a class="join_now" href="/create">JOIN NOW</a>
                            @endif
                        </div>
                    </div>
                    <div class="item flipcard" style='background-image: url("/img/slider_pimboo_2.jpg");'>
                        <div class="wrap">
                            <div class="text1">Create Fun Flip cards</div>
                            <div class="text2">SHARE & PROFIT!</div>
                            @if (Auth::guest())
                                <a class="join_now" data-toggle="modal" data-target="#register-modal">JOIN NOW</a>
                            @else
                                <a class="join_now" href="/add_flip_cards">JOIN NOW</a>
                            @endif
                        </div>
                    </div>
                    <div class="item trivia" style='background-image: url("/img/slider_pimboo_3.jpg");'>
                        <div class="wrap">
                            <div class="text1">Stump Your Friends With</div>
                            <div class="text2">Our Trivia Tool & Profit!</div>
                            @if (Auth::guest())
                                <a class="join_now" data-toggle="modal" data-target="#register-modal">JOIN NOW</a>
                            @else
                                <a class="join_now" href="/add_trivia_quiz">JOIN NOW</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="posts-color">
                <div class="wrap">
                    <div class="posts">
                        <div class="head">FEATURED POSTS</div>
                        <div class="left">
                            <div class="img"><img src="/img/home_post.jpg" /></div>
                            <div class="title">White House Defends Yemen Raid</div>
                            <div class="text">Pellentesque egestas neque ac consequat finibus. Curabitur vel aliquet risus. Vivamus aliquam aliquam mauris quis hendrerit. Aliquam volutpat, eros eu consequat mollis.  Aliquam volutpat, eros eu consequat mollis. </div>
                            <div class="info distab">
                                <div class="time">January 23, 2017</div>
                                <a class="readmore">Read More >></a>
                            </div>
                        </div>
                        <div class="right">
                            <div class="post">
                                <a class="post_name" href="#">Daniel Dodarrio</a>
                                <a class="post_text" href="#">Arnold Schwarzenegger Is Lucky The Apprentice Ratings Are So Bad</a>
                            </div>
                            <div class="post">
                                <a class="post_name" href="#">Tavis Smiley</a>
                                <a class="post_text" href="#">Review: I Am Not Your Negro Shows How Far We Only Think We’ve Come</a>
                            </div>
                            <div class="post">
                                <a class="post_name" href="#">Alan Levinovitz</a>
                                <a class="post_text" href="#">Donald Trump Got Black History Month All Wrong</a>
                            </div>
                            <div class="post">
                                <a class="post_name" href="#">Daniel Dodarrio</a>
                                <a class="post_text" href="#">The Myth That Christianity Provides Ethical Guidance</a>
                            </div>
                            <div class="post">
                                <a class="post_name" href="#">Daniel Dodarrio</a>
                                <a class="post_text" href="#">Arnold Schwarzenegger Is Lucky The Apprentice Ratings Are So Bad</a>
                            </div>
                            <div class="post">
                                <a class="post_name" href="#">Tavis Smiley</a>
                                <a class="post_text" href="#">Review: I Am Not Your Negro Shows How Far We Only Think We’ve Come</a>
                            </div>
                            <div class="post">
                                <a class="post_name" href="#">Alan Levinovitz</a>
                                <a class="post_text" href="#">Donald Trump Got Black History Month All Wrong</a>
                            </div>
                            <div class="post">
                                <a class="post_name" href="#">Daniel Dodarrio</a>
                                <a class="post_text" href="#">The Myth That Christianity Provides Ethical Guidance</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrap" style="position: relative;">
                <div class="headlines-title">LATEST HEADLINES</div>
                <div class="headlines">
                    <div class="headline">
                        <a class="img"><img src="/img/home_headline_1.jpg" /></a>
                        <a class="text">Jared Kushner Wouldn’t Be the First Powerful Son-in-Law in Presidential History</a>
                    </div>
                    <div class="headline">
                        <a class="img"><img src="/img/home_headline_2.jpg" /></a>
                        <a class="text">James Comey Cannot Be Trusted With a Trump-Russia Investigation</a>
                    </div>
                    <div class="headline">
                        <a class="img"><img src="/img/home_headline_3.jpg" /></a>
                        <a class="text">Reject False Prophets. Protect Our Allies</a>
                    </div>
                    <div class="headline">
                        <a class="img"><img src="/img/home_headline_4.jpg" /></a>
                        <a class="text">Obama Says Goodbye and Returns to His Roots</a>
                    </div>
                    <div class="headline">
                        <a class="img"><img src="/img/home_headline_5.jpg" /></a>
                        <a class="text">Pay Women More If You Want a Stronger Economy</a>
                    </div>
                    <div class="headline">
                        <a class="img"><img src="/img/home_headline_6.jpg" /></a>
                        <a class="text">Amazon Is Already Winning the Next Big Arms Race in Tech</a>
                    </div>
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
