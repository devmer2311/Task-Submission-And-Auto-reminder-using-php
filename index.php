<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Admin Panel</title>
</head>

<body>
    <div class="admin-panel">
        <h1>User Data</h1>
    </div>
    <a href="admin.php"><button>ADMIN</button></a>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="data-form">
        <label for="user">Select User:</label>
        <select id="user" name="user" required>
            <?php
            include 'conn.php'; // Include the database connection file

            // Fetch user names from the database
            $userQuery = "SELECT name FROM users";
            $userResult = $conn->query($userQuery);

            if ($userResult->num_rows > 0) {
                while ($userRow = $userResult->fetch_assoc()) {
                    echo "<option value=\"" . $userRow['name'] . "\">" . $userRow['name'] . "</option>";
                }
            }
            ?>
        </select> <br>
        <label for="datetime">Date and Time:</label>
        <input type="date" id="datetime" name="datetime" required><br>
        <label for="details">Details:</label>
        <textarea id="details" name="details" required></textarea><br>
        <input type="submit" value="Submit">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include 'conn.php'; // Include the database connection file

        $selectedUser = $_POST["user"];
        $datetime = $_POST["datetime"];
        $details = $_POST["details"];

        $sql = "INSERT INTO user_data (name, time, details) VALUES ('$selectedUser', '$datetime', '$details')";

        $emailQuery = "SELECT email FROM users WHERE name = '$selectedUser'";

        if ($conn->query($sql) === TRUE) {
            echo "User data saved successfully";
            header("Location: reminder.php?user=" . urlencode($selectedUser));
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close(); // Close the connection after use
    }
    ?>



</body>

</html>
