<?php
// admin_products.php

// Database connection using MySQL (phpMyAdmin)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";

// Connect to MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    photo VARCHAR(255) NOT NULL
)";
$conn->query($sql);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $photo = $_FILES['photo']['name'];

    // Upload photo
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($photo);
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
        // Insert product into the database
        $stmt = $conn->prepare("INSERT INTO products (name, description, photo) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $description, $targetFile);
        $stmt->execute();

        // Redirect to products.php
        header('Location: products.php');
        exit;
    } else {
        $error = "Failed to upload photo.";
    }
}

// Get the list of products
$result = $conn->query("SELECT COUNT(*) as count FROM products");
$productCount = $result->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .navbar {
            background-color: #333;
            overflow: hidden;
            display: flex;
        }

        .navbar a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            text-align: center;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .form-container {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            max-width: 500px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input, textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="admin_products.php">Add Product</a>
        <a href="update_products.php">Update Product</a>
        <a href="delete_products.php">Delete Product</a>
    </div>

    <h1>Admin - Manage Products</h1>
    <p>Total Products Listed: <strong><?php echo $productCount; ?></strong></p>

    <div class="form-container">
        <h2>Add a New Product</h2>
        <?php if (!empty($error)): ?>
            <p class="error">Error: <?php echo $error; ?></p>
        <?php endif; ?>
        <form action="admin_products.php" method="post" enctype="multipart/form-data">
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="description">Product Description:</label>
            <textarea id="description" name="description" rows="3" required></textarea>

            <label for="photo">Product Photo:</label>
            <input type="file" id="photo" name="photo" accept="image/*" required>

            <button type="submit">Add Product</button>
        </form>
    </div>
</body>
</html>
