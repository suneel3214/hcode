$(document).ready(function(){
	$('.js-example-basic-single').select2();
	$(".select2-tag").select2({
	    placeholder: "Select Tag",
	    tags: true,
	    allowClear: true,
	    tokenSeparators: [',', ';'],
	});
})

$(document).on('click','#allDelete,.singleCheck',function(){

	var numItems = $('.singleCheck').length
	var totalCheckboxes = $('.singleCheck:checkbox:checked').length;

	if(($('#allDelete').is(":checked")) ){
		$('.singleCheck').prop('checked',true)
	}
	if(($('#allDelete').is(":checked")) || totalCheckboxes > 0){
		$('.delteButton').css('display','block')
	}
	else{
		$('.delteButton').css('display','none')
	}
})

$(document).on('click','.singleCheck',function(){
	var numItems = $('.singleCheck').length
	var totalCheckboxes = $('.singleCheck:checkbox:checked').length;

	if(numItems !== totalCheckboxes){
		$('#allDelete').prop('checked',false)
	}
	else{
		$('#allDelete').prop('checked',true)
	}
})

function bulkDelete(modelName){

	var ids = []
	$('.singleCheck:checkbox').each(function () {
       var sThisVal = (this.checked ? $(this).val() : "");
       if(this.checked){
       		ids.push($(this).val());
       }
  	});

  	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	})

  	$.ajax({
  		method:'post',
  		url:'bulk_delete',
  		data:{ids,model:modelName},
  		success:function(res){
  			$('.delteButton').css('display','none')
  			$('#productList').html(res)
  		}
  	})
}

$(document).on('click','.approval',function(e){
    e.preventDefault();
    var product_id = $(this).data('id');
     $.ajax({
        type:'GET',
        url:"/product_approve/"+product_id,
        success:function(res){
            // if(res.status == 'success'){
  				$('#productList').html(res)
            // }
        }
    });
});

$(document).on('click','.addMoreDays',function(e){
	var id = $(this).attr('data-id')
	alert(id)
})