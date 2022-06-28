<!DOCTYPE html>
<html lang="en" dir="">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
   <link rel="icon" href="https://hithere.co.nz/static/img/favi.png" sizes="192x192">

    <title>Hithere - Marketplace for Kiwis</title>    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="https://demos.ui-lib.com/gull/dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />

    {{-- <link href="https://demos.ui-lib.com/gull/dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" /> --}}
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/lite.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/perfectscroll.css') }}" rel="stylesheet">

<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



</head>

<body class="text-left">
    <input type="hidden" id="pageNumber" value="{{auth()->user()->wallet}}">
    <div class="app-admin-wrap layout-sidebar-compact sidebar-dark-purple sidenav-open clearfix">
        @include('partials.sidebar')
         <!--=============== Left side End ================-->
         <div class="main-content-wrap d-flex flex-column">
            <div class="main-header">
                <div class="logo">
                </div>
                {{-- <div class="menu-toggle">
                    <div></div>
                    <div></div>
                    <div></div>
                </div> --}}
                <div class="d-flex align-items-center">
                    <!-- Mega menu -->
                    {{-- <div class="dropdown mega-menu d-none d-md-block">
                        <a href="#" class="btn text-muted dropdown-toggle mr-3" id="dropdownMegaMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mega Menu</a>
                        <div class="dropdown-menu text-left" aria-labelledby="dropdownMenuButton">
                            <div class="row m-0">
                                <div class="col-md-4 p-4 bg-img">
                                    <h2 class="title">Mega Menu <br> Sidebar</h2>
                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Asperiores natus laboriosam fugit, consequatur.
                                    </p>
                                    <p class="mb-4">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Exercitationem odio amet eos dolore suscipit placeat.</p>
                                    <button class="btn btn-lg btn-rounded btn-outline-warning">Learn More</button>
                                </div>
                                <div class="col-md-4 p-4">
                                    <p class="text-primary text--cap border-bottom-primary d-inline-block">Features</p>
                                    <div class="menu-icon-grid w-auto p-0">
                                        <a href="#"><i class="i-Shop-4"></i> Home</a>
                                        <a href="#"><i class="i-Library"></i> UI Kits</a>
                                        <a href="#"><i class="i-Drop"></i> Apps</a>
                                        <a href="#"><i class="i-File-Clipboard-File--Text"></i> Forms</a>
                                        <a href="#"><i class="i-Checked-User"></i> Sessions</a>
                                        <a href="#"><i class="i-Ambulance"></i> Support</a>
                                    </div>
                                </div>
                                <div class="col-md-4 p-4">
                                    <p class="text-primary text--cap border-bottom-primary d-inline-block">Components</p>
                                    <ul class="links">
                                        <li><a href="accordion.html">Accordion</a></li>
                                        <li><a href="alerts.html">Alerts</a></li>
                                        <li><a href="buttons.html">Buttons</a></li>
                                        <li><a href="badges.html">Badges</a></li>
                                        <li><a href="carousel.html">Carousels</a></li>
                                        <li><a href="lists.html">Lists</a></li>
                                        <li><a href="popover.html">Popover</a></li>
                                        <li><a href="tables.html">Tables</a></li>
                                        <li><a href="datatables.html">Datatables</a></li>
                                        <li><a href="modals.html">Modals</a></li>
                                        <li><a href="nouislider.html">Sliders</a></li>
                                        <li><a href="tabs.html">Tabs</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <!-- / Mega menu -->
                    {{-- <div class="search-bar">
                        <input type="text" placeholder="Search">
                        <i class="search-icon text-muted i-Magnifi-Glass1"></i>
                    </div> --}}
                </div>
                <div style="margin: auto"></div>
                <div class="header-part-right">
                    @role('seller')

                        <div>
                            <a  title="The wallet amount is total of only delivered product" class="text-white btn btn-primary ripple m-1 float-right">    
                               <span>Wallet</span> ${{auth()->user()->wallet}}
                            </a>
                        </div>
                       {{--  <div>
                            <a  class="text-white btn btn-danger ripple m-1 float-right">    
                               <span>Total Loss</span> ${{total_loss()}}
                            </a>
                        </div> 
                        <div>
                            <a  class="text-white btn btn-success ripple m-1 float-right">    
                               <span>Total Earn</span> ${{total_earn()}}
                            </a>
                        </div>  --}}
                        <div>
                            <a href="{{route('feedbackAndSupport')}}" class="text-white btn btn-primary ripple m-1 float-right">Feedback & Support</a>
                        </div> 
                        <div>
                            <a href="{{route('banner.create')}}" class="text-white btn btn-primary ripple m-1 float-right">Get Your Own Banner</a>
                        </div> 
                    @endrole       
                    <!-- Full screen toggle -->
                    <i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></i>
                    <!-- Grid menu Dropdown -->
                   {{--  <div class="dropdown">
                        <i class="i-Safe-Box text-muted header-icon" role="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <div class="menu-icon-grid">
                                <a href="#"><i class="i-Shop-4"></i> Home</a>
                                <a href="#"><i class="i-Library"></i> UI Kits</a>
                                <a href="#"><i class="i-Drop"></i> Apps</a>
                                <a href="#"><i class="i-File-Clipboard-File--Text"></i> Forms</a>
                                <a href="#"><i class="i-Checked-User"></i> Sessions</a>
                                <a href="#"><i class="i-Ambulance"></i> Support</a>
                            </div>
                        </div>
                    </div> --}}
                    <!-- Notificaiton -->
                    <div class="dropdown">
                        <div class="badge-top-container" role="button" id="dropdownNotification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="badge badge-warning text-white count" style="background-color:#6420ff">{{notiCount()}}</span>
                            <i class="i-Bell text-muted header-icon"></i>
                        </div>
                        <!-- Notification dropdown -->
                        <div class="dropdown-menu dropdown-menu-right notification-dropdown rtl-ps-none notificatin" aria-labelledby="dropdownNotification" data-perfect-scrollbar data-suppress-scroll-x="true">
                            {{notification()}}
                        </div>
                    </div>
                    <!-- Notificaiton End -->
                    <!-- User avatar dropdown -->
                    <div class="dropdown">
                        <div class="user col align-self-end">

                            <img src="{{userImage()}}" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                <div class="dropdown-header">
                                    <i class="i-Lock-User mr-1"></i> {{auth()->user()->name}}
                                </div>
                                <a href="{{route('edit_profile')}}" class="dropdown-item">Account settings</a>
                                <a href="{{route('addBankDetails')}}" class="dropdown-item">Save Bank Details</a>
                                    <a href="{{route('logout')}}" class="dropdown-item" 
                                        >
                                       Sign out
                                   </a>
                                        {{-- {{ __('Log Out') }} --}}
                                    </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ Body content start ============= -->
            <div class="main-content">
                @if(!allFieldRequired())
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-bell mr-1"> </i>{{'Please complete your profile basic details! After that you can add product'}}
                        <a href="/edit_profile">click here</a>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                @endif
                @if(!acountDetails())    
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-bell mr-1"> </i>{{'Please complete your profile for timely payout!'}}
                        <a href="/add_bank_details">click here</a>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                @endif 
                @if(pendingOrder())    
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-bell mr-1"> </i>{{'You have some pending orders!'}}
                        <a href="/orders">click here</a>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                @endif
                @if(productReviewMsg())    
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-bell mr-1"> </i>{{'Thanks for uploading your first product. Our team will review your first product and status will change automatically. Moving forward you will be able to change status by yourself.!'}}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                @endif    
                <!-- MAIN SIDEBAR CONTAINER-->
                @yield('content')                
            </div>
        </div>
        <!-- Edit Modal -->
        <div class="modal fade closeModal" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Notification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body modalData">
                
              </div>
            </div>
          </div>
        </div>
    </div>  
    <script src="https://code.jquery.com/jquery-3.6.0.js" ></script>
    <script src="{{ asset('js/notify.min.js') }}" defer></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <script>

        function notificationAndCount(){
            $.ajax({
                    method:'get',
                    url:'/notifications',
                    success:function(res){
                       $('.notificatin').html(res.noti)
                       $('.count').text(res.count)
                    }
                })
        }
        $(document).ready(function(){        

            Pusher.logToConsole = true;
            var pusher = new Pusher('2251ddd9f2ee53cbe0ba', {
              cluster: 'ap2'    
            });
            function getCount(){
                console.log({{notiCount()}})
            }            

            var channel = pusher.subscribe('my-channel');
            channel.bind('my-event', function(data) {
                console.log('noti',data)
                $.ajax({
                    method:'get',
                    url:'/notifications',
                    success:function(res){
                        $.notify("You have recived new notification", "info");
                        var url = "https://dashboard.hithere.co.nz/sound/Notification.mp3";
                        var audio = new Audio(url);
                        audio.play();
                       $('.notificatin').html(res.noti)
                       $('.count').text(res.count)
                    }
                })
            });
        })

        function notiList(){
            $.ajax({
                method:'get',
                url:'/notifications_list',
                success:function(res){   
                    $('.modalData').html(res)
                    $('#addModal').modal('show')
                }
            })
        }   

        $(document).on('click','.allNotifications',function(){
            $.ajax({
                method:'get',
                url:'/notifications_list',
                success:function(res){   
                    $('.modalData').html(res)
                    $('#addModal').modal('show')
                }
            })
         })

        $(document).on('click','.read',function(){
            var id = $(this).attr('data-id')
            $.ajax({
                method:'get',
                url:'/notifications_reat/'+id,
                success:function(res){   
                    notificationAndCount()   
                          
                    $('.modalData').html(res)
                    // $('#addModal').modal('show')
                }
            })
         })

        $(document).on('click','.action',function(){
            var type = $(this).attr('data-type')
            var notifiId = $(this).attr('data-id')
            var orderid = $(this).attr('data-orderid')
            var desc=''
            if(type==='reject'){
                desc = prompt('Why you are reject this order');
            }    
            var data={
                'id':orderid,
                status:type,
                desc:desc,
                notifiId:notifiId
            }
            $.ajax({
                method:'post',
                url:'noti_orders_status/',
                data:data,
                success:function(res){   
                    notificationAndCount()   
                    setTimeout(()=>{
                         notiList()  
                     },200)
                    $('.modalData').html(res)
                    // $('#addModal').modal('show')
                }
            })
         })

    </script>