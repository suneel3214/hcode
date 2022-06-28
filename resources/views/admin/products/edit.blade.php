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
						  		<h4 class="box-title mt-2">Edit Product</h4>
						  	</div>	
								
					  	</div>		
					  	</div>	
					</div>
        			 <div class="card-body1">
						<form id="forme" data-action="{{url('products_edit/'.$product->pro_id)}}" method="post" autocomplete="off" enctype="multipart/form-data"	>
							@csrf
							<div class="form">
								@include('admin.products.form')
								<div class="row">
					    			<div class="col-md-12 form-group" style="display:none;">
					    				<button class="next btn-lg  btn btn-sm btn-primary">Next</button>
					    			</div>
				    			</div>
							</div>	
							<div id="form2" class="hidden">
								@include('admin.products.form2')
								<div class="col-md-12 form-group" >
				    				<a data-type="submit" class="text-white preview btn-lg submit btn btn-sm btn-primary" style="display:none;">Previous</a>
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
			    		<form  method="post"  id="upload-widget-edit" action="{{url('testMy')}}" class="dropzone hidden">
								@csrf
							    <input name="proId" type="hidden" id="proId" />
							    <input name="type" type="hidden" value='edit' />
							  <div class="fallback">
							    <input name="image[]" type="file" />
							  </div>
							</form>
			    		<input type="hidden" value="1" id="formN">
			    		{{-- <form method="post" id="form2" enctype="multipart/form-data" class="hidden">
							@csrf
							@include('admin.products.form2')
				    		<div class="row">
				    			<div class="col-md-12 form-group" >
				    				<button class="submit btn btn-sm btn-primary">Submit</button>
				    			</div>
				    		</div>
			    		</form> --}}
					</div>
					@foreach($tagIds as $key => $tagid)
	    				<input  type="hidden" class="selectedtagid" value="{{$tagid}}">
	    			@endforeach	
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
{{-- <script src="https://cdn.tiny.cloud/1/yn9zuvxxxes2eb8two0jgc2e9r55jzvoxkjwmpja50wv0fwe/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> --}}
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
	$(document).ready(function(){
			setTimeout(()=>{
				$('.mysuccess').remove()
			},3000)
	})
</script>
<script>

	Dropzone.autoDiscover = false;
	$(document).ready(function(){
    var myDropzone = new Dropzone("#upload-widget-edit", { 
       autoProcessQueue: false,
       uploadMultiple: true,
       parallelUploads:10,
       maxFiles: 10,
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
  
    $('.submit').click(function(e){
    	e.preventDefault()
    	var url = $('#forme').attr('data-action')
    	
    	for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    	}

    	$.ajax({
    		method:'post',
    		url:url,
    		data:$('#forme').serialize(),
    		beforeSend: function(){
          $('.save').attr("disabled", true);
        },
    		success:function(res){
    			$('#proId').val(res)
    			$('#long_des-error').hide()
          $('#long_des-error').text('')
    			$('#short_des-error').hide()
	        $('#short_des-error').text('')
    			setTimeout(()=>{
       			myDropzone.processQueue();
    			},2000)
    			var queue = myDropzone.getAcceptedFiles();
    			if(queue.length === 0){
    				setTimeout(()=>{
			      	location.href = '/products'
	     			},2000)
    			}	
    		},
    		error:function(error){
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

     $("#upload-widget-edit").sortable(
     		{
     			 stop: function () {
			      var queue = myDropzone.getAcceptedFiles();
			      newQueue = [];
			      $('#upload-widget-edit > .dz-preview > .dz-image > img').each(function (count, el) {           
			            var name = $(el).attr('alt');
			            queue.forEach(function(file) {
			                if (file.name === name) {
			                    newQueue.push(file);
			                }
			            });
			      });
			      myDropzone.files = newQueue;
			      var queue = myDropzone.getAcceptedFiles();
			    },
			     update: function (event, ui) {
                console.log(ui)
            }
     		}

     	);

     $(".imgSort").sortable(
     		{
     			update: function (event, ui) {
     				var array = []
             $('.imgSingle').each((index,element)=>{
              	var newID = $(element).attr('data-newid');
              	var imgID = $(element).attr('data-imgid').toString();
              	array.push({'newOrder':newID,'imgId':imgID});
              })
            $.ajax({
            	method:'post',
            	url:'/updateImageOrder',
            	data:{'data':array},
            	success:function(res){
            		console.log(res)
            	}

            })
          }
     		}

     	);

		setTimeout(()=>{
			$('.mysuccess').remove()
		},7000)
	})
</script>
<script type="text/javascript">

	// Vanilla JS
$(document).on('click','.preview',function(){
	$('#formN').val(1)
	$('.form').removeClass('hidden')
	$('#form2').addClass('hidden')
	$('.nextBtn').attr('disabled',false)
		$('.dropzone').addClass('hidden')
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
})

$(document).ready(function(){
	$('.next').click(function(e){
				e.preventDefault()
        var form = '#forme'
          $(form).validate({  
            rules: {  
              name: 'required',  
              bid_option: 'required',  
              add_to_cart_option: {  
                required: true,  
              },  
              free_option: {  
                required: false,  
              },
              catg_id: {  
                required: true,  
              },
              subcatg_id: {  
                required: false,  
              },
              image: {  
                required: false,  
              }, 
              discount: {  
                required: false,  
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
            	var num = $('#formN').val() 
            	if(num === '1'){
            		var bid_option = $('#bid_option').val()
            		var add_to_cart = $('#add_to_cart').val()
            		var free = $('#free').val()
            		$('.nextBtn').attr('disabled',true)
            		$('.preview').attr('disabled',false)
            		$('.save').attr('disabled',false)
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
            	$(document).ready(function(){
	            	var id = $('.province').val()
						    var selectid = $('#citySelect').val()
						     getRegion(id,selectid)
            	})
            }  
          });  
        }); 
})

$(document).ready(function(){
	 $('#forme').submit(function(e){
	 				e.preventDefault()
        	var form = '#forme'
          $(form).validate({  
            rules: {  
              name: 'required',  
              bid_option: 'required',  
            
              discount: {  
                required: false,  
              }, 
              image: {  
                required: false,  
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
	// tinymce.init({
 //    selector: '#short_des',
 //    toolbar_mode: 'floating',
 //    init_instance_callback: function (editor) {
	//     editor.on('Change', function (e) {
	//     	$('#short_des').text(e.level.content)
	//   	});
	//   }
 //  });
 //  tinymce.init({
 //    selector: '#long_des',
 //    toolbar_mode: 'floating',
 //    init_instance_callback: function (editor) {
	//     editor.on('Change', function (e) {
	//     	$('#long_des').text(e.level.content)
	//   });
 //  }
 //  });

  function myCustomOnChangeHandler(inst) {
	  alert("Some one modified something");
	  alert("The HTML is now:" + inst.getBody().innerHTML);
	}

  tinymce.get('#short_des').setContent('my_value_to_set');
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

$(document).on('change','.bid_option',function(){
	var value = $(this).val()
	if(value === 'Yes'){
		$('.bid_price').css('display','inline')
		$('.free-div').css('display','none')
		$('#free').val('No')
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
		$('.bid-div').css('display','none')
		$('#bid_price').css('display','none')
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

function getSubCategory(id,selected=''){
	$.ajax({
		method:'get',
		url:'/gatSubCategory/'+id+'/'+selected,
		success:function(subcat){
			$('.subcatg_id').html(subcat)
		}
	})
}
$(document).ready(function(){
	var tagids = [];
	getSubCategory({{$catIds}},{{$subcatIds}})
	$('.selectedtagid').each(function () {
       	tagids.push($(this).val());
  	});
  	$('.select2-tag').val(tagids)
})
$(document).on('change','#category',function(){
	var id = $(this).val()
	getSubCategory(id)
})

$(document).on('click','.deleteImage',function(){
	var url = $(this).attr('url')
	$.ajax({
		method:'get',
		url:url,
		success:function(res){
			$('.deleteimg').html(res)
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
