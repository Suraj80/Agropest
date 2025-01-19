<?php
$conn = new mysqli('localhost', 'root', '', 'user_db'); // Update with your MySQL credentials

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE Username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result  ->fetch_assoc();
        if (password_verify($password, $row['Password'])) {
            // Redirect to login.html on successful signup
            header("Location: admin_dashboard.html");
            exit(); // Always call exit after header to prevent further script execution
        } else {
            ?>
            <script>
                alert("Wrong Password ! Please Try Again");
            </script>
            <?php
            exit();
        }
    } else {
        ?>
            <script>
                alert("No Such User Found! Please Try Again");
            </script>
            <?php
             exit();
    }
}
?>
