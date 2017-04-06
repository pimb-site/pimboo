@extends('page')

@section('css')
	@yield('css')
@endsection


@section('content')
        <div class="body">
            <div class="wrap">
                <div class="title">{{ $content->description_title }}</div>
                <div class="center">
                    <div class="left">
                        <div class="border">
                            <div class="top">
                                <div class="info">
                                    <div class="published">Published on February 16, 2016 by <a href="/channel/{{ $content->user_id }}">{{ $user_name }}</a></div>
                                </div>
                                <div class="buttons">
                                    <a href="" class="facebook"></a>
                                    <a href="" class="twitter"></a>
                                    <a href="" class="google_plus"></a>
                                    <a href="" class="linked_in"></a>
                                    <button>GET LINK</button>
                                </div>
                            </div>
                            <div class="content">
                                @yield('tool_content')
                            </div>
                        </div>
                        <button class="report_button">REPORT POST</button>
                    </div>
                    <div class="right">
                        <div class="start-creating">
                            <div class="utitle">Like This Content?<br/>Create/Share/Profit On It As Well!</div>
                            <div class="image-creating"><img src="/img/start-creating.png"/></div>
                            <div class="join-text">Join Pimboo & Create/Share/Profit For Free!</div>
                            <button onclick="document.location.href='/create';">START CREATING</button>
                        </div>
                        <div class="tags">
                            <h2> TAGS </h2>
                            <a href="#">Arts</a>, <a href="#">Internet</a>, <a href="#">Tech</a>, <a href="#">Celebrities</a>
                        </div>
                        <div class="more-text">
                            MORE FROM PIMBOO
                        </div>
                        <div class="content">
                            <div class="content-side">
                                <div class="content-left">
                                    <div class="content-image"><img src="/img/view_back_3.jpg"/></div>
                                    <div class="content-title">Can you help astronomers fint Planet</div>
                                </div>
                                <div class="content-right">
                                    <div class="content-image"><img src="/img/view_back_1.jpg"/></div>
                                    <div class="content-title">Apple wins Chinese IPhone 6 patent now</div>
                                </div>
                            </div>
                            <div class="content-side">
                                <div class="content-left">
                                    <div class="content-image"><img src="/img/view_back_2.jpg"/></div>
                                    <div class="content-title">Online Shopping for E-commerce</div>
                                </div>
                                <div class="content-right">
                                    <div class="content-image"><img src="/img/view_back_3.jpg"/></div>
                                    <div class="content-title">How to Pay with Cards</div>
                                </div>
                            </div>
                            <div class="content-side">
                                <div class="content-left">
                                    <div class="content-image"><img src="/img/view_back_4.jpg"/></div>
                                    <div class="content-title">How to make fast Delivery and do not Loose your Money?</div>
                                </div>
                                <div class="content-right">
                                    <div class="content-image"><img src="/img/view_back_2.jpg"/></div>
                                    <div class="content-title">Poligraphy Trends 2017</div>
                                </div>
                            </div>
                            <div class="content-side">
                                <div class="content-left">
                                    <div class="content-image"><img src="/img/view_back_3.jpg"/></div>
                                    <div class="content-title">Why are leggins so controversial?</div>
                                </div>
                                <div class="content-right">
                                    <div class="content-image"><img src="/img/view_back_1.jpg"/></div>
                                    <div class="content-title">British scientists in world-first TB</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="content-bottom">
                        <div class="content-side">
                            <div class="content-image"><img src="/img/view_back_4.jpg"/></div>
                            <div class="content-title">How to Make fast Delivery and do not Loose your Money?</div>
                        </div>
                        <div class="content-side">
                            <div class="content-image"><img src="/img/view_back_3.jpg"/></div>
                            <div class="content-title">Poligraphy Trends 2017</div>
                        </div>
                        <div class="content-side">
                            <div class="content-image"><img src="/img/view_back_1.jpg"/></div>
                            <div class="content-title">Vechicle Mashap Attorney Atlanta</div>
                        </div>
                        <div class="content-side">
                            <div class="content-image"><img src="/img/view_back_3.jpg"/></div>
                            <div class="content-title">Why Hashish Edibles?</div>
                        </div>
                        <div class="content-side">
                            <div class="content-image"><img src="/img/view_back_2.jpg"/></div>
                            <div class="content-title">How to Make fast Delivery and do not Loose your Money?</div>
                        </div>
                        <div class="content-side">
                            <div class="content-image"><img src="/img/view_back_2.jpg"/></div>
                            <div class="content-title">Poligraphy Trends 2017</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('script')
	@yield('script')
@endsection