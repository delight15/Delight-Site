<?php
    session_start();
    include 'fruitkha_db.php';

    $message = '';
    $message_type = '';

    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
    } else {
        header("Location: login.php");
        session_destroy();  
        // exit();
    }

    if(isset($_POST['upload'])){
        $name = trim($_POST['name']);
        $price = trim($_POST['price']);
        $categories = trim($_POST['categories']);
        $pics = $_FILES['pics'];
        $filename = $pics['name'];
        $tmp_name = $pics['tmp_name'];
        $file_error = $pics['error'];
        $file_size = $pics['size'];

        // Validation
        $errors = [];

        if(empty($name)) {
            $errors[] = "Product name is required";
        }
        if(empty($price) || !is_numeric($price) || $price <= 0) {
            $errors[] = "Valid price is required";
        }
        if(empty($categories)) {
            $errors[] = "Category is required";
        }
        if($file_error !== 0) {
            $errors[] = "File upload error";
        }
        if($file_size > 5000000) { // 5MB limit
            $errors[] = "File size must be less than 5MB";
        }

        $pathinfo = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $allowed_formats = ["jpg", "jpeg", "webp", "jfif", "avif", "png"];

        if(!in_array($pathinfo, $allowed_formats)) {
            $errors[] = "File format not supported. Allowed: " . implode(", ", $allowed_formats);
        }

        if(count($errors) === 0) {
            $new_filename = time() . '.' . $pathinfo;
            $insert = "INSERT INTO products (p_name, price, category, picture) VALUES ('$name', '$price', '$categories', '$new_filename')";
            $qry = mysqli_query($conn, $insert);
            

            if($qry) {
                if(move_uploaded_file($tmp_name, "uploads/$new_filename")) {
                    $message = "✓ Product uploaded successfully!";
                    $message_type = "success";
                } else {
                    $message = "✗ Database saved but file upload failed";
                    $message_type = "error";
                }
            } else {
                $message = "✗ Database error: " . mysqli_error($conn);
                $message_type = "error";
            }
        } else {
            $message = implode("<br>", $errors);
            $message_type = "error";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Product - Admin</title>
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
            padding: 2rem 1rem;
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
            margin: -2rem -1rem 2rem -1rem;
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
            width: 250px;
            background-color: rgba(255, 255, 255, 0.95);
        }

        #cart {
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }

        #bar {
            font-size: 1.5rem;
            color: white;
            display: none;
            cursor: pointer;
        }

        #closebar {
            display: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }

        #sidebar {
            display: flex;
        }

        .logout-btn {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            margin-bottom: 5px;
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

        /* ===== MAIN CONTAINER ===== */
        .container {
            max-width: 600px;
            margin: 2rem auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        /* ===== HEADER ===== */
        .upload-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .upload-header h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .upload-header p {
            opacity: 0.95;
            font-size: 0.95rem;
        }

        /* ===== FORM ===== */
        .upload-form {
            padding: 2rem;
        }

        /* Message/Alert */
        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert.success {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert.error {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .alert i {
            font-size: 1.2rem;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.95rem;
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

        /* File Upload */
        .file-upload-wrapper {
            position: relative;
            overflow: hidden;
        }

        .file-upload-label {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 2rem;
            border: 2px dashed #667eea;
            border-radius: 8px;
            background-color: #f5f7fa;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            color: #667eea;
            font-weight: 600;
        }

        .file-upload-label:hover {
            background-color: #ede9ff;
            border-color: #764ba2;
            color: #764ba2;
        }

        .file-upload-label i {
            font-size: 2rem;
            margin-right: 0.5rem;
        }

        .form-group input[type="file"] {
            display: none;
        }

        .file-name {
            margin-top: 0.75rem;
            padding: 0.75rem;
            background-color: #f5f7fa;
            border-radius: 6px;
            color: #2c3e50;
            font-size: 0.9rem;
            text-align: center;
        }

        /* Helper Text */
        .helper-text {
            font-size: 0.8rem;
            color: #7f8c8d;
            margin-top: 0.3rem;
        }

        /* Button */
        .btn-upload {
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

        .btn-upload:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-upload:active {
            transform: translateY(0);
        }

        /* Image Preview */
        .image-preview {
            width: 100%;
            height: 200px;
            background-color: #f5f7fa;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .image-preview img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .image-placeholder {
            color: #bdc3c7;
            font-size: 3rem;
        }

        /* Category Suggestions */
        .category-list {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-top: 0.5rem;
        }

        .category-tag {
            padding: 0.4rem 0.8rem;
            background-color: #667eea;
            color: white;
            border-radius: 20px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .category-tag:hover {
            background-color: #764ba2;
            transform: scale(1.05);
        }

        /* Responsive */
        @media (max-width: 1100px) {
            #navbar {
                flex-wrap: wrap;
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

            #closebar {
                display: block;
                align-self: flex-end;
            }

            #bar {
                display: block;
            }

            #search {
                width: 100%;
                order: 3;
                flex-basis: 100%;
            }

            .container {
                max-width: 95%;
            }
        }

        @media (max-width: 600px) {
            #navbar {
                padding: 0.75rem 1rem;
            }

            .upload-header {
                padding: 1.5rem;
            }

            .upload-header h1 {
                font-size: 1.5rem;
            }

            .upload-form {
                padding: 1.5rem;
            }

            .file-upload-label {
                padding: 1.5rem;
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
            <i class="fa fa-sign-out"></i>
            Logout
        </a>
        <i class="fa fa-shopping-cart" id="cart"></i>
    </nav>

    <!-- UPLOAD CONTAINER -->
    <div class="container">
        <div class="upload-header">
            <h1><i class="fa fa-cloud-upload-alt"></i> Upload Product</h1>
            <p>Add a new product to your store</p>
        </div>

        <form action="" method="POST" enctype="multipart/form-data" class="upload-form">
            <!-- Alert Messages -->
            <?php if($message): ?>
                <div class="alert <?php echo $message_type; ?>">
                    <i class="fa fa-<?php echo ($message_type === 'success') ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                    <span><?php echo $message; ?></span>
                </div>
            <?php endif; ?>

            <!-- Image Preview -->
            <div class="image-preview" id="imagePreview">
                <i class="fa fa-image image-placeholder"></i>
            </div>

            <!-- Product Name -->
            <div class="form-group">
                <label for="name"><i class="fa fa-box"></i> Product Name</label>
                <input type="text" id="name" name="name" placeholder="Enter product name" required>
                <div class="helper-text">e.g., Laptop Pro 15, Wireless Headphones</div>
            </div>

            <!-- Product Price -->
            <div class="form-group">
                <label for="price"><i class="fa fa-dollar-sign"></i> Price</label>
                <input type="number" id="price" name="price" placeholder="Enter price" step="0.01" min="0" required>
                <div class="helper-text">e.g., 99.99</div>
            </div>

            <!-- Category -->
            <div class="form-group">
                <label for="categories"><i class="fa fa-tag"></i> Category</label>
                <input type="text" id="categories" name="categories" placeholder="select category" required>
                <div class="category-list">
                    <span class="category-tag" onclick="setCategory('Laptops')">Laptops</span>
                    <span class="category-tag" onclick="setCategory('Phones')">Phones</span>
                    <span class="category-tag" onclick="setCategory('Tablets')">Tablets</span>
                    <span class="category-tag" onclick="setCategory('Accessories')">Accessories</span>
                    <span class="category-tag" onclick="setCategory('Smart Watches')">Smart Watches</span>
                </div>
            </div>

            <!-- File Upload -->
            <div class="form-group file-upload-wrapper">
                <label for="pics" class="file-upload-label">
                    <div>
                        <i class="fa fa-upload"></i>
                        <span>Click or drag to upload image</span>
                    </div>
                </label>
                <input type="file" id="pics" name="pics" accept="image/*" required onchange="previewImage(event)">
                <div id="fileName" class="file-name" style="display:none;"></div>
                <div class="helper-text">Supported: JPG, PNG, WebP, AVIF, JFIF (Max 5MB)</div>
            </div>

            <!-- Submit Button -->
            <button type="submit" name="upload" class="btn-upload">
                <i class="fa fa-cloud-upload"></i> Upload Product
            </button>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('imagePreview');
            const fileNameDiv = document.getElementById('fileName');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                };
                reader.readAsDataURL(file);
                fileNameDiv.textContent = '✓ ' + file.name;
                fileNameDiv.style.display = 'block';
            }
        }

        function setCategory(category) {
            document.getElementById('categories').value = category;
        }

        function opensidebar() {
            document.getElementById('sidebar').classList.add('show');
        }

        function closesidebar() {
            document.getElementById('sidebar').classList.remove('show');
        }

        // Drag and drop
        const fileInput = document.getElementById('pics');
        const fileLabel = document.querySelector('.file-upload-label');

        fileLabel.addEventListener('dragover', (e) => {
            e.preventDefault();
            fileLabel.style.backgroundColor = '#ede9ff';
            fileLabel.style.borderColor = '#764ba2';
        });

        fileLabel.addEventListener('dragleave', () => {
            fileLabel.style.backgroundColor = '#f5f7fa';
            fileLabel.style.borderColor = '#667eea';
        });

        fileLabel.addEventListener('drop', (e) => {
            e.preventDefault();
            fileInput.files = e.dataTransfer.files;
            previewImage({ target: { files: e.dataTransfer.files } });
            fileLabel.style.backgroundColor = '#f5f7fa';
            fileLabel.style.borderColor = '#667eea';
        });
    </script>
</body>
</html>

