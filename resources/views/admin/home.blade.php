@extends('admin.layouts.main')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <div class="container-full">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xxxl-3 col-lg-6 col-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="d-flex align-items-start">
                                <div>
                                    <img src="{{asset('/backend-images/online-order-1.png')}}" class="w-80 mr-20" alt="" />
                                </div>
                                <div>
                                    <h2 class="my-0 font-weight-700">89</h2>
                                    <p class="text-fade mb-0">Total Order</p>
                                    <p class="font-size-12 mb-0 text-success"><span class="badge badge-pill badge-success-light mr-5"><i class="fa fa-arrow-up"></i></span>3% (15 Days)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-3 col-lg-6 col-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="d-flex align-items-start">
                                <div>
                                    <img src="{{asset('/backend-images/online-order-2.png')}}" class="w-80 mr-20" alt="" />
                                </div>
                                <div>
                                    <h2 class="my-0 font-weight-700">899</h2>
                                    <p class="text-fade mb-0">Total Delivered</p>
                                    <p class="font-size-12 mb-0 text-success"><span class="badge badge-pill badge-success-light mr-5"><i class="fa fa-arrow-up"></i></span>8% (15 Days)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-3 col-lg-6 col-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="d-flex align-items-start">
                                <div>
                                    <img src="{{asset('/backend-images/online-order-3.png')}}" class="w-80 mr-20" alt="" />
                                </div>
                                <div>
                                    <h2 class="my-0 font-weight-700">59</h2>
                                    <p class="text-fade mb-0">Total Canceled</p>
                                    <p class="font-size-12 mb-0 text-primary"><span class="badge badge-pill badge-primary-light mr-5"><i class="fa fa-arrow-down"></i></span>2% (15 Days)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-3 col-lg-6 col-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="d-flex align-items-start">
                                <div>
                                    <img src="{{asset('/backend-images/online-order-4.png')}}" class="w-80 mr-20" alt="" />
                                </div>
                                <div>
                                    <h2 class="my-0 font-weight-700">$789k</h2>
                                    <p class="text-fade mb-0">Total Revenue</p>
                                    <p class="font-size-12 mb-0 text-primary"><span class="badge badge-pill badge-primary-light mr-5"><i class="fa fa-arrow-down"></i></span>12% (15 Days)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-7 col-xl-6 col-lg-6 col-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="box-title mb-0">Daily Revenue</h4>
                                    <p class="mb-0 text-mute">Lorem ipsum dolor</p>
                                </div>
                                <div class="text-right">
                                    <h3 class="box-title mb-0 font-weight-700">$ 154K</h3>
                                    <p class="mb-0"><span class="text-success">+ 1.5%</span> than last week</p>
                                </div>
                            </div>
                            <div id="chart" class="mt-20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-5 col-xl-6 col-lg-6 col-12">
                    <div class="box">
                        <div class="box-body">
                            <h4 class="box-title">Customer Flow</h4>
                            <div class="d-md-flex d-block justify-content-between">
                                <div>
                                    <h3 class="mb-0 font-weight-700">$2,780k</h3>
                                    <p class="mb-0 text-primary"><small>In Restaurant</small></p>
                                </div>
                                <div>
                                    <h3 class="mb-0 font-weight-700">$1,410k</h3>
                                    <p class="mb-0 text-danger"><small>Online Order</small></p>
                                </div>
                            </div>
                            <div id="yearly-comparison"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="box bg-transparent no-shadow">
                        <div class="box-header pt-0 px-0">
                            <h4 class="box-title">
                                Customer Review
                            </h4>
                        </div>
                        <div class="box-body px-0">
                            <div class="review-slider owl-carousel">
                                <div class="box p-0">
                                    <div class="box-body">
                                        <div class="d-flex align-items-center">
                                            <div class="review-tx">
                                                <div class="d-flex mb-10">
                                                    <img src="{{asset('/backend-images/1.jpg')}}" class="w-40 h-40 mr-10 rounded100" alt="" />
                                                    <div>
                                                        <p class="mb-0">Johen Doe</p>
                                                        <p class="mb-0"><small class="text-mute">1 day ago</small></p>
                                                    </div>
                                                </div>
                                                <p class="mb-10">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.. </p>
                                                <div class="d-flex text-warning align-items-center">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-half-empty"></i>
                                                    <span class="text-fade ml-10">4.5</span>
                                                </div>
                                            </div>
                                            <img src="{{asset('/backend-images/dish-1.png')}}" class="dish-img" alt="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="box p-0">
                                    <div class="box-body">
                                        <div class="d-flex align-items-center">
                                            <div class="review-tx">
                                                <div class="d-flex mb-10">
                                                    <img src="{{asset('/backend-images/avatar-11.png')}}https://multipurposethemes.com/admin/riday-admin-template/bs4/images/avatar/2.jpg" class="w-40 h-40 mr-10 rounded100" alt="" />
                                                    <div>
                                                        <p class="mb-0">Mical Doe</p>
                                                        <p class="mb-0"><small class="text-mute">2 day ago</small></p>
                                                    </div>
                                                </div>
                                                <p class="mb-10">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.. </p>
                                                <div class="d-flex text-warning align-items-center">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-half-empty"></i>
                                                    <span class="text-fade ml-10">4.5</span>
                                                </div>
                                            </div>
                                            <img src="{{asset('/backend-images/dish-2.png')}}" class="dish-img" alt="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="box p-0">
                                    <div class="box-body">
                                        <div class="d-flex align-items-center">
                                            <div class="review-tx">
                                                <div class="d-flex mb-10">
                                                    <img src="{{asset('/backend-images/3.jpg')}}" class="w-40 h-40 mr-10 rounded100" alt="" />
                                                    <div>
                                                        <p class="mb-0">Stepni Doe</p>
                                                        <p class="mb-0"><small class="text-mute">3 day ago</small></p>
                                                    </div>
                                                </div>
                                                <p class="mb-10">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.. </p>
                                                <div class="d-flex text-warning align-items-center">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-half-empty"></i>
                                                    <span class="text-fade ml-10">4.5</span>
                                                </div>
                                            </div>
                                            <img src="{{asset('/backend-images/dish-3.png')}}" class="dish-img" alt="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="box p-0">
                                    <div class="box-body">
                                        <div class="d-flex align-items-center">
                                            <div class="review-tx">
                                                <div class="d-flex mb-10">
                                                    <img src="{{asset('/backend-images/4.jpg')}}" class="w-40 h-40 mr-10 rounded100" alt="" />
                                                    <div>
                                                        <p class="mb-0">Rehan Doe</p>
                                                        <p class="mb-0"><small class="text-mute">4 day ago</small></p>
                                                    </div>
                                                </div>
                                                <p class="mb-10">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.. </p>
                                                <div class="d-flex text-warning align-items-center">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-half-empty"></i>
                                                    <span class="text-fade ml-10">4.5</span>
                                                </div>
                                            </div>
                                            <img src="{{asset('/backend-images/dish-4.png')}}" class="dish-img" alt="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="box p-0">
                                    <div class="box-body">
                                        <div class="d-flex align-items-center">
                                            <div class="review-tx">
                                                <div class="d-flex mb-10">
                                                    <img src="{{asset('/backend-images/5.jpg')}}" class="w-40 h-40 mr-10 rounded100" alt="" />
                                                    <div>
                                                        <p class="mb-0">Himesh Doe</p>
                                                        <p class="mb-0"><small class="text-mute">1 day ago</small></p>
                                                    </div>
                                                </div>
                                                <p class="mb-10">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.. </p>
                                                <div class="d-flex text-warning align-items-center">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-half-empty"></i>
                                                    <span class="text-fade ml-10">4.5</span>
                                                </div>
                                            </div>
                                            <img src="{{asset('/backend-images/dish-5.png')}}" class="dish-img" alt="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-5 col-12">
                    <div class="box">
                        <div class="box-header no-border">
                            <h4 class="box-title">
                                Trending Keyword
                                <small class="subtitle">Lorem ipsum dolor sit amet, consectetur adipisicing elit</small>
                            </h4>
                        </div>
                        <div class="box-body pt-0">
                            <div>
                                <div class="progress mb-5">
                                    <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="text-primary">#paneer</p>
                                    <p class="text-mute">420 times</p>
                                </div>
                            </div>
                            <div>
                                <div class="progress mb-5">
                                    <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="text-primary">#breakfast</p>
                                    <p class="text-mute">150 times</p>
                                </div>
                            </div>
                            <div>
                                <div class="progress mb-5">
                                    <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="text-primary">#tea</p>
                                    <p class="text-mute">120 times</p>
                                </div>
                            </div>
                        </div>
                        <div class="box-body pt-0">
                            <h4 class="box-title d-block">
                                Others Tag
                            </h4>
                            <div class="d-inline-block">
                                <a href="#" class="waves-effect waves-light btn btn-outline btn-rounded btn-primary mb-5">#panjabifood</a>
                                <a href="#" class="waves-effect waves-light btn btn-outline btn-rounded btn-primary mb-5">#chainissfood</a>
                                <a href="#" class="waves-effect waves-light btn btn-outline btn-rounded btn-primary mb-5">#pizza</a>
                                <a href="#" class="waves-effect waves-light btn btn-outline btn-rounded btn-primary mb-5">#burgar</a>
                                <a href="#" class="waves-effect waves-light btn btn-outline btn-rounded btn-primary mb-5">#coffee</a>
                                <a href="#" class="waves-effect waves-light btn btn-outline btn-rounded btn-primary mb-5">20+</a>
                            </div>
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-header no-border">
                            <h4 class="box-title">
                                Today's Special
                            </h4>
                        </div>
                        <div class="box-body pt-0">
                            <div class="mb-5">
                                <img class="rounded img-fluid" src="{{asset('/backend-images/aimg1.jpg')}}"  alt="">
                            </div>
                            <div class="info-content">
                                <h5 class="my-15"><a href="ecommerce_details.html">Spicy Pizza with Extra Cheese</a></h5>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="mb-0 text-black">$6.53</h4>
                                    <div class="d-flex align-items-center"> 
                                        <i class="fa fa-heart text-primary"></i>
                                        <h6 class="text-black mb-0">256k</h6>
                                    </div>
                                </div>
                            </div>
                        </div>                      
                    </div>
                </div>
                <div class="col-xxxl-7 col-12">
                    <div class="box">
                        <div class="box-header no-border pb-0">
                            <h4 class="box-title">Delivery Map</h4>
                        </div>
                        <div class="box-body">
                            <div id="chartdiv" class="h-400"></div>
                            <div class="pt-30">
                                <h4 class="box-title mb-20">Upcoming Shipping Schedule</h4>
                                <div class="bb-1 pb-10 mb-20 d-lg-flex d-block justify-content-between">
                                    <div class="d-flex">
                                        <img src="{{asset('/backend-images/4.jpg')}}" class="w-40 h-40 mr-10 rounded100" alt="">
                                        <div>
                                            <p class="mb-0">Stepni Doe <span class="text-primary ml-10">(3 items)</span></p>
                                            <p class="mb-0"><small class="text-mute">will be shipping on 10:12 am</small></p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <p class="mb-0 mr-10">8817 Sand Pine Dr, Navarre, FL, 32566</p>
                                        <div class="bg-info rounded-circle w-30 h-30 l-h-30 text-center">
                                            <i class="fa fa-location-arrow"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="bb-1 pb-10 mb-20  d-lg-flex d-block justify-content-between">
                                    <div class="d-flex">
                                        <img src="{{asset('/backend-images/5.jpg')}}" class="w-40 h-40 mr-10 rounded100" alt="">
                                        <div>
                                            <p class="mb-0">Mical clark <span class="text-primary ml-10">(2 items)</span></p>
                                            <p class="mb-0"><small class="text-mute">will be shipping on 12:12 am</small></p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <p class="mb-0 mr-10">8817 Sand Pine Dr, Navarre, FL, 32566</p>
                                        <div class="bg-info rounded-circle w-30 h-30 l-h-30 text-center">
                                            <i class="fa fa-location-arrow"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="bb-1 pb-10  d-lg-flex d-block justify-content-between">
                                    <div class="d-flex">
                                        <img src="{{asset('/backend-images/7.jpg')}}" class="w-40 h-40 mr-10 rounded100" alt="">
                                        <div>
                                            <p class="mb-0">Steponi mohan <span class="text-primary ml-10">(7 items)</span></p>
                                            <p class="mb-0"><small class="text-mute">will be shipping on 11:12 am</small></p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <p class="mb-0 mr-10">8817 Sand Pine Dr, Navarre, FL, 32566</p>
                                        <div class="bg-info rounded-circle w-30 h-30 l-h-30 text-center">
                                            <i class="fa fa-location-arrow"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
      </div>
  </div>
  <!-- /.content-wrapper -->
 
  
    
 
  <!-- Control Sidebar -->
  <aside class="control-sidebar">
      
    <div class="rpanel-title"><span class="pull-right btn btn-circle btn-danger"><i class="ion ion-close text-white" data-toggle="control-sidebar"></i></span> </div>  <!-- Create the tabs -->
    <ul class="nav nav-tabs control-sidebar-tabs">
      <li class="nav-item"><a href="#control-sidebar-home-tab" data-toggle="tab" class="active"><i class="mdi mdi-message-text"></i></a></li>
      <li class="nav-item"><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="mdi mdi-playlist-check"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane active" id="control-sidebar-home-tab">
          <div class="flexbox">
            <a href="javascript:void(0)" class="text-grey">
                <i class="ti-more"></i>
            </a>    
            <p>Users</p>
            <a href="javascript:void(0)" class="text-right text-grey"><i class="ti-plus"></i></a>
          </div>
          <div class="lookup lookup-sm lookup-right d-none d-lg-block">
            <input type="text" name="s" placeholder="Search" class="w-p100">
          </div>
          <div class="media-list media-list-hover mt-20">
            <div class="media py-10 px-0">
              <a class="avatar avatar-lg status-success" href="#">
                <img src="{{asset('/backend-images/1.jpg')}}" alt="...">
              </a>
              <div class="media-body">
                <p class="font-size-16">
                  <a class="hover-primary" href="#"><strong>Tyler</strong></a>
                </p>
                <p>Praesent tristique diam...</p>
                  <span>Just now</span>
              </div>
            </div>

            <div class="media py-10 px-0">
              <a class="avatar avatar-lg status-danger" href="#">
                <img src="{{asset('/backend-images/2.jpg')}}" alt="...">
              </a>
              <div class="media-body">
                <p class="font-size-16">
                  <a class="hover-primary" href="#"><strong>Luke</strong></a>
                </p>
                <p>Cras tempor diam ...</p>
                  <span>33 min ago</span>
              </div>
            </div>

            <div class="media py-10 px-0">
              <a class="avatar avatar-lg status-warning" href="#">
                <img src="{{asset('/backend-images/3.jpg')}}" alt="...">
              </a>
              <div class="media-body">
                <p class="font-size-16">
                  <a class="hover-primary" href="#"><strong>Evan</strong></a>
                </p>
                <p>In posuere tortor vel...</p>
                  <span>42 min ago</span>
              </div>
            </div>

            <div class="media py-10 px-0">
              <a class="avatar avatar-lg status-primary" href="#">
                <img src="{{asset('/backend-images/4.jpg')}}" alt="...">
              </a>
              <div class="media-body">
                <p class="font-size-16">
                  <a class="hover-primary" href="#"><strong>Evan</strong></a>
                </p>
                <p>In posuere tortor vel...</p>
                  <span>42 min ago</span>
              </div>
            </div>          
            
            <div class="media py-10 px-0">
              <a class="avatar avatar-lg status-success" href="#">
                <img src="{{asset('/backend-images/1.jpg')}}" alt="...">
              </a>
              <div class="media-body">
                <p class="font-size-16">
                  <a class="hover-primary" href="#"><strong>Tyler</strong></a>
                </p>
                <p>Praesent tristique diam...</p>
                  <span>Just now</span>
              </div>
            </div>

            <div class="media py-10 px-0">
              <a class="avatar avatar-lg status-danger" href="#">
                <img src="{{asset('/backend-images/2.jpg')}}" alt="...">
              </a>
              <div class="media-body">
                <p class="font-size-16">
                  <a class="hover-primary" href="#"><strong>Luke</strong></a>
                </p>
                <p>Cras tempor diam ...</p>
                  <span>33 min ago</span>
              </div>
            </div>

            <div class="media py-10 px-0">
              <a class="avatar avatar-lg status-warning" href="#">
                <img src="{{asset('/backend-images/3.jpg')}}" alt="...">
              </a>
              <div class="media-body">
                <p class="font-size-16">
                  <a class="hover-primary" href="#"><strong>Evan</strong></a>
                </p>
                <p>In posuere tortor vel...</p>
                  <span>42 min ago</span>
              </div>
            </div>

            <div class="media py-10 px-0">
              <a class="avatar avatar-lg status-primary" href="#">
                <img src="{{asset('/backend-images/4.jpg')}}" alt="...">
              </a>
              <div class="media-body">
                <p class="font-size-16">
                  <a class="hover-primary" href="#"><strong>Evan</strong></a>
                </p>
                <p>In posuere tortor vel...</p>
                  <span>42 min ago</span>
              </div>
            </div>
              
          </div>

      </div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
          <div class="flexbox">
            <a href="javascript:void(0)" class="text-grey">
                <i class="ti-more"></i>
            </a>    
            <p>Todo List</p>
            <a href="javascript:void(0)" class="text-right text-grey"><i class="ti-plus"></i></a>
          </div>
        <ul class="todo-list mt-20">
            <li class="py-15 px-5 by-1">
              <!-- checkbox -->
              <input type="checkbox" id="basic_checkbox_1" class="filled-in">
              <label for="basic_checkbox_1" class="mb-0 h-15"></label>
              <!-- todo text -->
              <span class="text-line">Nulla vitae purus</span>
              <!-- Emphasis label -->
              <small class="badge bg-danger"><i class="fa fa-clock-o"></i> 2 mins</small>
              <!-- General tools such as edit or delete-->
              <div class="tools">
                <i class="fa fa-edit"></i>
                <i class="fa fa-trash-o"></i>
              </div>
            </li>
            <li class="py-15 px-5">
              <!-- checkbox -->
              <input type="checkbox" id="basic_checkbox_2" class="filled-in">
              <label for="basic_checkbox_2" class="mb-0 h-15"></label>
              <span class="text-line">Phasellus interdum</span>
              <small class="badge bg-info"><i class="fa fa-clock-o"></i> 4 hours</small>
              <div class="tools">
                <i class="fa fa-edit"></i>
                <i class="fa fa-trash-o"></i>
              </div>
            </li>
            <li class="py-15 px-5 by-1">
              <!-- checkbox -->
              <input type="checkbox" id="basic_checkbox_3" class="filled-in">
              <label for="basic_checkbox_3" class="mb-0 h-15"></label>
              <span class="text-line">Quisque sodales</span>
              <small class="badge bg-warning"><i class="fa fa-clock-o"></i> 1 day</small>
              <div class="tools">
                <i class="fa fa-edit"></i>
                <i class="fa fa-trash-o"></i>
              </div>
            </li>
            <li class="py-15 px-5">
              <!-- checkbox -->
              <input type="checkbox" id="basic_checkbox_4" class="filled-in">
              <label for="basic_checkbox_4" class="mb-0 h-15"></label>
              <span class="text-line">Proin nec mi porta</span>
              <small class="badge bg-success"><i class="fa fa-clock-o"></i> 3 days</small>
              <div class="tools">
                <i class="fa fa-edit"></i>
                <i class="fa fa-trash-o"></i>
              </div>
            </li>
            <li class="py-15 px-5 by-1">
              <!-- checkbox -->
              <input type="checkbox" id="basic_checkbox_5" class="filled-in">
              <label for="basic_checkbox_5" class="mb-0 h-15"></label>
              <span class="text-line">Maecenas scelerisque</span>
              <small class="badge bg-primary"><i class="fa fa-clock-o"></i> 1 week</small>
              <div class="tools">
                <i class="fa fa-edit"></i>
                <i class="fa fa-trash-o"></i>
              </div>
            </li>
            <li class="py-15 px-5">
              <!-- checkbox -->
              <input type="checkbox" id="basic_checkbox_6" class="filled-in">
              <label for="basic_checkbox_6" class="mb-0 h-15"></label>
              <span class="text-line">Vivamus nec orci</span>
              <small class="badge bg-info"><i class="fa fa-clock-o"></i> 1 month</small>
              <div class="tools">
                <i class="fa fa-edit"></i>
                <i class="fa fa-trash-o"></i>
              </div>
            </li>
            <li class="py-15 px-5 by-1">
              <!-- checkbox -->
              <input type="checkbox" id="basic_checkbox_7" class="filled-in">
              <label for="basic_checkbox_7" class="mb-0 h-15"></label>
              <!-- todo text -->
              <span class="text-line">Nulla vitae purus</span>
              <!-- Emphasis label -->
              <small class="badge bg-danger"><i class="fa fa-clock-o"></i> 2 mins</small>
              <!-- General tools such as edit or delete-->
              <div class="tools">
                <i class="fa fa-edit"></i>
                <i class="fa fa-trash-o"></i>
              </div>
            </li>
            <li class="py-15 px-5">
              <!-- checkbox -->
              <input type="checkbox" id="basic_checkbox_8" class="filled-in">
              <label for="basic_checkbox_8" class="mb-0 h-15"></label>
              <span class="text-line">Phasellus interdum</span>
              <small class="badge bg-info"><i class="fa fa-clock-o"></i> 4 hours</small>
              <div class="tools">
                <i class="fa fa-edit"></i>
                <i class="fa fa-trash-o"></i>
              </div>
            </li>
            <li class="py-15 px-5 by-1">
              <!-- checkbox -->
              <input type="checkbox" id="basic_checkbox_9" class="filled-in">
              <label for="basic_checkbox_9" class="mb-0 h-15"></label>
              <span class="text-line">Quisque sodales</span>
              <small class="badge bg-warning"><i class="fa fa-clock-o"></i> 1 day</small>
              <div class="tools">
                <i class="fa fa-edit"></i>
                <i class="fa fa-trash-o"></i>
              </div>
            </li>
            <li class="py-15 px-5">
              <!-- checkbox -->
              <input type="checkbox" id="basic_checkbox_10" class="filled-in">
              <label for="basic_checkbox_10" class="mb-0 h-15"></label>
              <span class="text-line">Proin nec mi porta</span>
              <small class="badge bg-success"><i class="fa fa-clock-o"></i> 3 days</small>
              <div class="tools">
                <i class="fa fa-edit"></i>
                <i class="fa fa-trash-o"></i>
              </div>
            </li>
          </ul>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  
<!-- ./wrapper -->
        
    <div id="chat-box-body">
        <div id="chat-circle" class="waves-effect waves-circle btn btn-circle btn-sm btn-warning l-h-45">
            <div id="chat-overlay"></div>
            <span class="icon-Group-chat font-size-18"><span class="path1"></span><span class="path2"></span></span>
        </div>

        <div class="chat-box">
            <div class="chat-box-header p-15 d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <button class="waves-effect waves-circle btn btn-circle btn-primary-light h-40 w-40 rounded-circle l-h-45" type="button" data-toggle="dropdown">
                      <span class="icon-Add-user font-size-22"><span class="path1"></span><span class="path2"></span></span>
                  </button>
                  <div class="dropdown-menu min-w-200">
                    <a class="dropdown-item font-size-16" href="#">
                        <span class="icon-Color mr-15"></span>
                        New Group</a>
                    <a class="dropdown-item font-size-16" href="#">
                        <span class="icon-Clipboard mr-15"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>
                        Contacts</a>
                    <a class="dropdown-item font-size-16" href="#">
                        <span class="icon-Group mr-15"><span class="path1"></span><span class="path2"></span></span>
                        Groups</a>
                    <a class="dropdown-item font-size-16" href="#">
                        <span class="icon-Active-call mr-15"><span class="path1"></span><span class="path2"></span></span>
                        Calls</a>
                    <a class="dropdown-item font-size-16" href="#">
                        <span class="icon-Settings1 mr-15"><span class="path1"></span><span class="path2"></span></span>
                        Settings</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item font-size-16" href="#">
                        <span class="icon-Question-circle mr-15"><span class="path1"></span><span class="path2"></span></span>
                        Help</a>
                    <a class="dropdown-item font-size-16" href="#">
                        <span class="icon-Notifications mr-15"><span class="path1"></span><span class="path2"></span></span> 
                        Privacy</a>
                  </div>
                </div>
                <div class="text-center flex-grow-1">
                    <div class="text-dark font-size-18">Mayra Sibley</div>
                    <div>
                        <span class="badge badge-sm badge-dot badge-primary"></span>
                        <span class="text-muted font-size-12">Active</span>
                    </div>
                </div>
                <div class="chat-box-toggle">
                    <button id="chat-box-toggle" class="waves-effect waves-circle btn btn-circle btn-danger-light h-40 w-40 rounded-circle l-h-45" type="button">
                      <span class="icon-Close font-size-22"><span class="path1"></span><span class="path2"></span></span>
                    </button>                    
                </div>
            </div>
            <div class="chat-box-body">
                <div class="chat-box-overlay">   
                </div>
                <div class="chat-logs">
                    <div class="chat-msg user">
                        <div class="d-flex align-items-center">
                            <span class="msg-avatar">
                                <img src="{{asset('/backend-images/2.jpg')}}" class="avatar avatar-lg">
                            </span>
                            <div class="mx-10">
                                <a href="#" class="text-dark hover-primary font-weight-bold">Mayra Sibley</a>
                                <p class="text-muted font-size-12 mb-0">2 Hours</p>
                            </div>
                        </div>
                        <div class="cm-msg-text">
                            Hi there, I'm Jesse and you?
                        </div>
                    </div>
                    <div class="chat-msg self">
                        <div class="d-flex align-items-center justify-content-end">
                            <div class="mx-10">
                                <a href="#" class="text-dark hover-primary font-weight-bold">You</a>
                                <p class="text-muted font-size-12 mb-0">3 minutes</p>
                            </div>
                            <span class="msg-avatar">
                                <img src="{{asset('/backend-images/3.jpg')}}" class="avatar avatar-lg">
                            </span>
                        </div>
                        <div class="cm-msg-text">
                           My name is Anne Clarc.         
                        </div>        
                    </div>
                    <div class="chat-msg user">
                        <div class="d-flex align-items-center">
                            <span class="msg-avatar">
                                <img src="{{asset('/backend-images/2.jpg')}}" class="avatar avatar-lg">
                            </span>
                            <div class="mx-10">
                                <a href="#" class="text-dark hover-primary font-weight-bold">Mayra Sibley</a>
                                <p class="text-muted font-size-12 mb-0">40 seconds</p>
                            </div>
                        </div>
                        <div class="cm-msg-text">
                            Nice to meet you Anne.<br>How can i help you?
                        </div>
                    </div>
                </div><!--chat-log -->
            </div>
            <div class="chat-input">      
                <form>
                    <input type="text" id="chat-input" placeholder="Send a message..."/>
                    <button type="submit" class="chat-submit" id="chat-submit">
                        <span class="icon-Send font-size-22"></span>
                    </button>
                </form>      
            </div>
        </div>
    </div>
    
@endsection
  