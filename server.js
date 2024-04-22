const mysql = require('mysql');
const connection = mysql.createConnection({
    host: 'sql1.njit.edu',
    user: 'asd26',
    password: '@Yl&K9Akh0',
    database: 'asd26'
});

connection.connect(function(err) {
    if (err) {
        console.error('error connecting: ' + err.stack);
        return;
    }
    console.log('connected as id ' + connection.threadId);
});

