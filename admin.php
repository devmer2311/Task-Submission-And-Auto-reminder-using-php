<?php

//admin page for see work


session_start();

if (!isset($_SESSION['username'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit();
}

include 'conn.php';

// Fetch all data from the user_data table
$query = "SELECT * FROM user_data";
$result = $conn->query($query);

// Check if there are any rows
if ($result->num_rows > 0) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <title>Admin Page</title>
    </head>
    <body>
        <h1>User Data</h1>
        <a href="details.php"><button>User Details</button></a><br><br>
        <table border="1">
            <tr>
                <th>Name</th>
                <th>Time</th>
                <th>Details</th>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['time']; ?></td>
                    <td><?php echo $row['details']; ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <br>
        <a href="logout.php">Logout</a>
    </body>
    </html>
    <?php
} else {
    echo "No users found.";
}

// Close the database connection
$conn->close();
?>
