@extends('layouts.main')
@section('content')
<div class="card text-left">
    <div class="card-body">
    <div class="row">
        <div class="col-md-12">
					<div class="box-header">	
						<div class="row">
							<div class="col-md-6">					
								<h4 class="box-title pl-3 mt-2">Sub Categories</h4>
							</div>	

							<div class="col-md-6">					
								<a href="{{route('sub-category')}}" class="btn btn-primary pull-right mr-3 float-right mt-2 btn-sm">Add</a>
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
							<table id="complex_header" class="table " style="width:100%">
								<thead>
									<tr>
										<th>#</th>
										<th>Sub-Category</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $count = 1; ?>
									@foreach($categories as $category )
									<tr>
										<td>{{$count++}}</td>
										<td>{{$category->catg_name}}</td>
										<td>
											<a class="text-warning text-white p-2 ml-2 " href="{{route('category.edit',$category->catg_id)}}">
												<i class="nav-icon i-Pen-2 font-weight-bold"></i>
											</a>
											<a class="text-danger text-white p-2 ml-2 " href="{{route('category.destroy',$category->catg_id)}}"><i class="nav-icon i-Close-Window font-weight-bold"></i></a>
											
										</td>
									</tr>
									@endforeach
									
								</tbody>
							</table>
						</div>
					</div>
			</div>
		</div>
	</div>
</div>

@endsection
