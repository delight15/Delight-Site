<?php
include 'fruitkha_db.php';

$errors = [];

if(isset($_POST['login'])){
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validation
    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }
    if(empty($password)) {
        $errors[] = "Password is required";
    }

    if(count($errors) === 0) {
        $select = "SELECT * FROM users WHERE email='$email' AND password='$password'";
        $result = mysqli_query($conn, $select);
        $num_rows = mysqli_num_rows($result);
        
        if($num_rows > 0){
            $array = mysqli_fetch_assoc($result);
            session_start();
            $_SESSION['user_id'] = $array['user_id'];
              $role = $_SESSION['role'] = $array['role'];
            if($role === 'admin'){
                header("location: index.php");
            }else{
                header("location: ../index.php");
            }
        } else {
            $errors[] = "Invalid email or password";
        }
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
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> -->
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
            <h1><i class="fa fa-sign-in"></i> Login</h1>
            <p>Welcome back! Please login to your account</p>
            <?php
            if(isset($_GET['message'])) {
                echo '<div class="alert alert-success">
                    <i class="fa fa-check-circle"></i>
                    <div class="alert-list">
                        ' . htmlspecialchars($_GET['message']) . '
                    </div>
                </div>';
            
            }
            ?>
        </div>

        <form action="" method="POST" class="login-form">
            <!-- Errors -->
            <?php if(count($errors) > 0): ?>
                <div class="alert alert-error">
                    <i class="fa fa-exclamation-circle"></i>
                    <div class="alert-list">
                        <ul>
                            <?php foreach($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Email -->
            <div class="form-group">
                <label for="email"><i class="fa fa-envelope"></i> Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password"><i class="fa fa-lock"></i> Password</label>
                <div class="password-container">
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    <i class="fa fa-eye password-toggle" id="togglePassword" onclick="togglePasswordVisibility('password', 'togglePassword')"></i>
                </div>
            </div>

            <!-- Remember & Forgot -->
            <div class="remember-forgot">
                <label>
                    <input type="checkbox" name="remember" value="yes">
                    Remember me
                </label>
                <a href="#" class="forgot-password"><i class="fa fa-question-circle"></i> Forgot password?</a>
            </div>

            <!-- Submit Button -->
            <button type="submit" name="login" class="btn-login">
                <i class="fa fa-sign-in"></i> Login
            </button>

            <!-- Signup Link -->
            <div class="signup-link">
                Don't have an account? <a href="signup.php">Create one here</a>
            </div>
        </form>
    </div>

    <script>
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

