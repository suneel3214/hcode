@foreach($data as $Data)
	<div class="card text-left mb-3">
		<div class="card-body">
			<div class="row">
				<div class="col-md-8">
					<h6>
						@if(gettype($Data->data) === 'string')
						 	@php 
						 		$newArray = (object)$Data->data;
						 		dd($newArray);
						 	@endphp 		
						@else
							{{$Data->data[0]['title']}}
						@endif 
					</h6>
					<p>
						@php $body=''; $orderID=''@endphp	
						@if(gettype($Data->data) === 'string')
						 	@php 
						 		$newArray = json_decode($Data->data);
						 		$body = $newArray[0]['body'];
						 		$orderID = $newArray[0]['actionURL'];
						 	@endphp 		
						@else							
							@php 
						 		$orderID = $Data->data[0]['actionURL'];
								$body=	$Data->data[0]['body'];
							 @endphp
						@endif 
						{{$body}};
					</p>
					@if($Data->data[0]['title'] === 'New Order!')
						@php $amt=0; @endphp
						<p>
							@if(gettype($Data->data) === 'string')
							 	@php 
							 		$newArray = json_decode($Data->data);
							 		$amt = $newArray[0]['amount'];
							 	@endphp 		
							@else							
								@php 
									$amt=	$Data->data[0]['amount'];
								 @endphp
							@endif 
							{{'Order Price:- $'.$amt}};
						</p>	
					@endif
				</div>
				<div class="col-md-3">
					<button class="btn btn-primary read" data-id="{{$Data->id}}">Mark as a read</button>
				</div>
			</div> 
			@if($Data->data[0]['title'] === 'New Order!')
				<div class="col-md-12">
					<a 	 href="{{route('orders_show',$orderID)}}" class="btn btn-primary text-white " data-id="{{$Data->id}}" data-orderid="{{$orderID}}" data-type="accept" >Details</a>
				</div>
			@endif
		</div>
	</div>	
@endforeach	

