@extends('layouts.app')

@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"> </script>  
    <script src="https://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"> </script>  
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />   
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css">   

    <script type="text/javascript">

        $(document).ready(function(){
            var crntobject = new Date()
            var crnt_year = crntobject.getFullYear()
            var crnt_month = crntobject.getMonth()+1
            var crnt_day = crntobject.getDate()
            var crntDate = ((crnt_year-18)+'-'+crnt_month+'-'+crnt_day) 
            $("#bid_start_date").datepicker({
                dateFormat:'yy-mm-dd',
                maxDate:crntDate,
                showButtonPanel: true,
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+0",
                onSelect: function() {
                    var crntobject = new Date()
                    var crnt_year = crntobject.getFullYear()
                    var crnt_month = crntobject.getMonth()+1
                    var crnt_day = crntobject.getDate()
                    var crntDate = (crnt_year+'-'+crnt_month+'-'+crnt_day) 
                    
                    // var date = $(this).val()
                    // var dateObj = new Date(date)    
                    // var from_year = dateObj.getFullYear()
                    // var from_month = dateObj.getMonth()+1
                    // var from_day = dateObj.getDate()
                    // // alert(nextDate)

                    // $('.submit').attr('disabled',true)
                }
            });
            "use strict";  
            $('.next').click(function(){
                var form = '.myForm'

                  $(form).validate({  
                    rules: {  
                      f_name: 'required',  
                      l_name: 'required',  
                      email: {  
                        required: true,  
                        email: true,  
                      },  
                  
                      business_name: {  
                        required: true,  
                      },
                      phone_no: {  
                        required: true,
                        digits:true  
                      }, 
                      gender: {  
                            required: true,  
                          },

                    },  
                    messages: {  
                      f_name: 'This field is required',  
                      l_name: 'This field is required',  
                      user_email: 'Enter a valid email',  
                      psword: {  
                        minlength: 'Password must be at least 8 characters long'  
                      }  
                    }, 
                    submitHandler: function(form) {  
                        $('.preview').removeClass('hidden')
                        $('.submit').removeClass('hidden')
                        $('.next').addClass('hidden')
                        $('.first').addClass('hidden')
                        $('.myForm1').removeClass('hidden')
                        $('.preview').removeClass('hidden')
                        $('.phone').text('')
                        $('.email').text('')
                        }  
                  });  
                });  

                $('.submit').click(function(){
                    var form = '.myForm1'
                    $(form).validate({  
                    rules: {  
                        
                          password: {  
                            required: true,  
                            minlength: 8,  
                          },
                          password_confirmation: {
                            equalTo: "#password"
                            },
                          dob: 'required', 
                          phone_no: {  
                            required: true,  
                            digits:true 
                          },
                          gender: {  
                            required: true,  
                          },
                          address_finder: {  
                            required: true,  
                          },
                          billing_address: {  
                            required: true,  
                          },
                          district_town: {  
                            required: true,  
                          },
                          terms: {  
                            required: true,  
                          },  

                        }, 
                    messages: {  
                      dob: 'This field is required',  
                      l_name: 'This field is required',  
                      user_email: 'Enter a valid email',  
                      psword: {  
                        minlength: 'Password must be at least 8 characters long'  
                      }  
                    }, 
                    submitHandler: function(form) {  
                       // $('.myForm').remove()
                       var formData = ($('.myForm, .myForm1').serialize());
                       $.ajax({
                        method:'post',
                        url:"{{route('register')}}",
                        data:formData,
                        beforeSend: function(msg){
                            $(".mk").attr("disable",true);
                            $(".mk").text("Please wait...");
                          },
                        success:function(res){
                            $('.showMsg').text(res)
                            $('.showMsg').removeClass('hidden')
                            setTimeout(()=>{
                                location.href ='/login'
                            },5000)
                        },
                        error:function(res){
                            var {email,phone_no,business_name} = res.responseJSON.errors
                            if(email){
                                $('.email').text('The email has already been taken.')
                            }
                            if(business_name){
                                $('.business_name').text('The business name has already been taken.')
                            }

                            if(phone_no){
                                $('.phone').text('The phone number has already used.')
                            }
                            if(!phone_no){
                                $('.phone').text('')
                            }
                            if(!email){
                                $('.email').text('')
                            }
                            // var error = JSON.parse(res.responseJSON)
                            // res.responseJSON.errors.map((value,index)=>{
                            //     console.log(value)
                            // })
                        }
                       })

                    }  
                  });  
                });
            })

        $(document).on('click','.preview',function(){
            $('.myForm1').addClass('hidden')
            $('.myForm').removeClass('hidden')
            $('.first').removeClass('hidden')
            $('.next').removeClass('hidden')
        })
        
        $(document).on('change','.province',function(){
            var id = $(this).val()
            $.ajax({
                method:'get',
                url:'/regions/'+id,
                success:function(res){
                    $('.regions').html(res)
                }
            })
        })
       
    </script>
    <style>
    #terms-error{
        position: absolute;
        top: 22px;
        left: 0px;
    }
    .hover:hover{
        background: #5A3CF3;
        box-shadow: 0 8px 25px -8px #663399;
        border-color: #5A3CF3;
    }
    .error{
        color: red !important;
    }
    #gender-error{
        position: absolute;
        margin-top: 20px;
        width: 132px;
    }
    </style>
    <div class="auth-layout-wrap" style="    background: radial-gradient(100.99% 100.73% at 0 0, rgba(0, 196, 204, 0.725916) 0, #00c4cc 0.01%, rgba(0, 196, 204, 0) 100%), radial-gradient(68.47% 129.02% at 22.82% 97.71%, #6420ff 0, rgba(100, 32, 255, 0) 100%), radial-gradient(106.1% 249.18% at 0 0, #00c4cc 0, rgba(0, 196, 204, 0) 100%), radial-gradient(64.14% 115.13% at 5.49% 50%, #6420ff 0, rgba(100, 32, 255, 0) 100%), #7d2ae7;">
    <div class="auth-content">
        <div class="card o-hidden">        
            <div class="p-4">
                <form method="POST" class="myForm">
                    @csrf
                    <div class="row">
                        <div class="auth-logo col-sm-12 " style="text-align: center;">
                            <img src="{{asset('/logo/logo12.png')}}" alt="">
                        </div>
                        <div class="hidden col-sm-12 alert alert-success pull-right btn-sm showMsg">
                        </div>
                    </div>        
                    <div class="first">
                        <div class="row">
                            <div class="hidden col-sm-12 alert alert-success pull-right btn-sm showMsg">
                            </div>
                            <div class="col-md-12">
                                <h1 class="mb-3 text-18">Sign Up</h1>
                            </div>    
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="f_name">First name*</label>
                                    <input value="{{old('f_name')}}" class="form-control form-control-rounded" id="f_name" type="text" name="f_name">
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
                                    <input value="{{old('l_name')}}" class="form-control form-control-rounded" id="l_name" name="l_name" type="text">
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
                                    <input value="{{old('email')}}" class="form-control form-control-rounded" id="email" type="email" name="email">
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
                                    <input value="{{old('business_name')}}" class="form-control form-control-rounded" id="business_name" type="text" name="business_name">
                                    @error('business_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> 
                        </div>   
                    </div> 
                    <div class="row">
                        <button  class="hover next backGroungColor btn btn-primary btn-block btn-rounded mt-3"> Next
                        </button>
                    </div>   
                </form>    
                <form method="POST" class="myForm1 hidden">    
                    <div class="second" > 
                        <div class="row">
                            <div class="col-md-12" style="padding-top: 24px;">
                                <h1 class="mb-3 text-18">Basic Details</h1>
                            </div>  
                                <div class="email col-sm-12 error"></div>
                                <div class="phone col-sm-12 error"></div>
                                <div class="business_name col-sm-12 error"></div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label for="dob">Date of birth*</label>
                                    <input readonly value="{{old('dob')}}" id="bid_start_date" class="form-control form-control-rounded" id="dob"  name="dob">
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
                                    <input value="{{old('phone_no')}}" class="form-control form-control-rounded" id="phone_no" type="tel" name="phone_no">
                                    @error('phone_no')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>Phone number is required.</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- <div class="col-md-6">                           
                                <div class="form-group">
                                    <label for="password">NZ GST no (optional)</label>
                                    <input value="{{old('nz_gst_no')}}" class="form-control form-control-rounded" id="password" type="tel" name="nz_gst_no">
                                </div>
                            </div> --}}                                
                            
                        </div>    
                        <div class="row">
                             
                              <div class="col-md-6">                           
                                <div class="form-group ">
                                    <label for="repassword">Gender</label>
                                    <div style="display: flex;">
                                        <div class="form-check mr-3">
                                            <input class="form-check-input" id="gender" type="radio" name="gender" value="male" checked="checked">
                                            <label class="form-check-label ml-1" for="gridRadios1">
                                                Male
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" id="gender" type="radio" name="gender" value="female">
                                            <label class="form-check-label ml-1" for="gender">
                                               Female
                                            </label>
                                        </div>
                                        <div class="form-check" style="padding-left: 35px;">
                                            <input class="form-check-input" id="gender" type="radio" name="gender" value="Diverse" >
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
                                
                                {{-- <div class="form-group">
                                    <label for="password">Business contact number </label>
                                    <input value="{{old('nz_business_no')}}" class="form-control form-control-rounded" id="password" type="text" name="nz_business_no">
                                    @error('nz_business_no')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div> --}}
                        <div class="row">
                            <div class="col-md-12 form-group error-div">
                                <label>Region </label><span class="text">*</span><br>
                                <select name="state"  class="form-control province form-control-rounded required js-example-basic-single"   >
                                    <option value="">Select Region</option>
                                    @foreach(getAllProvince() as $key => $Citt)
                                        <option value="{{$Citt->id}}">{{$Citt->name}}</option>
                                    @endforeach
                                </select>   
                                @error('country')
                                    <p class="help-block text-danger font-size-12">
                                        <strong>{{ 'This field is required' }}</strong>
                                    </p>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group error-div">
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="repassword">Address*</label>
                                    <input value="{{old('address_finder')}}" class="form-control form-control-rounded" id="address" type="text" name="address_finder">
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
                                    <input value="{{old('billing_address')}}" class="form-control form-control-rounded" id="billing_address" type="text" name="billing_address">
                                    @error('billing_address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span> 
                                    @enderror
                                </div>
                             </div>
                            <div class="col-md-12">
                                <label class="checkbox checkbox-success">
                                    <input type="checkbox" name="terms">
                                    <span>
                                        I am over 18 and have read and accept hithere's <a href="https://hithere.co.nz/terms_condition" style="text-decoration: revert;">terms and conditions </a> and <a style="text-decoration: revert;" href="https://hithere.co.nz/privacy_policy">privacy policy</a>.
                                    </span><span class="checkmark"></span>
                                </label>
                                  @error('terms')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ 'Please check...' }}</strong>
                                        </span> 
                                    @enderror
                                
                            </div>    
                        </div>
                    </div>
                    <div class="row">
                        <button  class="hover submit mk hidden backGroungColor btn btn-primary btn-block btn-rounded mt-3"> Submit
                        </button>
                        <a  class=" hover text-white preview hidden backGroungColor btn btn-primary btn-block btn-rounded mt-3"> Previous
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('change','#bill_address',function(e){
        var address = $('#address').val()
        if($('#bill_address').is(":checked")){
         $('#billing_address').val(address)   
        }
        else{
         $('#billing_address').val('')   
        }

        var dateObj = new Date()
        var from_year = dateObj.getFullYear()-18
        var from_month = dateObj.getMonth()+1
        var from_day = dateObj.getDate()
        var nextDate = (from_year+'-'+from_month+'-'+from_day)

        $("#dob").datepicker({
            format:'dd-mm-yyyy',
            maxDate:nextDate,
            onSelect: function() {
                // alert(new Date(nextDate))
            }
        });
    })
</script>
<style>
    .hidden{
        display: none;
    }
    .show{
        display: none;
    }
    .backGroungColor{
        background: radial-gradient(100.99% 100.73% at 0 0, rgba(0, 196, 204, 0.725916) 0, #00c4cc 0.01%, rgba(0, 196, 204, 0) 100%), radial-gradient(68.47% 129.02% at 22.82% 97.71%, #6420ff 0, rgba(100, 32, 255, 0) 100%), radial-gradient(106.1% 249.18% at 0 0, #00c4cc 0, rgba(0, 196, 204, 0) 100%), radial-gradient(64.14% 115.13% at 5.49% 50%, #6420ff 0, rgba(100, 32, 255, 0) 100%), #7d2ae7;
    }
</style>
@endsection