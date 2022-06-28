var app = require('express')();
var http = require('http');
const socketio = require('socket.io')
// var Redis = require('ioredis');
var cors = require('cors');

// var redis = new Redis();

const server = http.createServer(app)

const io = socketio(server,{cors: {
    origin: "*",
    methods: ["GET", "POST"],
    credentials: true
  }})

io.on('connection',socket =>{
    var allRomes = []
    socket.on('joinRoom',(chatroomId)=>{  
        allRomes.push(chatroomId)
        socket.join(chatroomId)
        socket.broadcast.emit('newUser','fatch')   
    })

    socket.on('startchat',function(msg){
        socket.broadcast.emit('joinNew',msg)   
    })

    socket.on('logout',function(msg){
        socket.broadcast.emit('userGone','fatch')   
    })

    socket.on('sendMesage',async (msg) =>{
        io.sockets.to(msg.chatroomId).emit('recivedMesage',msg)
    })

    socket.on('sendFromSeller',async (sellerMsg) =>{     
        socket.join(sellerMsg.chatroomId)   
        io.emit('mk',sellerMsg)
        // socket.emit('recivedToBuyer',sellerMsg)
    })
})


server.listen(4000, function(){
    console.log('Listening on Port 4000');
});