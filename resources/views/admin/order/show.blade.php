@extends('layouts.main')
@section('content')
<style>
    .ajax-loader {
      visibility: hidden;
      background-color: rgba(255,255,255,0.7);
      position: absolute;
      z-index: +100 !important;
      width: 100%;
      height:100%;
    }

    .ajax-loader img {
      position: relative;
      top:50%;
      left:40%;
    }
</style>
<div class="card text-left">
    <div class="ajax-loader">
  <img src="{{ asset('loader/loading.gif') }}" class="img-responsive" />
</div>
    <div class="card-body">
        <div class="col-12 ">
            <div class="box">
                <div class="box-header"> 
                    <div class="row">
                        <div class="col-md-6">                     
                            <h4 class="box-title mt-2">Orders Number:- {{$order->invoice_number}}
                                @include('admin.order.status')
                            </h4>
                            @if($message = Session::get('success'))
                                <div class="alert alert-success btn-sm">
                                    {{$message}}
                                </div>
                            @endif
                        </div>    
                        <div class="col-md-6" >
                            <a href="{{route('orders')}}"class="btn btn-primary float-right  btn-sm">Back</a>
                        </div>                       
                    </div>  
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <h6>Customer Details:</h6>
                        </div> 
                        <div class="col-md-6">
                            <div>
                                Name:- <span>{{$order->get_user->name}}</span>
                            </div>
                            <div>
                                Email:- <span>{{$order->get_user->email}}</span>
                            </div>
                            <div>
                                Phone No. :- <span>{{$order->get_user->phone_no}}</span>
                            </div>
                            <div>
                                Address :- <span>{{$order->get_user->address}}</span>
                            </div>
                            <div>
                                Shipping :- <span>{{$order->shipping ? 'Yes' : 'No'}}</span>
                            </div> 
                        </div>      
                    </div>  
                </div>
                <div class="mt-3"> 
                    <div class="table-responsive">
                        <table id="order_list1" class="table" style="width:100%" >
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Date</th>
                                    <th>Customer Name</th>
                                    <th>Quantity</th>
                                    <th>Cancel Quantity</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $count = 1; ?>
                                @foreach($order->get_order_items as $Order )
                                <tr>
                                    <td>{{$count++}}</td>
                                    <td>{{$Order->get_product->name}}</td>
                                    <td>{{date('D M y',strtotime($Order->created_at))}}</td>
                                    <td>{{$order->get_user ? $order->get_user->f_name:''}} {{$order->get_user ? $order->get_user->l_name:''}}</td>
                                    
                                    <td>{{$Order->quantity}}</td>
                                    <td>{{$Order->cancel_qty}}</td>
                                    <td>${{$order->shipping ? ($Order->amount + ($Order->get_product->shipping_price*$Order->quantity)-$Order->discount_amount ):$Order->amount-$Order->discount_amount}}</td>
                                    <td>
                                        @include('admin.order.status')
                                    </td>
                                    <td style="text-align: center;">
                                        @if($Order->status === 'placed')
                                            <a class="btn btn-success" onclick="changeOrder({{$Order->id}},'confirmed')" href="javascript:void(0)">
                                                Confirmed
                                            </a>                                            
                                            <a class="btn btn-success" onclick="changeOrder({{$Order->id}},'rejected',{{$Order->quantity}})" href="javascript:void(0)">
                                                Rejected
                                            </a>
                                        @elseif($Order->status === 'confirmed')    
                                            <a class="btn btn-success" onclick="changeOrder({{$Order->id}},'shipped')" type="inactive" href="javascript:void(0)">
                                                Shipped
                                            </a>
                                            <a class="btn btn-success" onclick="changeOrder({{$Order->id}},'cancelled')" href="javascript:void(0)">
                                                Cancelled
                                            </a>
                                        @endif    
                                        @if($Order->status === 'confirmed' || $Order->status === 'shipped')    
                                            <a class="btn btn-success" onclick="changeOrder({{$Order->id}},'delivered')"  href="javascript:void(0)">
                                                Delivered
                                            </a>

                                           <a class="btn btn-success" onclick="changeOrder({{$Order->id}},'return')" href="javascript:void(0)">
                                                Return
                                            </a>
                                        @elseif($Order->status === 'rejected')    
                                            <a class="btn btn-success" onclick="changeOrder({{$Order->id}},'return')" href="javascript:void(0)">
                                                Return
                                            </a>
                                            <a class="btn btn-success" onclick="changeOrder({{$Order->id}},'refunded')" href="javascript:void(0)">
                                                Refunded
                                            </a>
                                        @endif    
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div> 
</div>

{{-- shipping form  --}}


<div class="modal fade" id="shippingModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Shipping Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="shippingForm">
            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Tracking ID:</label>
                <input type="text" class="form-control" id="awb">
                <span id="awb-error" class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Shipping Company Name:</label>
                <input type="text" class="form-control" id="shipping_company_name">
                <span id="shipping_company_name-error" class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="message-text" class="col-form-label">Shipping Details:</label>
                <textarea class="form-control" id="shippingDetails"></textarea>
                <span id="shippingDetails-error" class=" text-danger"></span>
              </div>
              <input type="hidden" id="shippingId" >
          </div>
          <div class="modal-footer" style="justify-content: left;">        
            <button type="submit" class="btn btn-primary float-left ">Save</button>
          </div>
        </form>
    </div>
  </div>
</div>

{{-- cancel form  --}}

<div class="modal fade" id="cancelModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cancel Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form id="cancelForm">
            <div class="modal-body">
            <div class="form-group">
                <label>Quantity</label>
                <input class="form-control" type="number" id="productQty">
                <span id="cancelQty-error" class=" text-danger"></span>
            </div>    
             <div class="form-group">
                <label for="message-text" class="col-form-label">Reason:</label>
                <textarea class="form-control" id="cancelDesc"></textarea>
                <span id="cancelDesc-error" class=" text-danger"></span>
              </div>
              <input type="hidden" id="cancelId" >
              <input type="hidden" id="statusModel" >
              <input type="hidden" id="crntQty" >
          </div>
          <div class="modal-footer" style="justify-content: left;">        
            <button type="submit" class="btn btn-primary float-left ">Save</button>
          </div>
        </form>
    </div>
  </div>
</div>


{{-- deliver form  --}}
<div class="modal fade" id="deliverModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Deliver</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form id="deliverForm">
            <div class="modal-body">
             <div class="form-group">
                <label for="message-text" class="col-form-label">Comment:</label>
                <textarea class="form-control" id="cancelDesc"></textarea>
                <span id="deliverComment-error" class=" text-danger"></span>
              </div>
              <input type="hidden" id="deliverId" >
              <input type="hidden" id="deliverStatus" >
          </div>
          <div class="modal-footer" style="justify-content: left;">        
            <button type="submit" class="btn btn-primary float-left ">Save</button>
          </div>
        </form>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.js" ></script>

<script>
    $(document).ready(function(){
        
        $(document).on('click','.approval',function(e){
            e.preventDefault();
            var product_id = $(this).data('id');
             $.ajax({
                type:'GET',
                url:"/product_approve/"+product_id,
                success:function(res){
                    if(res.status == 'success'){
                        alert(res.message)
                        window.location.reload();
                    }
                }
            });


        });
    });
</script>
@endsection
