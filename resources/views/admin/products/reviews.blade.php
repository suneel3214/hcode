@foreach($reviews as $Review)
	<div class="card text-left mb-3">
	    <div class="card-body">
	    	<div class="row">
	    		<div class="col-md-6">
		        	<h class="card-title mb-3">{{$Review->customer_name}}</h5>
		        </div>	
				<div class="col-md-6 text-right">
					@php $count=1; @endphp
					@while($count <= 5 )
						@if($Review->rate > $count)
			    			<i class="nav-icon i-David-Star font-weight-bold" style="color:#5A3CF3"></i>
			    		@else	
			    			<i class="nav-icon i-David-Star font-weight-bold"></i>
			    		@endif	
						@php $count++; @endphp
					@endwhile
				</div>	
				<div class="col-md-12 mt-3">
					{{$Review->description}}
				</div>	
		    </div> 
		</div>    
	</div>    
@endforeach    
