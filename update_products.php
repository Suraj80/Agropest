<?php


// Check if username is "admin" and logg_in is true
if ($_SESSION['username'] !== 'admin' || $_SESSION['logged_in'] !== true) {
    // Redirect to login page if the conditions are not met
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$product = null; // Holds product details after fetching

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['fetch'])) {
        // Fetch product details by ID or name
        $search = $_POST['search'];
        $query = "SELECT * FROM products WHERE id = ? OR name = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("is", $search, $search);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();
    } elseif (isset($_POST['update'])) {
        // Update product details
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $photo = $_FILES['photo']['name'];

        if ($photo) {
            $targetDir = "uploads/";
            $targetFile = $targetDir . basename($photo);
            move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile);

            $sql = "UPDATE products SET name=?, description=?, price=?, quantity=?, photo=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdibi", $name, $description, $price, $quantity, $targetFile, $id);
        } else {
            $sql = "UPDATE products SET name=?, description=?, price=?, quantity=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdii", $name, $description, $price, $quantity, $id);
        }

        if ($stmt->execute()) {
            header("Location: update_products.php?success=1");
            exit;
        } else {
            echo "Error updating product: " . $stmt->error;
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
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
            margin-top: auto;
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
            max-width: 600px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input, textarea, select {
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

        img {
            max-width: 100%;
            height: auto;
            border: 1px solid #ccc;
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

        <h1>Update Product</h1>

        <!-- Fetch Product Form -->
        <div class="form-container">
            <h2>Fetch Product Details</h2>
            <form action="update_products.php" method="post">
                <label for="search">Enter Product ID or Name:</label>
                <input type="text" id="search" name="search" required>
                <button type="submit" name="fetch">Fetch</button>
            </form>
        </div>

        <!-- Display and Update Product Form -->
        <?php if ($product): ?>
            <div class="form-container">
                <h2>Update Product Details</h2>
                <form action="update_products.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $product['Id']; ?>">

                    <label for="name">Product Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo $product['Name']; ?>" required>

                    <label for="description">Product Description:</label>
                    <textarea id="description" name="description" rows="3" required><?php echo $product['Description']; ?></textarea>

                    <label for="price">Product Price:</label>
                    <input type="number" id="price" name="price" value="<?php echo $product['Price']; ?>" required>

                    <label for="quantity">Product Quantity:</label>
                    <input type="number" id="quantity" name="quantity" value="<?php echo $product['Quantity']; ?>" required>

                    <label for="photo">Product Photo (Current):</label>
                    <img src="<?php echo $product['image']; ?>" alt="Product Photo" width="20px" height="40px">
                    <input type="file" id="photo" name="photo" accept="image/*">

                    <button type="submit" name="update">Update Product</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
