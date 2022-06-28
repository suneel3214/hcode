<!DOCTYPE html>
<html lang="en">
  
<!-- Mirrored from multipurposethemes.com/admin/riday-admin-template/bs4/main/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 27 Jun 2021 09:34:47 GMT -->
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="https://multipurposethemes.com/admin/riday-admin-template/bs4/images/favicon.ico">

    <title>HiThere</title>
    
    <!-- Vendors Style-->
    <link rel="stylesheet" href="{{asset('css/vendors_css.css')}}">
      
    <!-- Style-->  
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/skin_color.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/perfect-scrollbar@1.5.2/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/ycodetech/horizontal-timeline-2.0@2.0.5.3/css/horizontal_timeline.2.0_v2.0.5.2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.7.0/flexslider.min.css">
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css" integrity="sha512-Cv93isQdFwaKBV+Z4X8kaVBYWHST58Xb/jVOcV9aRsGSArZsgAnFIhMpDoMDcFNoUtday1hdjn0nGp3+KZyyFw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.min.css" integrity="sha512-QKC1UZ/ZHNgFzVKSAhV5v5j73eeL9EEN289eKAEFaAjgAiobVAnVv/AGuPbXsKl1dNoel3kNr6PYnSiTzVVBCw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.9.55/css/materialdesignicons.min.css" integrity="sha512-vIgFb4o1CL8iMGoIF7cYiEVFrel13k/BkTGvs0hGfVnlbV6XjAA0M0oEHdWqGdAVRTDID3vIZPOHmKdrMAUChA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.13/fc-3.2.2/fh-3.1.2/r-2.1.0/sc-1.4.2/datatables.min.css" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/duotone.css" integrity="sha384-R3QzTxyukP03CMqKFe0ssp5wUvBPEyy9ZspCB+Y01fEjhMwcXixTyeot+S40+AjZ" crossorigin="anonymous"/>
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/fontawesome.css" integrity="sha384-eHoocPgXsiuZh+Yy6+7DsKAerLXyJmu2Hadh4QYyt+8v86geixVYwFqUvMU8X90l" crossorigin="anonymous"/>
    <!-- Latest compiled JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/perfect-scrollbar@1.5.2/dist/perfect-scrollbar.common.min.js"></script> 
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.6.0/components/prism-css.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/3.2.2/js/dataTables.fixedColumns.min.js"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Acme&display=swap" rel="stylesheet">
  </head>

<body class="hold-transition light-skin sidebar-mini theme-danger fixed">
    
<div class="wrapper">
    <div id="loader"></div>
    
  <header class="main-header">
    <div class="d-flex align-items-center logo-box justify-content-start">
        <a href="#" class="waves-effect waves-light nav-link d-none d-md-inline-block mx-10 push-btn bg-transparent hover-primary" data-toggle="push-menu" role="button">
            <span class="icon-Align-left"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
        </a>    
        <!-- Logo -->
        <a href="index.html" class="logo">
          <!-- logo-->
          <div class="logo-lg" style="font-family: 'Acme', sans-serif;font-size: 28px;font-weight: 800;">
              <span class="light-logo">
                {{-- <img src="{{asset('/backend-images/logo-dark-text.png')}}" alt="logo"> --}}
                <span>
                  <span style="color: #000;">Hi</span> <span style="color: #fff;">There</span>
                </span>  
                {{-- <img src="https://multipurposethemes.com/admin/riday-admin-template/bs4/images/logo-dark-text.png" alt="logo"> --}}
              </span>
              <span class="dark-logo"><img src="{{asset('/backend-images/logo-light-text.png')}}" alt="logo"></span>
          </div>
        </a>    
    </div>  
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" style="float: right;">
      <!-- Sidebar toggle button-->
      <div class="app-menu">
        <ul class="header-megamenu nav">
            <li class="btn-group nav-item d-md-none">
                <a href="#" class="waves-effect waves-light nav-link push-btn btn-info-light" data-toggle="push-menu" role="button">
                    <span class="icon-Align-left"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
                </a>
            </li>
            <li class="btn-group nav-item d-none d-xl-inline-block">
                <div class="app-menu">
                    <div class="search-bx mx-5">
                        
                    </div>
                </div>
            </li>
        </ul> 
      </div>
        
      <div class="navbar-custom-menu r-side">
        <ul class="nav navbar-nav"> 
            {{-- <li class="btn-group nav-item d-lg-inline-flex d-none">
                <a href="#" data-provide="fullscreen" class="waves-effect waves-light nav-link full-screen btn-info-light" title="Full Screen">
                    <i class="icon-Expand-arrows"><span class="path1"></span><span class="path2"></span></i>
                </a>
            </li>   --}} 
          <!-- Notifications -->
          <li class="dropdown notifications-menu">
            <span class="label label-danger">5</span>
            <a href="#" class="waves-effect waves-light dropdown-toggle btn-danger-light" data-toggle="dropdown" title="Notifications">
              <i class="far fa-bell"><span class="path1"></span><span class="path2"></span></i>
            </a>
            <ul class="dropdown-menu animated bounceIn">

              <li class="header">
                <div class="p-20">
                    <div class="flexbox">
                        <div>
                            <h4 class="mb-0 mt-0">Notifications</h4>
                        </div>
                        <div>
                            <a href="#" class="text-danger">Clear All</a>
                        </div>
                    </div>
                </div>
              </li>

              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu sm-scrol">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-info"></i> Curabitur id eros quis nunc suscipit blandit.
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-warning"></i> Duis malesuada justo eu sapien elementum, in semper diam posuere.
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-danger"></i> Donec at nisi sit amet tortor commodo porttitor pretium a erat.
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-shopping-cart text-success"></i> In gravida mauris et nisi
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-user text-danger"></i> Praesent eu lacus in libero dictum fermentum.
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-user text-primary"></i> Nunc fringilla lorem 
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-user text-success"></i> Nullam euismod dolor ut quam interdum, at scelerisque ipsum imperdiet.
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer">
                  <a href="#">View all</a>
              </li>
            </ul>
          </li> 
          
          <!-- Messages -->
          <li class="dropdown messages-menu">
            <span class="label label-danger">5</span>
            <a href="#" class="dropdown-toggle btn-danger-light" data-toggle="dropdown" title="Messages">
              <i class="fas fa-envelope-open-text"><span class="path1"></span><span class="path2"></span></i>
            </a>
            <ul class="dropdown-menu animated bounceIn">

              <li class="header">
                <div class="p-20">
                    <div class="flexbox">
                        <div>
                            <h4 class="mb-0 mt-0">Messages</h4>
                        </div>
                        <div>
                            <a href="#" class="text-danger">Clear All</a>
                        </div>
                    </div>
                </div>
              </li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu sm-scrol">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <img src="{{asset('/backend-images/user2-128x128.jpg')}}" class="rounded-circle" alt="User Image">
                      </div>
                      <div class="mail-contnet">
                         <h4>
                          Lorem Ipsum
                          <small><i class="fa fa-clock-o"></i> 15 mins</small>
                         </h4>
                         <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
                      </div>
                    </a>
                  </li>
                  <!-- end message -->
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="{{asset('/backend-images/user3-128x128.jpg')}}" class="rounded-circle" alt="User Image">
                      </div>
                      <div class="mail-contnet">
                         <h4>
                          Nullam tempor
                          <small><i class="fa fa-clock-o"></i> 4 hours</small>
                         </h4>
                         <span>Curabitur facilisis erat quis metus congue viverra.</span>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="{{asset('/backend-images/user4-128x128.jpg')}}" class="rounded-circle" alt="User Image">
                      </div>
                      <div class="mail-contnet">
                         <h4>
                          Proin venenatis
                          <small><i class="fa fa-clock-o"></i> Today</small>
                         </h4>
                         <span>Vestibulum nec ligula nec quam sodales rutrum sed luctus.</span>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="{{asset('/backend-images/user3-128x128.jpg')}}" class="rounded-circle" alt="User Image">
                      </div>
                      <div class="mail-contnet">
                         <h4>
                          Praesent suscipit
                        <small><i class="fa fa-clock-o"></i> Yesterday</small>
                         </h4>
                         <span>Curabitur quis risus aliquet, luctus arcu nec, venenatis neque.</span>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="{{asset('/backend-images/user4-128x128.jpg')}}" class="rounded-circle" alt="User Image">
                      </div>
                      <div class="mail-contnet">
                         <h4>
                          Donec tempor
                          <small><i class="fa fa-clock-o"></i> 2 days</small>
                         </h4>
                         <span>Praesent vitae tellus eget nibh lacinia pretium.</span>
                      </div>

                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer">                 
                  <a href="#">See all e-Mails</a>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          {{-- <li class="btn-group nav-item">
              <span class="label label-primary">5</span>
              <a href="#" data-toggle="control-sidebar" title="Setting" class="waves-effect waves-light nav-link full-screen btn-primary-light">
                <i class="icon-Settings-2"></i>
              </a>
          </li>   --}}     
          <!-- Right Sidebar Toggle Button -->
          <li class="btn-group nav-item d-xl-none d-inline-flex">
              <a href="#" class="push-btn right-bar-btn waves-effect waves-light nav-link full-screen btn-info-light">
                <span class="icon-Layout-left-panel-1"><span class="path1"></span><span class="path2"></span></span>
              </a>
          </li>
          <!-- User Account-->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle p-0 text-dark hover-primary ml-md-30 ml-10" data-toggle="dropdown" title="User">
                <span class="pl-30 d-md-inline-block d-none">Hello,</span> <strong class="d-md-inline-block d-none">{{ Auth::user() ? Auth::user()->name :'11xdaz'}}</strong><img src="{{asset('/backend-images/avatar-11.png')}}" class="user-image rounded-circle avatar bg-white mx-10" alt="User Image">
            </a>
            <ul class="dropdown-menu animated flipInX">
              <li class="user-body">
                 <a class="dropdown-item" href="#"><i class="ti-user text-muted mr-2"></i> Profile</a>
                 <a class="dropdown-item" href="#"><i class="ti-wallet text-muted mr-2"></i> My Wallet</a>
                 <a class="dropdown-item" href="#"><i class="ti-settings text-muted mr-2"></i> Settings</a>
                 <div class="dropdown-divider"></div>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                    this.closest('form').submit();">
                       <i class="ti-lock text-muted mr-2"></i> Logout</a>
                        {{-- {{ __('Log Out') }} --}}
                    </a>
                </form>
                 {{-- <a class="dropdown-item" href="#"><i class="ti-lock text-muted mr-2"></i> Logout</a> --}}
              </li>
            </ul>
          </li> 
            
        </ul>
      </div>
    </nav>
  </header> 