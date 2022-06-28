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
									<div class="alert alert-success alert-dismissible fade show" role="alert">
									  	{{$message}}
									  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
									    <span aria-hidden="true">&times;</span>
									  </button>
									</div>
			        	@endif
							</div>	

							<div class="col-md-6">
						  		<h4 class="box-title mt-2">Add Product</h4>
						  	</div>	
							
					  	</div>	
					</div>
        			 <div class="card-body1">
						<form id="form" data-action="{{route('products.store')}}" method="post" autocomplete="off" enctype="multipart/form-data"	>
							@csrf
							<div class="form">
								@include('admin.products.form')
								<div class="row">
					    			<div class="col-md-12 form-group" style="display:none;">
					    				<button class="next btn-lg  btn btn-sm btn-primary">Next</button>.
					    			</div>
				    			</div>
							</div>	
							<div id="form2" class="hidden">
								@include('admin.products.form2')
								<div class="col-md-12 form-group" style="display:none;">
				    				<button data-type="submit" class="btn-lg submit btn btn-sm btn-primary saveBtn" style="display: none;">Submit</button>
				    			</div>
							</div>	

							<div class="row">
								<div class="col-md-6 mb-3">
					  			<button class="btn btn-primary pull-left mt-2 btn-sm float-left preview mr-2" disabled> << Previous
					  			</button>
									<button class="btn btn-primary pull-left mt-2 btn-sm float-left save mr-2" disabled> Submit
					  			</button>
					  			<button class="btn btn-primary pull-left mt-2 btn-sm float-left nextBtn mr-2">Next >>
					  			</button>
					  		</div>
							</div>				    		
			    		</form>
			    		<span id="image-error" class="text-danger"></span>
							<form  method="post"  id="upload-widget-create" action="{{url('testMy')}}" class="dropzone hidden">
								@csrf

							    <input name="proId" type="hidden" id="proId" />
							    <input name="type" type="hidden" value='create' />
							  <div class="fallback">
							    <input name="image[]" type="file" />
							  </div>
							</form>
			    		<input type="hidden" value="1" id="formN">
			    		{{-- <form method="post" id="form2" enctype="multipart/form-data" class="hidden">
							@csrf
							@include('admin.products.form2')
				    		<div class="row">
				    			<div class="col-md-12 form-group" style="text-align: center;">
				    				<button class="submit btn btn-sm btn-primary">Submit</button>
				    			</div>
				    		</div>
			    		</form> --}}
					</div>
				</div>
			</div>		
		</div> 
	</div>
</div>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<script src="https://code.jquery.com/jquery-3.6.0.js" ></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
 <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>

<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>

<!-- Change /upload-target to your upload address -->
<style>
.hidden{
	display: none;
}
.error{
	color: red !important;
}

</style>


<script>

	Dropzone.autoDiscover = false;
	$(document).ready(function(){
    var myDropzone = new Dropzone("#upload-widget-create", { 
       autoProcessQueue: false,
       uploadMultiple: true,
       parallelUploads:10,
       maxFiles: 5,
       acceptedFiles: ".jpeg,.jpg,.png,.gif",
       addRemoveLinks: true,
       init: function() {
	      this.on('completemultiple', function(file, json) {
	       $('.sortable').sortable('enable');
	      });

	      this.on("complete", function (file) {
		      setTimeout(()=>{
		      	location.href = '/products'
     			},2000)
		    });
	    }
    });
  
    $('.submit').click(function(){
    	var url = $('#form').attr('data-action')
    	var queue = myDropzone.getAcceptedFiles();
    	if(queue.length ===0){
    		$('#image-error').text('This field is required')
    		return
    	}

    	for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    	}
    	
    	$.ajax({
    		method:'post',
    		url:url,
    		data:$('#form').serialize(),
    		beforeSend: function(){
          $('.save').attr("disabled", true);
        },
    		success:function(res){
    			$('#short_des-error').hide()
    			$('#long_des-error').hide()
    			$('#proId').val(res)
    			setTimeout(()=>{
       			myDropzone.processQueue();
    			},2000)

    		},
    		error:function(error){
    			$('.save').attr("disabled", false);
    			var {responseJSON} = error
    			var{errors} = responseJSON
    			if(errors.long_des){
    					$('#long_des-error').show()
            	$('#long_des-error').text('This field is required')
    			}else{
    				$('#long_des-error').hide()
            	$('#long_des-error').text('')
    			}
    			if(errors.short_des){
    					$('#short_des-error').show()
	            $('#short_des-error').text('This field is required')
    			}
    			else{
    				$('#short_des-error').hide()
	          $('#short_des-error').text('')
    			}
    		}
    	})
    });

     $("#upload-widget-create").sortable(
     		{
     			 stop: function () {
			      var queue = myDropzone.getAcceptedFiles();
			      newQueue = [];
			      $('#upload-widget-create > .dz-preview > .dz-image > img').each(function (count, el) {           
			            var name = $(el).attr('alt');
			            queue.forEach(function(file) {
			                if (file.name === name) {
			                    newQueue.push(file);
			                }
			            });
			      });
			      myDropzone.files = newQueue;
			      var queue = myDropzone.getAcceptedFiles();
			    }
     		}
     	);

		setTimeout(()=>{
			$('.mysuccess').remove()
			$('.show').remove()
		},7000)
	})
</script>
<script type="text/javascript">
	// Vanilla JS
$(document).on('click','.preview',function(){
	$('#formN').val(1)
	$('.form').removeClass('hidden')
	$('.dropzone').addClass('hidden')
	$('#form2').addClass('hidden')
	$('.nextBtn').attr('disabled',false)
	$('.preview').attr('disabled',true)
	$('.save').attr('disabled',true)
})
$(document).ready(function(){
	$('.nextBtn').click(function(){
		$('.next').click()
	})

	$('.save').click(function(){
		$('.saveBtn').click()
	})

	$('.next').click(function(e){
				e.preventDefault()
        var form = '#form'

          $(form).validate({  
            rules: {  
              name: {required:true},  
              bid_option: 'required',  
              add_to_cart_option: {  
                required: true,  
              },  
              free_option: {  
                required: true,  
              },
              catg_id: {  
                required: true,  
              },
              subcatg_id: {  
                required: false,  
              }, 
              discount:{
              	required:false,
              },
              shipping_price:{
              	required:true,
              },


            },  
            messages: {  
              name: 'This field is required',  
              l_name: 'This field is required',  
              user_email: 'Enter a valid email',  
              psword: {  
                minlength: 'Password must be at least 8 characters long'  
              }  
            }, 
            submitHandler: function(form) {
            	var num = $('#formN').val() 
            	if(num === '1'){
            		var bid_option = $('#bid_option').val()
            		var add_to_cart = $('#add_to_cart').val()
            		var free = $('#free').val()
            		// $('.nextBtn').attr('disabled',true)
            		$('.preview').attr('disabled',false)
            		$('.save').attr('disabled',false)
            		$('.nextBtn').attr('disabled',true)
            		$('.dropzone').removeClass('hidden')

            		if(bid_option === 'No' && add_to_cart === 'No' && free === 'No'){
            			alert("Sorry! You have to select yes for any one field (Bid, Add to cart, Free)")
            		}else{
            			$('#formN').val(2)
	            		$('.form').addClass('hidden')
	              	$('#form2').removeClass('hidden')
            		}
            	}else{
            	

            		 $.ajax({
            		 	method:'pots',
            		 	url:'products/store',
            		 	data:new FormData($(form)),
            		 	success:function(res){
            		 		console.log(res)
            		 	}

            		 })
            	}
            }  
          });  
        }); 
})
// $('.long_des').keyup(function(){
// 	var long_des_hide = $(this).val()
// 	alert(long_des_hide)
// 	// $('#long_des_hide').val(long_des_hide)
// })
$(document).ready(function(){
	 $('#form').submit(function(e){
	 			e.preventDefault()
        	var form = '#form'
          $(form).validate({  
            rules: {  
              name: 'required',  
              bid_option: 'required',  
            
              discount: {  
                required: false,  
              },
              shipping_price:{
              	required:false,
              },
              state:{
              	required:true,
              },
              city:{
              	required:true,
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
            	
            }   
          });  
        });
})

$(document).ready(function() {
	var nextDate
	CKEDITOR.replace( 'long_des');
	CKEDITOR.replace( 'short_des');
	// $(document).ready(function () {
	    $("#bid_start_date").datepicker({
	    	dateFormat:'yy-mm-dd',
	    	maxDate: '2D',
	    	minDate:new Date(),
	    	onSelect: function() {
        		var date = $(this).val()
				var dateObj = new Date(date)	
				var from_year = dateObj.getFullYear()
				var from_month = dateObj.getMonth()+1
				var from_day = dateObj.getDate()
				nextDate = (from_year+'-'+from_month+'-'+from_day)	
				// alert(nextDate)
    		}
	    });
	    // $('#bid_end_date').datepicker('option', 'minDate', new Date(nextDate));
	    $("#bid_end_date").datepicker({
	    	dateFormat:'yy-mm-dd',
	    	minDate:new Date(),	
	    	maxDate: '14D',
	    	onSelect: function() {
	    		// alert(new Date(nextDate))
    		}
	    });
	// });

	var imagesPreview = function(input, placeToInsertImagePreview) {
        if (input.files) {
        	var oldImg = $('.gallery').children().length
            var filesAmount = input.files.length;
            var arraysize = [];
            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();
                reader.onload = function(event) {
                	var html = `<span id="delimg${oldImg}"><a class="delimg fa fa-trash" data-id="${oldImg}"></a><img class="imgPro" src="${event.target.result}"></span>`
                    $(placeToInsertImagePreview).append(html);
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

    }


    $('#gallery-photo-add').on('change', function() {
    		var newImg = $('.gallery').children().length
    		var oldImg = $('.imgShow').children().length
    		if($('span').hasClass('imgShow')){
    			newImg = newImg + oldImg
    		}
    		if( newImg <= 8 ){
        	imagesPreview(this, 'div.gallery');
        }
        if( newImg > 8 ){
        	alert('You can upload only 8 images...')
        }
    });
});
  $(document).on('click','.delimg',function(){
  	var id = $(this).attr('data-id')
  	$('#delimg'+id).remove()
  })

$(document).on('change','.bid_option',function(){
	var value = $(this).val()
	if(value === 'Yes'){
		$('.bid_price').css('display','inline')
		$('.free-div').css('display','none')
	}
	else{
		$('.bid_price').css('display','none')
		$('.free-div').css('display','inline')
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
	$('#bid_end_date').attr('max',nextDate)
})

$(document).on('change','#category',function(){
	var id = $(this).val()
	$.ajax({
		method:'get',
		url:'/gatSubCategory/'+id,
		success:function(subcat){
			$('.subcatg_id').html(subcat)
		}
	})
})

$(document).on('change','#shipping_option',function(){
	var status = $(this).val()

	if(status === 'Available'){
		$('.shipping_price').css('display','inline')
	}
	else{
		$('.shipping_price').css('display','none')
	}
})
</script>

@endsection
