<?php

session_start();



// Check if username is "admin" and logg_in is true
if ($_SESSION['username'] !== 'admin' || $_SESSION['logged_in'] !== true) {
    // Redirect to login page if the conditions are not met
    header("Location: login.php");
    exit();
}



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
<?php include 'sidebar.php'; ?>
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