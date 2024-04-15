<?php
include "connect.php";
include "functions.php";

$book = null;

// Checks if user is searching for a book and if 'search' url parameter has value.
if (isset($_GET['book']) && strlen($_GET['book']) > 0) {
    $book = sanitizeInput($_GET['search']);

    $query = "SELECT * FROM books WHERE id LIKE '%$book%' OR title LIKE '%$book%' OR author LIKE '%$book%' ORDER BY publication DESC";

} else {
    $query = "SELECT * FROM books ORDER BY publication DESC";
}

$books = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>1C1AB7</title>
</head>
<body>
    <nav>
        <ul>
            <li><a href="addbook.php">Add Book</a></li>
            <li><a href="indexcustomers.php">View Customers</a></li>
            <li><a href="transact.php">Transaction</a></li>
        </ul>
    </nav>
    <main>
        <h1>Books</h1>
        <form action="index.php" method="get">
            <input type="text" name="book" id="book" value="<?= $book ?>">
            <button type="submit">Search</button>
        </form>
        <table>
            <thead>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Publication Date</th>
                <th>Quantity</th>
                <th>Actions</th>
            </thead>
            <tbody>
                <?php
                if ($books) {
                    while ($row = mysqli_fetch_assoc($books)) {
                        ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['title'] ?></td>
                            <td><?= $row['author'] ?></td>
                            <td><?= date_format(date_create($row['publication']), 'F j, Y') ?></td>
                            <td><?= $row['quantity'] ?></td>
                            <td>
                                <a href="editbook.php?id=<?= $row['id'] ?>">Edit</a>
                                <form action="deletebook.php" method="post">
                                    <input type="hidden" name="id" id="id" value="<?= $row['id'] ?>">
                                    <button type="submit" name="delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </main>
</body>
</html>