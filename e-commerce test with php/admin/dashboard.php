<?php
    session_start();
    if(isset($_SESSION['user_id'])){
        include 'fruitkha_db.php';

        $id = $_SESSION['user_id'];
        // echo $id;

        $select = "SELECT * FROM users WHERE user_id ='$id' ";
        $result = mysqli_query($conn, $select);
        $user = mysqli_fetch_assoc($result);


        // print_r($user);

        $select2 = "SELECT * FROM users WHERE user_id = $id";
        $qry = mysqli_query($conn, $select2);
        $fetch = mysqli_fetch_assoc($qry);
        $role = $fetch['role'];

        if ($role !== 'admin'){
            header("location: ../dashboard  .php");
        }
    }
    else{
        header("Location: login.php");
    }

    if(isset($_GET['logout'])){
        session_destroy();
        header("Location: login.php");
    }

     if(isset($_GET['changepassword'])){
        include 'fruitkha_db.php';
        
        // session_start();
        $id = $_SESSION['user_id'];
        
        $select = "SELECT * FROM users WHERE user_id = '$id' ";
        $qry = mysqli_query($conn, $select);
        $fetch = mysqli_fetch_assoc($qry);

        $userid = $fetch['user_id'];
        
        // print_r($fetch);
        header("Location: changepassword.php?userid=$userid");
        exit();
        }

    if(isset($_GET['editprofile'])){

        $id = $_SESSION['user_id'];
        
        $select = "SELECT * FROM users WHERE user_id = '$id' ";
        $qry = mysqli_query($conn, $select);
        $fetch = mysqli_fetch_assoc($qry);

        $userid = $fetch['user_id'];
        header("Location:profileedit.php?userid=$id");
        exit();
    }
    if(isset($_GET['deleteaccount'])){

        $id = $_SESSION['user_id'];
        
        $select = "SELECT * FROM users WHERE user_id = '$id' ";
        $qry = mysqli_query($conn, $select);
        $fetch = mysqli_fetch_assoc($qry);

        $userid = $fetch['user_id'];
        header("Location:Account-deactivation.php?userid=$id");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="owlcarousel/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="owlcarousel/owl.theme.default.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: #333;
        }

        /* ===== NAVBAR ===== */
        #navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        #navbar ul {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        #navbar ul li a {
            text-decoration: none;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 5px;
        }

        #navbar ul li a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        #search {
            padding: 0.75rem 1rem;
            border: none;
            border-radius: 8px;
            width: 300px;
            background-color: rgba(255, 255, 255, 0.95);
            transition: all 0.3s ease;
        }

        #search:focus {
            outline: none;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.3);
        }

        #cart {
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        #cart:hover {
            transform: scale(1.1);
        }

        #cart-number {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #e74c3c;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.8rem;
        }

        #bar {
            font-size: 1.5rem;
            color: white;
            display: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        #bar:hover {
            transform: scale(1.1);
        }

        #closebar {
            display: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 1rem;
            border-radius: 5px;
        }

        #sidebar {
            display: flex;
        }

        .logout-btn {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid white;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
        }

        .logout-btn:hover {
            background-color: #e74c3c;
            border-color: #e74c3c;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.4);
        }

        /* Profile Header */
        .profile-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .profile-header h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .profile-header p {
            font-size: 1.1rem;
            opacity: 0.95;
        }

        /* Main Content */
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        /* Profile Section */
        .profile-section {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 2rem;
            margin-bottom: 3rem;
        }

        /* Profile Card */
        .profile-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            text-align: center;
        }

        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: white;
            margin: 0 auto 1.5rem;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .profile-name {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #2c3e50;
        }

        .profile-role {
            color: #7f8c8d;
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }

        .profile-status {
            display: inline-block;
            background-color: #2ecc71;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        /* Information Grid */
        .info-grid {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .info-grid h2 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: #2c3e50;
            border-bottom: 2px solid #667eea;
            padding-bottom: 1rem;
        }

        .info-rows {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .info-item {
            padding: 1.5rem;
            background-color: #f5f7fa;
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }

        .info-label {
            font-size: 0.85rem;
            text-transform: uppercase;
            color: #7f8c8d;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .info-value {
            font-size: 1.1rem;
            color: #2c3e50;
            font-weight: 500;
            word-break: break-word;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            font-weight: 600;
        }

        .btn-primary {
            background-color: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background-color: #764ba2;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background-color: #ecf0f1;
            color: #2c3e50;
        }

        .btn-secondary:hover {
            background-color: #bdc3c7;
            transform: translateY(-2px);
        }

        .btn-danger {
            background-color: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
        }

        /* Activity Section */
        .activity-section {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 3rem;
        }

        .activity-section h2 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: #2c3e50;
            border-bottom: 2px solid #667eea;
            padding-bottom: 1rem;
        }

        .activity-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid #ecf0f1;
            transition: background-color 0.3s ease;
        }

        .activity-item:hover {
            background-color: #f5f7fa;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #667eea;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .activity-content {
            flex: 1;
        }

        .activity-text {
            color: #2c3e50;
            font-weight: 500;
        }

        .activity-time {
            font-size: 0.85rem;
            color: #7f8c8d;
        }

        /* Footer */
        footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 2rem;
            margin-top: 3rem;
        }

        /* Responsive */
        @media (max-width: 1100px) {
            #navbar {
                flex-wrap: wrap;
            }

            #navbar ul {
                gap: 1rem;
            }

            #sidebar {
                position: fixed;
                flex-direction: column;
                background-color: #667eea;
                width: 70%;
                height: 100vh;
                top: 0;
                left: -100%;
                transition: left 0.4s ease;
                padding: 2rem 1rem;
                z-index: 99;
                gap: 1rem;
            }

            #sidebar.show {
                left: 0;
            }

            #sidebar li {
                margin-bottom: 1rem;
            }

            #sidebar li a {
                display: block;
                padding: 0.75rem;
                border-radius: 8px;
            }

            #bar {
                display: block;
            }

            #closebar {
                display: block;
                align-self: flex-end;
            }

            #search {
                width: 200px;
                order: 3;
                flex-basis: 100%;
                margin-top: 0.5rem;
            }

            .profile-section {
                grid-template-columns: 1fr;
            }

            .profile-header h1 {
                font-size: 1.8rem;
            }

            .container {
                padding: 0 1rem;
            }

            .info-rows {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
        }

        @media (max-width: 600px) {
            #navbar {
                padding: 0.75rem 1rem;
            }

            

            #search {
                width: 100%;
                order: 2;
            }

            .profile-header h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav id="navbar">
        <i id="bar" class="fa fa-bars" onclick="opensidebar()"></i>
        <ul id="sidebar">
            <i id="closebar" class="fa fa-times" onclick="closesidebar()"></i>
            <li><a href="index.php">HOME</a></li>
            <li><a href="admin-logic.php">UPLOAD PRODUCT</a></li>
            <li><a href="dashboard.php">PROFILE</a></li>
            <li><a href="">CONTACT US</a></li>
        </ul>
        <input type="text" placeholder="Search products..." id="search">
        <a href="?logout=true" class="logout-btn" title="Logout">
            <i class="fas fa-sign-out-alt"></i>
            Logout
        </a>
        <a id="cart">
            <i class="fa fa-shopping-cart"></i>
            <sup id="cart-number"></sup>
        </a>
    </nav>
    <div class="profile-header">
        <h1>User Profile</h1>
        <p>Manage your account and personal information</p>
    </div>

    <!-- Main Container -->
    <div class="container">
        <!-- Profile Section -->
        <div class="profile-section">
            <!-- Profile Card -->
            <div class="profile-card">
                <div class="profile-avatar">
                    <i class="fa fa-user"></i>
                </div>
                <?php if($user): ?>
                    <div class="profile-name"><?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></div>
                    <div class="profile-role"><?php echo $user['role'] ;?> Account</div>
                    <span class="profile-status">Active</span>
                    <div class="action-buttons" style="margin-top: 1.5rem;">
                        <form action="" method="GET">
                            <button class="btn btn-primary" name="editprofile">Edit Profile</button>
                        </form>
                        <form action="" method="GET">

                            <button class="btn btn-secondary" name="changepassword">Change Password</button>
                        </form>
                        <form action="" method="GET">
                            <button class="btn btn-secondary" name="deleteaccount">Delete Account Permanently</button>
                        </form>

                    </div>
                <?php endif; ?>
            </div>

            <!-- Information Grid -->
            <div class="info-grid">
                <h2>Personal Information</h2>
                <div class="info-rows">
                    <?php if($user): ?>
                        <div class="info-item">
                            <div class="info-label">First Name</div>
                            <div class="info-value"><?php echo htmlspecialchars($user['firstname']); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Last Name</div>
                            <div class="info-value"><?php echo htmlspecialchars($user['lastname']); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Email Address</div>
                            <div class="info-value"><?php echo htmlspecialchars($user['email']); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Phone Number</div>
                            <div class="info-value"><?php echo htmlspecialchars($user['phone']); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Region</div>
                            <div class="info-value"><?php echo htmlspecialchars($user['region']); ?></div>
                        </div>
                     
                    <?php else: ?>
                        <p style="color: #e74c3c; font-weight: bold;">Please log in to view your profile.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Activity Section -->
        <?php if($user): ?>
        <div class="activity-section">
            <h2>Recent Activity</h2>
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fa fa-check"></i>
                </div>
                <div class="activity-content">
                    <div class="activity-text">Profile account created</div>
                    <div class="activity-time">Today</div>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fa fa-lock"></i>
                </div>
                <div class="activity-content">
                    <div class="activity-text">Password was set</div>
                    <div class="activity-time">Today</div>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fa fa-envelope"></i>
                </div>
                <div class="activity-content">
                    <div class="activity-text">Email verified</div>
                    <div class="activity-time">Today</div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 E-Commerce Platform. All rights reserved.</p>
    </footer>

    <script src="script.js" defer></script>
    <script src="owlcarousel/docs/assets/vendors/jquery.min.js"></script>
    <script src="owlcarousel/dist/owl.carousel.min.js"></script>
    <script>
        function opensidebar() {
            document.getElementById('sidebar').classList.add('show');
        }

        function closesidebar() {
            document.getElementById('sidebar').classList.remove('show');
        }

        
    </script>
</body>
</html>
