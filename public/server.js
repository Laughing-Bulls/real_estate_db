const express = require('express');
const mysql = require('mysql');
const app = express();
const port = 3000;

// Database connection setup
const db = mysql.createConnection({
    host: 'sql1.njit.edu',
    user: 'asd26',
    password: '@Yl&K9Akh0', // Use environment variables or config files to secure credentials
    database: 'asd26'
});

db.connect(err => {
    if (err) throw err;
    console.log("Connected to the database!");
});

// Route to handle GET request
app.get('/getviewing', (req, res) => {
    const viewingId = req.query.id;
    if (!viewingId) {
        return res.status(400).send("Viewing ID is required");
    }
    const query = "SELECT * FROM viewings WHERE viewing_id = ?";
    db.query(query, [viewingId], (err, results) => {
        if (err) return res.status(500).send(err.message);
        res.json(results);
    });
});

// Serve static files from the 'public' directory
app.use(express.static('public'));

app.listen(port, () => {
    console.log(`Server running on http://localhost:${port}`);
});
