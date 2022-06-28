@if(count($data) > 0)		
	@foreach($data as $Data)
		@if(isset($Data->data[0]))
			<div class="dropdown-item d-flex allNotifications" id="readNotification" url="{{$Data->data[0]['actionURL']}}">
			    <div class="notification-icon">
			        <i class="i-Speach-Bubble-6 text-primary mr-1"></i>
			    </div>
			    <a  >
				    <div class="notification-details flex-grow-1">
				        <p class="m-0 d-flex align-items-center allNotifications">
				            <span>{{$Data->data[0]['title']}}</span>
				            <span class="badge badge-pill badge-primary ml-1 mr-1">new</span>
				            <span class="flex-grow-1"></span>
				        </p>
				        <p class="text-small text-muted m-0">{{$Data->data[0]['body']}}</p>
				    </div>
				</a>    
			</div>
		@endif	
	@endforeach	
@endif	