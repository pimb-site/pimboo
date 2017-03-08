@extends('page')

@section('css')
	@yield('css')
@endsection


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                	@yield('content')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
	@yield('script')
@endsection