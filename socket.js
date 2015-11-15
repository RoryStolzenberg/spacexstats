var app = require('express')();
var server = require('http').Server(app);

var io = require('socket.io')(server);
io.set('origins', 'http://spacexstats.app:8000'); // Development only

var redis = require('ioredis');
var Redis = new redis();

Redis.subscribe('live-updates');

Redis.on('message', function(channel, message) {
    message = JSON.parse(message);
    io.emit(channel + ':' + message.event, message.data);
});

server.listen(3000, function() {
    console.log('listening on port 3000');
});