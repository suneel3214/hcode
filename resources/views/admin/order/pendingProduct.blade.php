<table id="order_list" class="table" style="width:100%" >
	<thead>
		<tr>
			<th>#</th>
			<th>Order ID</th>
			<th>Date</th>
			<th>Customer Name</th>
			<th>Amount</th>
			<th>Discount</th>
			<th>Shipping Amount</th>
			<th>Total Amount</th>
			<th>Total Item</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php $count = 1; ?>
		@foreach($data as $order )
		<tr>
			<td>{{$count++}}</td>
			<td>{{$order->invoice_number}}</td>
			<td>{{date('D M y',strtotime($order->created_at))}}</td>
			<td>{{$order->get_user ? $order->get_user->f_name:''}}-{{$order->get_user ? $order->get_user->l_name:''}}</td>
			<td>${{$order->total_price}}</td>
			<td>${{$order->discounted_price}}</td>
			<td>${{$order->shipping_price}}</td>
			<td>${{$order->total_price + $order->shipping_price}}</td>
			<td>{{$order->item_qty}}</td>
			<td>
				@if($order->status === null)
					<span class="badge badge-warning">Few products are waiting for accept / reject action</span>
				@elseif($order->status === 'completed')	
					<span class="badge badge-success">Completed</span>
				@else	
					<span class="badge badge-danger">Rejected</span>
				@endif		

			</td>
			
			<td>
			  <a href="{{route('orders_show',$order->id)}}"> &nbsp;<i class="nav-icon i-Eye-Scan font-weight-bold" title="Show Details"></i></a>
				
			</td>
		</tr>
		@endforeach
		
	</tbody>
</table>