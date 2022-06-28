@extends('layouts.main')
@section('content')
<style>
	th,td{
		text-align: left;
	}
	.notText{
		text-align: left !important;	
		text-transform: capitalize;
	}
	blink{
		position: absolute;
	}
</style>
<div class="card text-left">
    <div class="card-body">
    	<div class="row">
    		<div class="col-md-6">
	        	<h4 class="card-title mb-3">Withdrawal Request</h4>
	        </div>	
    			<div class="col-md-6" style="text-align: end;">
				<a href="{{ route('pay-exports') }}" class="btn btn-primary ripple m-1 float-right" type="button">CSV Download</a>
				<a href="javascript:void(0)" class="btn btn-primary ripple m-1 float-right payoutRequest" type="button">Withdrawal Request</a>
	       	</div>	
	    </div>   	
        <div class="table-responsive" id="productUpdateList">
        	<div class="table_fields">
	        	<div class="">
		        	<select name="productList_length" aria-controls="productList" class="withdrawStausDrop">
		        		<option value="">-- Select Status --</option>
		        		<option value="pending">Pending</option>
		        		<option value="inprogress">Inprogress</option>
		        		<option value="rejected">Rejected</option>
		        		<option value="inreview">Inreview</option>
		        		<option value="cancelled">Cancelled</option>
		        	</select>
		        </div>
		        <div>
		        	<a class="btn btn-primary fa fa-search ml-1 withDrawsearch" rel='' style="color:#fff;"></a>
		        </div>
		      </div>  	
            @if(count($payout) > 0)        
	            <table class="table" id="productList1">
	                <thead>
	                    <tr>	                	
							<th scope="col">#</th>
							@role('super_admin')
								<th scope="col">Seller Name</th>
							@endrole
							<th scope="col">Email</th>
							<th scope="col">Request Date</th>
							<th scope="col">Amount</th>
							<th scope="col">Status</th>														
							<th scope="col">Action</th>
	                    </tr>
	                </thead>
	           		<tbody>
	                    <?php $count = 1; ?>
						@foreach($payout as $Payout )						
		                    <tr>
		                    	<th>{{$count++}}</th>
		                       
		                        @role('super_admin')
									<td scope="col">{{$Payout->seller->name}}</td>
								@endrole
								<td scope="col">{{$Payout->seller->email}}</td>
		                        <th scope="row">{{date('d M y',strtotime($Payout->date))}}</th>
		                        <td>${{$Payout->amount}}</td>
		                        <td>
		                        	@if($Payout->status === 'pending')
			                        	<span style="background-color: #6420ff;color:#fff" class="badge">Pending</span>
			                        @elseif($Payout->status === 'inprogress')
			                       		<span  class="badge badge-warning" style="background-color:#898983;color:#fff"> Inprogress</span>
			                       	@elseif($Payout->status === 'rejected')
			                       		<span  class="badge badge-danger"> Rejected	</span>
			                       	@elseif($Payout->status === 'complete')
			                       		<span  class="badge badge-success"> Completed</span>
			                       	@elseif($Payout->status === 'inreview')
			                       		<span  class="badge badge-warning"> Inreview</span>	
			                       	@elseif($Payout->status === 'cancelled')
			                       		<span  class="badge badge-warning"> Cancelled</span>			
			                        @endif					                       
		                        </td>

		                        @role('super_admin')
									<td scope="col">
										@if($Payout->status === 'pending')
											<a class="btn btn-warning text-white btn-sm" href="{{route('payout.status',[$Payout->id,'inprogress'])}}">Inprogress</a>
										@elseif($Payout->status === 'inprogress')	
											<a class="btn btn-success btn-sm text-white" href="{{route('payout.status',[$Payout->id,'complete'])}}">Complete</a>	
										@endif	
										@if($Payout->status !== 'rejected')
											<a class="btn btn-danger btn-sm rejectPayout text-white" payout-page="{{$Payout->amount}}" data-id="{{$Payout->id}}">Reject</a>
										@endif	
									</td>
								@endrole
								@role('seller')
									<td scope="col">
									@if($Payout->status === 'pending')
										<a class="btn btn-danger btn-sm text-white" href="{{route('payout.status_seller',[$Payout->id,'cancelled'])}}">Cancel</a>
									@else
										<button style="background-color: #402927;border-color: #402927;" class="btn btn-danger btn-sm text-white" disabled>Cancel</button>	
									@endif	
									</td>
								@endrole
		                       
		                    </tr>
		                @endforeach
		              </tbody>   
	            </table>
	            @else
		            <table class="table" id="productList1">
		                <thead>
		                    <tr>	                	
								<th scope="col">#</th>
								<th scope="col">Request Date</th>
								<th scope="col">Amount</th>
								<th scope="col">Status</th>
		                    </tr>
	                	</thead>
	           			<tbody>

	           			</tbody>
		           	</table>
		           	<div style="text-align: center;">
		           		No record found
		           	</div>		
				      @endif     
        </div>
            <div id="paginationwithDraw">
            	{{ $payout->links() }}
            </div>	
    </div>
    {{-- Show review --}}
    <div class="modal fade closeModal" id="payoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Withdrawal Request</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body modalData">
		      	<div class="row">
		      		<div class="col-md-12 mb-2">
				      	<lable>Wallet Amount</lable>
				      	<input class="form-control" readonly style="width:100%;" value="{{auth()->user()->wallet}}">	
				      	<span class="with-error text-danger"></span>	        
				    	</div>
		      		<div class="col-md-12">
				      	<lable>Withdrawal Request Amount</lable>
				      	<input class="form-control" style="width:100%;" id="withdrawAmount">	
				      	<span class="with-error text-danger"></span>	        
				    	</div>
				    	
		      		<div class="col-md-12 mt-2">
		      			<button class="btn btn-primary submitRequest">Submit</button>
		      		</div>				      	
			    </div>  	
		      </div>
		    </div>
		  </div>
		</div>

	{{-- Payout Cancell --}}
    <div class="modal fade closeModal" id="rejectPayout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Payout request reject</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body modalData">
		      	<div class="row">
		      		<div class="col-md-12">
				      	<lable>Amount</lable>
				      	<input type="number" min="0" class="form-control" style="width:100%;" id="payoutAmount">
				      	<span class="with-error text-danger"></span>	        
				    </div>
				    <div class="col-md-12 mt-2">
				      	<lable>Remark</lable>
				      	<textarea class="form-control" id="payoutRemark"></textarea>	
				    </div>
		      		<div class="col-md-12 mt-2">
		      			<button class="btn btn-primary submitReject" data-page="" id="">Submit</button>
		      		</div>				      	
			    </div>  	
		      </div>
		    </div>
		  </div>
		</div>
</div>

<style>
blink {
  -webkit-animation: 2s linear infinite condemned_blink_effect; /* for Safari 4.0 - 8.0 */
  animation: 2s linear infinite condemned_blink_effect;
}

blink:hover {
  -webkit-animation: 2s linear infinite condemned_blink_effect; /* for Safari 4.0 - 8.0 */
  animation: none;
}

/* for Safari 4.0 - 8.0 */
@-webkit-keyframes condemned_blink_effect {
  0% {
    visibility: hidden;
  }
  50% {
    visibility: hidden;
  }
  100% {
    visibility: visible;
  }
}

@keyframes condemned_blink_effect {
  0% {
    visibility: hidden;
  }
  50% {
    visibility: hidden;
  }
  100% {
    visibility: visible;
  }
}
</style>
@endsection
