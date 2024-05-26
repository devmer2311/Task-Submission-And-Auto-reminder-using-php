<?php


include 'conn.php';

if ($conn->connect_error) {
    throw new Exception("Database connection failed: " . $conn->connect_error);
}

// Fetch users from users who haven't submitted data and don't have corresponding records in user_data
$sql = "SELECT u.email, u.name, MAX(ud.time) AS last_submission_date
FROM users u
LEFT JOIN user_data ud ON u.name = ud.name
GROUP BY u.name
HAVING MAX(ud.time) IS NULL OR DATE_SUB(CURDATE(), INTERVAL 3 DAY) > MAX(ud.time);";
$result = $conn->query($sql);

// Check query execution
if ($result === false) {
    throw new Exception("Database query failed: " . $conn->error);
}


if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $name = $row['name'];
        $email = $row['email'];

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
                    'htmlContent' => '<h1>Warning</h1>
                    <p style="color: #333; font-size: 18px; line-height: 1.6; margin-bottom: 20px; text-align: left; padding: 10px; background-color: #f7f7f7; border-radius: 8px;">You Have Not Submitted Your Work Since last 3 days.',
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
        }}
?>

