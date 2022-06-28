@extends('layouts.main')
@section('content')
 	
<div class="card text-left">
    <div class="card-body">
	<div class="row mt-3 ">
		<div class="col-12">
			<div class="box">
				<div class="box-header">						
					<h4 class="box-title mt-2">Customer Or Seller </h4>
					@if($message = Session::get('success'))
		            <div class="alert alert-success pull-right btn-sm">
		                {{$message}}
		            </div>
		        	@endif
					{{-- <a href="{{route('products.create')}}"class="btn btn-primary pull-right mt-2 btn-sm">Add</a> --}}
				</div>
				
    			 <div class="card-body">
    			 	<div class="table_fields">
			        	<div class="">
				        	<select name="productList_length" aria-controls="productList" class="userSearch">
				        		<option value="">-- Select Status --</option>
				        		<option value="active">Active</option>
				        		<option value="inactive">Inactive</option>
				        		<option value="verified">Verified</option>
				        		<option value="unverified">Unverified</option>
				        	</select>
				        </div>
				        <div id="productList_filter" class="dataTables_filter">
				        	<input type="search" class="customerField" placeholder="Search customer by name" aria-controls="productList">
				        </div>
				        <div>
				        	<a class="btn btn-primary fa fa-search ml-1 searchUser" rel='' style="color:#fff;"></a>
				        </div>
				      </div>
					<div class="table-responsive refreshTable">
						<table id="buyer_seller1" class="table" style="width:100%">
							<thead>
								<tr>
				                	<th scope="col">#</th>
									<th scope="col">User Name</th>
									<th scope="col">Email</th>
									<th scope="col">Type</th>
									<th scope="col">Status</th>
									<th scope="col">Action</th>
			                    </tr>
							</thead>
							<tbody>
								<?php $count = 1; ?>
								@foreach($users as $user )
								<tr>
									<td>{{$count++}}</td>
									<td>{{$user->f_name}}-{{$user->l_name}}</td>
									<td>{{$user->email}}</td>
									<td>
										<span class="badge {{$user->email_verified_at !=null ? 'badge-success' : 'badge-warning'}} text-white p-1  f-11 ">{{$user->email_verified_at !=null ? 'Verified' : 'Unverified'}}
										</span>
									</td>
									<td>
										<span class="badge {{$user->status == 'P' ? 'badge-danger' : 'badge-success'}} text-white p-1  f-11 ">{{$user->status =='P' ? 'Inactive' : 'Active'}}
										</span>
									</td>
									<td>
										@role('super_admin')

										<a href="javascript:void(0)"  class="{{$user->status == 'P' ? 'text-danger' : 'text-success'}} text-white ml-1 approvalUser" data-id="{{$user->id}}" data-type="{{$user->user_role}}"><i class="nav-icon i-Navigation-Right-Window font-weight-bold" title="{{$user->status == 'P' ? 'Unapprove' : 'Approve'}}" ></i></a> 
										@endrole 

										<a href="{{route('buyerseller.edit',$user->id)}}" class="text-info text-white ml-1 " title="Edit">
											<i class="nav-icon i-Eye-Scan font-weight-bold"></i>
										</a>            
							            <a href="{{route('buyerseller.show',$user->id)}}" class="text-warning text-white ml-1 " title="View"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>            
							            <a href="{{route('buyerseller_destroy',$user->id)}}" class="text-danger text-white ml-1 " title="Delete" onclick="return confirm('Are you sure you want to delete user?');"><i class="nav-icon i-Close-Window font-weight-bold"></i></a>   
									</td>
									
								</tr>
								@endforeach
								
							</tbody>
						</table>
					</div>
						<div id="paginationLinkbuyer">
			            	{{ $users->links() }}
			            </div>	
					</div>
				</div>
			</div>
		</div>
	</div> 
	</div>
</div>

@endsection
