@extends('layouts.app')

@section('content')
<style>
    .hidden{
        display: none;
    }
    .show{
        display: none;
    }
    .backGroungColor{
        background: radial-gradient(100.99% 100.73% at 0 0, rgba(0, 196, 204, 0.725916) 0, #00c4cc 0.01%, rgba(0, 196, 204, 0) 100%), radial-gradient(68.47% 129.02% at 22.82% 97.71%, #6420ff 0, rgba(100, 32, 255, 0) 100%), radial-gradient(106.1% 249.18% at 0 0, #00c4cc 0, rgba(0, 196, 204, 0) 100%), radial-gradient(64.14% 115.13% at 5.49% 50%, #6420ff 0, rgba(100, 32, 255, 0) 100%), #7d2ae7;
    }

    .backGroungColor:hover{
        background: #6420ff !important;
    }
</style>
<div class="auth-layout-wrap" style="    background: radial-gradient(100.99% 100.73% at 0 0, rgba(0, 196, 204, 0.725916) 0, #00c4cc 0.01%, rgba(0, 196, 204, 0) 100%), radial-gradient(68.47% 129.02% at 22.82% 97.71%, #6420ff 0, rgba(100, 32, 255, 0) 100%), radial-gradient(106.1% 249.18% at 0 0, #00c4cc 0, rgba(0, 196, 204, 0) 100%), radial-gradient(64.14% 115.13% at 5.49% 50%, #6420ff 0, rgba(100, 32, 255, 0) 100%), #7d2ae7;">
    <div class="auth-content">
        <div class="card o-hidden">
            {{updateForfotPasswordUser()}}
            <div class="row">
                <div class="col-md-12">
                    <div class="p-4">
                        <div class="auth-logo text-center mb-4"><img src="{{asset('/logo/logo12.png')}}" alt=""></div>
                        <h1 class="mb-3 text-18 text-center">Reset Password</h1>

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="backGroungColor btn btn-primary">
                                        {{ __('Reset Password') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
