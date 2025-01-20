<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$product = null;

if (isset($_POST['fetch'])) {
    $search = $conn->real_escape_string($_POST['search']);
    $sql = "SELECT * FROM products WHERE id='$search' OR name LIKE '%$search%'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "<p style='color:red;'>Product not found.</p>";
    }
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $conn->query("DELETE FROM products WHERE id=$id");
    header('Location: admin_products.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Product</title>
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
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
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
        .back-btn {
            background-color: #007bff;
        }
        button:hover {
            opacity: 0.9;
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
    <div class="form-container">
        <h2>Fetch Product Details</h2>
        <form method="post">
            <label for="search">Enter Product ID or Name:</label>
            <input type="text" id="search" name="search" required>
            <button type="submit" name="fetch">Fetch</button>
        </form>

        <?php if ($product): ?>
            <h2>Product Details</h2>
            <form method="post">
                <label>Product Name:</label>
                <input type="text" value="<?php echo $product['Name']; ?>" readonly>
                <label>Product Description:</label>
                <textarea readonly><?php echo $product['Description']; ?></textarea>
                <input type="hidden" name="id" value="<?php echo $product['Id']; ?>">
                <button type="submit" name="delete">Delete</button>
                <button type="button" class="back-btn" onclick="window.location.href='delete_products.php'">Back</button>
            </form>
        <?php endif; ?>
    </div>
</div>
</body>
</html>