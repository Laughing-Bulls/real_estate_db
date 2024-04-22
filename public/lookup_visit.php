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
    // Check if the viewing_id parameter is set
    if (isset($_GET['viewing_id'])) {
        // Retrieve the visit_id from the GET parameters
        $visit_id = $_GET['viewing_id'];

        // Perform any necessary validation on the visit_id

        // Assume $date is fetched from the database based on $viewing_id
        // For demonstration purposes, we'll just hardcode it here
        $date = '2024-05-01';

        // Display the date and time associated with the visit_id
        echo "<p>Date: $date</p>";
    } else {
        // If viewing_id parameter is not set, display an error message
        echo "<p>Error: Viewing ID not provided.</p>";
    }
    ?>
    <p><a href="visit_find.html">Go back</a></p>
</body>
</html>
