<?php

include "connect.php";
include "functions.php";

$errors = [];

$id = null;
$title = null;
$author = null;
$publication = null;
$quantity = null;

if (isset($_POST['create'])) {
    $title = sanitizeInput($_POST['title']);
    $author = sanitizeInput($_POST['author']);
    $publication = sanitizeInput($_POST['publication']);
    $quantity = intval(sanitizeInput($_POST['quantity']));

    // Validation

    // Title
    if (empty($title)) {
        $errors['title'] = "Please specify the book title.";
    }

    // Author
    if (empty($author)) {
        $errors['author'] = "Please specify the book author.";
    }

    // Publication Date
    $publication_timestamp = strtotime($publication);
    if (!$publication_timestamp) {
        $errors['publication'] = "Please enter a valid date.";
    } else if ($publication_timestamp > time()) {
        $errors['publication'] = "Publication date cannot be a future date.";
    }

    // Quantity
    if (empty($quantity)) {
        $errors['quantity'] = "Please specify the quantity of the book.";
    } else if ($quantity <= 0) {
        $errors['quantity'] = "Quantity cannot be a negative number or zero.";
    }

    if (count($errors) == 0) {
        // Check functions.php for the logic.
        $id = generateBookID($title, $author, $publication);

        $query = "INSERT INTO books (id, title, author, publication, quantity) VALUES ('$id', '$title', '$author', '$publication', $quantity)";
        if ($conn->query($query)) {
            $conn->close();
            header("Location: index.php");
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
    <title>Add Book</title>

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
    <h1>Add Book</h1>
    <form action="addbook.php" method="post">
        <div>
            <label for="title">Book Title</label>
            <input type="text" name="title" id="title" value="<?= $title ?>">
            <?php
            if (isset($errors['title'])) {
                ?>
                <p class="error-msg"><?= $errors['title'] ?></p>
                <?php
            }
            ?>
        </div>
        <div>
            <label for="author">Book Author</label>
            <input type="text" name="author" id="author" value="<?= $author ?>">
            <?php
            if (isset($errors['author'])) {
                ?>
                <p class="error-msg"><?= $errors['author'] ?></p>
                <?php
            }
            ?>
        </div>
        <div>
            <label for="publication">Publication Date</label>
            <input type="date" name="publication" id="publication" value="<?= $publication ?>">
            <?php
            if (isset($errors['publication'])) {
                ?>
                <p class="error-msg"><?= $errors['publication'] ?></p>
                <?php
            }
            ?>
        </div>
        <div>
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" value="<?= $quantity ?>">
            <?php
            if (isset($errors['quantity'])) {
                ?>
                <p class="error-msg"><?= $errors['quantity'] ?></p>
                <?php
            }
            ?>
        </div>
        <button type="submit" name="create">Add Book</button>
    </form>
</body>

</html>