<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Display</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .top-nav {
            background-color: darkgreen;
            color: white;
            padding: 10px;
            text-align: right;
        }

        .top-nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
        }

        .top-nav a:hover {
            background-color: white;
            padding: 8px;
            text-decoration: none;
            color: darkgreen;
            border-radius: 20px;
        }

        .main-nav {
            background-color: rgb(231, 231, 231);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }

        .main-nav .logo {
            font-size: 24px;
            font-weight: bold;
            color: darkgreen;
        }

        .main-nav .nav-links {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .main-nav .nav-links a {
            text-decoration: none;
            color: darkgreen;
            font-weight: bold;
            padding: 8px 12px;
            transition: all 0.3s ease;
        }

        .main-nav .nav-links a:hover {
            background-color: darkgreen;
            color: white;
            border-radius: 5px;
        }

        header {
            text-align: center;
            background-color: #ffffff;
            padding: 20px 10px;
        }

        header img {
            max-width: 100%;
            height: auto;
        }

        section {
            text-align: center;
            padding: 20px;
            background-color: #ffffff;
        }

        section h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .product {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .product img {
            width: 150px;
            height: auto;
            margin-bottom: 10px;
        }

        .product h2 {
            font-size: 18px;
            color: #333;
            margin: 10px 0;
        }

        .product p {
            font-size: 14px;
            color: #666;
        }

        .product button {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            font-size: 14px;
        }

        .product button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="top-nav">
        <a href="Login.php">Admin Login</a>
    </div>

    <div class="main-nav">
        <div class="logo">Agro Pest</div>
        <div class="nav-links">
            <a href="Index.html">Home</a>
            <a href="Products.html">Products</a>
            <a href="Crops.html">Crops</a>
            <a href="About.html">About Us</a>
            <a href="Contact.html">Contact</a>
        </div>
    </div>

    <header>
        <img src="Images/box.png" alt="Product Banner" width="100px" height="80px">
    </header>

    <section>
        <h1>TRANSFORMING INDIA Through Agriculture</h1>
        <p>Dhanuka provides a wide range of agrochemical solutions under its Herbicide, Insecticide, Fungicide, and Plant Growth Regulator (PGR) portfolio of brands.</p>
    </section>

    <section class="products">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="product">
            <img src="data:image/jpeg;base64,<?php echo base64_encode($row['Image']); ?>" alt="<?php echo $row['Name']; ?>">
            <h2><?php echo htmlspecialchars($row['Name']); ?></h2>
            <p><?php echo htmlspecialchars($row['Description']); ?></p>
            <p><strong>Price:</strong> ₹<?php echo htmlspecialchars($row['Price']); ?></p>
            <p><strong>Quantity:</strong> <?php echo htmlspecialchars($row['Quantity']); ?></p>
            <button>Know More</button>
        </div>
    <?php endwhile; ?>
</section>

</body>
</html>

<?php $conn->close(); ?>