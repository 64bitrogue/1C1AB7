<?php

include "connect.php";

if (isset($_POST['delete'])) {
    $id = sanitizeInput($_POST['id']);
    $query = "DELETE FROM books WHERE id = '$id'";
    if ($conn->query($query)) {
        $conn->close();
        header("Location: index.php");
    } else {
        echo "Unable to delete record. Error: " . $conn->error;
        die();
    }
}