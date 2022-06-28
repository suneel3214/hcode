function fn_user_approval(user_id){
    $.ajax({
        type:'GET',
        url:"/buyerseller_approve/"+user_id,
        success:function(res){
            if(res.status == 'success'){
                alert(res.message)
                window.location.reload();
            }
        }
    });
}