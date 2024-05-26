<?php

if (isset($_GET['user'])) {
    $user = urldecode($_GET["user"]);
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        include 'conn.php';

        $emailQuery = "SELECT email FROM users WHERE name = ?";
        $stmt = $conn->prepare($emailQuery);

        if ($stmt) {
            // Bind the parameter
            $stmt->bind_param('s', $user);

            // Execute the statement
            $stmt->execute();

            // Bind the result variable
            $stmt->bind_result($email);

            // Fetch the result
            $stmt->fetch();

            // Close the statement
            $stmt->close();

            if ($email) {
                // Set SendinBlue API key
                $api_key = ''; // Replace with your SendinBlue API key

                // SendinBlue API endpoint
                $url = 'https://api.sendinblue.com/v3/smtp/email';

                // Template ID from your SendinBlue account
               

                // Email data
                $email_data = [
                    'to' => [['email' => $email]],
                    'subject' => 'Ok',
                    'htmlContent' => 'You Have Successfully Submitted Your Work.',
                    'sender' => ['email' => 'dj23forido@gmail.com']// Replace with recipient email address
                ];

                // ...

                // Prepare cURL request
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($email_data));
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'api-key: ' . $api_key,
                ]);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                // Execute cURL request
                $response = curl_exec($ch);
                $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                // Check the response
                if ($http_code === 201) {
                    echo "Email sent successfully!";
                } else {
                    echo "Email failed to send. Response: $response";
                }
            } else {
                echo "User not found.";
            }
        } else {
            echo 'Error preparing statement.';
        }
    } else {
        echo "Invalid request method.";
    }
} else {
    echo "Username not provided in the POST data.";
}
?>
