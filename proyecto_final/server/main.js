const { SocketAddress } = require('net');

const port = 3000;

let express = require('express'),
    app = express(),
    http = require('http').Server(app),
    mongodb = require('mongodb').MongoClient,
    url = 'mongodb://localhost:27017',
    dbName = 'proyecto_final',
    socketio = require('socket.io')(http, {
        allowEIO3: true,
        cors: {
            origin: ['http://localhost:8000', 'http://127.0.0.1:8000'],
            credentials: true
        }
    });

function emit(user, msg = '') {
    let options = {
        title: user.name,
        body: msg,
        icon: user.avatar,
        url: 'http://127.0.0.1:8000'
    };
    console.log(`Chanel: ${user.id}Chan`);
    console.log('Send', options);
    socketio.emit(`${user.id}Chan`, options);
}

socketio.on('connection', socket => {
    console.log('Client connected from ' + socket.handshake.address);
    socket.on('request', data => {
        emit(data, `${data.name} te ha enviado una solicitud`);
        
    });
    socket.on('accept', data => {
        emit(data, `${data.name} ha aceptado tu solicitud`);
    });
    socket.on('sendMsg', data => {
        mongodb.connect(url, (err, client) => {
            if (err) console.log(err);
            const db = client.db(dbName);
            db.collection('chats').insertOne({
                by: data.by,
                to: data.to,
                msg: data.msg,
                date: data.date
            }).then(response => {
                let sortids = [data.by, data.to].sort((a, b) => a - b);
                console.log(`${sortids.join('_')}Chan`, data);
                socketio.emit(`${data.by}${data.to}Chan`, data);
                emit({name: `${data.name} envió`, avatar: data.icon, id: data.to}, data.msg);
            }).catch(error => {
                console.log(error);
            }); 
        });
    });
    socket.on('chats', data => {
        mongodb.connect(url, (err, client) => {
            console.log(data, typeof data);
            if (err) console.log(err);
            const db = client.db(dbName);
            db.collection('chats').find({
                $or: [
                    {by: data.ids[0], to: data.ids[1]},
                    {by: data.ids[1], to: data.ids[0]}
                ]
            }).toArray((err, chat) => {
                if (err) console.log(err);
                console.log(`${data.ids.join('_')}Chat`);
                socket.emit(`${data.ids.join('_')}Chat`, chat);
            });
        });
    });

});
app.use(express.json());
app.get('/', function(req, res){
    res.redirect('http://127.0.0.1:8000/');
});
http.listen(port, function() {
    console.log('listening on http://127.0.0.1:' + port);
});