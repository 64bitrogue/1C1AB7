<?php

// Set up variables to connect to the database.

$hostname = 'localhost';
$username = 'root';
$password = '';
$database = '1c1ab7';
 
$conn = new mysqli($hostname, $username, $password, $database);

// If database connection fails,
// the echo statement prints out the error.

if (!$conn) {
    echo "Connection failed. Error: " . $conn->error;
    die();
}