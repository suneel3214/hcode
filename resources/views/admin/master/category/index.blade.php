@extends('layouts.main')
@section('content')
<div class="card text-left">
<div class="card-body">
    <div class="row">
        <div class="col-md-12">
			<div class="box-header">	
				<div class="row">
					<div class="col-md-6">					
						<h4 class="box-title pl-3 mt-2">Categories</h4>
					</div>	

					<div class="col-md-6">					
						<a href="#" url="{{route('category.create')}}" class="btn btn-primary pull-right mr-3 add float-right mt-2 btn-sm">Add</a>
					</div>	
				</div>
				@if($message = Session::get('success'))
	            <div class="alert alert-success pull-right btn-sm">
	                {{$message}}
	            </div>
	        	@endif
			</div>
        	<div class="card-body">
				<div class="table-responsive ">
					<table id="cate_table" class="table " style="width:100%">
						<thead>
							<tr>
								<th>#</th>
								<th>Cateory Name</th>
								<th>Sub-Category</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody id="updateCateTable">
							<?php $count = 1; ?>
							@foreach($categories as $category )
							<tr>
								<td>{{$count++}}</td>
								<td>{{$category->catg_name}}
									<a href="#" url="{{route('category.edit',$category->catg_id)}}" class="editCategory nav-icon i-Pen-2 font-weight-bold">
										
									</a>
								</td>
								<td>
									<?php $subCount = 0; ?>
									@foreach($category->subcategories as $subcategory )
										{{$subcategory->catg_name}}
										<span>
											<a href="#" url="{{route('category.edit',$subcategory->catg_id)}}" class="editCategory nav-icon i-Pen-2 font-weight-bold">
											</a>
											<a class="text-danger text-white" href="{{route('category.destroy',$subcategory->catg_id)}}"><i class="nav-icon i-Close-Window font-weight-bold"></i></a>
											
										</span>	,
										<?php 
											if($subCount===3){
												echo '<br>';
												$subCount=0	;
											}
											
											$subCount++; 
										?>
									@endforeach 										
								</td>
								<td>
									<a class="text-danger text-white " href="{{route('category.destroy',$category->catg_id)}}"><i class="nav-icon i-Close-Window font-weight-bold"></i></a>
									<a class="text-danger text-white p-2 ml-2 add" url="{{route('sub-category')}}"><i class="nav-icon  i-Add font-weight-bold"></i></a>
									
								</td>
							</tr>
							@endforeach
							
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<!-- Edit Modal -->
		<div class="modal closeModal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Update</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body modalData">
		        
		      </div>
		    </div>
		  </div>
		</div>

		<!-- Edit Modal -->
		<div class="modal fade closeModal" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Add</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body modalData">
		        
		      </div>
		    </div>
		  </div>
		</div>
	</div>
</div>


@endsection
