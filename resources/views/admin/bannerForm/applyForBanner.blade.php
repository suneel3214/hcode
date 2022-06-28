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
						            <div class="alert alert-success">
						                {{$message}}
						            </div>
					        	@endif
							</div>	
							<div class="col-md-6">
						  		<h4 class="box-title mt-2 pl-3">Apply For Banner</h4>
						  	</div>	
					  	</div>						   
					</div>
        			<div class="card-body">
						<form action="{{route('banner.store')}}" method="post" autocomplete="off" enctype="multipart/form-data" id="example-form">
							@csrf
							<div class="row">
								<hr class="my-15">
								<div class="col-md-6 form-group error-div">
									<label>Heading</label><span class="text-danger">*</span><br>
									<input type="text" name="heading" class="form-control required" placeholder="Enter Name" value="{{old('name')}}">
									@error('heading')
								        <span class="help-block text-danger font-size-12">
								            <strong>{{ $message }}</strong>
								        </span>
								    @enderror
								</div>
								<div class="col-md-6 form-group ">
									<label>Highlight Text<span class="text-danger">*</span></label>
									<input type="text" name="highlight_text" class="form-control" placeholder="Enter Name" value="{{old('shrt_name')}}">
									@error('highlight_text')
								        <span class="help-block text-danger font-size-12">
								            <strong>{{ $message }}</strong>
								        </span>
								    @enderror
								</div>
								
								<div class="col-md-6 form-group">
									<label>Link<span class="text-danger">*</span></label>
									<input type="text" name="link" class="form-control" placeholder="Enter Name" value="{{old('link')}}">
									@error('link')
								        <span class="help-block text-danger font-size-12">
								            <strong>{{ $message }}</strong>
								        </span>
								    @enderror
								</div>
								
								<div class="col-md-6 form-group bid_price" >
									<label>Start Date<span class="text-danger">*</span></label>
									<input  name="start_date" class="form-control bid_price" id="banner_start_date" placeholder="Enter Bid Price" value="{{old('bid_start_date')}}">
									@error('start_date')
								        <span class="help-block text-danger font-size-12">
								            <strong>{{ $message }}</strong>
								        </span>
								    @enderror
								</div>
								<div class="col-md-6 form-group bid_price" >
									<label>End Date<span class="text-danger">*</span></label>
									<input name="end_date" id="banner_end_date" class="form-control bid_price" placeholder="Enter Bid Price" value="{{old('end_date')}}">
									@error('end_date')
								        <span class="help-block text-danger font-size-12">
								            <strong>{{ $message }}</strong>
								        </span>
								    @enderror
								</div>
								<div class="col-md-6 form-group bid_price" >
									<label> Banner Location On Website<span class="text-danger">*</span></label>
						<select class="form-control" name="banner_location">
							<option value="">Select Banner Location</option>
							<option value="Top Main Banner 1200x320">Top Main Banner 1200x320</option>
							<option value="Top Right Top Banner 390x142">Top Right Top Banner 390x142</option>
							<option value="Top Right Bottom Banner 390x142">Top Right Bottom Banner 390x142</option>
							<option value="Middle First Banner 520x189">Middle First Banner 520x189</option>
							<option value="Middle Second Banner 520x189" >Middle Second Banner 520x189</option>
							<option value="Middle Third Banner 520x189">Middle Third Banner 520x189</option>
							<option value="Bottom Main Banner 1070x370">Bottom Main Banner 1070x370</option>
							<option value="Bottom Right Top Banner 189x520">Bottom Right Top Banner 189x520</option>
							<option value="Bottom Right Bottom Banner 189x520">Bottom Right Bottom Banner 189x520</option>
							<option value="All Product Page 1618x400">All Product Page 1618x400</option>
						</select>	
									@error('banner_location')
								        <span class="help-block text-danger font-size-12">
								            <strong>{{ $message }}</strong>
								        </span>
								    @enderror
								</div>
								
								<div class="col-md-12 form-group error-div">
									<label>Description</label><span class="text-danger">*</span><br>
									<textarea type="text" name="description" class="form-control required" placeholder="Enter Long Description" >{{old('description')}}</textarea>
									@error('description')
								        <span class="help-block text-danger font-size-12">
								            <strong>{{ $message }}</strong>
								        </span>
								    @enderror
								</div>
							</div>
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
<script src="https://code.jquery.com/jquery-3.6.0.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>

 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/basic.css"/>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>
<!-- Change /upload-target to your upload address -->
<script>

	$(document).ready(function() {
		var nextDate
		CKEDITOR.replace( 'long_des');
		CKEDITOR.replace( 'short_des');
		// $(document).ready(function () {
		    $("#banner_start_date").datepicker({
		    	dateFormat:'yy-mm-dd',
		    	minDate:new Date()
		    });
		    // $('#bid_end_date').datepicker('option', 'minDate', new Date(nextDate));
		    $("#banner_end_date").datepicker({
		    	dateFormat:'yy-mm-dd',
		    	minDate:new Date(),	
		    });
		// });

		var imagesPreview = function(input, placeToInsertImagePreview) {

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

	    $('#gallery-photo-add').on('change', function() {
	        imagesPreview(this, 'div.gallery');
	    });
	});

	$(document).on('change','.bid_option',function(){
		var value = $(this).val()
		if(value === 'Yes'){
			$('.bid_price').css('display','inline')
		}
		else{
			$('.bid_price').css('display','none')
		}
	})

	$(document).on('change','#free',function(){
		var status = $(this).val()

		if(status === 'Yes'){
			$('#bid_option').val('No')
			$('#add_to_cart').val('Yes')
			$('#add_to_cart').attr('disabled',true)
			$('#bid_option').attr('disabled',true)
			$('#price').attr('disabled',true)
			$('#discount').attr('disabled',true)
			$('.bid_price').css('display','none')	
		}
		else{
			$('#bid_option').val('No')
			$('#bid_option').attr('disabled',false)	
			$('#price').attr('disabled',false)
			$('#discount').attr('disabled',false)
			$('#add_to_cart').attr('disabled',false)
		}
	})
	$(document).on('change','#add_to_cart',function(){
		if($(this).val() === 'Yes'){
			$('#discount').attr('disabled',false)
		}
		else{
			$('#discount').attr('disabled',true)
		}
	})

	$(document).on('change','#bid_start_date',function(){
		var date = $(this).val()
		var dateObj = new Date(date)	
		var from_year = dateObj.getFullYear()
		var from_month = dateObj.getMonth()
		var from_day = dateObj.getDate()+14
		var nextDate = (from_year+'-'+from_month+'-'+from_day)	
		alert(nextDate)
		$('#bid_end_date').attr('max',nextDate)
	})
	</script>
@endsection
