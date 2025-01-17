<?php
// delete_products.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $sql = "DELETE FROM products WHERE id=$id";
    $conn->query($sql);
    header('Location: admin_products.php');
    exit;
}

$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Product</title>
</head>
<body>
    <h1>Delete Product</h1>
    <form action="delete_products.php" method="post">
        <label for="id">Select Product to Delete:</label>
        <select name="id" id="id">
            <?php while ($row = $result->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit">Delete Product</button>
    </form>
</body>
</html>
