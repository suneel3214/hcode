
<div class=" ">
    <div class="">
		<div class="">			  
			<div class="">
				 <div class="">
					<div class="box-header with-border">	

					   @if($message = Session::get('success'))
			            <div class="alert alert-success pull-right btn-sm">
			                {{$message}}
			            </div>
			        	@endif
					</div>
        			 <div class="">
					<form action="{{route('category.store')}}" method="post" autocomplete="off" enctype="multipart/form-data">
						@csrf
						@include('admin.master.category.form')
		    		
		    		<div class="row">
		    			<div class="col-md-12 form-group">
		    				<button class="btn btn-sm btn-primary">Submit</button>
		    			</div>
		    		</div>
		    	</form>
				</div>
			</div>		
		</div> 
		</div> 
	</div>
</div>

