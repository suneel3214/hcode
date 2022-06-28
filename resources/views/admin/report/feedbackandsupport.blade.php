@extends('layouts.main')
@section('content')
<div class="card text-left">
    <div class="card-body">
		<div class="row mt-3">			  
			<div class="col-lg-12 col-md-12">
				 <div class="box">
					<div class="box-header with-border">
						<div class="row">	
							<div class="col-md-12">
								@if($errors->any())
								    <div class="alert alert-danger">
								        <p><strong>Opps Something went wrong</strong></p>
								        <ul>
								        @foreach ($errors->all() as $error)
								            <li>{{ $error }}</li>
								        @endforeach
								        </ul>
								    </div>
								@endif
							@if($message = Session::get('success'))
				                <div class="alert alert-success">
				                    {{$message}}
				                </div>
			                @endif
							</div>

							<div class="col-md-6">
						  		<h4 class="box-title mt-2 pl-3">Feedback & Support</h4>
						  	</div>	
							<div class="col-md-6">
					  			<a href="{{route('products.index')}}"class="btn btn-primary pull-right mt-2 btn-sm float-right mr-5">Back
					  			</a>
					  		</div>	
					  	</div>	

					</div>
        			 <div class="card-body">
						<form id="form" action="{{route('saveFeedback')}}" method="post" autocomplete="off">
							@csrf
							<div class="row">  
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                    <label for="sbject">Subject*</label>
	                                    <input value="{{old('subject') }}" class="form-control" id="sbject" type="text" name="sbject">
	                                    @error('subject')
	                                        <span class="invalid-feedback" role="alert">
	                                            <strong>Subject is required.</strong>
	                                        </span>
	                                    @enderror
	                                </div>
	                            </div>
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                    <label for="l_name">Type of issue</label>
	                                    <select class="form-control" name="type_of_issue">
	                                    	<option value="Accont issue">Account issue</option>
	                                    	<option value="Payment issue">Payment issue</option>
	                                    	<option value="Banner">Banner</option>
	                                    	<option value="Feedback">Feedback</option>
	                                    	<option value="Others">Others</option>
	                                    </select>
	                                    @error('type_of_issue')
	                                        <span class="invalid-feedback" role="alert">
	                                            <strong>Type of issue is required.</strong>
	                                        </span>
	                                    @enderror
	                                </div>
	                            </div>   
	                            <div class="col-md-12">
	                                <div class="form-group">
	                                    <label for="f_name">Message*</label>
	                                    <textarea type="text" name="message" class="form-control required" placeholder="Enter Long Description" ></textarea>
											@error('message')
										        <span class="help-block text-danger font-size-12">
										            <strong>{{ $message }}</strong>
										        </span>
										    @enderror
	                                </div>
	                            </div>
                            </div>
	                         
		                    <div class="row">
		                    	<div class="col-md-12">
		                    		<button class="btn btn-primary">Save</button>
		                    	</div>
		                    </div>	
			    		</form>
					</div>
				</div>
			</div>		
		</div> 
	</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>

<script>
	$(document).ready(function(){
		CKEDITOR.replace( 'message');
	})
</script>

@endsection
