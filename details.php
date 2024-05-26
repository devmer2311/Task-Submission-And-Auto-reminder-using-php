<?php

//user details page


include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    // Handle deletion here
    $user_id = $_POST['user_id'];
    
    // Prepare and execute the DELETE query
    $delete_query = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    
    if ($stmt) {
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $stmt->close();

        echo "User deleted successfully!";
    } else {
        echo "Error preparing deletion statement.";
    }
}

// Fetch all data from the users table
$query = "SELECT * FROM users";
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
        <a href="adduser.php"><button>Add new users</button></a><br><br>
        
        <table border="1">
            <tr>
                <th>id</th>
                <th>Time</th>
                <th>email</th>
                <th>Action</th>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td>
                    <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this data')">Delete</a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
        <br>
        <a href="admin.php">Go BAck</a>
    </body>
    </html>
    <?php
} else {
    echo "No users found.";
}

// Close the database connection
$conn->close();
?>
