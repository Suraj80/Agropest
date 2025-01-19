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

#message-icon:hover + .badge {
    transform: scale(1.3); /* Optional hover effect for the badge */
    transition: transform 0.3s ease;
}


        h1 {
            margin: 0;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h1>Agropest</h1>
        <a href="Admin_dashboard.html"><img src="Images/dashboard.png" alt="Dashboard Icon">Dashboard</a>
        <a href="admin_products.php"><img src="Images/box.png" alt="Products Icon">Products</a>
        <a href="user_info.html"><img src="Images/user.png" alt="User Icon">CRM</a>
        <div class="logout">Logout</div>
    </div>
    
    

    <div class="content">
        <div class="header">
            <h1>CRM DashBoard</h1>
            <div class="nav-bar">
                <div class="icon-container">
                    <img src="Images/email.png" alt="Messages" id="message-icon">
                    <span class="badge" id="message-badge">0</span>
                </div>
                <img src="Images/user.png" alt="Profile Picture" class="profile-pic">
            </div>
            
        </div>
        <div id="dashboard">
            <h2>Dashboard Section</h2>
            <p>Welcome to the dashboard!</p>
            <div id="website-stats">
                <h3>Website Stats</h3>
                <p>Total Visits: <span id="total-visits">Loading...</span></p>
                <p>Traffic Details: <span id="traffic-details">Loading...</span></p>
            </div>
        </div>
        
        <div id="products">
            <h2>Products Section</h2>
            <p>Manage your products here.</p>
        </div>
        
        <div id="user-info">
            <h2>User Info Section</h2>
            <p>View and manage user information here.</p>
        </div>
        

    <script>
        let messageCount = 0;

    // Function to increment message count and display badge
    function addNewMessage() {
        messageCount++;
        const badge = document.getElementById("message-badge");
        badge.textContent = messageCount;
        badge.style.display = "block"; // Show badge when new messages arrive
    }

    // Simulating new messages (call this whenever a new message arrives)
    setTimeout(() => addNewMessage(), 2000); // Message 1 arrives after 2 seconds
    setTimeout(() => addNewMessage(), 5000); // Message 2 arrives after 5 seconds

    document.querySelectorAll('.sidebar a').forEach(link => {
    link.addEventListener('click', function(event) {
        const href = this.getAttribute('href');
        if (href.startsWith('#')) { // Only prevent default for internal navigation
            event.preventDefault();
            const targetId = href.substring(1); // Remove '#' from href
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                targetElement.scrollIntoView({ behavior: 'smooth' });
            }
        }
    });
});


</body>
</html>
