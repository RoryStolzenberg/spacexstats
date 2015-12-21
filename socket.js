require('dotenv').load();
// for future reference on digitalocean VPS: https://www.digitalocean.com/community/questions/socket-io-connection-timing-out
// https://help.ubuntu.com/lts/serverguide/firewall.html
var https = require('https');
var fs = require('fs');

var options = {
    key: fs.readFileSync(process.env.SSL_KEY),
    cert: fs.readFileSync(process.env.SSL_CERT)
};

var app = https.createServer(options);

var io = require('socket.io')(app);

var redis = require('ioredis');
var Redis = new redis();

Redis.subscribe('live-updates');

Redis.on('message', function(channel, message) {
    message = JSON.parse(message);
    io.emit(channel + ':' + message.event, message.data);
});

app.listen(3000, function() {
});