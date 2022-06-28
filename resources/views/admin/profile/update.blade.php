@extends('layouts.main')
@section('content')
<div class="card text-left">
    <div class="card-body">
		<div class="row mt-3">			  
			<div class="col-lg-12 col-md-12">
				 <div class="box">
                    <div class="col-md-12">
                        @if($message = Session::get('success'))
                            <div class="alert alert-success btn-sm">
                                {{$message}}
                            </div>
                        @endif
                    </div>
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
							</div>	
							<div class="col-md-6">
						  		<h4 class="box-title mt-2 pl-3">Update Profile</h4>
						  	</div>	
							<div class="col-md-6">
					  			<a href="{{route('products.index')}}"class="btn btn-primary pull-right mt-2 btn-sm float-right mr-5">Back
					  			</a>
					  		</div>	
					  	</div>	

					</div>
        			 <div class="card-body">
						<form id="form" action="{{route('updateProfile')}}" method="post" autocomplete="off" enctype="multipart/form-data"	>
							@csrf
							<div class="row">  
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                    <label for="f_name">First name*</label>
	                                    <input value="{{old('f_name') ? old('f_name'):$user->f_name}}" class="form-control form-control-rounded" id="f_name" type="text" name="f_name">
	                                    @error('f_name')
	                                        <span class="invalid-feedback" role="alert">
	                                            <strong>First name is required.</strong>
	                                        </span>
	                                    @enderror
	                                </div>
	                            </div>
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                    <label for="l_name">Last name*</label>
	                                    <input value="{{old('l_name') ? old('l_name'):$user->l_name}}" class="form-control form-control-rounded" id="l_name" name="l_name" type="text">
	                                    @error('l_name')
	                                        <span class="invalid-feedback" role="alert">
	                                            <strong>Last name is required.</strong>
	                                        </span>
	                                    @enderror
	                                </div>
	                            </div>   
                            </div>
	                        <div class="row ">
	                             <div class="col-md-6">
	                                <div class="form-group">
	                                    <label for="email">Email*</label>
	                                    <input disabled="disabled" value="{{old('email') ? old('email'):$user->email}}" class="form-control form-control-rounded" id="email" type="email" name="email">
	                                    @error('email')
	                                        <span class="invalid-feedback" role="alert">
	                                            <strong>{{$message}}</strong>
	                                        </span>
	                                    @enderror
	                                </div>
	                            </div>
	                             <div class="col-md-6">    
	                                <div class="form-group">
	                                    <label for="business_name">Username/Business name*</label>
	                                    <input value="{{old('business_name') ? old('business_name'):$user->business_name}}" class="form-control form-control-rounded" id="business_name" type="text" name="business_name">
	                                    @error('business_name')
	                                        <span class="invalid-feedback" role="alert">
	                                            <strong>{{ $message }}</strong>
	                                        </span>
	                                    @enderror
	                                </div>
	                            </div> 
	                        </div> 
	                        <div class="second" > 
                        <div class="row">
                            <div class="col-md-12" style="padding-top: 24px;">
                                <h1 class="mb-3 text-18">Basic Details</h1>
                            </div>  
                                <div class="email col-sm-12 error"></div>
                                <div class="phone col-sm-12 error"></div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label for="dob">Date of birth*</label>
                                    <input value="{{old('dob') ? old('dob'):$user->dob}}" class="form-control form-control-rounded " id="dob"  name="dob">
                                    @error('dob')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>Date of birth is required.</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>    
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone_no">Phone number*</label>
                                    <input value="{{old('phone_no') ? old('phone_no'):$user->phone_no}}" class="form-control form-control-rounded" id="phone_no" type="tel" name="phone_no">
                                    @error('phone_no')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>Phone number is required.</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>                       
                            
                        </div>    
                        <div class="row">
                              <div class="col-md-6">                           
                                <div class="form-group ">
                                    <label for="repassword">Gender</label>
                                    <div style="display: flex;">
                                        <div class="form-check mr-3">
                                            <input class="form-check-input" id="gender" type="radio" name="gender" value="male" {{$user->gender==='male' ? 'checked=checked':''}} >
                                            <label class="form-check-label ml-1" for="gridRadios1">
                                                Male
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" id="gender1" type="radio" name="gender" {{$user->gender==='female' ? 'checked=checked':''}} value="female" >
                                            <label class="form-check-label ml-1" for="gender">
                                               Female
                                            </label>
                                        </div>
                                        <div class="form-check" style="padding-left: 35px;">
                                            <input {{$user->gender==='Diverse' ? 'checked=checked':''}} class="form-check-input" id="gender2" type="radio" name="gender" value="Diverse" >
                                            <label class="form-check-label ml-1" for="gender">
                                               Diverse
                                            </label>
                                        </div>
                                    </div>    
                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                             <div class="col-md-6">        
                                <div class="form-group 454545">
                                    <label for="repassword">Country</label>
                                    <div style="display: flex;">
                                        <div class="form-check mr-3">
                                            <input class="form-check-input" id="country" type="radio" name="country" value="New Zealand" checked="checked">
                                            <label class="form-check-label ml-1" for="country">
                                                New Zealand 
                                            </label>
                                        </div>
                                    </div>    
                                    @error('country')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>  
                        <div class="row">
                            <div class="col-md-6 form-group error-div">
                                <label>Region </label><span class="text">*</span><br>
                                <select name="state"  class="form-control province form-control-rounded required js-example-basic-single"   >
                                    <option value="">Select Region</option>
                                    @foreach(getAllProvince() as $key => $Citt)
                                        <option {{(int)$user->state === $Citt->id ? 'selected=selected' : ''}} value="{{$Citt->id}}">{{$Citt->name}}</option>
                                    @endforeach
                                </select>   
                                @error('country')
                                    <p class="help-block text-danger font-size-12">
                                        <strong>{{ 'This field is required' }}</strong>
                                    </p>
                                @enderror
                                <input type='hidden' value='{{$user->city}}' id="citySelect">
                            </div>
                            <div class="col-md-6 form-group error-div">
                                <label>District </label><span class="text">*</span><br>
                                <select name="city"  class="form-control regions form-control-rounded required js-example-basic-single"   >
                                    <option value="">Select District</option>
                                    
                                </select>   
                                @error('state')
                                    <p class="help-block text-danger font-size-12">
                                        <strong>{{ 'This field is required' }}</strong>
                                    </p>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">  
                                <div class="form-group">
                                    <label for="password">Password*</label>
                                    <input value="{{old('password')}}" class="form-control form-control-rounded" id="password" type="password" name="password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>Password is required.</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">    
                                <div class="form-group">
                                    <label for="password_confirmation">Password Confirmation*</label>
                                    <input value="{{old('f_name')}}" class="form-control form-control-rounded" id="password_confirmation" type="password" name="password_confirmation">
                                    @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>        
            
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="repassword">Address*</label>
                                    <input value="{{old('address_finder') ? old('address_finder'):$user->address_finder}}" class="form-control form-control-rounded" id="address" type="text" name="address_finder">
                                    @error('address_finder')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                             </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div style="display: flex;">
                                        <label>
                                            Billing address
                                        </label>
                                        <label style="margin-left: 10px;" class="checkbox checkbox-success">
                                            <input type="checkbox" id="bill_address">
                                            <span>
                                                Same as above
                                            </span><span class="checkmark"></span>
                                        </label>
                                    </div>        
                                    <input value="{{old('billing_address') ? old('billing_address'):$user->billing_address}}" class="form-control form-control-rounded" id="billing_address" type="text" name="billing_address">
                                    @error('billing_address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span> 
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-4 form-group error-div">
                                        <label>Select you profile image</label></span><br>
                                        <div class="fallback">
                                            <input type="file" name="image" class="form-control required" id="gallery-photo-profile" data-maxsize="1024"
                                >
                                        </div>
                                        @error('image')
                                            <span class="help-block text-danger font-size-12">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <div class="gallery" style="width: 800px; height: 100px; display: grid;
                                    grid-template-columns: repeat(10, 1fr);">
                                        
                                        </div>
                                    </div> 

                                </div>
                                @if($user->image !== null)
                                    <div class="row">
                                        <div class="col-md-2">
                                            <img src="{{url('/storage').'/'.$user->image->doc_path}}">
                                        </div>    
                                    </div>  
                                @endif      
                             </div>   
                        </div>
                    </div>
                    <div class="row">
                    	<div class="col-md-12 mt-2">
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
<?php
	$mydate = (string)date('Y-m-d',strtotime(date('Y-m-d'))-504576000);
?>
<script src="https://code.jquery.com/jquery-3.6.0.js" ></script>

<script >
	$(document).ready(function(){
		var dateObj = new Date()
		var from_year = dateObj.getFullYear()-18
		var from_month = dateObj.getMonth()+1
		var from_day = dateObj.getDate()
		var nextDate = (from_year+'-'+from_month+'-'+from_day)
		$("#dob").datepicker({
	    	dateFormat:'yy-mm-dd',
	    	maxDate:nextDate,
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0",
	    	onSelect: function() {
	    		// alert(new Date(nextDate))
    		}
	    });
	})


	$(document).on('change','#bill_address',function(e){
        var address = $('#address').val()
        if($('#bill_address').is(":checked")){
         $('#billing_address').val(address)   
        }
        else{
         $('#billing_address').val('')   
        }
    })

    function imagesPreview (input, placeToInsertImagePreview) {
        alert('file')
        console.log(input.files)
        if (input.files) {
            var filesAmount = input.files.length;
            var arraysize = [];
            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }
               reader.readAsDataURL(input.files[i]);
                                var sizeInKB =input.files[i].size
                var sizeLimit= 100;

                // if (sizeInKB >= sizeLimit) {
                //     alert("Max file size 10MB");
                //     return false;
                // }
            }

        }

    };

    $('#gallery-photo-profile').on('change', function() {
        alert('dfdf')
        imagesPreview(this, 'div.gallery');
    });
</script>
@endsection
