<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Auth;

class CustomDbChannel 
{

  public function send($notifiable, Notification $notification)
  {
    // $data = $notification->toDatabase($notifiable);

    return $notifiable->routeNotificationFor('database')->create([
        'id' => $notification->id,

        //customize here
        'answer_id' => $data['answer_id'], //<-- comes from toDatabase() Method below
        'user_id'=> Auth::user()->id,
        'data' => $data,
        'read_at' => null,
    ]);
  }

}