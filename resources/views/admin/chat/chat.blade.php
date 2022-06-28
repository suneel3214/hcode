@extends('layouts.main')
@section('content')
<div class="">
    <div class="card chat-sidebar-container" data-sidebar-container="chat">
        <div class="chat-sidebar-wrap" data-sidebar="chat">
            <div class="border-right">
                <div class="pt-2 pb-2 pl-3 pr-3 d-flex align-items-center o-hidden box-shadow-1 chat-topbar"><a class="link-icon d-md-none" data-sidebar-toggle="chat"><i class="icon-regular ml-0 mr-3 i-Left"></i></a>
                    <div class="form-group m-0 flex-grow-1">
                        <input class="form-control form-control-rounded" id="search" type="text" placeholder="Search contacts" />
                    </div>
                </div>
                <div class="contacts-scrollable perfect-scrollbar">
                    {{-- @include('admin.chat.reccentUser') --}}
                    <span id="contectList">
                    	@include('admin.chat.contact')                    
                	</span>
                </div>
            </div>
        </div>
        <div class="chat-content-wrap" data-sidebar-content="chat">
            <span id="chatArea">
            	{{-- @include('admin.chat.chatarea') --}}
            </span>	
        </div>
    </div>
</div>

@endsection
