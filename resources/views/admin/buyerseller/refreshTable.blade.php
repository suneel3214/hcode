<table id="complex_header1" class="table" style="width:100%">
	<thead>
		<tr>
        	<th scope="col">
        		<a onclick='bulkDelete("Product")'
					style="display: none;" class=" delteButton fa fa-trash">
						
				</a>
				<input id="allDelete" type="checkbox">
			</th>
			<th scope="col">#</th>
			<th scope="col">User Name</th>
			<th scope="col">Email</th>
			<th scope="col">Type</th>
			<th scope="col">Status</th>
			<th scope="col">Action</th>
        </tr>
	</thead>
	<tbody>
		<?php $count = 1; ?>
		@foreach($users as $user )
		<tr>
			<td><input type="checkbox"></td>
			<td>{{$count++}}</td>
			<td>{{$user->f_name}}-{{$user->l_name}}</td>
			<td>{{$user->email}}</td>
			<td>
				<span class="badge {{$user->email_verified_at !=null ? 'badge-success' : 'badge-warning'}} text-white p-1  f-11 pull-right">{{$user->email_verified_at !=null ? 'Verified' : 'Not Verify'}}
				</span>
			</td>
			<td>
				<span class="badge {{$user->status == 'P' ? 'badge-danger' : 'badge-success'}} text-white p-1  f-11 pull-right">{{$user->status =='P' ? 'Not active' : 'Active'}}
				</span>
			</td>
			<td>
				@role('super_admin')

					<a href="javascript:void(0)"  class="{{$user->status == 'P' ? 'text-danger' : 'text-success'}} text-white ml-1 approvalUser" data-id="{{$user->id}}" data-type="{{$user->user_role}}"><i class="nav-icon i-Navigation-Right-Window font-weight-bold" title="{{$user->status == 'P' ? 'Unapprove' : 'Approve'}}" ></i></a> 
				@endrole 

				<a href="{{route('buyerseller.edit',$user->id)}}" class="text-info text-white ml-1 " title="Edit">
					<i class="nav-icon i-Eye-Scan font-weight-bold"></i>
				</a>            
	            <a href="{{route('buyerseller.show',$user->id)}}" class="text-warning text-white ml-1 " title="View"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>            
	            <a href="{{route('buyerseller_destroy',$user->id)}}" class="text-danger text-white ml-1 " title="Delete" onclick="return confirm('Are you sure you want to delete user?');"><i class="nav-icon i-Close-Window font-weight-bold"></i></a>   
			</td>
			
		</tr>
		@endforeach
		
	</tbody>
</table>
<script>
	$(document).ready(function(){
		$('#complex_header1').DataTable( { } );
	})
</script>	