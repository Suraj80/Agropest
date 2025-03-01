<?php
?>
<style>
    
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
</style>

<div class="sidebar">
    <h1>Agropest</h1>
    <a href="Admin_dashboard.php"><img src="../Images/dashboard.png" alt="Dashboard Icon">Dashboard</a>
    <a href="admin_products.php"><img src="../Images/box.png" alt="Products Icon">Products</a>
    <a href="user_info.php"><img src="../Images/user.png" alt="User Icon">CRM</a>
    <div class="logout"><a href="Logout.php">Logout</a></div>
</div>
