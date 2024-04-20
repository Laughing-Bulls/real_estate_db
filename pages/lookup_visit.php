<!-- lookup_visit.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visit Date and Time</title>
</head>
<body>
    <h2>Visit Date and Time</h2>
    <?php
    // Check if the visit_id parameter is set
    if (isset($_GET['visit_id'])) {
        // Retrieve the visit_id from the GET parameters
        $visit_id = $_GET['visit_id'];

        // Perform any necessary validation on the visit_id

        // Assume $visit_date_time is fetched from the database based on $visit_id
        // For demonstration purposes, we'll just hardcode it here
        $visit_date_time = '2024-05-01 09:00:00';

        // Display the date and time associated with the visit_id
        echo "<p>Date and Time: $visit_date_time</p>";
    } else {
        // If visit_id parameter is not set, display an error message
        echo "<p>Error: Visit ID not provided.</p>";
    }
    ?>
    <p><a href="input_form.html">Go back</a></p>
</body>
</html>
