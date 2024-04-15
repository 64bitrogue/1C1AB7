<?php

include "connect.php";
include "functions.php";

$errors = [];

$username = null;
$id = null;

if (!isset($_POST['edit'])) {

    $id = sanitizeInput($_GET['id']);

    $query = "SELECT * FROM customers WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $id = $row['id'];
        $username = $row['username'];  
    } else {
        echo "ID not found.";
        die();
    }
} else {
    $id = sanitizeInput($_POST['id']);
    $username = sanitizeInput($_POST['username']);

    // Validation
    // Username
    if (empty($username)) {
        $errors['username'] = "Please specify the username.";
    } else if (preg_match("/[^a-zA-Z0-9]/", $username)) {
        $errors['username'] = "Username must be alphanumeric only.";
    }

    if (count($errors) == 0) {
        $query = "UPDATE customers SET username = '$username' WHERE id = $id";

        if ($conn->query($query)) {
            $conn->close();
            header("Location: indexcustomers.php");
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>

    <style>
        .error-msg {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <nav>
        <ul>
            <li><a href="index.php">View Books</a></li>
            <li><a href="indexcustomers.php">View Customers</a></li>
        </ul>
    </nav>
    <h1>Add Customer</h1>
    <form action="editcustomer.php" method="post">
        <input type="hidden" name="id" id="id" value="<?= $_GET['id'] ?>">
        <div>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="<?= $username ?>">
            <?php
            if (isset($errors['username'])) {
                ?>
                <p class="error-msg"><?= $errors['username'] ?></p>
                <?php
            }
            ?>
        </div>
        <button type="submit" name="edit">Edit Customer</button>
    </form>
</body>

</html>