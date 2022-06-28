
<div class=" text-left">
	<div class="">
		<div class="row mt-3">			  
			<div class="col-lg-12 col-12">
				 <div class="">
					@if($message = Session::get('success'))
			            <div class="alert alert-success pull-right btn-sm">
			                {{$message}}
			            </div>
			        	@endif
    			 <div class="">
					<form action="{{route('category.update',$category1->catg_id)}}" method="post" class="updateCategoryForm" autocomplete="off" enctype="multipart/form-data">
						@csrf
						@method('PUT')
						@include('admin.master.category.form')
		    		<div class="row">
		    			<div class="col-md-12 form-group">
		    				<button class="btn btn-sm btn-primary">Update</button>
		    			</div>
		    		</div>
		    	</form>
				</div>
			</div>
			</div>		
		</div> 
	</div>
</div>
