var app = require('express')();
var cors = require('cors');
app.use(cors());
var server = require('http').Server(app);

var io = require('socket.io')(server);

var redis = require('ioredis');
var Redis = new redis();

Redis.subscribe('live-updates');

Redis.on('message', function(channel, message) {
    message = JSON.parse(message);
    console.log(message);
    io.emit(channel + ':' + message.event, message.data);
});

app.listen(3000, function() {
    console.log('listening');
});