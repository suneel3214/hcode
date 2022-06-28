<div class="mt-3 pb-2 pl-3 pr-3 font-weight-bold text-muted border-bottom">Contacts</div>
<?php $count = 1; ?>
@foreach($chatuser as $Contacts)
	<div  id="{{$count}}" chatroomId="{{$Contacts->chatroom_id}}" userId="{{$Contacts->user->id}}" class="selecteUser p-3 d-flex border-bottom align-items-center contact {{$Contacts->user->online_status === 1 ? 'online' :''}}"><img class="avatar-sm rounded-circle mr-3" src="{{asset('logo/user.png')}}" alt="alt" />
	    <h6>{{$Contacts->user->name}} 
	    	@if($Contacts->user->unread_message_count !==0)
				<span 
					style="background-color: red;
						   border-radius: 100%;
						    padding: 1px 6px 1px 5px;
						    color: white;">
				{{$Contacts->user->unread_message_count}}
				</span>
			@endif	
		</h6>
	</div>
	
<?php $count++ ; ?>
@endforeach	

{{-- <div class="p-3 d-flex border-bottom align-items-center contact online"><img class="avatar-sm rounded-circle mr-3" src="http://demos.ui-lib.com/gull/dist-assets/images/faces/4.jpg" alt="alt" />
	    <h6>Jaqueline Day</h6>
	</div>
	<div class="p-3 d-flex border-bottom align-items-center contact"><img class="avatar-sm rounded-circle mr-3" src="http://demos.ui-lib.com/gull/dist-assets/images/faces/5.jpg" alt="alt" />
	    <h6>Jhone Will</h6>
	</div> --}}