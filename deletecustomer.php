<?php

include "connect.php";

if (isset($_POST['delete'])) {
    $id = sanitizeInput($_POST['id']);
    $query = "DELETE FROM customers WHERE id = $id";
    if ($conn->query($query)) {
        $conn->close();
        header("Location: indexcustomers.php");
    } else {
        echo "Unable to delete record. Error: " . $conn->error;
        die();
    }
}