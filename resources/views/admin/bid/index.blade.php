@extends('layouts.main')
@section('content')
<div class="card text-left">
    <div class="card-body">
		<div class="col-12 ">
			<div class="box">
				<div class="box-header">						
					<h4 class="box-title mt-2">Bids</h4>
					@if($message = Session::get('success'))
		            <div class="alert alert-success btn-sm">
		                {{$message}}
		            </div>
		        	@endif
					{{-- <a href="{{route('products.create')}}"class="btn btn-primary pull-right  btn-sm">Add</a> --}}
				</div>
				<div class="card-body1"> 
					<div class="table_fields">
						<div id="productList_filter" class="dataTables_filter mb-2">
				        	<input type="search" class="BidSearchField" style="margin-left:0px;" placeholder="Search Product by name" aria-controls="productList">
				        </div>
				        <div>
				        	<a class="btn btn-primary fa fa-search ml-1 bidSearch" rel='' style="color:#fff;"></a>
				        </div>
				     </div> 
					<div class="table-responsive">
						<table id="bid1" class="table" style="width:100%" >
							<thead>
								<tr>
									<th>#</th>
									<th>Product Name</th>
									<th>Customer Name</th>
									<th>Bid Price</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $count = 1; ?>
									@foreach($bid as $bids )
									<tr>
										<td>{{$count++}}</td>
										<td>{{$bids->product->name}}</td>
										<td>{{$bids->user->name}}</td>
										<td>
											<a class="nav-icon i-Eye-Scan font-weight-bold">
												
											</a>
										</td>
									</tr>
									@endforeach
								
							</tbody>
						</table>
					</div>
					<div id="paginationLinkBid">
		            	{{ $bid->links() }}
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
