<script src="{{ asset('js/jquery.min.js') }}"></script>
{{-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> --}}
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<script src="{{ asset('js/comman.js') }}" defer></script>
<script src="{{ asset('js/bootstrapBunde.js') }}" defer></script>
<script src="{{ asset('js/perfectScroll.min.js') }}" defer></script>
<script src="{{ asset('js/perfectScroll.min.js') }}" defer></script>
<script src="{{ asset('js/script.min.js') }}" defer></script>
<script src="{{ asset('js/sidebar.component.js') }}" defer></script>
<script src="{{ asset('js/script.cutomize.js') }}" defer></script>
<script src="{{ asset('js/script.sidebar.js') }}" defer></script>
<script src="{{ asset('js/bootstrapBundel2.js') }}" defer></script>

<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>
{{-- Chart Related  --}}
<script src="{{ asset('js/echart.min.js') }}" defer></script>
<script src="{{ asset('js/echart.option.js') }}" defer></script>
<script src="{{ asset('js/dashboardv1.js') }}" defer></script>

<script src="{{ asset('js/multi-form.js') }}" defer></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

{{-- Select2 Related  --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>

<script src="https://cdn.socket.io/4.3.2/socket.io.min.js" integrity="sha384-KAZ4DtjNhLChOB/hxXuKqhMLYvx3b5MlT55xPEiNmREKRzeEm+RVPlTnAn0ajQNs" crossorigin="anonymous"></script>
<input type="hidden" id="csrf"  value="{{csrf_token()}}">

    <script>
        // scrollIntoView({ behavior: 'smooth', block: 'end' });
        // $('#chatList').scrollTop(1000000); 
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('#csrf').val()
            }
        });

        // $("#chatList").animate({ scrollTop: $('#chatList').prop("scrollHeight")}, 1000);
        // $('#chatList').scrollTop($('#div1')[0].scrollHeight);
         
        

        var socket = io('https://backend.hithere.co.nz:6000');
        // var socket = io('http://localhost:4000');
        socket.on("connect", () => {
            console.log('Connected laravel')
            var rooms = {{chatrooms()}}
            rooms.map((index,value)=>{
                socket.emit('joinRoom', index)
            })
        });

        function getUserList(){
            $.ajax({
                method:'get',
                url:'/chatroom_users',
                success:function(users){
                    $('#contectList').html(users)
                    // console.log(users)
                }
            })
        }

        function unreadMessage(){
            $.ajax({
                method:'get',
                url:'/unreadMessageCount',
                success:function(users){
                    $('.checkCount').html(users)
                    // console.log(users)
                }
            })
        }

        function unreadMessageDelete(chatroomId,userId){
            $.ajax({
                method:'get',
                url:`/readMessage/${chatroomId}/${userId}`,
                success:function(users){
                    console.log(users)
                }
            })
        }

        async function getMessages(chatroomId,userId){
            await unreadMessageDelete(chatroomId,userId)
            $.ajax({
                method:'get',
                url:'/chatroom_messages/'+chatroomId+'/'+userId,
                success:function(message){
                    $('#chatArea').html(message)
                    getUserList()
                    setTimeout(() => {
                        var objDiv = document.getElementById('chatList124');
                        if(objDiv){
                            objDiv.scrollTop = objDiv.scrollHeight
                        }
                    }, 10)
                    var messageOld = $('#message').val() 
                    $('#message').focus()
                    $('#message').val(messageOld)
                    // console.log(message)
                }
            })
        }

        function getNewMesage(userId,chatroomId){
            $.ajax({
                method:'get',
                url:'/get_last_messages/'+userId+'/'+chatroomId,
                success:function(message){
                    console.log('getMessage',message)
                    socket.emit("sendFromSeller",message)   
                }
            })
        }

        socket.on('newUser',(mesg)=>{
            setTimeout(() => {
                getUserList()
            }, 2000)
        })
        socket.on('userGone',(mesg)=>{
            getUserList()
        })

        socket.on("recivedToBuyer", (newMsg) => {
            var crntUser = parseInt($('#selectedUser').attr('selected-user'))
            newMsg.selectedUser = crntUser

            $.ajax({
                method:'post',
                url:'/get_new_messages',
                data:newMsg,
                success:function(message){
                    getUserList()
                    // var url = "https://dashboard.hithere.co.nz/sound/cool_chat_sound.mp3";
                    // var audio = new Audio(url);
                    // audio.play();

                    if(newMsg.senderId===crntUser){
                        $("#chatList124").append(message);
                            setTimeout(() => {
                                var objDiv = document.getElementById('chatList124');
                                if(objDiv){
                                    objDiv.scrollTop = objDiv.scrollHeight
                                }
                            }, 10)                    
                    }
                }
            })
        })

        socket.on("recivedMesage", async(msg) => {
            var crntUser = parseInt($('#selectedUser').attr('selected-user'))
            msg.selectedUser = crntUser
            var messageOld = $('#message').val() 
            getUserList()
            unreadMessage()
            if(msg.senderId === crntUser){
                await getMessages(msg.chatroomId,msg.senderId);     
            }
            $('#message').focus()
            setTimeout(()=>{
                $('#message').val(messageOld)
            },500)

        });

        $(document).ready(function() {
          $('#complex_header').DataTable();

            var userId = $('#'+1).attr('userId')
            var chatroomId = $('#'+1).attr('chatroomId')
            // alert(chatroomId)
              
                getUserList()
                getMessages(chatroomId,userId)   
            });

        $(document).on('click','.selecteUser',function(){
            var chatroomId = $(this).attr('chatroomId')
            var userId = $(this).attr('userId')
            getMessages(chatroomId,userId)  
            unreadMessage()
            getUserList()
        })
        
        $(document).on('submit','#messageSendForm',function(event){
            event.preventDefault()
            var chatroomId = $('#messageSend').attr('chatroomId')
            var userId = $('#messageSend').attr('UserId')
            var senderId = {{auth()->user()->id}}
            var message = $("#message").val()
            $("#message").val('')
            $.ajax({
                method:'post',
                url:'/save_messages',
                data:{chatroomId:chatroomId,senderId:senderId,message:message},
                success:function(message){
                    getNewMesage(userId,chatroomId)
                    $("#chatList124").append(message);
                    setTimeout(() => {
                        var objDiv = document.getElementById('chatList124');
                        objDiv.scrollTop = objDiv.scrollHeight
                    }, 10)                    
                }
            })
        })


        //var socket = io('http://localhost:3000');
        
        // socket.on("chat-mk:App\\Events\\MessageSent", function(message){
        //     // increase the power everytime we load test route
        //     $('#power').text(parseInt($('#power').text()) + parseInt(message.data.power));
        // });
    </script>
