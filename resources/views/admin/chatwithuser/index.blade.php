@extends('admin.layouts.main')
@section('content')

<div class="container">

    <!-- Page header start -->
    <div class="page-title">
        <div class="row gutters">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <h5 class="title"><a href="{{route('home')}}">Back to home</a></h5>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"> </div>
        </div>
    </div>
    <!-- Page header end -->

    <!-- Content wrapper start -->
    <div class="content-wrapper">
        <div class="row gutters card-body">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card m-0">
                    <div class="row no-gutters">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-3 col-3">
                            <div class="users-container">
                                <div class="chat-search-box">
                                    <div class="input-group">
                                        <input class="form-control" placeholder="Search">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-info">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <ul class="users">
                                    @foreach($users as $user)
                                    @php $stat = $user->is_terms ==1 ? 'online' : 'away'; @endphp
                                    <li class="person " id="user-id{{$user->id}}" data-chat="person2" data-id={{$user->id}} data-email={{$user->email}} data-name={{$user->name}}>
                                    {{-- <li class="person active-user" data-chat="person2"> --}}
                                        <div class="user">
                                            {{-- <span class={{$user->is_terms ==1 ? "logged-in" : "logged-out" }}>●</span> --}}
                                            <img src="https://www.bootdey.com/img/Content/avatar/avatar2.png" alt="{{$user->name}}">
                                            <span class="status user-status-icon user-icon-{{$user->id}}" {{-- id={{$stat}} --}}> </span>
                                        </div>
                                        <p class="name-time">
                                            <span class="name text-weight size-medium" style="font-size: 15px;">{{$user->name}}</span>
                                            <span class="time">{{date('H:i:s', strtotime($user->created_at))}}</span>
                                        </p>
                                    </li>
                                   @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-9 col-9">
                            <div class="selected-user mt-2">
                                <span>To: <span class="name name-selected-user"></span></span>
                            </div>
                            <div class="chat-container  chat-content">
                                <ul class="chat-box1 chatContainerScroll scroll ">
                                   
                                </ul>
                                <div class="form-group mt-3 mb-0 message-type" style="display: none;">
                                    <div class="chat-section">
                                        <div class="chat-box1">
                                            <div class="chat-input bg-white" ID="chatInput" contenteditable="">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="{{ asset('/css/chat.css') }}">

<script src="https://code.jquery.com/jquery-3.6.0.js" ></script>
<script src="https://cdn.socket.io/4.1.2/socket.io.min.js" integrity="sha384-toS6mmwu70G0fw54EGlWWeA4z3dyJ+dlXBtSURSKN4vyRFOcxd3Bzjj/AoOwY+Rg" crossorigin="anonymous"></script>

<script type="text/javascript">


const ip_address = 'localhost';
const port = '7000';
const socket = io(ip_address + ':' + port);
const auth_id ="{{ Auth::user()->id }}";

$('.person').on('click',function(){

    $('.message-type').show();

    const userId = $(this).attr("data-id")
    const senderName = $(this).attr("data-name")
   $('.name-selected-user').html(senderName)

    $('#user-id'+userId).addClass("active-user");
    // $('#user-id').removeClass("active-user");

    const name = 'User '+parseInt(Math.random()*10)
    const userEmail = $(this).attr("data-email")
    const userName = "{{ Auth::user()->name }}";
    var sellerId ="{{ Auth::user()->id }}";
    var sellerEmail ="{{ Auth::user()->email }}";
    
    socket.on('test');

    const chatInput = $('#chatInput');

    chatInput.keypress(function(e){

        const message = $(this).html();
        const data ={
            message:message,
            user_id:userId,
            email:sellerEmail,
            seller_id:sellerId,
            name:userName,

        }
        if (e.which===13 && !e.shiftKey) {
            socket.emit('message',data)
        
            chatInput.html('');

            return false;
        }
    });

    socket.on('sendtoclient',(data)=>{
        console.log(data.users)
        $.each(data.users, function(key,val){
            if (val !==null && val !==0) {
                if (userId == key) {
                    const ids = data.payload.email == sellerEmail ? 'chat-left' :'chat-right';
                    var now = new Date(Date.now());
                    var formatted = now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds();

                    $( ".chat-content ul" ).append( "<li class='"+ids+"'><div class='chat-avatar'><img src='https://www.bootdey.com/img/Content/avatar/avatar3.png' alt='Retail Admin'><div class='chat-name'>"+data.payload.name+"</div></div> <div class='chat-text'>"+data.payload.message+"</div><div class='chat-hour'>"+formatted+" <span class='fa fa-check-circle'></span></div></li>" );
                }
                // let $userIcon = $('.user-icon-'+key);
                // console.log('io'+key)
                // console.log('local'+userId)
                // $userIcon.addClass('text-success online');
                // $userIcon.attr('title','Online');
            }
        })

        // if(data.email == sellerEmail){
          
        // }

    })
      
})

socket.on('connect',()=>{
    socket.emit('user_connected',auth_id)
})
socket.on('updateUserStatus',(data)=>{
    // console.log(data)
    let $userStatusIcon = $('.user-status-icon')
    $userStatusIcon.removeClass('online');
     // $userStatusIcon.addClass('Away');
    $userStatusIcon.attr('title','Away');
    $.each(data, function(key,val){
        if (val !==null && val !==0) {
            let $userIcon = $('.user-icon-'+key);
            // console.log(key)
            $userIcon.addClass('text-success online');
            $userIcon.attr('title','Online');
        }
    })
})
// socket.on('broadcast',function(data){
//     $( ".chat-content ul" ).append( data );

// })
// socket.on('sendtoclient',(data)=>{
//     $(".status" ).addClass('away');
//     console.log(data)
// })

// socket.on('disconnect',()=>{
//     $(".status" ).addClass('offline');
//     console.log('lsfds')

// })

    // var userId = $(this).attr("data-id")
    // alert(userId)

$('.person').on('click',function(){
    var userId = $(this).attr("data-id")
    var userEmail = $(this).attr("data-email")
    let _url = '{{route('user_messages')}}';
    var token = '<?php echo csrf_token() ?>';

    $.ajax({
          url: _url,
          type: "POST",
          data: {
            "userId": userId,
            "_token": "{{ csrf_token() }}"
            },
           
          success: function(response) {
              if(response) {
                $( ".chat-content ul" ).empty('');
                $( ".chat-content ul" ).append( response );
              }
          }
        });

})


</script>
@endsection

