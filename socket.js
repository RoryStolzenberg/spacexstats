var app = require('express')();
var server = require('http').Server(app);

var io = require('socket.io')(server);

var redis = require('ioredis');
var Redis = new redis();

Redis.subscribe('live-updates');

Redis.on('message', function(channel, message) {
    message = JSON.parse(message);

    console.log(channel, message);
    io.emit('foo', message.data);
});

server.listen(3000, function() {
    console.log('listening on port 3000');
});