<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection setup
$host = 'sql1.njit.edu';  // Might need to use the internal network address
$user = 'asd26';
$password = '@Yl&K9Akh0';
$dbname = 'asd26';

// Create connection
$conn = new mysqli($host, $user, $password, $dbname, 3306);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['customer'])) {
    $buyer_id = $_POST['customer'];

    // Prepare SQL statement to retrieve visits
    $stmt = $conn->prepare("SELECT V.MLS_id, V.viewing_date, V.viewing_time, B.first_name, B.last_name, P.street_address
                            FROM Viewings V
                            JOIN BuyersRenters B ON V.buyer_id = B.buyer_id
                            JOIN Listings L ON V.MLS_id = L.MLS_id
                            JOIN Properties P ON L.property_id = P.property_id
                            WHERE V.buyer_id = ?
                            ORDER BY V.viewing_date ASC, V.viewing_time ASC");
    $stmt->bind_param("i", $buyer_id);
    $stmt->execute();
    $stmt->bind_result($MLS_id, $viewing_date, $viewing_time, $first_name, $last_name, $street_address);  // Bind result variables

    if ($stmt->fetch()) {
        echo "<h2>Visits for customer number $buyer_id: $first_name $last_name</h2>";
        echo "<ul>";
        do {
            echo "<li>Date: $viewing_date, Time: $viewing_time,   MLS Listing: $MLS_id, Street Address: $street_address</li>";
        } while ($stmt->fetch());
        echo "</ul>";
    } else {
        echo "No visits found for customer number $buyer_id: $first_name $last_name";
    }

    $stmt->close();
} else {
    echo "Please enter a customer number to check visits.";
}

$conn->close();
?>
