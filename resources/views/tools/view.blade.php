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
                                    @if ($source_link)
                                        <a class="source_link" href="{{ $source_link }}">Link to source</a>
                                    @endif
                                </div>
                                <div class="buttons">
                                    <a href="" class="facebook"></a>
                                    <a href="" class="twitter"></a>
                                    <a href="" class="google_plus"></a>
                                    <a href="" class="linked_in"></a>
                                </div>
                            </div>
                            <div class="content">
                                @yield('tool_content')
                            </div>
                        </div>
                        <button class="report_button">REPORT POST</button>
                    </div>
                    <div class="right">
                        <div class="title">More from Pimboo</div>
                        <div class="more">
                            <a class="content">
                                <img src="/img/view_back_1.jpg">
                                <div class="name">Vechicle Mashap Attorney Atlanta</div>
                            </a>
                            <a class="content">
                                <img src="/img/view_back_2.jpg">
                                <div class="name">Why Hashish Edibles?</div>
                            </a>
                            <a class="content">
                                <img src="/img/view_back_3.jpg">
                                <div class="name">Online Shopping for E-commerce</div>
                            </a>
                            <a class="content">
                                <img src="/img/view_back_4.jpg">
                                <div class="name">How to Pay with Cards?</div>
                            </a>
                            <a class="content">
                                <img src="/img/view_back_5.jpg">
                                <div class="name">How to Make fast Delivery and do not Loose your Money?</div>
                            </a>
                            <a class="content">
                                <img src="/img/view_back_6.jpg">
                                <div class="name">Poligraphy Trends 2017</div>
                            </a>
                            <a class="content">
                                <img src="/img/view_back_1.jpg">
                                <div class="name">Vechicle Mashap Attorney Atlanta</div>
                            </a>
                            <a class="content">
                                <img src="/img/view_back_2.jpg">
                                <div class="name">Why Hashish Edibles?</div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="another_contents">
                    <a class="content">
                        <img src="/img/view_back_5.jpg">
                        <div class="name">How to Make fast Delivery and do not Loose your Money?</div>
                    </a>
                    <a class="content">
                        <img src="/img/view_back_6.jpg">
                        <div class="name">Poligraphy Trends 2017</div>
                    </a>
                    <a class="content">
                        <img src="/img/view_back_1.jpg">
                        <div class="name">Vechicle Mashap Attorney Atlanta</div>
                    </a>
                    <a class="content">
                        <img src="/img/view_back_2.jpg">
                        <div class="name">Why Hashish Edibles?</div>
                    </a>
                    <a class="content">
                        <img src="/img/view_back_5.jpg">
                        <div class="name">How to Make fast Delivery and do not Loose your Money?</div>
                    </a>
                    <a class="content">
                        <img src="/img/view_back_6.jpg">
                        <div class="name">Poligraphy Trends 2017</div>
                    </a>
                </div>
            </div>
        </div>
@endsection

@section('script')
	@yield('script')
@endsection