<div class="d-flex pl-3 pr-3 pt-2 pb-2 o-hidden box-shadow-1 chat-topbar"><a class="link-icon d-md-none" data-sidebar-toggle="chat"><i class="icon-regular i-Right ml-0 mr-3"></i></a>
    <div class="d-flex align-items-center">
        <img class="avatar-sm rounded-circle mr-2" src="https://seller.hithere.co.nz/logo/user.png" alt="alt" />
        <p class="m-0 text-title text-16 flex-grow-1">{{$user->user->name}}</p>
        <input id="selectedUser" type="hidden" selected-user="{{$user->user->id}}">
    </div>
</div>
<div id="chatList124" style="overflow-y: scroll;" class="mukesh chat-content perfect-scrollbar" data-suppress-scroll-x="true">
    @foreach($messages as $Message)
        @if($Message->senderId === auth()->user()->id)
            <div class="d-flex mb-4 ">
                <div class="message flex-grow-1" style="margin-left: 30%; background-color: #e3e3ff;:">
                    <p class="m-0">{{$Message->message}}</p>
                    <span class="d-flex">
                        <span class="text-small text-muted">
                            <?php
                                $date1 = $Message->created_at;
                                $date2 = date('Y-m-d H:i:s');
                                $timestamp1 = strtotime($date1);
                                $timestamp2 = strtotime($date2);
                                $hour = ($timestamp2 - $timestamp1)/(60*60);
                                if(round($hour) < 25){
                                        if(round($hour) === 0){
                                            echo round($hour)  . " hour's ago";
                                        }
                                        else{
                                            if(date('i',($timestamp2 - $timestamp1)) < 1){
                                                echo 'just';
                                            }
                                            else{
                                                echo date('i',($timestamp2 - $timestamp1))." minute's ago";
                                            }
                                        }
                                }
                                else{
                                    $start = strtotime(date('Y-m-d'));
                                    $end = !empty($Message->created_at) ? strtotime($Message->created_at):strtotime(date('Y-m-d'));
                                
                                    $days_between = !empty($Message->created_at) ? ceil(abs($end - $start) / 86400) : 0;
                                    echo $days_between  . " day's ago";

                                }
                            ?>
                        </span>
                        <!-- <div class="seller-name text-16 "></div> -->
                    </span>
                </div>
           {{--      <img class="avatar-sm rounded-circle ml-3" src="https://demos.ui-lib.com/gull/dist-assets/images/faces/13.jpg" alt="alt" /> --}}
            </div>
        @else
            <div class="d-flex mb-4 user">
                {{-- <img class="avatar-sm rounded-circle mr-3" src="https://demos.ui-lib.com/gull/dist-assets/images/faces/1.jpg" alt="alt" /> --}}
                <div class="message flex-grow-1">
                        <p class="m-0">{{$Message->message}}</p>
                    <div class="d-flex">
                        <!-- <p class="mb-1 text-title text-16 flex-grow-1"></p> -->
                    </div>
                        <span class="text-small text-muted">
                            <?php
                                $date1 = $Message->created_at;
                                $date2 = date('Y-m-d H:i:s');
                                $timestamp1 = strtotime($date1);
                                $timestamp2 = strtotime($date2);
                                $hour = ($timestamp2 - $timestamp1)/(60*60);

                                if(round($hour) < 25){
                                    if(round($hour) < 1){
                                        if(date('i',($timestamp2 - $timestamp1)) < 1){
                                            echo 'just';
                                        }
                                        else{
                                            echo date('i',($timestamp2 - $timestamp1))." minute's ago";
                                        }
                                    }
                                    else{
                                        echo round($hour)  . " hour's ago";
                                    }
                                }
                                else{
                                    $start = strtotime(date('Y-m-d'));
                                    $end = !empty($Message->created_at) ? strtotime($Message->created_at):strtotime(date('Y-m-d'));
                                
                                    $days_between = !empty($Message->created_at) ? ceil(abs($end - $start) / 86400) : 0;
                                    echo $days_between  . " day's ago";

                                }
                            ?>
                            @if($Message->url)
                                <span style="margin-left:10px;" class="messageSentUrl"><a href="{{$Message->url}}" target="_blank">{{$Message->url}} </a></span>
                                </span>
                            @endif    
                </div>
            </div>    
        @endif    
    @endforeach    
</div>
<div class="pl-3 pr-3 pt-3 pb-3 box-shadow-1 chat-input-area">
    <form id="messageSendForm" class="row">
        <div class="form-group col-lg-11 col-md-11 col-sm-11">
            <input style="padding-top: 34px;padding-bottom: 34px;" class="form-control form-control-rounded" id="message" placeholder="Type your message" name="message" cols="30" rows="3">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1">
            <button style="margin-top: 15px;background: #6420ff !important;border-color: #6420ff;" chatroomId="{{$user->chatroom_id}}" senderId="{{auth::user()->id}}" UserId="{{$user->UserId}}" id="messageSend" class="btn btn-icon btn-rounded btn-primary mr-2"><i style="color: #fff;font-size: 20px;" class="nav-icon i-Paper-Plane text-black"></i></button>
            {{-- <button class="btn btn-icon btn-rounded btn-outline-primary" type="button"><i class="i-Add-File"></i></button> --}}
        </div>
    </form>    
</div>