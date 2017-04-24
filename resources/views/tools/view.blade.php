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
                                    <button class="butt-for-sharing facebook"></button>
                                    <button class="butt-for-sharing twitter"></button>
                                    <button class="butt-for-sharing google_plus"></button>
                                    <button class="butt-for-sharing linked_in"></button>
                                    <button class="get_link">GET LINK</button>
                                </div>
                            </div>
                            <div class="content">
                                @yield('tool_content')
                            </div>
                        </div>
                        <button class="report_button" data-toggle="modal" data-target="#myModal">REPORT POST</button>
                        <div class="modal reports" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">Report Post</h4>
                              </div>
                              <div class="modal-body">
                                <input type="radio" id="report_type1" name="report_type" value="It's rude, vulgar or uses bad language" checked><label for="report_type1"><span></span>It's rude, vulgar or uses bad language</label><br>
                                <input type="radio" id="report_type2" name="report_type" value="It's sexually explicit"><label for="report_type2"><span></span>It's sexually explicit</label><br>
                                <input type="radio" id="report_type3" name="report_type" value="It's harassment or hate speech"><label for="report_type3"><span></span>It's harassment or hate speech</label><br>
                                <input type="radio" id="report_type4" name="report_type" value="It's threatening, violent or suicidal"><label for="report_type4"><span></span>It's threatening, violent or suicidal</label><br>
                                <input type="radio" id="report_type5" name="report_type" value="File a DMCA Request/Copyright Violation"><label for="report_type5"><span></span>File a DMCA Request/Copyright Violation</label><br>
                                <input type="radio" id="report_type6" name="report_type" value="Something else"><label for="report_type6"><span></span>Something else</label><br>
                              </div>
                              <div class="modal-footer">
                                <button id="report-submit-btn" type="button" class="btn btn-primary" data-dismiss="modal">SUBMIT</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal reports" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                              </div>
                              <div class="modal-body">
                                <div class="head">Thank You!</div>
                                <div class="sub-head">Thank you for reporting your data!</div>
                                <div class="text">If you want to include your email address so as to have direct contact with administrators of Pimboo.com please enter it in below and click the green arrow. Otherwise click "cancel" to close.</div>
                                <input type="hidden" id="report_id" name="report_id">
                                <div class="mailer">
                                    <input placeholder="Email Address" id="report_mail" name="report_mail">
                                    <button id="mail-submit"><img src="/wp-content/themes/PricerrTheme/images/report-mail-arrow.png"></button><span class="optional">(optional)</span>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">CANCEL</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <script type="text/javascript">
                            post_id = '{{ $content->id }}';
                            _token = '{{ csrf_token() }}';
                        </script>
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