<?php
$email = "Surajjangavali80@gmail.com"; // Replace with user's email
$token = bin2hex(random_bytes(32)); // Generate a secure token
$resetLink = "https://yourwebsite.com/reset_password.php?token=$token"; // Reset link

$subject = "Password Reset Request";
$message = "
    Hi,

    We received a request to reset your password. Click the link below to reset your password:

    $resetLink

    If you did not request a password reset, please ignore this email.

    Regards,
    Your Website Team
";

$headers = "From: noreply@yourwebsite.com\r\n";
$headers .= "Reply-To: noreply@yourwebsite.com\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Send the email
if (mail($email, $subject, $message, $headers)) {
    echo "Password reset link has been sent to $email.";
} else {
    echo "Failed to send email. Please try again.";
}
?>
