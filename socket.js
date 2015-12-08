var app = require('express')();
var cors = require('cors');
app.use(cors());
var https = require('https');
var fs = require('fs');

var io = require('socket.io')(https);

var redis = require('ioredis');
var Redis = new redis();

Redis.subscribe('live-updates');

Redis.on('message', function(channel, message) {
    message = JSON.parse(message);
    console.log(message);
    io.emit(channel + ':' + message.event, message.data);
});

var options = {
    key: fs.readFileSync('/etc/nginx/ssl/spacexstatsbeta.com/17710/server.key'),
    cert: fs.readFileSync('/etc/nginx/ssl/spacexstatsbeta.com/17710/server.crt')
};

https.createServer(options, app).listen(3000, function() {
    console.log('listening');
});