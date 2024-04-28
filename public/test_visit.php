<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

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

// Read the post values
$mls = $_POST['MLS'];
$customer = $_POST['customer'];
$day = $_POST['day'];
$time = $_POST['time'];

echo "MLS: $mls<br>";
echo "Customer: $customer<br>";
echo "Day: $day<br>";
echo "Time: $time<br>";

if (!empty($mls) && !empty($customer) && !empty($day) && !empty($time)) {

    // Check for property availability
    $stmt_property = $conn->prepare("SELECT 1 FROM Viewings WHERE MLS_id = ? AND viewing_date = ? AND viewing_time BETWEEN ADDTIME(?, '-00:30:00') AND ADDTIME(?, '00:30:00')");
    if ($stmt_property === false) {
        die('MySQL prepare property check error: ' . $conn->error);
    }
    $stmt_property->bind_param("isss", $mls, $day, $time, $time);
    $stmt_property->execute();
    if ($stmt_property->error) {
        die("Execute error in property check: " . $stmt_property->error);
    }
    // Using bind_result and fetch
    $stmt_property->bind_result($exists);
    if ($stmt_property->fetch()) {
        die("Property not available for the selected time.");
    }
    $stmt_property->close();

    // Check for customer availability
    $stmt_customer = $conn->prepare("SELECT 1 FROM Viewings WHERE buyer_id = ? AND viewing_date = ? AND viewing_time BETWEEN ADDTIME(?, '-01:00:00') AND ADDTIME(?, '01:00:00')");
    if ($stmt_customer === false) {
        die('MySQL prepare customer check error: ' . $conn->error);
    }
    $stmt_customer->bind_param("isss", $customer, $day, $time, $time);
    $stmt_customer->execute();
    if ($stmt_customer->error) {
        die("Execute error in customer check: " . $stmt_customer->error);
    }
    // Using bind_result and fetch to determine if the customer is available
    $stmt_customer->bind_result($exists);
    if ($stmt_customer->fetch()) {
        die("Customer not available for the selected time.");
    }
    $stmt_customer->close();

    // Prepare and bind the insertion query
    $stmt = $conn->prepare("INSERT INTO Viewings (MLS_id, buyer_id, viewing_date, viewing_time)
                            SELECT ?, ?, ?, ?
                            WHERE NOT EXISTS (
                                SELECT 1 FROM Viewings
                                WHERE (
                                    -- Check for property availability
                                    (MLS_id = ? AND (
                                        (viewing_date = ? AND viewing_time BETWEEN ADDTIME(?, '-00:30:00') AND ADDTIME(?, '00:30:00'))
                                    ))
                                    OR
                                    -- Check for customer availability
                                    (buyer_id = ? AND (
                                        (viewing_date = ? AND viewing_time BETWEEN ADDTIME(?, '-01:00:00') AND ADDTIME(?, '01:00:00'))
                                    ))
                                )
                            );");

    if ($stmt === false) {
        die('MySQL prepare insertion error: ' . $conn->error);
    }

    $stmt->bind_param("iississsisss", $mls, $customer, $day, $time, $mls, $day, $time, $time, $customer, $day, $time, $time);  // Adjusted to match query

    // Execute the statement
    if ($stmt->execute()) {
        echo "Viewing insertion process finished";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Bind the result variables
    // $stmt->bind_result($property_id, $street_address, $city); // Ensure these variables are in the order of the select statement

    // Fetch values
    //if ($stmt->fetch()) {
    //    do {
    //        echo "Property ID: " . $property_id . " - Address: " . $street_address . ", " . $city . ", " . $state . "<br>";
    //    } while ($stmt->fetch());
    //} else {
    //    echo "0 properties found in " . $state;
    //}

    // Close statement
    $stmt->close();

} else {
    echo "Please provide all inputs again.";
}

// Close connection
$conn->close();
?>
