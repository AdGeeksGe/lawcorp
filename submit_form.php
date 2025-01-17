<?php
// submit_form.php

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate inputs
    if (empty($name) || !$email || empty($message)) {
        echo "<script>alert('All fields are required and the email must be valid.'); window.history.back();</script>";
        exit;
    }

    // Email settings
    $to = 'your_email@example.com'; // Replace with your email address
    $subject = 'New Contact Form Submission';
    $headers = "From: $email\r\n" .
               "Reply-To: $email\r\n" .
               "Content-Type: text/plain; charset=UTF-8";

    $emailBody = "You have received a new message from the contact form on your website:\n\n" .
                 "Name: $name\n" .
                 "Email: $email\n" .
                 "Message:\n$message\n";

    // Send the email
    if (mail($to, $subject, $emailBody, $headers)) {
        echo "<script>alert('Your message has been sent successfully!'); window.location.href = '/';</script>";
    } else {
        echo "<script>alert('There was an error sending your message. Please try again later.'); window.history.back();</script>";
    }
} else {
    // Redirect to the homepage if the form is accessed without a POST request
    header('Location: /');
    exit;
}
?>
