<style>
	.placed{
		background-color:#6DB3F2;
	}
	.confirmed{
		background-color:#ffc107;
	}
	.shipped{
		background-color:#0C9D80;
	}
	.delivered{
		background-color:#7A1DE2;
	}
	.return{
		background-color:#E21DC1;
	}
	.refunded{
		background-color:#F1AA72;
	}
	.cancelled{
		background-color:#A4366F;
	}

</style>
@php 
	$order = isset($Order) ? $Order:$order;
@endphp
@if($order->status === 'placed')
	<span class="badge  text-capitalize text-white placed" style="">placed</span>
@elseif($order->status === 'pconfirmed')	
	<span class="badge badge-warning text-capitalize text-white">Partial Confirmed</span>
@elseif($order->status === 'pshipped')	
	<span class="badge badge-warning text-capitalize text-white" style="background-color:#0C9D80;">Partial Shipped</span>
@elseif($order->status === 'pdelivered')	
	<span class="badge badge-warning text-capitalize text-white" style="background-color:#7A1DE2;">Partial Delivered</span>
@elseif($order->status === 'preturn')	
	<span class="badge badge-warning text-capitalize text-white" style="background-color:#E21DC1;">Partial Return</span>
@elseif($order->status === 'prefunded')	
	<span class="badge badge-warning text-capitalize text-white" style="background-color:#F1AA72;">Partial Refunded</span>
@elseif($order->status === 'prejected')	
	<span class="badge badge-warning text-capitalize text-white" style="background-color:#D32222;">Partial Rejected</span>	
@elseif($order->status === 'pcancelled')	
	<span class="badge badge-warning text-capitalize text-white" style="background-color:#A4366F;">Partial Cancelled</span>		
@else	
	<span class="badge badge-danger text-capitalize text-white {{$order->status}}">{{$order->status}}</span>
@endif	