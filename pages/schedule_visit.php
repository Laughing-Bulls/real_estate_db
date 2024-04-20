<!-- Begin schedule_visit.php -->

<?php

$buyer_name = $_POST['buyer_name'];
$agent_name = $_POST['agent_name'];
$house_id = $_POST['house_id'];
$visit_date = $_POST['visit_date'];

// Connect to MySQL server
$connection = mysqli_connect("localhost", "username", "password", "dbname");

// Check connection
if ($connection === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Insert new visit record into the database
$sql = "INSERT INTO visits (buyer_name, agent_name, house_id, visit_date)
        VALUES ('$buyer_name', '$agent_name', '$house_id', '$visit_date')";

if (mysqli_query($connection, $sql)) {
    echo "Visit scheduled successfully.";
} else {
    echo "ERROR: Could not execute $sql. " . mysqli_error($connection);
}

// Close connection
mysqli_close($connection);

?>

<!-- End schedule_visit.php -->
