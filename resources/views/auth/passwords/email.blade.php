@extends('app')

@section('page_title') Reset Password @endsection
@section('auth-content')
    <div class="height-10 w-100 shadow-lg px-4 bg-brand-gradient">
        <div class="d-flex align-items-center container p-0">
            @include('header')
            @if (Route::has('password.request'))
                <a class="btn btn-link text-white ml-auto" href="{{ route('login') }}">
                    {{ __('Remembered Password?') }}
                </a>
            @endif
        </div>
    </div>
    <div class="flex-1" style="background: url(img/svg/pattern-1.svg) no-repeat center bottom fixed; background-size: cover;">
        <div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0">
            <div class="row">
                <div class="col col-md-6 col-lg-7 hidden-sm-down">
                    <h2 class="fs-xxl fw-500 mt-4 text-white">
                        The simplest UI toolkit for developers &amp; programmers
                        <small class="h3 fw-300 mt-3 mb-5 text-white opacity-60">
                            Presenting you with the next level of innovative UX design and engineering. The most modular toolkit available with over 600+ layout permutations. Experience the simplicity of SmartAdmin, everywhere you go!
                        </small>
                    </h2>
                    <a href="#" class="fs-lg fw-500 text-white opacity-70">Learn more &gt;&gt;</a>
                    <div class="d-sm-flex flex-column align-items-center justify-content-center d-md-block">
                        <div class="px-0 py-1 mt-5 text-white fs-nano opacity-50">
                            Find us on social media
                        </div>
                        <div class="d-flex flex-row opacity-70">
                            <a href="#" class="mr-2 fs-xxl text-white">
                                <i class="fab fa-facebook-square"></i>
                            </a>
                            <a href="#" class="mr-2 fs-xxl text-white">
                                <i class="fab fa-twitter-square"></i>
                            </a>
                            <a href="#" class="mr-2 fs-xxl text-white">
                                <i class="fab fa-google-plus-square"></i>
                            </a>
                            <a href="#" class="mr-2 fs-xxl text-white">
                                <i class="fab fa-linkedin"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-5 col-xl-4 ml-auto">
                    <h1 class="text-white fw-300 mb-3 d-sm-block">
                        Secure Reset Password
                    </h1>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="card p-4 rounded-plus bg-faded">
                        <form id="js-login" novalidate="" method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="form-group">
                                <label class="form-label" for="username">Your Email Address</label>
                                <input id="login" type="email" placeholder="Enter Email" class="form-control form-control-md @error('email') is-invalid @enderror" name="login" value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>
                            <div class="row no-gutters">
                                <div class="col-lg-12 pr-lg-1 my-2">
                                    <button type="submit" class="btn btn-danger btn-block btn-md">
                                        {{ __('Send Password Reset Link') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

