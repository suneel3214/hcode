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
	        	<h4 class="card-title mb-3">Transaction Tracker</h4>
	        </div>	
    			<div class="col-md-6" style="text-align: end;">
	       		{{--<a href="javascript:void(0)" class="btn btn-primary ripple m-1 float-right payoutRequest" type="button">Withdrawal Request</a>--}}
	       	</div>	
	    </div>   	
        <div class="table-responsive" id="productUpdateList">
        	{{--<div class="table_fields">
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
		      </div>  --}}	
			 <?php $unique = []; ?>
            @if(count($payouts) > 0)        
	            <table class="table" id="productList1">
	                <thead>
	                    <tr>	                	
							<th scope="col">#</th>
							<th scope="col">Order No.</th>
							@role('super_admin')
								<th scope="col">Seller Email</th>
							@endrole	
							<th scope="col">Transaction Amount</th>
							<th scope="col">Seller Order List Amount</th>
							<th scope="col">Transaction Fees</th>														
							<th scope="col">Status of Product</th>
							<th scope="col">Wallet Amount</th>
							<th scope="col">Report</th>
	                    </tr>
	                </thead>
	           		<tbody>
	                    <?php $count = 1; ?>
				
						@foreach($payouts as $payout )	
               <?php   
							if(!in_array($payout->payment_method,$unique)){                 
                            	$compareAmt = same_method($payout->payment_method);
															$unique[] = $payout->payment_method;
                        ?>
		                    <tr>
		                    	<td>{{$count++}}</td>
                                <td>{{$payout->order->invoice_number}}</td>
								<td scope="col">{{$payout->order->get_seller->email}}</td>
		                    	<td>{{$payout->shipping ? $payout->shipping_price + $payout->amount:$payout->amount}}</td>
                                <td>{{$payout->order->total_price}}</td>
		                    	<td>{{$payout->amount - $payout->order->total_price}}</td>
		                    	<td>{{$payout->order->status}}</td>
		                    	<td>{{$payout->order->get_seller->wallet}} {{$payout->amount}}</td>
		                    	<td>
                            @if( $compareAmt === $payout->amount)
			                       		<span  class="badge badge-success">Good </span>
                                     @else
			                       		<span  class="badge badge-danger">Bad </span>
                                    @endif
                                </td>

		                    </tr>
										<?php }?>
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
          
    </div>
    {{-- Show review --}}
   {{-- <div class="modal fade closeModal" id="payoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
		</div>--}}

	{{-- Payout Cancell --}}
    {{--<div class="modal fade closeModal" id="rejectPayout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
		</div>--}}
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
