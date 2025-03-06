<?php
// Start the session
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin' || !isset($_SESSION['logged-in']) || $_SESSION['logged-in'] !== true) {
    header("Location: login.php");
    exit();
}

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

        #dashboard {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        #dashboard h2 {
            text-align: center;
            color: #333;
        }

        #website-stats {
            background-color: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        #website-stats h3 {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 20px;
        }

        #website-stats p {
            font-size: 1rem;
            color: #666;
            margin: 10px 0;
        }

        #website-stats span {
            font-weight: bold;
            color: #333;
        }

        /* Sample data styling */
        #traffic-details {
            display: block;
            font-size: 1rem;
            color: #666;
        }

        #traffic-details ul {
            list-style-type: none;
            padding-left: 0;
        }

        #traffic-details li {
            margin: 8px 0;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            #dashboard {
                padding: 15px;
            }

            #website-stats {
                padding: 15px;
            }
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

<?php include 'sidebar.php'; ?>


    

    <div class="content">
        <div class="header">
            <h1>Agropest Admin Dashboard</h1>
            <div class="nav-bar">
                <div class="icon-container">
                    <img src="../Images/email.png" alt="Messages" id="message-icon">
                    <span class="badge" id="message-badge">0</span>
                </div>
                <img src="../Images/user.png" alt="Profile Picture" class="profile-pic">
            </div>
        </div>
        <div id="dashboard">
            <h2>Dashboard Section</h2>
            <p>Welcome to the dashboard!</p>
            <div id="website-stats">
                <h3>Website Stats</h3>
                <p>Total Visits: <span id="total-visits">12,342 viewers</span></p>
                <p>Unique Visitors: <span id="unique-visitors">9,215</span></p>
                <p>Page Views: <span id="page-views">42,785</span></p>
                <p>Average Session Duration: <span id="avg-session-duration">3m 25s</span></p>
                <p>Bounce Rate: <span id="bounce-rate">45.2%</span></p>
                <p>New vs Returning Visitors: <span id="new-vs-returning">65% new, 35% returning</span></p>
                <div id="traffic-details">
                    <h3>Traffic Details:</h3>
                    <ul>
                        <li><strong>Top Traffic Source:</strong> Organic Search</li>
                        <li><strong>Top Referring Site:</strong> Facebook</li>
                        <li><strong>Mobile vs Desktop:</strong> 70% mobile, 30% desktop</li>
                        <li><strong>Top Landing Page:</strong> /Index</li>
                        <li><strong>Top Exit Page:</strong> /Contact</li>
                        <li><strong>Country with Most Visitor   s:</strong> India</li>
                        <li><strong>Gender Distribution:</strong> 55% Male, 45% Female</li>
                        <li><strong>Age Range:</strong> 18-34 (45%), 35-54 (35%), 55+ (20%)</li>
                    </ul>
                </div>
            </div>
        </div>
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

        async function fetchWebsiteStats() {
    try {
        // Mocking the API response for now
        const data = {
            totalVisits: '12,342',
            trafficDetails: `
                <ul>
                    <li><strong>Top Traffic Source:</strong> Organic Search</li>
                    <li><strong>Top Referring Site:</strong> Facebook</li>
                    <li><strong>Mobile vs Desktop:</strong> 70% mobile, 30% desktop</li>
                    <li><strong>Top Landing Page:</strong> /home</li>
                    <li><strong>Top Exit Page:</strong> /contact-us</li>
                    <li><strong>Country with Most Visitors:</strong>India</li>
                    <li><strong>Gender Distribution:</strong> 55% Male, 45% Female</li>
                    <li><strong>Age Range:</strong> 18-34 (45%), 35-54 (35%), 55+ (20%)</li>
                </ul>`
        };

        document.getElementById('total-visits').textContent = data.totalVisits;
        document.getElementById('traffic-details').innerHTML = data.trafficDetails;
    } catch (error) {
        console.error('Error fetching website stats:', error);
        document.getElementById('total-visits').textContent = 'Error fetching data';
        document.getElementById('traffic-details').textContent = 'Error fetching data';
    }
}

    </script>

</body>
</html>
