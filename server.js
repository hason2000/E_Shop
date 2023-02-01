const express = require('express')
const app = express()

const http = require('http')
const server = http.createServer(app)
const Redis = require('ioredis');
server.listen(9000)
const redis = new Redis();

const io = require('socket.io')(server, {
    cors: {origin: "*"}
});

var arrayUserOnline = [];
var objOnline = {};

io.on('connection', function (socket) {
    console.log("client is connected");

    socket.on("user-online", ({userId}) => {
        arrayUserOnline.indexOf(userId) === -1 ? arrayUserOnline.push(userId) : '' ;
        socket.userId = userId;
        objOnline[socket.userId] = socket.id;
        if (!socket.id){
            delete objOnline[userId];
        };
        io.emit("notify-online", objOnline);
    });

    socket.on("private-message", ({to, content, info}) => {
        socket.to(to).emit("private-message", {
            content: content,
            info: info
        })
    })

    socket.on('disconnect', () => {
        console.log('Client is disconnect!!');
        console.log(socket.id);
        for (let socketOff in objOnline) {
            if (objOnline[socketOff] === socket.id) {
                delete  bv[socketOff];
                break
            }
        }
        io.emit("notify-online", objOnline);
    })
});





