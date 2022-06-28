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
								@if($message = Session::get('success'))
						            <div class="alert alert-success btn-sm">
						                {{$message}}
						            </div>
					        	@endif
							</div>	
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
							</div>	
							<div class="col-md-12">
						  		<h4 class="box-title mt-2 pl-3">Save Bank Details</h4>
						  	</div>		
					  	</div>	
					</div>
        			 <div class="card-body">
						<form onsubmit="return confirm('Make sure you provided details is correct? seller will responsible for money loss');" id="form" action="{{route('addBankDetailsUpdate')}}" method="post" autocomplete="off" >
							@csrf						
	                        <div class="second" > 
                        <div class="row">
                            <div class="col-md-6">                           
                                <div class="form-group">
                                    <label for="password">Bank Account Number</label>
                                    <input value="{{old('account_number') ? old('account_number'):$data->account_number}}" placeholder="Do not use space and special special characters Ex.123456789136655" class="form-control form-control-rounded" id="bankname" type="tel" name="account_number">
                                    @error('account_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> 
                            <div class="col-md-6">                           
                                <div class="form-group">
                                    <label for="password">Bank Name</label>
                                    <input value="{{old('account_name') ? old('account_name'):$data->account_name}}" class="form-control form-control-rounded" id="acc" type="tel" name="account_name">
                                    @error('account_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> 
                            
                        </div>                            
                    </div>
                    <div class="row">
                    	<div class="col-md-12">
                    		<button class="btn btn-primary">Update</button>
                    	</div>
                    </div>	
			    		</form>
					</div>
				</div>
			</div>		
		</div> 
	</div>
</div>

@endsection
