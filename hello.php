<?php

// Set your SendinBlue API key
$api_key = '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';

// SendinBlue API endpoint for sending transactional emails
$url = 'https://api.sendinblue.com/v3/smtp/email';

// Template ID from your SendinBlue account
$template_id = '2'; // Replace with your template ID

// Sender information
$sender_name = 'DEMO';
$sender_email = 'dj23forido@gmail.com';

// Email data
$email_data = [
    'templateId' => $template_id,
    'to' => 'devkhatri231@gmail.com', // Replace with recipient email address
    'params' => [
        'SENDER_NAME' => $sender_name,
        'SENDER_EMAIL' => $sender_email,
    ],
];

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

// Check the response
if ($http_code === 201) {
    echo "Email sent successfully!";
} else {
    // Display detailed error information
    $error_message = json_decode($response, true);
    if (isset($error_message['message'])) {
        echo "Email failed to send. Response: " . $error_message['message'];
    } else {
        echo "Email failed to send. Response: $response";
    }
}

// Close cURL session
curl_close($ch);
?>
