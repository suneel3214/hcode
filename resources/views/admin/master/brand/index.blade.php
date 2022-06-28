@extends('layouts.main')
@section('content')
<div class="card text-left">
    <div class="card-body">
	<div class="row mt-3 ">
		<div class="col-12">
			<div class="box">
				<div class="box-header">
					<div class="row mb-2">
						<div class="col-md-6">						
							<h4 class="box-title pl-3 mt-2 ">Brands</h4>
						</div>
						<div class="col-md-6">						
							<a href="{{route('brands.create')}}" class="btn btn-primary pull-right mt-2 mr-3 float-right btn-sm">Add</a>
						</div>	
							@if($message = Session::get('success'))
				            <div class="alert alert-success pull-right btn-sm col-md-12">
				                {{$message}}
				            </div>
			        		@endif
		        	</div>	
				</div>
					<div class="table-responsive">
						<table id="complex_header" class="table " style="width:100%">
							<thead>
								<tr>
									<th>#</th>
									<th>Brand Name</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($brands as $brand )
								<tr>
									<td>{{$brand->brand_id}}</td>
									<td>{{$brand->name}}</td>
									<td>
										<a class="text-info p-2 ml-2" href="{{route('brands.edit',$brand->brand_id)}}">
											<i class="nav-icon i-Pen-2 font-weight-bold"></i>
										</a>
										<a class="text-danger text-white pr-1 "  href="{{route('brands_destory',$brand->brand_id)}}"><i class="nav-icon i-Close-Window font-weight-bold"></i></a>
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
</div>
@endsection
