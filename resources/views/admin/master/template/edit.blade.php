@extends('admin.layouts.main')
@section('content')
	<div class="content-wrapper">
		<section class="content">
			<div class="row mt-3">			  
				<div class="col-lg-12 col-12">
					 <div class="box">
						<div class="box-header with-border">
						  <h4 class="box-title mt-2">Update Template</h4>
						  <a href="{{route('category.index')}}" class="btn btn-primary pull-right mt-2 btn-sm">Back</a>
						  @if($message = Session::get('success'))
				            <div class="alert alert-success pull-right btn-sm mt-2">
				                {{$message}}
				            </div>
				        @endif
						</div>
						<form action="{{route('.update',$temlate->id)}}" method="post" autocomplete="off" enctype="multipart/form-data">
							@csrf
							@method('PUT')
							@include('admin.master.template.form')
			    		<div class="row">
			    			<div class="col-md-12 form-group">
			    				<button class="btn btn-sm btn-success">Update</button>
			    			</div>
			    		</div>
			    	</form>
					</div>
				</div>		
			</div> 
		</section>
</div>
@endsection
