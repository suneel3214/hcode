@extends('layouts.main')
@section('content')

<div class="card text-left">
    <div class="card-body">
    	<div class="row">
    		<div class="col-md-6">
	        	<h4 class="card-title mb-3">Report of issue</h4>
	        </div>	
	    </div>   	
        <div class="table-responsive" id="productUpdateList">
        	 <div class="table_fields">
                <div class="">
                    <select name="productList_length" aria-controls="productList" class="abuseSearch">
                        <option value="">--Select Type--</option>
                            <option value="Illicit Content">Illicit Content</option>
                            <option value="Website Banned List">Website Banned List</option>
                            <option value="Hateful Content">Hateful Content</option>
                            <option value="Sexual Content">Sexual Content</option>
                            <option value="Account">Account</option>
                            <option value="Policies,Terms and conditions">Policies,Terms and conditions</option>
                            <option value="Buying">Buying</option>
                            <option value="Site Security">Site Security</option>
                            <option value="Others">Others</option>
                    </select>
                </div>
               {{--  <div id="productList_filter" class="dataTables_filter">
                    <input type="search" class="customerField" placeholder="Search customer by name" aria-controls="productList">
                </div>
                <div>
                    <a class="btn btn-primary fa fa-search ml-1 searchUser" rel='' style="color:#fff;"></a>
                </div> --}}
            </div>
            @if(count($report) > 0)
	            <table class="table" id="abuse_table1">
	                <thead>
	                    <tr>
							<th scope="col">#</th>
							<th scope="col">Name</th>
							<th scope="col">Email</th>
							<th scope="col">Type Of Issue</th>
	                    </tr>
	                </thead>
	                <tbody >
	                    <?php $count = 1; ?>
						@foreach($report as $Report )
		                    <tr>
		                    	<th>{{$count++}}</th>
		                        <th scope="row">{{$Report->name}}</th>
		                        
		                        <td>{{$Report->email}}</td>
		                        <td>{{$Report->type_of_report}}</td>
		                    </tr>
		                @endforeach    
	                </tbody>
	            </table>
		        </div>
		        <div id="paginationLinkAbuse">
		            {{ $report->links() }}
		        </div>
		    @else
		    	 <table class="table" id="abuse_table1">
	                <thead>
	                    <tr>
							<th scope="col">#</th>
							<th scope="col">Name</th>
							<th scope="col">Email</th>
							<th scope="col">Type Of Issue</th>
	                    </tr>
	                </thead>
	                <tbody >	                     
	                </tbody>
	            </table>
	            <div style="text-align: center;">
	            	No record found
	            </div>	
		    @endif    
    </div>
</div>
@endsection
