<?php

    $error = "";
    $error2 = "";
    session_start();
    include 'fruitkha_db.php';
    if(isset($_GET['userid']) && isset($_POST['delete_account'])){
        $userid = $_GET['userid'];

        $select = "SELECT * FROM users WHERE user_id = '$userid' ";
        $qry = mysqli_query($conn, $select);
        $row = mysqli_fetch_assoc($qry);


        $password = $_POST['password'];
        if($password == $row['password']){
            $delete = "DELETE FROM users WHERE user_id = '$userid' ";
            $delete_qry = mysqli_query($conn, $delete);

            if($delete_qry){
                session_destroy();
                header("Location: login.php?message=Account deleted successfully");
                exit();
            } else {
                $error =   "Error deleting account. Please try again.";
            }
        } else {
            $error2 = "Incorrect password. Please try again.";
        }

    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Commerce</title>
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        .login-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            max-width: 450px;
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
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2.5rem 2rem;
            text-align: center;
        }

        .login-header h1 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            opacity: 0.95;
            font-size: 0.95rem;
        }

        /* Form */
        .login-form {
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
            margin-bottom: 1.5rem;
            padding: 0 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.9rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 2px solid #ecf0f1;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group input::placeholder {
            color: #bdc3c7;
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

        /* Remember Me */
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .remember-forgot input[type="checkbox"] {
            cursor: pointer;
            margin-right: 0.5rem;
        }

        .forgot-password {
            color: #667eea;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .forgot-password:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        /* Button */
        .btn-login {
            /* width: 100%; */
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
            margin: auto;
            margin-bottom: 20px;
            justify-content: center;
            gap: 0.75rem;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Signup Link */
        .signup-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #ecf0f1;
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        .signup-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .signup-link a:hover {
            color: #764ba2;
            text-decoration: underline;
        }
        strong{
            text-align: center;
            margin-bottom: 10px;
        }

        /* Responsive */
        @media (max-width: 600px) {
            .login-container {
                border-radius: 10px;
            }

            .login-header {
                padding: 1.5rem 1.5rem;
            }

            .login-header h1 {
                font-size: 1.5rem;
            }

            .login-form {
                padding: 1.5rem;
            }

            .form-group input {
                padding: 0.75rem 0.85rem;
                font-size: 16px;
            }

            .remember-forgot {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1><i class="fa fa-sign-in"></i> Account Deactivation</h1>
            <p>read the instructios carefully to delete your account</p>
        </div>
            <!-- Email -->
            <div class="form-group">
                
                <strong>Permanently delete your account?</strong>
                    <p>We’re sorry to see you go. Please take a moment to review what happens when you delete your account, as this action cannot be undone:</p>

                    <strong>Loss of Access:</strong> You will lose access to your profile, messages, and all saved preferences immediately.

                    <strong>Data Removal:</strong> Your photos, posts, and personal information will be permanently removed from our servers.

                    <strong>No Recovery:</strong> You will not be able to reactivate this account or retrieve any of your content in the future.</span>
            </div>
        <form class="login-form" method="POST" action="">
            <div class="form-group">
                <label for="password">Confirm your password to proceed:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>" required>
                <p style="color: red;"><?php echo $error2; ?></p>
            </div>

            <button class="btn-login" name="delete_account">Delete Account</button>
            <p style="color: red;"><?php echo $error; ?></p>
        </form>
    </div>


       


</body>
</html>

