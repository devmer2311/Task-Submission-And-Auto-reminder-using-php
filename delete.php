<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    // Handle deletion here
    $user_id = $_GET['id'];

    // Prepare and execute the DELETE query
    $delete_query = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($delete_query);

    if ($stmt) {
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $stmt->close();

        header("Location: details.php");
        exit(); 
    } else {
        echo "Error preparing deletion statement.";
    }
} else {
    echo "Invalid request.";
}

// Close the database connection
$conn->close();
?>
