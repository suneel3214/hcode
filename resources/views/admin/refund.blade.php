@extends('layouts.main')
@section('content')
<div class="card text-left">
    <div class="card-body">
		<div class="col-12 ">
			<div class="box">
				<div class="box-header">						
					<h4 class="box-title mt-2">Refund Request</h4>
					@if($message = Session::get('success'))
		            <div class="alert alert-success btn-sm">
		                {{$message}}
		            </div>
		        	@endif
					{{-- <a href="{{route('products.create')}}"class="btn btn-primary pull-right  btn-sm">Add</a> --}}
				</div>
				<div class="card-body1"> 
					<div class="table_fields">			        	
				        <div id="productList_filter" class="dataTables_filter">
				        	<input type="search" class="refundField" placeholder="Search customer by name" aria-controls="productList" style="margin-left: 0px;">
				        </div>
				        <div>
				        	<a class="btn btn-primary fa fa-search ml-1 refundSearch" rel='' style="color:#fff;"></a>
				        </div>
				    </div>
				    @if(count($data))
						<div class="table-responsive">
							<table id="" class="table" style="width:100%" >
								<thead>
									<tr>
										<th>#</th>
										<th>Order Number</th>
										<th>Product Name</th>
										<th>Order Price</th>
										<th>Seller Name</th>
										<th>Seller Email</th>
										<th>Buyer Name</th>
										<th>Payment Id</th>
									</tr>
								</thead>
								<tbody>
									<?php $count = 1; ?>
										@foreach($data as $bids )
										<tr>
											<td>{{$count++}}</td>
											<td>{{$bids->order->invoice_number}}</td>
											<td>{{$bids->product->name}}</td>
											<td>${{$bids->order->total_price}}</td>
											<td>{{$bids->order->get_seller->name}}</td>
											<td>{{$bids->order->get_seller->email}}</td>
											<td>{{$bids->order->get_user->name}}</td>
											<td>{{$bids->order->get_payment->stripe_id}}</td>
										</tr>
										@endforeach
									
								</tbody>
							</table>
						</div>
					</div>
					<div id="paginationLinkRefund">
		            	{{ $data->links() }}
		            </div>	
		        @else
		        	<div class="table-responsive">
						<table id="" class="table" style="width:100%" >
							<thead>
								<tr>
									<th>#</th>
									<th>Order Number</th>
									<th>Order Price</th>
									<th>Seller Name</th>
									<th>Seller Email</th>
									<th>Buyer Name</th>
									<th>Payment Id</th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
						</table>
					</div>
					<div style="text-align: center;">
						No record found
					</div>	
		        @endif    
				</div>
			</div>
		</div>
	</div> 
</div>
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
