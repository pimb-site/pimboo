@extends('app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">View trivia quiz</div>
                    <div class="posts">
                    @foreach ($contentflip as $value)
                        <div class="post">
                            <div class="photo"> <img class='testphoto' src="uploads/{!! $value->description_image !!}"> </div>
                            <div class="title"> <a href="viewID/{!! $value->id !!}">{!! $value->description_title !!} </a></div>
                            <div class="description"> {!! $value->description_text !!}</div>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection