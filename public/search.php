<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEARCH RESULTS</title>
    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = 'sql1.njit.edu';  // Might need to use the internal network address
$user = 'asd26';
$password = '<password>';
$dbname = 'asd26';

// Create connection
$conn = new mysqli($host, $user, $password, $dbname, 3306);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Read the post values
$state = $_POST['state'];
$property_type = $_POST['property_type'];
$status = $_POST['status'];

// Prepare the SQL statement
$sql = "SELECT l.MLS_id, p.street_address, p.unit_no, p.city, p.state, p.home_type, l.listing_status
        FROM Properties p
        JOIN Listings l ON p.property_id = l.property_id
        WHERE p.state = ? AND p.home_type = ? AND l.listing_status = ?";

$stmt = $conn->prepare($sql);
if (false === $stmt) {
    throw new Exception('MySQL prepare error: ' . $conn->error);
}

// Bind parameters and execute
$stmt->bind_param("sss", $state, $property_type, $status);
$stmt->execute();

// Bind the result variables
$stmt->bind_result($MLS_id, $street_address, $unit_no, $city, $state, $home_type, $listing_status); // Make sure to include all columns that you are fetching

// Formatting
echo '<div class="container mt-5">'; // Bootstrap container with top margin
echo '<h2 class="text-center bg-primary text-white p-3">Search Results</h2>'; // Bootstrap styled header
echo '<div class="row justify-content-center">'; // Centered row for results
echo '<div class="col-md-8">'; // Column sizing

// Fetch values
while ($stmt->fetch()) {
    echo "<div class='card mb-3'>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title'>MLS# $MLS_id - Address: $street_address" . (!empty($unit_no) ? ", Unit# $unit_no" : "") . ", $city, $state</h5>"; // Use card title for address
    echo "<p class='card-text'>Type: $home_type $listing_status</p>"; // Card text for details
    echo "</div>";
    echo "</div>";
}
echo '</div>'; // Close column
echo '</div>'; // Close row
echo '</div>'; // Close container

$stmt->close();
$conn->close();
?>

</body>
</html>
