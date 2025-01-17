<?php
// update_products.php

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
    $name = $_POST['name'];
    $description = $_POST['description'];
    $photo = $_FILES['photo']['name'];

    if ($photo) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($photo);
        move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile);
        $sql = "UPDATE products SET name='$name', description='$description', photo='$targetFile' WHERE id=$id";
    } else {
        $sql = "UPDATE products SET name='$name', description='$description' WHERE id=$id";
    }

    $conn->query($sql);
    header('Location: admin_products.php');
    exit;
}

$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Product</title>
</head>
<body>
    <h1>Update Product</h1>
    <form action="update_products.php" method="post" enctype="multipart/form-data">
        <label for="id">Select Product:</label>
        <select name="id" id="id">
            <?php while ($row = $result->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
            <?php endwhile; ?>
        </select>

        <label for="name">New Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="description">New Description:</label>
        <textarea id="description" name="description" required></textarea>

        <label for="photo">New Photo (optional):</label>
        <input type="file" id="photo" name="photo" accept="image/*">

        <button type="submit">Update Product</button>
    </form>
</body>
</html>
