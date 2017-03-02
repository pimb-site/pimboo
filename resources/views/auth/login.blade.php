@extends('page')

@section('content')
        <div class="login">
            <div class="wrap">
                <div class="title">LOGIN</div>
                <div class="form">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">   
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="email" name="email" placeholder="E-mail" value="{{ old('email') }}">
                        <input type="password" name="password" placeholder="Password">
                        <label><input class="checkbox" type="checkbox" name="remember"><span class="checkbox-custom"></span><span class="label">Remember me</span></label>
                        @if (count($errors) > 0)
                            <div class="alerts">
                                @foreach ($errors->all() as $error)
                                        <div class="alert">{{ $error }}</div>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <button>LOGIN</button>
                        <a href="/password/reset">Forgot your password?</a>
                    </form>
                </div>
            </div>
        </div>
@endsection