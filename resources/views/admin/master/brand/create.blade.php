@extends('layouts.main')
@section('content')
<div class="card text-left">
    <div class="card-body">
		<div class="row mt-3">			  
			<div class="col-lg-12 col-md-12">
				 <div class="box">
					<div class="box-header with-border">
					 	<div class="row">
								<div class="col-md-6">
						  			<h4 class="box-title pl-3 mt-2">Create Brand</h4>
						  		</div>	
								<div class="col-md-6">
						  			<a href="{{route('brands.create')}}" class="btn btn-primary pull-right float-right mr-3 mt-2 btn-sm">Back</a>
						  		</div>	
								@if($message = Session::get('success'))
						            <div class="alert alert-success btn-sm mt-2 col-md-12">
						                {{$message}}
						            </div>
						        @endif
						    </div>    
						</div>
					</div>
					<form action="{{route('brands.store')}}" method="post" autocomplete="off" enctype="multipart/form-data">
						@csrf
						@include('admin.master.brand.form')
		    		
		    		<div class="row">
		    			<div class="col-md-12 form-group">
		    				<button class="btn btn-sm btn-success ml-3">Submit</button>
		    			</div>
		    		</div>
		    	</form>
				</div>
			</div>		
		</div> 
	</div>
</div>
@endsection
