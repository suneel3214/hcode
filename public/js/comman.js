$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {

    $('#productList').DataTable( { } );
    $('#complex_header').DataTable( { } );
    $('#bid').DataTable( { } );
    $('#buyer_seller').DataTable( { } );
    $('#order_list').DataTable( { 
        "bPaginate": false,
        "bFilter": false,
        "bFilter": false,
        "ordering": false,
    } );
    $('#cate_table').DataTable( { } );
    $('#template_table').DataTable( {
        "bPaginate": false,
        "bFilter": false,
        "bFilter": false,
        "ordering": false,
    } );
    $('#abuse_table').DataTable( { } );
    $('#feedback').DataTable( { } );
    $('#request_banner').DataTable( { } );
    

    $('.js-example-basic-single').select2();
	$(".select2-tag").select2({
	    placeholder: "Select Tag",
	    tags: true,
	    allowClear: true,
	    tokenSeparators: [',', ';'],
	});
} );

$(document).ready(function(){
    var sPageURL = window.location.search.substring(1)
    var sURLVariables = sPageURL.split('&')
    if(sURLVariables.length >= 1){
        sURLVariables.map((val,ind)=>{
            if(val!==''){
                if(val.split('=')[0] === 'search'){

                    $('.searchField').val(val.split('=')[1] )
                    $('.withdrawStausDrop').val(val.split('=')[1] )
                    $('.customerField').val(val.split('=')[1].replace('%20',' ') )
                    $('.tranSearchField').val(val.split('=')[1].replace('#',''))
                }
                if(val.split('=')[0] === 'sort'){
                    var values = val.split('=')[1].replace('%20',' ')
                    values = values.replace('%20',' ')

                    $('.productStausDrop').val(val.split('=')[1] )
                    $('.userSearch').val(val.split('=')[1] )
                    $('.transStausDrop').val(val.split('=')[1] )
                    $('.feedbackSearch').val(values )
                    $('.abuseSearch').val(values )
                }      
            }
        })
        
            // console.log('onload',sURLVariables)
            // if(sURLVariables.length >= 3){
            //     $('.productStausDrop').val(sURLVariables[2].split('=')[1])
            // }
    }
})	

$(document).on('change','.productStausDrop',function(e){
    var sPageURL = window.location.search.substring(1)
    var sort = $(this).val()
    var sURLVariables = sPageURL.split('&')
    var searchStr='products?';
    if(sPageURL !==''){
        console.log(sURLVariables)
        sURLVariables.map((val,ind)=>{
            if(ind < 2){
                if(val.split('=')[0]!=='sort'){
                    searchStr += (ind === 0) ? val : '&'+val; 
                }
            }
        })
        location.href = searchStr+'&sort='+sort
    }
    else{
        location.href = searchStr+'sort='+sort
    }
})

$(document).on('change','.abuseSearch',function(e){
    var sPageURL = window.location.search.substring(1)
    var sort = $(this).val()
    var sURLVariables = sPageURL.split('&')
    var searchStr='products?';
    if(sPageURL !==''){
        console.log(sURLVariables)
        sURLVariables.map((val,ind)=>{
            if(ind < 2){
                if(val.split('=')[0]!=='sort'){
                    searchStr += (ind === 0) ? val : '&'+val; 
                }
            }
        })
        location.href = searchStr+'&sort='+sort
    }
    else{
        location.href = searchStr+'sort='+sort
    }
})

$(document).on('change','.userSearch',function(e){
    var sPageURL = window.location.search.substring(1)
    var sort = $(this).val()
    var sURLVariables = sPageURL.split('&')
    var searchStr='buyerseller?';
    if(sPageURL !==''){
        console.log(sURLVariables)
        sURLVariables.map((val,ind)=>{
            if(ind < 2){
                if(val.split('=')[0]!=='sort'){
                    searchStr += (ind === 0) ? val : '&'+val; 
                }
            }
        })
        location.href = searchStr+'&sort='+sort
    }
    else{
        location.href = searchStr+'sort='+sort
    }
})

$(document).on('change','.feedbackSearch',function(e){
    var sPageURL = window.location.search.substring(1)
    var sort = $(this).val()
    var sURLVariables = sPageURL.split('&')
    var searchStr='feedbacks?';
    if(sPageURL !==''){
        console.log(sURLVariables)
        sURLVariables.map((val,ind)=>{
            if(ind < 2){
                if(val.split('=')[0]!=='sort'){
                    searchStr += (ind === 0) ? val : '&'+val; 
                }
            }
        })
        location.href = searchStr+'&sort='+sort
    }
    else{
        location.href = searchStr+'sort='+sort
    }
})

$(document).on('change','.abuseSearch',function(e){
    var sPageURL = window.location.search.substring(1)
    var sort = $(this).val()
    var sURLVariables = sPageURL.split('&')
    var searchStr='report_abuse?';
    if(sPageURL !==''){
        console.log(sURLVariables)
        sURLVariables.map((val,ind)=>{
            if(ind < 2){
                if(val.split('=')[0]!=='sort'){
                    searchStr += (ind === 0) ? val : '&'+val; 
                }
            }
        })
        location.href = searchStr+'&sort='+sort
    }
    else{
        location.href = searchStr+'sort='+sort
    }
})

$(document).on('change','.transStausDrop',function(e){
    var sPageURL = window.location.search.substring(1)
    var sort = $(this).val()
    var sURLVariables = sPageURL.split('&')
    var searchStr='transactions?';
    if(sPageURL !==''){
        sURLVariables.map((val,ind)=>{
            if(ind < 2){
                if(val.split('=')[0]!=='sort'){
                    searchStr += (ind === 0) ? val : '&'+val; 
                }
            }
        })
        location.href = searchStr+'&sort='+sort
    }
    else{
        location.href = searchStr+'sort='+sort
    }
})



$(document).ready(function(){
    $('#paginationLink > nav > a.relative').addClass('productPage')
    $('#paginationLinkOrder > nav > a.relative').addClass('OrderPage')
    $('#paginationLinkBid > nav > a.relative').addClass('BidPage')
    $('#paginationLinkUser > nav > a.relative').addClass('userPage')
    $('#paginationLinkFeedback > nav > a.relative').addClass('FeedbackPage')
    $('#paginationLinkAbuse > nav > a.relative').addClass('abusePage')
    $('#paginationLinkRefund > nav > a.relative').addClass('refundPage')
    $('#paginationwithDraw > nav > a.relative').addClass('withDrawPage')
    $('#paginationtransSearch > nav > a.relative').addClass('transSearchPage')
    $('#paginationLinkbuyer > nav > a.relative').addClass('buyerPage')
})

$(document).on('click','.OrderPage, .orderSearch',function(e){
    var searchField = $('.searchField').val()
    var sPageURL = window.location.search.substring()
    var sURLVariables = sPageURL.split('&')

    if(sPageURL !==''){
        if(sURLVariables.length > 1){
            location.href = sURLVariables[0]+'&search='+searchField
            return
        }
        location.href=sPageURL+'&search='+searchField
    }

})

$(document).on('click','.bidSearch, .BidPage',function(e){

    var searchField = $('.BidSearchField').val()
    var sPageURL = window.location.search.substring()
    var sURLVariables = sPageURL.split('&')

    if(sPageURL !==''){
        if(sURLVariables.length > 1){
            location.href = sURLVariables[0]+'&search='+searchField
            return
        }
        location.href=sPageURL+'&search='+searchField
    }

})

$(document).on('click',' .searchUser, .buyerPage',function(e){
    e.preventDefault()
    var type = $(this).attr('rel')

    if(type === undefined){
         location.href =  $(this).attr('href')
         return 
    }

    var searchVal = $('.customerField').val()
    var sort = $('.userSearch').val()
    var sPageURL = window.location.search.substring(1)
    var sURLVariables = sPageURL.split('&')

    if(sPageURL !==''){
        if(sURLVariables.length === 1 ){  
            console.log(sURLVariables[0].split('=')[0])
            if($(this).attr('href') !== undefined){
                location.href=$(this).attr('href')+`&search=${searchVal}`+`&sort=${sort}`
            } 
            else{
                location.href=`buyerseller?search=${searchVal}`+`&sort=${sort}`
            }
            return

        }     
        if(sURLVariables.length === 2 ){
        // return        
            if( sURLVariables && sURLVariables[1].split('=').length === 2 ){
                if( sURLVariables[1].split('=')[0] === 'search' || sURLVariables[1].split('=')[0] === 'sort'){
                    if(type==='next' || type==='prev'){
                       var href =  $(this).attr('href')
                       sURLVariables.map((val,ind)=>{
                            if(val.split('=')[0] !=='page'){
                                href += '&'+val
                            }
                       })
                       console.log(href)
                        location.href = href
                    }   
                    else{
                       href = 'buyerseller?'
                        sURLVariables.map((val,ind)=>{
                            if(val.split('=')[0] !=='search'){
                                href += (ind === 0) ? val : '&'+val;
                            }
                       })
                       console.log(href)
                        location.href = href+'&search='+searchVal
                        // location.href = 'products?page=1&search='+searchVal
                    }    

                }
                else{
                    console.log('no')
                }
            }
            return
        }
        if(sURLVariables.length === 3 ){
            if( sURLVariables[1].split('=')[0] === 'search' || sURLVariables[1].split('=')[0] === 'sort'){  
                if(type==='next' || type==='prev'){
                    var href =  $(this).attr('href')
                    sURLVariables.map((val,ind)=>{
                        if(val.split('=')[0] !=='page'){
                            href += (ind === 0) ? val : '&'+val;
                        }
                    })
                    console.log(href) 
                    location.href = href
                }   
                else{
                    href = 'buyerseller?'
                    sURLVariables.map((val,ind)=>{
                        if(val.split('=')[0] ==='page')
                            href += val
                    })
                    // console.log(href)
                    location.href = href+'&search='+searchVal+'&sort='+sort
                }    

            }
         }
         return 
    }
    else{
        location.href = 'buyerseller?page=1&search='+searchVal
    }
    
})

$(document).on('click',' .transSearch, .transSearchPage',function(e){
    e.preventDefault()
    var type = $(this).attr('rel')

    if(type === undefined){
         location.href =  $(this).attr('href')
         return 
    }

    var searchVal = $('.tranSearchField').val()
    var sort = $('.transStausDrop').val()
    var sPageURL = window.location.search.substring(1)
    var sURLVariables = sPageURL.split('&')
    if(sPageURL !==''){
        if(sURLVariables.length === 1 ){  
            if($(this).attr('href') !== undefined){
                location.href=$(this).attr('href')+`&search=${searchVal.replace('#','')}`+`&sort=${sort}`
            } 
            else{
                location.href=`transactions?search=${searchVal.replace('#','')}`+`&sort=${sort}`
            }
            return

        }     
        if(sURLVariables.length === 2 ){
        // return        
            if( sURLVariables && sURLVariables[1].split('=').length === 2 ){
                if( sURLVariables[1].split('=')[0] === 'search' || sURLVariables[1].split('=')[0] === 'sort'){
                    if(type==='next' || type==='prev'){
                       var href =  $(this).attr('href')
                       sURLVariables.map((val,ind)=>{
                            if(val.split('=')[0] !=='page'){
                                href += '&'+val
                            }
                       })
                       console.log(href)
                        location.href = href
                    }   
                    else{
                       href = 'transactions?'
                        sURLVariables.map((val,ind)=>{
                            if(val.split('=')[0] !=='search'){
                                href += (ind === 0) ? val : '&'+val;
                            }
                       })
                        location.href = href+'&search='+searchVal.replace('#','')
                        // location.href = 'products?page=1&search='+searchVal
                    }    

                }
                else{
                    console.log('no')
                }
            }
            return
        }
        if(sURLVariables.length === 3 ){
            if( sURLVariables[1].split('=')[0] === 'search' || sURLVariables[1].split('=')[0] === 'sort'){  
                if(type==='next' || type==='prev'){
                    var href =  $(this).attr('href')
                    sURLVariables.map((val,ind)=>{
                        if(val.split('=')[0] !=='page'){
                            href += (ind === 0) ? val : '&'+val;
                        }
                    })
                    console.log(href) 
                    location.href = href
                }   
                else{
                    href = 'transactions?'
                    sURLVariables.map((val,ind)=>{
                        if(val.split('=')[0] ==='page')
                            href += val
                    })
                    // console.log(href)
                    location.href = href+'&search='+searchVal.replace('#','')+'&sort='+sort
                }    

            }
         }
         return 
    }
    else{
        location.href = 'transactions?page=1&search='+searchVal.replace('#','')
    }
    
})

$(document).on('click',' .refundSearch, .refundPage',function(e){
    e.preventDefault()
    var type = $(this).attr('rel')

    if(type === undefined){
         location.href =  $(this).attr('href')
         return 
    }

    var searchVal = $('.refundField').val()
    var sPageURL = window.location.search.substring(1)
    var sURLVariables = sPageURL.split('&')

    if(sPageURL !==''){
        if(sURLVariables.length === 1 ){  
            console.log(sURLVariables[0].split('=')[0])
            if($(this).attr('href') !== undefined){
                location.href=$(this).attr('href')+`&search=${searchVal}`
            } 
            else{
                location.href=`refund_list?search=${searchVal}`
            }
            return

        }     
        if(sURLVariables.length === 2 ){
        // return        
            if( sURLVariables && sURLVariables[1].split('=').length === 2 ){
                if( sURLVariables[1].split('=')[0] === 'search' ){
                    if(type==='next' || type==='prev'){
                       var href =  $(this).attr('href')
                       sURLVariables.map((val,ind)=>{
                            if(val.split('=')[0] !=='page'){
                                href += '&'+val
                            }
                       })
                       console.log(href)
                        location.href = href
                    }   
                    else{
                       href = 'refund_list?'
                        sURLVariables.map((val,ind)=>{
                            if(val.split('=')[0] !=='search'){
                                href += (ind === 0) ? val : '&'+val;
                            }
                       })
                       console.log(href)
                        location.href = href+'&search='+searchVal
                        // location.href = 'products?page=1&search='+searchVal
                    }    

                }
                else{
                    console.log('no')
                }
            }
            return
        }
     
    }
    else{
        location.href = 'refund_list?page=1&search='+searchVal
    }
    
})

$(document).on('click',' .FeedbackPage',function(e){
    e.preventDefault()
    var type = $(this).attr('rel')

    if(type === undefined){
         location.href =  $(this).attr('href')
         return 
    }

    // var searchVal = $('.customerField').val()
    var sort = $('.feedbackSearch').val()
    var sPageURL = window.location.search.substring(1)
    var sURLVariables = sPageURL.split('&')

    if(sPageURL !==''){
        if(sURLVariables.length === 1 ){  

            if($(this).attr('href') !== undefined){
                location.href=$(this).attr('href')+`&sort=${sort}`
            } 
            else{
                location.href=`feedbacks?&sort=${sort}`
            }
            return

        }     
        if(sURLVariables.length === 2 ){
        // return        
            if( sURLVariables && sURLVariables[1].split('=').length === 2 ){
                if( sURLVariables[1].split('=')[0] === 'sort'){
                    if(type==='next' || type==='prev'){
                       var href =  $(this).attr('href')
                       sURLVariables.map((val,ind)=>{
                            if(val.split('=')[0] !=='page'){
                                href += '&'+val
                            }
                       })
                       // console.log('if',href)
                        location.href = href
                    }   
                    else{
                       href = 'feedbacks?'
                        sURLVariables.map((val,ind)=>{
                            if(val.split('=')[0] !=='search'){
                                href += (ind === 0) ? val : '&'+val;
                            }
                       })
                       // console.log('else',href)
                        location.href = href+'&sort='+sort
                        // location.href = 'products?page=1&search='+searchVal
                    }    

                }
                else{
                    console.log('no')
                }
            }
            return
        }
        if(sURLVariables.length === 3 ){
            if( sURLVariables[1].split('=')[0] === 'search' || sURLVariables[1].split('=')[0] === 'sort'){  
                if(type==='next' || type==='prev'){
                    var href =  $(this).attr('href')
                    sURLVariables.map((val,ind)=>{
                        if(val.split('=')[0] !=='page'){
                            href += (ind === 0) ? val : '&'+val;
                        }
                    })
                    console.log(href) 
                    location.href = href
                }   
                else{
                    href = 'feedbacks?'
                    sURLVariables.map((val,ind)=>{
                        if(val.split('=')[0] ==='page')
                            href += val
                    })
                    // console.log(href)
                    location.href = href+'&search='+searchVal+'&sort='+sort
                }    

            }
         }
         return 
    }
    else{
        location.href = 'feedbacks?page=1'
    }
    
})

$(document).on('click',' .abusePage',function(e){
    e.preventDefault()
    var type = $(this).attr('rel')

    if(type === undefined){
         location.href =  $(this).attr('href')
         return 
    }

    // var searchVal = $('.customerField').val()
    var sort = $('.abuseSearch').val()
    var sPageURL = window.location.search.substring(1)
    var sURLVariables = sPageURL.split('&')

    if(sPageURL !==''){
        if(sURLVariables.length === 1 ){  

            if($(this).attr('href') !== undefined){
                location.href=$(this).attr('href')+`&sort=${sort}`
            } 
            else{
                location.href=`report_abuse?&sort=${sort}`
            }
            return

        }     
        if(sURLVariables.length === 2 ){
        // return        
            if( sURLVariables && sURLVariables[1].split('=').length === 2 ){
                if( sURLVariables[1].split('=')[0] === 'sort'){
                    if(type==='next' || type==='prev'){
                       var href =  $(this).attr('href')
                       sURLVariables.map((val,ind)=>{
                            if(val.split('=')[0] !=='page'){
                                href += '&'+val
                            }
                       })
                       // console.log('if',href)
                        location.href = href
                    }   
                    else{
                       href = 'report_abuse?'
                        sURLVariables.map((val,ind)=>{
                            if(val.split('=')[0] !=='search'){
                                href += (ind === 0) ? val : '&'+val;
                            }
                       })
                       // console.log('else',href)
                        location.href = href+'&sort='+sort
                        // location.href = 'products?page=1&search='+searchVal
                    }    

                }
                else{
                    console.log('no')
                }
            }
            return
        }
        if(sURLVariables.length === 3 ){
            if( sURLVariables[1].split('=')[0] === 'search' || sURLVariables[1].split('=')[0] === 'sort'){  
                if(type==='next' || type==='prev'){
                    var href =  $(this).attr('href')
                    sURLVariables.map((val,ind)=>{
                        if(val.split('=')[0] !=='page'){
                            href += (ind === 0) ? val : '&'+val;
                        }
                    })
                    console.log(href) 
                    location.href = href
                }   
                else{
                    href = 'report_abuse?'
                    sURLVariables.map((val,ind)=>{
                        if(val.split('=')[0] ==='page')
                            href += val
                    })
                    // console.log(href)
                    location.href = href+'&search='+searchVal+'&sort='+sort
                }    

            }
         }
         return 
    }
    else{
        location.href = 'buyerseller?page=1&search='+searchVal
    }
    
})

$(document).on('click',' .withDrawsearch, .withDrawPage',function(e){
    e.preventDefault()
    var type = $(this).attr('rel')

    if(type === undefined){
         location.href =  $(this).attr('href')
         return 
    }

    var sort = $('.withdrawStausDrop').val()
    var sPageURL = window.location.search.substring(1)
    var sURLVariables = sPageURL.split('&')
    if(sPageURL !==''){
        if(sURLVariables.length === 1 ){  

            if($(this).attr('href') !== undefined){
                location.href=$(this).attr('href')+`&search=${sort}`
            } 
            else{
                location.href=`payout?&search=${sort}`
            }
            return

        }     
        if(sURLVariables.length === 2 ){
        // return        
            if( sURLVariables && sURLVariables[1].split('=').length === 2 ){
                if( sURLVariables[1].split('=')[0] === 'search'){
                    if(type==='next' || type==='prev'){
                       var href =  $(this).attr('href')
                       sURLVariables.map((val,ind)=>{
                            if(val.split('=')[0] !=='page'){
                                href += '&'+val
                            }
                       })
                       // console.log('if',href)
                        location.href = href
                    }   
                    else{
                       href = 'payout?'
                        sURLVariables.map((val,ind)=>{
                            if(val.split('=')[0] !=='search'){
                                href += (ind === 0) ? val : '&'+val;
                            }
                       })
                       // console.log('else',href)
                        location.href = href+'&search='+sort
                        // location.href = 'products?page=1&search='+searchVal
                    }    

                }
                else{
                    console.log('no')
                }
            }
            return
        }  
    }
    else{
        location.href = 'payout?page=1&search='+sort
    }
    
})

$(document).on('click',' .withDrawsearch, .withDrawPage',function(e){
    e.preventDefault()
    var type = $(this).attr('rel')

    if(type === undefined){
         location.href =  $(this).attr('href')
         return 
    }

    var sort = $('.withdrawStausDrop').val()
    var sPageURL = window.location.search.substring(1)
    var sURLVariables = sPageURL.split('&')
    if(sPageURL !==''){
        if(sURLVariables.length === 1 ){  

            if($(this).attr('href') !== undefined){
                location.href=$(this).attr('href')+`&search=${sort}`
            } 
            else{
                location.href=`payout?&search=${sort}`
            }
            return

        }     
        if(sURLVariables.length === 2 ){
        // return        
            if( sURLVariables && sURLVariables[1].split('=').length === 2 ){
                if( sURLVariables[1].split('=')[0] === 'search'){
                    if(type==='next' || type==='prev'){
                       var href =  $(this).attr('href')
                       sURLVariables.map((val,ind)=>{
                            if(val.split('=')[0] !=='page'){
                                href += '&'+val
                            }
                       })
                       // console.log('if',href)
                        location.href = href
                    }   
                    else{
                       href = 'payout?'
                        sURLVariables.map((val,ind)=>{
                            if(val.split('=')[0] !=='search'){
                                href += (ind === 0) ? val : '&'+val;
                            }
                       })
                       // console.log('else',href)
                        location.href = href+'&search='+sort
                        // location.href = 'products?page=1&search='+searchVal
                    }    

                }
                else{
                    console.log('no')
                }
            }
            return
        }  
    }
    else{
        location.href = 'payout?page=1&search='+sort
    }
    
})

$(document).on('click','.search, .productPage',function(e){
    e.preventDefault()
    var type = $(this).attr('rel')
    if(type === undefined){
         location.href =  $(this).attr('href')
         return 
    }

    var searchVal = $('.searchField').val()
    var sort = $('.productStausDrop').val()
    var sPageURL = window.location.search.substring(1)
    var sURLVariables = sPageURL.split('&')

    if(sPageURL !==''){
        if(sURLVariables.length === 1 ){  
            console.log(sURLVariables[0].split('=')[0])
            if($(this).attr('href') !== undefined){
                location.href=$(this).attr('href')+`&search=${searchVal}`+`&sort=${sort}`
            } 
            else{
                location.href=`products?search=${searchVal}`+`&sort=${sort}`
            }

        }     
        if(sURLVariables.length === 2 ){
        // return        
            if( sURLVariables && sURLVariables[1].split('=').length === 2 ){
                if( sURLVariables[1].split('=')[0] === 'search' || sURLVariables[1].split('=')[0] === 'sort'){
                    if(type==='next' || type==='prev'){
                       var href =  $(this).attr('href')
                       sURLVariables.map((val,ind)=>{
                            if(val.split('=')[0] !=='page'){
                                href += '&'+val
                            }
                       })
                       console.log(href)
                        location.href = href
                    }   
                    else{
                       href = 'products?'
                        sURLVariables.map((val,ind)=>{
                            if(val.split('=')[0] !=='search'){
                                href += (ind === 0) ? val : '&'+val;
                            }
                       })
                       console.log(href)
                        location.href = href+'&search='+searchVal
                        // location.href = 'products?page=1&search='+searchVal
                    }    

                }
                else{
                    console.log('no')
                }
            }
        }
        if(sURLVariables.length === 3 ){
            if( sURLVariables[1].split('=')[0] === 'search' || sURLVariables[1].split('=')[0] === 'sort'){
                if(type==='next' || type==='prev'){
                    var href =  $(this).attr('href')
                    sURLVariables.map((val,ind)=>{
                        if(val.split('=')[0] !=='page'){
                            href += (ind === 0) ? val : '&'+val;
                        }
                    })
                    console.log(href) 
                    location.href = href
                }   
                else{
                    href = 'products?'
                    sURLVariables.map((val,ind)=>{
                        if(val.split('=')[0] ==='page')
                            href += val
                    })
                    console.log(href)
                    location.href = href+'&search='+searchVal+'&sort='+sort
                }    

            }
         }
    }
    else{
        location.href = 'products?page=1&search='+searchVal
    }
    
})

$(document).on('click','.approval',function(e){
    e.preventDefault();
    var product_id = $(this).attr('data-id');
    var status = $(this).attr('type');
    var sPageURL = window.location.search.substring(1)
    var sURLVariables = sPageURL.split('&')
    var sort = '';
    sURLVariables.map((value,index)=>{
        if(value !==''){
            if(value.split('=')[0] === 'sort'){
                sort = value.split('=')[1]
            }
        }
    })
    // console.log(sort)
     $.ajax({
        type:'GET',
        url:"/product_approve/"+product_id+'/'+status+'/'+sort,
        success:function(res){
        	console.log(res)
            // if(res.status == 'success'){
  				$('#productUpdateList').html(res)
            // }
        }
    });
});


$(document).on('click','.approvalUser',function(e){
    e.preventDefault();
    var user_id = $(this).attr('data-id');
    var type = $(this).attr('data-type');
     $.ajax({
        type:'GET',
        url:"/buyerseller_approve/"+user_id+'/'+type,
        success:function(res){
            location.reload()
            $('.refreshTable').html(res)
        }
    });


});

$(document).on('keyup','.catg_name',function(){
	// slug
	var cate_name = $(this).val()
	var slug = cate_name.toLowerCase().replace(" ","_");
	$('.slug').val(slug)
})

$(document).on('keyup','.templte_name',function(){
  var cate_name = $(this).val()
    var slug = cate_name.toLowerCase().replace(" ","_");
    $('.templte_slug').val(slug)  
})

$(document).on('click','.addTemplate',function(){
    $.ajax({
        method:'get',
        url:'template/create',
        success:function(res){
            console.log(res)
            $('.formhere').html(res)
            $('#exampleModal').modal('show')
        }
    })
})

$(document).on('click','.editTemplate',function(){
    var id = $(this).attr('data-id')
    $.ajax({
        method:'get',
        url:'template_edit/'+id,
        success:function(res){
            console.log(res)
            $('.formhere').html(res)
            $('#exampleModal').modal('show')
        }
    })
})

$(document).on('click','.close',function(){
    $('#cancelModel').modal('hide')
})

$(document).on('submit','#cancelForm',function(e){
    e.preventDefault()
    var desc = $('#cancelDesc').val()
    var id = $('#cancelId').val()
    var status = $('#statusModel').val()
    var productQty = $('#productQty').val()
    var crntQty = $('#crntQty').val()
    $('#productQty').val()

    if(parseInt(crntQty) < parseInt(productQty)){
        $('#cancelQty-error').text('Quantity should be less then or equal to order quantity.')
        return
    }
    if(!productQty){
        $('#cancelQty-error').text('This field is required.')
        return
    }
    if(desc ===''){
        $('#cancelDesc-error').text('This field is required.')
        return
    }
    var data = {
        'id':id,
        'description':desc,
        'status':status,
        qty:productQty,
        crntQty
     }

    $.ajax({
            method:'post',
            url:'/orders_status/',
            data:data,
            beforeSend: function(){
                $('.ajax-loader').css("visibility", "visible");
              },
            success:function(res){
                // console.log(res)
                location.reload()
            },
            completed:function(){
                $('.ajax-loader').css("visibility", "hidden");
            }
        })
})

$(document).on('submit','#deliverForm',function(e){
    e.preventDefault()
    var desc = $('#deliverDesc').val()
    var id = $('#deliverId').val()
    var status = $('#deliverStatus').val()

    if(desc ===''){
        $('#deliverComment-error').text('This field is required.')
        return
    }
    var data = {
        'id':id,
        'description':desc,
        'status':status
     }

    $.ajax({
            method:'post',
            url:'/orders_status/',
            data:data,
            beforeSend: function(){
                $('.ajax-loader').css("visibility", "visible");
              },
            success:function(res){
                // console.log(res)
                location.reload()
            },
            completed:function(){
                $('.ajax-loader').css("visibility", "hidden");
            }
        })
})

$(document).on('submit','#shippingForm',function(e){
    e.preventDefault()
    var shippingDetails = $('#shippingDetails').val()
    var awb = $('#awb').val()
    var shipping_company_name = $('#shipping_company_name').val()
    var id = $('#shippingId').val()
    if(awb ===''){
        $('#awb-error').text('This field is required.')
        return
    }
    if(shippingDetails ===''){
        $('#shippingDetails-error').text('This field is required.')
        return
    } 
    if(shipping_company_name ===''){
        $('#shipping_company_name-error').text('This field is required.')
        return
    }
    var data = {
        'id':id,
        'awb_number':awb,
        shipping_company_name,
        'shipping_details':shippingDetails,
        'status':'shipped'
     }

    $.ajax({
            method:'post',
            url:'/orders_status/',
            data:data,
            beforeSend: function(){
                $('.ajax-loader').css("visibility", "visible");
              },
            success:function(res){
                // console.log(res)
                location.reload()
            },
            completed:function(){
                $('.ajax-loader').css("visibility", "hidden");
            }
        })
})

$(document).on('click','.payoutRequest',function(){
    $('#payoutModal').modal('show')
})

$(document).on('click','.rejectPayout',function(){
    var id = $(this).attr('data-id')
    var payoutMaxAmt = $(this).attr('payout-page')
    $('#rejectPayout').modal('show')
    $('.submitReject').attr('id',id)
    $('.submitReject').attr('data-page',payoutMaxAmt)
})

$(document).on('click','.submitReject',function(){
    var amount = $('#payoutAmount').val();
    var remark = $('#payoutRemark').val();
    var id = $(this).attr('id');
    var maxAmount = $(this).attr('data-page');
    if(amount === ''){
        $('.with-error').text('This field is required.')
        return
    }
    if(parseFloat(amount) > parseFloat( maxAmount) ){
        $('.with-error').text('Given amount should be equal or less than requested amount.')
        return 
    }

    $.ajax({
        method:'post',
        url:'/payout_reject/',
        data:{amount,remark,id},
        beforeSend: function(){
            $('.ajax-loader').css("visibility", "visible");
          },
        success:function(res){
            location.reload()
        },
        completed:function(){
            $('.ajax-loader').css("visibility", "hidden");
        }
    })
})


$(document).on('click','.submitRequest',function(){
    var amount = $('#withdrawAmount').val()
    var crntAmount = $('#pageNumber').val()
    
    if(amount ===''){    
        $('.with-error').text('This field is required.')
        return
    }
    if(parseFloat(crntAmount) < parseFloat(amount)){
        $('.with-error').text('You dont have a sufficient fund.')   
        return
    }

    $.ajax({
        method:'post',
        url:'/payout_request/',
        data:{amount},
        beforeSend: function(){
            $('.ajax-loader').css("visibility", "visible");
          },
        success:function(res){
            location.reload()
        },
        completed:function(){
            $('.ajax-loader').css("visibility", "hidden");
        }
    })
})

function changeOrder(id,status,other=''){
    var desc=''
    if(status==='rejected' || status==='cancelled'){
        $('#cancelId').val(id)
        $('#statusModel').val(status)
        $('#cancelModel').modal('show')
        $('#crntQty').val(other)
        return
    }
    if(status==='shipped'){
        $('#shippingId').val(id)
        $('#shippingModel').modal('show')
        return 
    }
    if(status==='delivered'){
        $('#deliverId').val(id)
        $('#deliverStatus').val(status)
        $('#deliverModel').modal('show')
        return 
    }    
    var data={
        'id':id,
        status:status,
        desc:desc
    }
    if(status==='rejected' || status==='cancelled'){
        
        if(desc !==null ){
            $.ajax({
                method:'post',
                url:'/orders_status/',
                data:data,
                beforeSend: function(){
                    $('.ajax-loader').css("visibility", "visible");
                  },
                success:function(res){
                    // console.log(res)
                    location.reload()
                },
                completed:function(){
                    $('.ajax-loader').css("visibility", "hidden");
                }
            })
        }
        else{
            alert('When you rejecting the order description is required...')
        }
    }
    else{
        $.ajax({
            method:'post',
            url:'/orders_status/',
            data:data,
            beforeSend: function(){
                $('.ajax-loader').css("visibility", "visible");
              },
            success:function(res){
                location.reload()
            },
            completed:function(){
                    $('.ajax-loader').css("visibility", "hidden");
                }
        })
    }  
}



$(document).on('click','.addMoreDays',function(e){
    var id = $(this).attr('data-id')
    $.ajax({
        method:'get',
        url:'extendDate/'+id,
        success:function(res){
            console.log(res)
            $('#productUpdateList').html(res)
        }
    })
})

$(document).on('click','.editCategory',function(){
    var url = $(this).attr('url')
    $.ajax({
        url:url,
        method:'get',
        success:function(res){
            $('.modalData').html(res)
            $('#exampleModal').modal('show')
            console.log(res)
        }
    })
})

$(document).on('click','.add',function(){
    var url = $(this).attr('url')
    $.ajax({
        url:url,
        method:'get',
        success:function(res){
            $('.modalData').html(res)
            $('#addModal').modal('show')
        }
    })
})

$(document).on('submit','.updateCategoryForm',function(e){
    // e.preventDefault()
    var url = $(this).attr('action')

    var formData = new FormData($(this)[0]);
    var file_data = $('#image').prop('files');
    $.ajax({
        url:url,
        type:'put',
        data:formData,
        contentType: false,
        cache : false,
        processData: false,
        success:function(res){
            // $('.modalData').html(res)
            // $('#exampleModal').modal('show')
            console.log(res)
        }
    })
})

$(document).on('click','.close',function(){
    $('.closeModal').modal('hide')
})

$(document).on('click','.createTransction',function(){
    $('#transactionCreate').modal('show')
})

$(document).on('click','.sowReviews',function(){
    var url = $(this).attr('url')
    $.ajax({
        method:'get',
        url:url,
        success:function(res){
            $('#addModal').modal('show')
            $('.modalData').html(res)
        }
    })
})

$(document).on('click','.transactioSubmit',function(e){
    e.preventDefault()
    var orderId = $('#tranOrderID').val()
    var tranAmount = $('#tranAmount').val()
    var portanAmt = $('#portalAmount').val()
    var transType = $('#transType').val()
    var transFor = $('#transFor').val()
    var memberID = $('#memberID').val()

    if(orderId ==='' && transFor === 'order'){
        $('.orderwith-error').text('This field is required.')
        return
    }
    if(tranAmount ===''){
        $('.amtwith-error').text('This field is required.')
        return
    }
    if(portanAmt ===''){
        $('.portalwith-error').text('This field is required.')
        return
    }
    if(transFor ===''){
        $('.transFor-error').text('This field is required.')
        return
    }

    if(memberID ==='' && transFor === 'portal_sevice_charge'){
        $('.member-error').text('This field is required.')
        return
    }
    var data = {
        orderId,
        tranAmount,
        portanAmt,
        transType,
        transFor,
        memberID
    }
 
    $.ajax({
            method:'post',
            url:'/transactions_store/',
            data:data,
            beforeSend: function(){
                $('.ajax-loader').css("visibility", "visible");
              },
            success:function(res){
                location.reload()
            },
            error:function(error){
                var {responseJSON} = error
                $('.orderwith-error').text(responseJSON.errors)                
            },
            completed:function(){
                $('.ajax-loader').css("visibility", "hidden");
            }
        })
})

$(document).on('change','#transFor',function(){
    var value = $(this).val()
    if(value === 'portal_sevice_charge'){
        $('#tranOrderID').val('Sevice Charge')
        $('.customerMemberField').css('display','inline');
        $('.orderNumberField').css('display','none');
        $('#tranOrderID').attr('disabled',true)
    }
    else{
        if(value !== 'portal_sevice_charge'){
            $('#tranOrderID').val($('#tranOrderID').val())
        }
        else{
            $('#tranOrderID').val('')
        }
        $('#tranOrderID').attr('disabled',false)
        $('.customerMemberField').css('display','none');
        $('.orderNumberField').css('display','inline');
        return 
    }
})

$(document).on('keyup','#tranOrderID',function(){
    var value = $(this).val()
    value = value.replace('#','')

     $.ajax({
            method:'get',
            url:'/check_order_number/'+value,
            success:function(res){
                var { amount,commission } = res
                $('#tranAmount').val(amount)
                $('#portalAmount').val(commission)
                $('.orderwith-error').text('')  

            },
            error:function(error){
                var {responseJSON} = error
                $('.orderwith-error').text(responseJSON.errors)                
            }
        })
})

function getMember(memberId){
    $.ajax({
        method:'get',
        url:'/check_member_id/'+memberId,
        success:function(res){
            var { amount,commission } = res
            $('.member-error').text('')  
        },
        error:function(error){
            var {responseJSON} = error
            $('.member-error').text(responseJSON.errors)
        }
    })
}

$(document).on('keyup','#memberID',function(){
    var value = $(this).val()
    getMember(value)
})

function getRegion(id,selected=''){
    $.ajax({
        method:'get',
        url:'/regions/'+id+'/'+selected,
        success:function(res){
            $('.regions').html(res)
        }
    })
}

$(document).on('change','.province',function(){
    var id = $(this).val()
    getRegion(id)
})

$(document).ready( function(){
    var id = $('.province').val()
    var selectid = $('#citySelect').val()
     getRegion(id,selectid)
})

$(document).on('click','.excelImport',function(){
    $('#importTrans').modal('show')
})




