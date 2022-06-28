@extends('layouts.main')
@section('content')
<div class="card text-left">
    <div class="card-body">
		<div class="col-12 ">
			<div class="box">
				<div class="box-header">						
					<h4 class="box-title mt-2">Payment History</h4>
					@if($message = Session::get('success'))
		            <div class="alert alert-success btn-sm">
		                {{$message}}
		            </div>
		        	@endif
					{{-- <a href="{{route('products.create')}}"class="btn btn-primary pull-right  btn-sm">Add</a> --}}
				</div>
				<div class="card-body"> 
					<div class="table-responsive">
						<table id="bid" class="table" style="width:100%" >
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
								<?php $count = 1; ?>
									@foreach($data as $bids )
									<tr>
										<td>{{$count++}}</td>
										<td>{{$bids->order->invoice_number}}</td>
										<td>{{$bids->order->total_price}}</td>
										<td>{{$bids->order->get_seller->name}}</td>
										<td>{{$bids->order->get_seller->email}}</td>
										<td>{{$bids->order->get_user->name}}</td>
										<td>{{$bids->order->get_payment->stripe_id}}</td>
									</tr>
									@endforeach
								}
								
							</tbody>
						</table>
					</div>
				</div>
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
