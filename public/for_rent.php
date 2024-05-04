<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection setup
$host = 'sql1.njit.edu';
$user = 'asd26';
$password = '@Yl&K9Akh0';
$dbname = 'asd26';

// Create connection
$conn = new mysqli($host, $user, $password, $dbname, 3306);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Begin HTML output
echo '<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Management Result</title>
    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <a href="for_rent.html" class="btn btn-info mt-3">Back to Rental Search</a>';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch form data
    $city = $_POST['city'] ?? null;
    $state = $_POST['state'] ?? null;
    $home_type = $_POST['home_type'] ?? null;
    $bedrooms = $_POST['bedrooms'] ?? null;
    $bathrooms = $_POST['bathrooms'] ?? null;
    $sq_feet = $_POST['sq_feet'] ?? null;
    $architecture = $_POST['architecture'] ?? null;
    $pool = $_POST['pool'] ?? null;
    $condo_fees = $_POST['condo_fees'] ?? null;

    // Determine the operation
    $stmt = null;  // Initialize statement variable
    $operation = 'search';

    switch ($operation) {
        case 'search':
            // Start with a base SQL query
            $query = "SELECT L.MLS_id, P.street_address, P.unit_no, P.city, P.state, P.zip_code, L.listing_price, P.year_built, P.architecture, P.bedrooms, P.bathrooms, P.home_type, P.sq_feet, P.pool
            FROM Properties P, Listings L
            WHERE L.listing_status = 'for rent'
            AND P.property_id = L.property_id
            AND ";
            $params = [];
            $types = '';
            $conditions = [];

            // Add conditions based on provided input
            if (!empty($city)) {
                $conditions[] = "P.city LIKE CONCAT('%', ?, '%')";
                $params[] = $city;
                $types .= 's';
            }
            if (!empty($state)) {
                $conditions[] = "P.state = ?";
                $params[] = $state;
                $types .= 's';
            }
            if (!empty($home_type)) {
                $conditions[] = "P.home_type = ?";
                $params[] = $home_type;
                $types .= 's';
            }
            if (!empty($bedrooms)) {
                $conditions[] = "P.bedrooms = ?";
                $params[] = $bedrooms;
                $types .= 'i';
            }
            if (!empty($bathrooms)) {
                $conditions[] = "P.bathrooms >= ?";
                $params[] = $bathrooms;
                $types .= 'i';
            }
            if (!empty($sq_feet)) {
                $conditions[] = "P.sq_feet >= ?";
                $params[] = $sq_feet;
                $types .= 'i';
            }
            if (!empty($architecture)) {
                $conditions[] = "P.architecture = ?";
                $params[] = $architecture;
                $types .= 's';
            }
            if (!empty($pool)) {
                $conditions[] = "P.pool = ?";
                $params[] = $pool;
                $types .= 's';
            }
            if (!empty($condo_fees)) {
                $conditions[] = "P.condo_fees <= ?";
                $params[] = $condo_fees;
                $types .= 's';
            }

            if (count($conditions) == 0) {
                echo "<div class='alert alert-danger'>Please provide at least one search criterion.</div>";
                return;
            }

            // Concatenate all conditions for the final query
            $query .= implode(' AND ', $conditions);
            $stmt = $conn->prepare($query);
            if (!$stmt) {
                echo "<div class='alert alert-danger'>Prepare error: " . $conn->error . "</div>";
                return;
            }

            // Preparing an array of references for the parameter bind
            $ref = [];
            $ref[] = &$types; // The first element should be the string of types, passed by reference
            foreach ($params as $key => &$value) {
                $ref[] = &$value;
            }

            // Dynamically bind parameters using call_user_func_array
            call_user_func_array(array($stmt, 'bind_param'), $ref);

            if (!$stmt->execute()) {
                echo "<div class='alert alert-danger'>Execute error: " . $stmt->error . "</div>";
                return;
            }

            // Binding result variables
            $stmt->bind_result($MLS_id, $street_address, $unit_no, $city, $state, $zip_code, $listing_price,
            $year_built, $architecture, $bedrooms, $bathrooms, $home_type, $sq_feet, $pool);

            // Fetching results
            echo "<h2>Search Results</h2><ul class='list-group'>";
            $found = false; // Flag to check if any rows are found

            while ($stmt->fetch()) {
                $found = true; // Set flag to true if data is fetched
                echo "<li class='list-group-item'>MLS#: $MLS_id,
                Address: $street_address $unit_no, $city, $state, $zip_code: Monthly Rent: $$listing_price<br>
                Year Built: $year_built, Style: $architecture, Bedrooms/Bathrooms: $bedrooms / $bathrooms, <br>
                Home Type: $home_type, Square Ft: $sq_feet, Pool on Site: $pool</li>";
            }

            if (!$found) {
                // If no rows were found, display an information message
                echo "<div class='alert alert-info'>No results found for the given search criteria.</div>";
            }

            echo "</ul>"; // Close the list group
            break;

            default:
            echo "<div class='alert alert-danger'>Invalid operation requested.</div>";
            return;
}

    // Execute and close statement
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Completed your $operation</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }
    $stmt->close();

    // Close the database connection if it's still open
    if (isset($conn)) {
        $conn->close();
    }
} // Close the if block checking for POST

echo '</div>';
?>
