<?php
$host = 'sql1.njit.edu';  // Might need to use the internal network address
$user = 'asd26';
$password = '<PASSWORD>';
$dbname = 'asd26';

// Create connection
$conn = new mysqli($host, $user, $password, $dbname, 3306);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the state from the user input
$state = isset($_GET['state']) ? $_GET['state'] : '';

if (!empty($state)) {  // Only proceed if state is not empty
    // Prepare and bind
    $stmt = $conn->prepare("SELECT property_id, street_address, city FROM Properties WHERE state = ?");
    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }

    $stmt->bind_param("s", $state);  // "s" indicates the type of the parameter is a string

    // Execute the statement
    $stmt->execute();

    // Bind the result variables
    $stmt->bind_result($property_id, $street_address, $city); // Ensure these variables are in the order of the select statement

    // Fetch values
    if ($stmt->fetch()) {
        do {
            echo "Property ID: " . $property_id . " - Address: " . $street_address . ", " . $city . ", " . $state . "<br>";
        } while ($stmt->fetch());
    } else {
        echo "0 properties found in " . $state;
    }

    // Close statement
    $stmt->close();
} else {
    echo "Please provide a state.";
}

// Close connection
$conn->close();
?>
