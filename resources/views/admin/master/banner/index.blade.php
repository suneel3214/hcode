@extends('layouts.main')
@section('content')
<div class="card text-left">
    <div class="card-body">
    <div class="row">
        <div class="col-md-12">
					<div class="box-header">	
						<div class="row">
							<div class="col-md-6">					
								<h4 class="box-title pl-3 mt-2">Banner Request</h4>
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
							<table id="request_banner" class="table " style="width:100%">
								<thead>
									<tr>
										<th>#</th>
										<th>Seller Name</th>
										<th>Email</th>
										<th>Heading</th>
										<th>Highlight Text</th>
										<th>Link</th>
										<th>Start Date</th>
										<th>End Date</th>
										<th>Total Day's</th>
										<th>Location Of Banner</th>
									</tr>
								</thead>
								<tbody>
									<?php $count = 1; ?>
									@foreach($bannerRequest as $category )
									<?php 
										$start = !empty($category->start_date) ? strtotime($category->start_date): date('Y-m-d');
										$end = !empty($category->end_date) ? strtotime($category->end_date):date('Y-m-d');
									
										$days_between = !empty($category->start_date) ? ceil(abs($end - $start) / 86400) : 0;
									?>
									<tr>
										<td>{{$count++}}</td>
										<td>{{$category->seller->name}}</td>
										<td>{{$category->seller->email}}</td>
										<td>{{$category->heading}}</td>
										<td>{{$category->highlight_text}}</td>
										<td>{{$category->link}}</td>
										<td>{{$category->start_date}}</td>
										<td>{{$category->end_date}}</td>
										<td>{{$days_between}} Day's</td>
										<td>{{$category->banner_location}}</td>
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
