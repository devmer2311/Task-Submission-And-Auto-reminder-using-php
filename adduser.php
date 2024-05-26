<!DOCTYPE html>
<!-- Add user Page-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Add User</title>
</head>
<body>
    <h1>Add User</h1>

    <?php
    include 'conn.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Handle form submission
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];

        // Validate and sanitize input (you may add more validation)
        $id = mysqli_real_escape_string($conn, $id);
        $name = mysqli_real_escape_string($conn, $name);
        $email = mysqli_real_escape_string($conn, $email);

        // Insert user data into the database
        $insert_query = "INSERT INTO users (id, name,email) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_query);

        if ($stmt) {
            $stmt->bind_param('sss', $id, $name, $email);
            $stmt->execute();
            $stmt->close();

            echo "User added successfully!";
        } else {
            echo "Error preparing insertion statement.";
        }
    }
    ?>
    <div class="user">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="id">ID:</label>
        <input type="text" id="id" name="id" required>
        <br>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="name">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <input type="submit" value="Add User">
    </form>
    </div>
    <br>

    <a href="details.php">Back to User List</a>

    <?php
    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
