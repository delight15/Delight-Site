<?php
    session_start();
    include 'fruitkha_db.php';
    $error = "";
    $error1 = "";

    if(isset($_SESSION['user_id'])){
        $get = $_SESSION['user_id'];

        // echo $get;
        $select = "SELECT * FROM users WHERE user_id = '$get' ";
        $qry = mysqli_query($conn, $select);
        $fetch = mysqli_fetch_assoc($qry);

        // print_r($fetch);
    }


    if(isset($_GET['userid']) && isset($_POST['button'])){
        $get = $_GET['userid'];
        // echo $get;

        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $emails = trim($_POST['email']);
        $countries = trim($_POST['countries']);
        $phonenumber = trim($_POST['phone_number']);

        $select2 = "SELECT * from users WHERE email = '$emails' ";
        $qry2 = mysqli_query($conn, $select2);
        $fetch2 = mysqli_fetch_assoc($qry2);
        

        $select3 = "SELECT * FROM users WHERE phone ='$phonenumber'";
        $qry3 = mysqli_query($conn, $select3);
        $fetch3 = mysqli_fetch_assoc($qry3);

    

            if(mysqli_num_rows($qry2) > 0){
                $error = 'email already exists please use another email';
            }
            if(mysqli_num_rows($qry3) > 0){
                $error1 = 'phone number already exists please use another phone number';
            }

            if(empty($error) && empty($error1)){

                $update = "update users set firstname='$firstname', lastname='$lastname', email='$emails',region='$countries',phone='$phonenumber' WHERE user_id = '$get' ";
                $qry4 = mysqli_query($conn,$update);
                header("location:dashboard.php");
                exit();
            }
        



    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - E-Commerce</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        /* Container */
        .signup-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            max-width: 500px;
            width: 100%;
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Header */
        .signup-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2.5rem 2rem;
            text-align: center;
        }

        .signup-header h1 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .signup-header p {
            opacity: 0.95;
            font-size: 0.95rem;
        }

        /* Form */
        .signup-form {
            padding: 2rem;
        }

        /* Alerts */
        .alert {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert i {
            font-size: 1rem;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .alert-list {
            flex: 1;
        }

        .alert-list ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .alert-list li {
            margin: 0.3rem 0;
            font-size: 0.9rem;
        }

        /* Form Group */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.9rem;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 2px solid #ecf0f1;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: inherit;
            appearance: none;
            background-color: white;
            cursor: pointer;
            padding-right: 2.5rem;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23667eea' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1.25rem;
        }

        .form-group select option {
            padding: 0.5rem;
            background-color: white;
            color: #2c3e50;
        }

        .form-group select option:checked {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group input::placeholder {
            color: #bdc3c7;
        }

        /* Phone Number */
        .phone-group {
            display: flex;
            gap: 0.5rem;
        }

        .country-code {
            width: 80px;
            padding: 0.85rem 0.75rem;
            background-color: #f5f7fa;
            border: 2px solid #ecf0f1;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #2c3e50;
        }

        .phone-group input {
            flex: 1;
        }

        /* Password Container */
        .password-container {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #667eea;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .password-toggle:hover {
            color: #764ba2;
            transform: translateY(-50%) scale(1.1);
        }

        /* Button */
        .btn-signup {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .btn-signup:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-signup:active {
            transform: translateY(0);
        }

        /* Login Link */
        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #ecf0f1;
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .login-link a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        /* Success Message */
        .success-message {
            text-align: center;
            padding: 2rem;
        }

        .success-icon {
            font-size: 3rem;
            color: #2ecc71;
            margin-bottom: 1rem;
        }

        .success-message h2 {
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .success-message p {
            color: #7f8c8d;
            margin-bottom: 1.5rem;
        }

        .btn-success {
            padding: 0.75rem 2rem;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background: #764ba2;
        }

        /* Responsive */
        @media (max-width: 600px) {
            .signup-container {
                border-radius: 10px;
            }

            .signup-header {
                padding: 1.5rem 1.5rem;
            }

            .signup-header h1 {
                font-size: 1.5rem;
            }

            .signup-form {
                padding: 1.5rem;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .form-group input,
            .form-group select {
                padding: 0.75rem 0.85rem;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="signup-container">

            <div class="signup-header">
                <h1><i class="fa fa-user-plus"></i> Update Profile</h1>
                <p>Fill in the required details to update your profile!</p>
            </div>

            <form action="" method="POST" class="signup-form">

                <!-- Name Row -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="firstname"><i class="fa fa-user"></i> First Name</label>
                        <input type="text" id="firstname" name="firstname" placeholder="John" value="<?php echo $fetch['firstname'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="lastname"><i class="fa fa-user"></i> Last Name</label>
                        <input type="text" id="lastname" name="lastname" placeholder="Doe" value="<?php echo $fetch['lastname'] ?>" required>
                    </div>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email"><i class="fa fa-envelope"></i> Email Address</label>
                    <input type="email" id="email" name="email" placeholder="john@example.com" value="<?php echo $fetch['email'] ?>" required>
                    <p style="color: red"><?php echo $error; ?>
                </div>

                <!-- Region -->
                <div class="form-group">
                    <label for="countries"><i class="fa fa-globe"></i> Region</label>
                    <select id="countries" name="countries"  value=" <?php echo $fetch['region'] ?>" onchange="handlecountry()" required>
                        <option value="">Select region</option>
                        <option value="Nigeria" <?php echo (isset($_POST['countries']) && $_POST['countries'] === 'Nigeria') ? 'selected' : ''; ?>>Nigeria</option>
                        <option value="Ghana" <?php echo (isset($_POST['countries']) && $_POST['countries'] === 'Ghana') ? 'selected' : ''; ?>>Ghana</option>
                        <option value="Algeria" <?php echo (isset($_POST['countries']) && $_POST['countries'] === 'Algeria') ? 'selected' : ''; ?>>Algeria</option>
                    </select>
                </div>

                <!-- Phone Number -->
                <div class="form-group">
                    <label><i class="fa fa-phone"></i> Phone Number</label>
                    <div class="phone-group">
                        <div class="country-code" id="countryCode">+234</div>
                        <input type="text" placeholder="Enter phone number" name="phone_number" value="<?php echo $fetch['phone'] ?>" required>
                    </div>
                    <p style="color: red"> <?php echo $error1; ?></p>
                </div>

        

                <!-- Submit Button -->
                <button type="submit" name="button" class="btn-signup">
                    <i class="fa fa-user-plus"></i> Update Profile
                </button>

            </form>
    
    </div>

    <script>
        function handlecountry() {
            const country = document.getElementById('countries');
            const countryCode = document.getElementById('countryCode');

            const codes = {
                'Nigeria': '+234',
                'Ghana': '+233',
                'Algeria': '+213'
            };

            countryCode.textContent = codes[country.value] || '+';
        }

        function togglePasswordVisibility(inputId, toggleId) {
            const input = document.getElementById(inputId);
            const toggle = document.getElementById(toggleId);

            if (input.type === 'password') {
                input.type = 'text';
                toggle.classList.remove('fa-eye');
                toggle.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                toggle.classList.remove('fa-eye-slash');
                toggle.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
