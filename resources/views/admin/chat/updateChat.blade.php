@if($message->senderId === auth()->user()->id)
    <div class="d-flex mb-4 ">
        <div class="message flex-grow-1" style="margin-left: 30%; background-color: #e3e3ff;:">
            <p class="m-0">{{$message->message}}</p>
            <span class="d-flex">
                <span class="text-small text-muted">
                    <?php
                        $date1 = $message->created_at;
                        $date2 = date('Y-m-d H:i:s');
                        $timestamp1 = strtotime($date1);
                        $timestamp2 = strtotime($date2);
                        $hour = ($timestamp2 - $timestamp1)/(60*60);
                        if(round($hour) < 25){
                            if(round($hour) < 1){
                                if(date('i',($timestamp2 - $timestamp1)) < 1){
                                    echo "just";
                                }
                                else{
                                    echo date('i',($timestamp2 - $timestamp1))." minute's ago";
                                }
                            }
                            else{
                                echo round($hour)  . "hour's ago";
                            }
                        }
                        else{
                            $start = strtotime(date('Y-m-d'));
                            $end = !empty($message->created_at) ? strtotime($message->created_at):strtotime(date('Y-m-d'));
                        
                            $days_between = !empty($message->created_at) ? ceil(abs($end - $start) / 86400) : 0;
                            echo $days_between  . " day's ago";

                        }
                    ?>
                </span>
                <!-- <div class="seller-name text-16 "></div> -->
            </span>
        </div>
    </div>
@else
    <div class="d-flex mb-4 user">
        <div class="message flex-grow-1">
            <p class="m-0">{{$message->message}}</p>
            <div class="d-flex">
            <span class="text-small text-muted">
                    <?php
                        $date1 = $message->created_at;
                        $date2 = date('Y-m-d H:i:s');
                        $timestamp1 = strtotime($date1);
                        $timestamp2 = strtotime($date2);
                        $hour = ($timestamp2 - $timestamp1)/(60*60);
                        if(round($hour) < 25 ){
                            if(round($hour) === 0){
                                echo round($hour)  . "hour's ago";
                            }
                            else{
                                if(date('i',($timestamp2 - $timestamp1)) < 1){
                                    echo 'just';
                                }
                                else{
                                    echo date('i',($timestamp2 - $timestamp1))." minute's ago";
                                }
                            }
                        }
                        else{
                            $start = strtotime(date('Y-m-d'));
                            $end = !empty($message->created_at) ? strtotime($message->created_at):strtotime(date('Y-m-d'));
                        
                            $days_between = !empty($message->created_at) ? ceil(abs($end - $start) / 86400) : 0;
                            echo $days_between  . " day's ago";

                        }
                    ?>
                    @if($message->url)
                        <span style="margin-left:10px;" class="messageSentUrl"><a href="{{$message->url}}" target="_blank">{{$message->url}} </a></span>
                        </span>
                    @endif 
                </span>
            </div>
        </div>
    </div>    
@endif