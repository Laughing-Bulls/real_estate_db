const express = require('express');
const app = express();
const PORT = 3000;

app.use(express.static('public'));  // Serves your HTML files from the public directory
app.use(express.urlencoded({ extended: true })); // Parses URL-encoded bodies

// Route to handle GET request
app.get('/lookup-visit', (req, res) => {
    const visitId = req.query.visit_id;

    // Simulate database lookup
    const visitDateTime = '2024-05-01 09:00:00'; // Example date

    // Send response
    res.send(`
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Visit Date and Time</title>
        </head>
        <body>
            <h2>Visit Date and Time</h2>
            <p>Date and Time: ${visitDateTime}</p>
            <p><a href="input_form.html">Go back</a></p>
        </body>
        </html>
    `);
});

app.listen(PORT, () => {
    console.log(`Server running on http://localhost:${PORT}`);
});
