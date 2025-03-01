<?php


// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = isset($_POST['Name']) ? $conn->real_escape_string($_POST['Name']) : '';
    $email = isset($_POST['Email']) ? $conn->real_escape_string($_POST['Email']) : '';
    $phone = isset($_POST['Phone']) ? $conn->real_escape_string($_POST['Phone']) : '';
    $message = isset($_POST['Message']) ? $conn->real_escape_string($_POST['Message']) : '';

    // Validate form fields (basic validation)
    if (empty($name) || empty($email) || empty($phone) || empty($message)) {
        echo "All fields are required.";
        exit;
    }

    // Insert data into the contact table
    $sql = "INSERT INTO contact (name, email, phone, message) VALUES ('$name', '$email', '$phone', '$message')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to index.html on successful insertion
        header("Location: index.html");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
