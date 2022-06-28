
<?php
	foreach ($messages as $key => $message) {?>
        <li class="{{$message->email == Auth::user()->email ? 'chat-left' :'chat-right'}}">
            <div class="chat-avatar">
                <img src="https://www.bootdey.com/img/Content/avatar/avatar3.png" alt="Retail Admin">
                <div class="chat-name">{{$message->name}}</div>
            </div>
            <div class="chat-text">{{$message->message}}</div>
            <div class="chat-hour">{{date('H:i:s', strtotime($message->created_at))}} <span class="fa fa-check-circle"></span></div>
        </li>
	
		
<?php } ?>
