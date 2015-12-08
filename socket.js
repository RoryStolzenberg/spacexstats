//var app = require('express')();
//var cors = require('cors');
//app.use(cors());
var https = require('https');
var fs = require('fs');

var options = {
    key: fs.readFileSync('/etc/nginx/ssl/spacexstatsbeta.com/17710/server.key'),
    cert: fs.readFileSync('/etc/nginx/ssl/spacexstatsbeta.com/17710/server.crt')
};

var app = https.createServer(options);

var io = require('socket.io')(app);

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