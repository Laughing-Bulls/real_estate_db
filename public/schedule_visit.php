<!-- Begin schedule_visit.php -->

<?php

$buyer_name = $_POST['buyer_name'];
$agent_name = $_POST['agent_name'];
$house_id = $_POST['house_id'];
$visit_date = $_POST['visit_date'];

// Connect to MySQL server
$connection = mysqli_connect("webhost01.arcs.njit.edu:45320", "asd26", "@Yl&K9Akh0", "asd26");


<!-- 
mysql_connect (<MySQLserver>, <username>, <password>);

mysql_select_db (<dbname>);

$connection = mysqli_connect("localhost", "username", "password", "dbname");
    $connection = mysqli_connect("webhost01.arcs.njit.edu:45320", "asd26", "<password>", "asd26");

    
    Server: sql1.njit.edu via TCP/IP
Server type: MySQL
Server version: 8.0.17 - MySQL Community Server - GPL
Protocol version: 10
User: asd26@webhost01.arcs.njit.edu
Server charset: UTF-8 Unicode (utf8)

mysql_connect (<MySQLserver>, <username>, <password>);

mysql_select_db (<dbname>);
    -->

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
