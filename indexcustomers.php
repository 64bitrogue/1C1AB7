<?php
include "connect.php";
include "functions.php";

$customer = null;

// Checks if user is searching for a customer and if 'search' url parameter has value.
if (isset($_GET['customer']) && strlen($_GET['customer']) > 0) {
    $customer = sanitizeInput($_GET['search']);

    $query = "SELECT * FROM customers WHERE id LIKE '%$customer%' OR username LIKE '%$customer%'";

} else {
    $query = "SELECT * FROM customers";
}

$customers = mysqli_query($conn, $query);
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
            <li><a href="addcustomer.php">Add Customer</a></li>
            <li><a href="index.php">View Books</a></li>
            <li><a href="transact.php">Transaction</a></li>
        </ul>
    </nav>
    <main>
        <h1>Customers</h1>
        <form action="index.php" method="get">
            <input type="text" name="customer" id="customer" value="<?= $customer ?>">
            <button type="submit">Search</button>
        </form>
        <table>
            <thead>
                <th>ID</th>
                <th>Username</th>
                <th>Actions</th>
            </thead>
            <tbody>
                <?php
                if ($customers) {
                    while ($row = mysqli_fetch_assoc($customers)) {
                        ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['username'] ?></td>
                            <td>
                                <a href="editcustomer.php?id=<?= $row['id'] ?>">Edit</a>
                                <form action="deletecustomer.php" method="post">
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