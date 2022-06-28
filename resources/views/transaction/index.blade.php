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
	        	<h4 class="card-title mb-3">Transaction's</h4>
	        </div>	
    			<div class="col-md-6">
    			@role('super_admin')
				    <a href="{{route('trans-exports')}}" class="btn btn-primary ripple m-1 float-right " type="button">CSV Download</a>
	       			<a href="javascript:void(0)" class="btn btn-primary ripple m-1 float-right excelImport" type="button">Import</a>
	       			<a href="javascript:void(0)" class="btn btn-primary ripple m-1 float-right createTransction" type="button">Add Transctaion</a>
	       		@endrole	
	       	</div>	
	    </div>   	
        <div class="table-responsive" id="productUpdateList">
        	@role('super_admin')
	        	<div class="table_fields">
		        	<div class="">
			        	<select name="productList_length" aria-controls="productList" class="transStausDrop">
			        		<option value="">-- Select Status --</option>
			        		<option value="debit">Debit</option>
			        		<option value="credit">Credit</option>		        	
			        	</select>
			        </div>
			        <div id="productList_filter" class="dataTables_filter">
			        	<input type="search" class="tranSearchField" style="width: 220px;height: 22px;" placeholder="Search Order by Number & Email" aria-controls="productList">
			        </div>
			        <div>
			        	<a class="btn btn-primary fa fa-search ml-1 transSearch" rel='' style="color:#fff;"></a>
			        </div>
			      </div>
			    @endrole    
            @if(count($transaction) > 0)        
	            <table class="table" id="productList1">
	                <thead>
	                    <tr>	                	
							<th scope="col">#</th>
							<th scope="col">Order Number</th>
							@role('super_admin')
								<th scope="col">Seller Name</th>
							@endrole	
							<th scope="col">Transctaion date</th>
							<th scope="col">Transcation amount</th>
							<th scope="col">Commission amount</th>														
							<th scope="col">Payble amount</th>
							<th scope="col">Type</th>														
							@role('super_admin')													
								<th scope="col">Action</th>
							@endrole	
	                    </tr>
	                </thead>
	           		<tbody>
	                    <?php $count = 1; ?>
						@foreach($transaction as $Transaction )						
		                    <tr>
		                    	<th>{{$count++}}</th>
		                       
		                        <td>{{$Transaction->order ? $Transaction->order->invoice_number:'Service Charge'}}</td>
		                        @role('super_admin')
									<td scope="col">{{$Transaction->seller->name}}</td>
								@endrole
		                        <th scope="row">{{date('d M y',strtotime($Transaction->created_at))}}</th>
		                        <td>${{$Transaction->amount + $Transaction->commission}}</td>
		                        <td>${{$Transaction->commission}}</td>
		                        <td>${{$Transaction->amount}}</td>
		                        <td>
		                        	@if($Transaction->transaction === 'credit')
			                        	<span style="font-weight: 800;">CR</span>
			                        @else
			                       		<span style="font-weight: 800;"> DR</span>
			                        @endif					                       
		                        </td>
		                       {{--  <td>
		                        	@if($Transaction->status === 'active')
			                        	<span style="background-color: #6420ff;color:#fff" class="badge">Active</span>
			                        @else
			                       		<span  class="badge badge-danger" style="color:#fff"> Cancelled</span>
			                        @endif					                       
		                        </td> --}}
		                        @role('super_admin')
									<td scope="col">
										@if($Transaction->status === 'active')
											<a class="btn btn-danger text-white btn-sm" href="{{route('transactions.show',[$Transaction->id,'cancel'])}}">Cancel</a>
										@else	
											<a class="btn btn-success btn-sm text-white" href="{{route('transactions.show',[$Transaction->id,'active'])}}">Active</a>	
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
								@role('super_admin')
									<th scope="col">Seller Name</th>
								@endrole	
								<th scope="col">Date</th>
								<th scope="col">Amount</th>
								<th scope="col">Portal Fee</th>
								<th scope="col">Transaction Type</th>														
								<th scope="col">Status</th>	
								@role('super_admin')													
									<th scope="col">Action</th>
								@endrole	
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
            <div id="paginationtransSearch">
            	{{ $transaction->links() }}
            </div>	
    </div>
    {{-- Show review --}}
    <div class="modal fade closeModal" id="transactionCreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Save Transaction</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body modalData">
		      	<div class="row">
		      		<div class="col-md-12 mb-2">
				      	<lable>Transaction For</lable>
				      	<select class="form-control" id="transFor">
				      		<option value="order">Order</option>
				      		<option value="penalti">Penalti</option>
				      		<option value="portal_sevice_charge">Portal Sevice Charge</option>
				      	</select>	
				      	<span class="transFor-error text-danger"></span>	        
				    </div>
				    <div class="col-md-12 mb-2">
				      	<lable>Transaction Type</lable>
				      	<select class="form-control" id="transType">
				      		<option value="credit">Credit</option>
				      		<option value="debit">Debit</option>
				      	</select>	
				      	<span class="portalwith-error text-danger"></span>	        
				    </div>
		      		<div class="col-md-12 mb-2 orderNumberField">
				      	<lable>Order Number</lable>
				      	<input class="form-control" placeholder="#12345678745" style="width:100%;" id="tranOrderID">	
				      	<span class="orderwith-error text-danger"></span>	        
				    </div>
				    <div class="col-md-12 mb-2 customerMemberField" style="display:none;">
				      	<lable>Customer Member ID</lable>
				      	<input class="form-control" placeholder="1001" style="width:100%;" id="memberID">	
				      	<span class="member-error text-danger"></span>	        
				    </div>
				    <div class="col-md-12 mb-2">
				      	<lable>Amount</lable>
				      	<input class="form-control" style="width:100%;" id="tranAmount">	
				      	<span class="amtwith-error text-danger"></span>	        
				    </div>
				    <div class="col-md-12 mb-2">
				      	<lable>Portal Commission</lable>
				      	<input class="form-control" style="width:100%;" id="portalAmount">	
				      	<span class="portalwith-error text-danger"></span>	        
				    </div>				   
		      		<div class="col-md-12 mt-2">
		      			<button class="btn btn-primary transactioSubmit">Save</button>
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
		      			<button class="btn btn-primary submitReject" data-page="" id="">Save</button>
		      		</div>				      	
			    </div>  	
		      </div>
		    </div>
		  </div>
		</div>
</div>

{{-- Excel import --}}
    <div class="modal fade closeModal" id="importTrans" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Import Transaction's</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body modalData">
		      	<form action="{{route('importTransction')}}" method="post" enctype="multipart/form-data">
		      		@csrf
			      	<div class="row">
			      		<div class="col-md-12">
					      	<lable>CSV</lable>
					      	<input type="file" name="file" min="0" class="form-control" >
					    </div>
			      		<div class="col-md-12 mt-2">
			      			<button class="btn btn-primary submitReject" data-page="" id="">Save</button>
			      		</div>				      	
				    </div>  	
				  </form>  
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
