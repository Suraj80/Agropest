<?php

session_start();
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

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch contact form data
$sql = "SELECT Name, Email, Phone, Message FROM contact";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Agropest</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
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

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .header {
            background-color: #ecf0f1;
            padding: 15px;
            border-bottom: 1px solid #bdc3c7;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-bar {
            display: flex;
            align-items: center;
        }

        .nav-bar img {
            width: 25px;
            height: 25px;
            margin-left: 20px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .nav-bar img:hover {
            transform: scale(1.3);
        }

        .profile-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .profile-pic:hover {
            transform: scale(1.3);
        }

        .icon-container {
            position: relative;
            display: inline-block;
        }

        .badge {
            position: absolute;
            top: -5px;
            right: -10px;
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
            font-weight: bold;
            display: none; /* Initially hidden when there are no messages */
        }

        h1 {
            margin: 0;
        }

        .table-container {
            margin-top: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #bdc3c7;
        }

        th {
            background-color: #2c3e50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #ecf0f1;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h1>Agropest</h1>
        <a href="Admin_dashboard.php"><img src="Images/dashboard.png" alt="Dashboard Icon">Dashboard</a>
        <a href="admin_products.php"><img src="Images/box.png" alt="Products Icon">Products</a>
        <a href="user_info.php"><img src="Images/user.png" alt="User Icon">CRM</a>
        <div class="logout"><a href="Logout.php">Logout</a></div>
    </div>
    
    <div class="content">
        <div class="header">
            <h1>CRM Dashboard</h1>
        </div>

        <div class="table-container">
            <h2>Contact Us Submissions</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row['Name']) . "</td>
                                    <td>" . htmlspecialchars($row['Email']) . "</td>
                                    <td>" . htmlspecialchars($row['Phone']) . "</td>
                                    <td>" . htmlspecialchars($row['Message']) . "</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No submissions found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.querySelectorAll('.sidebar a').forEach(link => {
            link.addEventListener('click', function(event) {
                const href = this.getAttribute('href');
                if (href.startsWith('#')) { 
                    event.preventDefault();
                    const targetId = href.substring(1);
                    const targetElement = document.getElementById(targetId);

                    if (targetElement) {
                        targetElement.scrollIntoView({ behavior: 'smooth' });
                    }
                }
            });
        });
    </script>
</body>
</html>
<?php
$conn->close();
?>
