@extends('layouts.app')

@section('content')

<div class="auth-layout-wrap" style="    background: radial-gradient(100.99% 100.73% at 0 0, rgba(0, 196, 204, 0.725916) 0, #00c4cc 0.01%, rgba(0, 196, 204, 0) 100%), radial-gradient(68.47% 129.02% at 22.82% 97.71%, #6420ff 0, rgba(100, 32, 255, 0) 100%), radial-gradient(106.1% 249.18% at 0 0, #00c4cc 0, rgba(0, 196, 204, 0) 100%), radial-gradient(64.14% 115.13% at 5.49% 50%, #6420ff 0, rgba(100, 32, 255, 0) 100%), #7d2ae7;">
    <div class="auth-content">
        <div class="card o-hidden">
            <div class="row">
                <div class="col-md-12">
                    <div class="p-4">
                        <div class="auth-logo" style="text-align: center;">
                            <img src="{{asset('/logo/logo12.png')}}" alt="">
                        </div>
                        <h1 class="mb-3 text-18">Sign In</h1>
                        @if($message = Session::get('success'))
                            <div class="alert alert-warning pull-right btn-sm">
                                {{$message}}
                            </div>
                        @endif
                        @if(Session::get('errorMessage'))
                            <div class="alert alert-warning pull-right btn-sm">
                                {{Session::get('errorMessage')}}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input class="form-control-rounded form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus id="email" type="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" type="password" class="form-control-rounded form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button style="    background: radial-gradient(100.99% 100.73% at 0 0, rgba(0, 196, 204, 0.725916) 0, #00c4cc 0.01%, rgba(0, 196, 204, 0) 100%), radial-gradient(68.47% 129.02% at 22.82% 97.71%, #6420ff 0, rgba(100, 32, 255, 0) 100%), radial-gradient(106.1% 249.18% at 0 0, #00c4cc 0, rgba(0, 196, 204, 0) 100%), radial-gradient(64.14% 115.13% at 5.49% 50%, #6420ff 0, rgba(100, 32, 255, 0) 100%), #7d2ae7;" class="btn btn-rounded btn-primary btn-block mt-2">Sign In</button>
                        </form>
                            <div class="form-group mt-1">
                                <span>Note - If you are already registered as a user via Google or Facebook. To become a seller please click on forgot password.</span>
                            </div>
                        <div class="row">
                            <div class="col-md-6 mt-3 text-right">
                                <a  class="text-muted" href="{{route('password.request')}}">
                                    <u>Forgot Password?</u>
                                </a>
                            </div>
                            <div class="col-md-6 mt-3 text-left">
                                <a  class="text-muted" href="{{route('email.verify')}}">
                                    <u>Resend Email Verification Link?</u>
                                </a>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"> </script> 
<script src="https://cdn.socket.io/4.3.2/socket.io.min.js" integrity="sha384-KAZ4DtjNhLChOB/hxXuKqhMLYvx3b5MlT55xPEiNmREKRzeEm+RVPlTnAn0ajQNs" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var socket = io('https://dashboard.hithere.co.nz:4000');
        socket.on("connect", () => {
            console.log('Connected laravel')
            
            socket.on("recivedMesage", (msg) => {
                var crntUser = parseInt($('#selectedUser').attr('selected-user'))
                msg.selectedUser = crntUser
                console.log(msg)
                $.ajax({
                    method:'post',
                    url:'/OutsaveMessages',
                    data:msg,
                    success:function(message){
                        getUserList()
                        var url = "https://dashboard.hithere.co.nz/sound/cool_chat_sound.mp3";
                        var audio = new Audio(url);
                        audio.play();
                        if(msg.senderId===crntUser){
                            $("#chatList124").append(message);
                                setTimeout(() => {
                                    var objDiv = document.getElementById('chatList124');
                                    objDiv.scrollTop = objDiv.scrollHeight
                                }, 10)
                        }
                            
                    }
                })
            });
        });
    })
</script>
@endsection
