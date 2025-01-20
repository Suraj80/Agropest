<?php

// Enable error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Database connection
$conn = new mysqli('localhost', 'root', '', 'user_db');

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize success and error messages
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Handle image upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        // Get binary content of the uploaded image
        $photo = file_get_contents($_FILES['photo']['tmp_name']);
    } else {
        $error = "Error: Please upload an image.";
    }

    // Proceed if no errors in the upload
    if (empty($error)) {
        // Prepare the SQL query
        $query = "INSERT INTO products (image, Name, Price, Quantity, Description) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        // Bind parameters (b = blob, s = string, i = integer)
        $stmt->bind_param('bsiss', $photo, $name, $price, $quantity, $description);

        // Execute the query
        if ($stmt->execute()) {
            $success = "Product added successfully!";
        } else {
            $error = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Count total products
$result = $conn->query("SELECT COUNT(*) AS productCount FROM products");
$productCount = $result->fetch_assoc()['productCount'];
$result->close();

$conn->close();
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
            margin: 0;
            padding: 0;
            display: flex;
        }

        .sidebar {
            height: 100vh;
            width: 250px;
            background-color: #2c3e50;
            color: white;
            position: fixed;
            display: flex;
            flex-direction: column;
            padding-top: 20px;
        }

        .sidebar h1 {
            text-align: center;
            margin: 0;
            font-size: 20px;
            padding: 15px 0;
            border-bottom: 1px solid #34495e;
        }

        .sidebar a {
            text-decoration: none;
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #34495e;
        }

        .sidebar img {
            margin-right: 10px;
            width: 20px;
            height: 20px;
        }

        .logout {
            margin-top: 10px;
            padding: 15px 20px;
            background-color: #e74c3c;
            color: white;
            text-align: center;
            cursor: pointer;
        }

        .logout:hover {
            background-color: #c0392b;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            width: 100%;
        }

        .navbar {
            background-color: #333;
            color: white;
            overflow: hidden;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 30px;
        }

        .navbar-title {
            font-size: 20px;
            font-weight: bold;
        }

        .navbar-links a {
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            margin-left: 10px;
        }

        .navbar-links a:hover {
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

        .success {
            color: green;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h1>Agropest</h1>
        <a href="Admin_dashboard.html"><img src="Images/dashboard.png" alt="Dashboard Icon">Dashboard</a>
        <a href="admin_products.php"><img src="Images/box.png" alt="Products Icon">Products</a>
        <a href="CMS.html"><img src="Images/user.png" alt="User Icon">CRM</a>
        <div class="logout">Logout</div>
    </div>

    <div class="main-content">
        <div class="navbar">
            <div class="navbar-title">Products Dashboard</div>
            <div class="navbar-links">
                <a href="admin_products.php">Add Product</a>
                <a href="update_products.php">Update Product</a>
                <a href="delete_products.php">Delete Product</a>
            </div>
        </div>

        <h1>Admin - Manage Products</h1>
        <p>Total Products Listed: <strong><?php echo $productCount; ?></strong></p>

        <div class="form-container">
            <h2>Add a New Product</h2>
            <?php if (!empty($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php elseif (!empty($success)): ?>
                <p class="success"><?php echo $success; ?></p>
            <?php endif; ?>

            <form action="admin_products.php" method="post" enctype="multipart/form-data">
                <label for="name">Product Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="description">Product Description:</label>
                <textarea id="description" name="description" rows="3" required></textarea>

                <label for="price">Product Price (INR):</label>
                <input type="number" id="price" name="price" step="0.01" required>

                <label for="quantity">Product Quantity:</label>
                <input type="number" id="quantity" name="quantity" required>

                <label for="photo">Product Photo:</label>
                <input type="file" id="photo" name="photo" accept="image/*" required>

                <button type="submit">Add Product</button>
            </form>
        </div>
    </div>
</body>
</html>
                