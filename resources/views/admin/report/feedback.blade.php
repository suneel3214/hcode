@extends('layouts.main')
@section('content')
<div class="card text-left">
    <div class="card-body">
    <div class="row">
        <div class="col-md-12">
				<div class="box-header">	
					<div class="row">
						<div class="col-md-6">					
							<h4 class="box-title pl-3 mt-2">Feedback & Support</h4>
						</div>	
					</div>
					@if($message = Session::get('success'))
		            <div class="alert alert-success pull-right btn-sm">
		                {{$message}}
		            </div>
		        	@endif
				</div>
            		<div class="card-body">
	            		<div class="table_fields">
				        	<div class="">
					        	<select name="productList_length" aria-controls="productList" class="feedbackSearch">
					        		<option value="">--Select Type--</option>
					        		<option value="Accont issue">Account issue</option>
	                            	<option value="Payment issue">Payment issue</option>
	                            	<option value="Banner">Banner</option>
	                            	<option value="Feedback">Feedback</option>
	                            	<option value="Others">Others</option>
					        	</select>
					        </div>
					       {{--  <div id="productList_filter" class="dataTables_filter">
					        	<input type="search" class="customerField" placeholder="Search customer by name" aria-controls="productList">
					        </div>
					        <div>
					        	<a class="btn btn-primary fa fa-search ml-1 searchUser" rel='' style="color:#fff;"></a>
					        </div> --}}
					    </div>
            		@if(count($feedbacks) > 0)
						<div class="table-responsive ">
							<table id="feedback1" class="table " style="width:100%">
								<thead>
									<tr>
										<th>#</th>
										<th>Name</th>
										<th>Email</th>
										<th>SubmitDate</th>
										<th>Type Of Issue</th>
										<th>Subject</th>
										<th>Message</th>
									</tr>
								</thead>
								<tbody>
									<?php $count = 1; ?>
									@foreach($feedbacks as $feedback )
										<tr>
											<td>{{$count++}}</td>
											<td>{{$feedback->user->name}}</td>
											<td>{{$feedback->user->email}}</td>
											<td>{{date('d M y',strtotime($feedback->created_at))}}</td>
											<td>{{$feedback->type_of_issue}}</td>
											<td>{{$feedback->sbject}}</td>
											<td>{!!$feedback->message!!}</td>
										</tr>
									@endforeach
									
								</tbody>
							</table>
						</div>
						<div id="paginationLinkFeedback">
				            {{ $feedbacks->links() }}
				        </div>
				    @else
				    	<table id="feedback1" class="table " style="width:100%">
							<thead>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>Email</th>
									<th>SubmitDate</th>
									<th>Type Of Issue</th>
									<th>Subject</th>
									<th>Message</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>	
				    	<div style="text-align: center;" class="">
				    		No record found
					   	</div>	
				    @endif    
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
