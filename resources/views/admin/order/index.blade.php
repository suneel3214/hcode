@extends('layouts.main')
@section('content')
<div class="card text-left">
    <div class="card-body">
		<div class="col-12 ">
			<div class="box">
				<div class="box-header">						
					<h4 class="box-title mt-2">Orders</h4>
					@if($message = Session::get('success'))
		            <div class="alert alert-success btn-sm">
		                {{$message}}
		            </div>
		        	@endif
					{{-- <a href="{{route('products.create')}}"class="btn btn-primary pull-right  btn-sm">Add</a> --}}
				</div>
				<div class="card-body1"> 
					<div class="table-responsive">
						<div class="table_fields">
							<div id="productList_filter" class="dataTables_filter mb-2">
			        	<input type="search" class="searchField" style="margin-left:0px;" placeholder="Search Product by order number" aria-controls="productList">
			        </div>
			        <div>
			        	<a class="btn btn-primary fa fa-search ml-1 orderSearch" rel='' style="color:#fff;"></a>
			        </div>
			      </div>  
						<table id="order_list1" class="table" style="width:100%" >
							<thead>
								<tr>
									<th>#</th>
									<th>Order Number</th>
									<th>Order Date</th>
									<th>Customer Name</th>
									<th>Total Amount</th>
									<th>Total Item</th>
									<th>Status</th>
									<th title="Change the status">View</th>
								</tr>
							</thead>
							<tbody>
								<?php  
									$count = ($orders->currentpage()-1)* $orders->perpage() + 1;
								?>
								@foreach($orders as $order )
							
								<tr>
									<td>{{$count++}}</td>
									<td>{{$order->invoice_number}}</td>
									<td>{{date('D M y',strtotime($order->created_at))}}</td>
									<td>{{$order->get_user ? $order->get_user->f_name:''}}-{{$order->get_user ? $order->get_user->l_name:''}}</td>
									<td>${{$order->shipping ? totalOrderPrice($order->id) : $order->total_price}}</td>
									<td>{{totalOrderProduct($order->id)}}</td>
									<td>
										@include('admin.order.status')
									</td>
									
									<td>						    
									  <a href="{{route('orders_show',$order->id)}}"> &nbsp;<i class="nav-icon i-Eye-Scan font-weight-bold" title="Show Details"></i></a>
										
									</td>
								</tr>
								@endforeach
								
							</tbody>
						</table>
					</div>
					<div id="paginationLinkOrder">
          	{{ $orders->links() }}
          </div>
				</div>
				</div>
			</div>
		</div>
	</div> 
</div>
 <!-- Edit Modal -->


    <div class="modal fade closeModal" id="pendingOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document" style="max-width: 1200px;">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Order For Approve</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body modalData">
            {{allPendingOrder()}}
          </div>
        </div>
      </div>
    </div>
<script src="https://code.jquery.com/jquery-3.6.0.js" ></script>

<script>
    $(document).ready(function(){

    	if({{isPending()}}){
    		$('#pendingOrder').modal('show')

    	}
        $(document).on('click','.approval',function(e){
        	alert('dfdffg')
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
