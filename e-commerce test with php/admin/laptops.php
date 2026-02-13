<?php
    session_start();
       if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
    } else {
        header("Location: login.php");
        session_destroy();  
        // exit();
    }
    include 'product-logic.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Laptops - Premium Electronics</title>
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
                width: 250px;
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
            }

            #cart:hover {
                transform: scale(1.1);
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

            /* ===== HERO SECTION ===== */
            .background-image {
                width: 100%;
                min-height: 400px;
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
                overflow: hidden;
            }

            .background-image::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(135deg, rgba(0, 0, 0, 0.5), rgba(102, 126, 234, 0.3));
                z-index: 1;
            }

            .text {
                position: relative;
                z-index: 2;
                text-align: center;
                color: white;
                animation: fadeInUp 0.8s ease;
            }

            .background-image h1 {
                font-size: 3rem;
                margin-bottom: 1rem;
                font-weight: 800;
                text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
                line-height: 1.2;
            }

            .background-image span {
                font-size: 1.3rem;
                font-weight: 600;
                text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.5);
                display: block;
                margin-top: 1rem;
            }

            /* ===== CATEGORY HEADER ===== */
            .Categories {
                padding: 2rem;
                background-color: white;
                text-align: center;
                border-bottom: 2px solid #ecf0f1;
            }

            .Categories h2 {
                font-size: 2.5rem;
                color: #2c3e50;
                position: relative;
                display: inline-block;
                padding-bottom: 1rem;
            }

            .Categories h2::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 50%;
                transform: translateX(-50%);
                width: 100px;
                height: 4px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border-radius: 2px;
            }

            /* ===== PRODUCTS SECTION ===== */
            .products {
                padding: 3rem 2rem;
                background-color: #f5f7fa;
            }

            .uploaded-products {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 2rem;
                padding: 2rem 0;
                max-width: 1400px;
                margin: 0 auto;
            }

            .each-products {
                background: white;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
                transition: all 0.3s ease;
                position: relative;
                display: flex;
                flex-direction: column;
                height: 100%;
                min-height: 450px;
            }

            .each-products:hover {
                transform: translateY(-8px);
                box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
            }

            .product-image-container {
                position: relative;
                width: 100%;
                height: 250px;
                background: linear-gradient(135deg, #f5f7fa 0%, #ecf0f1 100%);
                overflow: hidden;
                display: flex;
                align-items: center;
                justify-content: center;
                border-bottom: 1px solid #ecf0f1;
            }

            .each-products img {
                width: 85%;
                height: 85%;
                object-fit: contain;
                padding: 0.5rem;
                transition: transform 0.3s ease, filter 0.3s ease;
                max-width: 100%;
                max-height: 100%;
            }

            .each-products:hover img {
                transform: scale(1.1);
                filter: brightness(0.95);
            }

            .product-badge {
                position: absolute;
                top: 10px;
                right: 10px;
                background-color: #e74c3c;
                color: white;
                padding: 0.4rem 0.8rem;
                border-radius: 8px;
                font-size: 0.8rem;
                font-weight: 700;
                z-index: 10;
            }

            .product-info {
                padding: 1.5rem;
                flex-grow: 1;
                display: flex;
                flex-direction: column;
            }

            .product-name {
                font-size: 1rem;
                font-weight: 700;
                color: #2c3e50;
                margin-bottom: 0.5rem;
                line-height: 1.4;
                min-height: 2.8rem;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .product-rating {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                margin-bottom: 0.75rem;
                font-size: 0.9rem;
            }

            .stars {
                color: #f39c12;
                font-size: 0.85rem;
            }

            .rating-count {
                color: #7f8c8d;
                font-size: 0.85rem;
            }

            .product-description {
                font-size: 0.85rem;
                color: #7f8c8d;
                margin-bottom: 1rem;
                line-height: 1.3;
                display: -webkit-box;
                -webkit-line-clamp: 1;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .product-price-section {
                margin-bottom: 0.75rem;
                margin-top: auto;
            }

            .price-container {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .price {
                font-size: 1.5rem;
                color: #667eea;
                font-weight: 800;
            }

            .original-price {
                font-size: 0.9rem;
                color: #bdc3c7;
                text-decoration: line-through;
            }

            .discount {
                font-size: 0.8rem;
                color: #e74c3c;
                font-weight: 700;
                background-color: #ffe6e6;
                padding: 0.2rem 0.6rem;
                border-radius: 4px;
            }

            .product-availability {
                font-size: 0.8rem;
                margin-bottom: 1rem;
                padding: 0.5rem 0;
            }

            .in-stock {
                color: #2ecc71;
                font-weight: 600;
            }

            .out-of-stock {
                color: #e74c3c;
                font-weight: 600;
            }

            .btns {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                border: none;
                padding: 0.85rem 1.5rem;
                border-radius: 8px;
                cursor: pointer;
                font-weight: 700;
                width: 100%;
                transition: all 0.3s ease;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.75rem;
                font-size: 0.95rem;
                margin-top: auto;
            }

            .btns:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            }

            .btns:active {
                transform: translateY(0);
            }

            /* ===== ANIMATIONS ===== */
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* ===== MOBILE RESPONSIVE ===== */
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
                    width: 100%;
                    order: 3;
                    flex-basis: 100%;
                    margin-top: 0.5rem;
                }

                .background-image h1 {
                    font-size: 2rem;
                }

                .background-image span {
                    font-size: 1rem;
                }

                .uploaded-products {
                    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                    gap: 1.5rem;
                }

                .each-products {
                    min-height: 400px;
                }

                .product-image-container {
                    height: 200px;
                }

                .Categories h2 {
                    font-size: 1.8rem;
                }
            }

            @media (max-width: 600px) {
                #navbar {
                    padding: 0.75rem 1rem;
                }

                #navbar ul {
                    display: none;
                }

                #search {
                    width: 100%;
                    order: 2;
                    flex-basis: 100%;
                }

                .background-image h1 {
                    font-size: 1.5rem;
                }

                .background-image span {
                    font-size: 0.9rem;
                }

                .products {
                    padding: 2rem 1rem;
                }

                .uploaded-products {
                    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                    gap: 1rem;
                }

                .each-products {
                    min-height: auto;
                }

                .product-image-container {
                    height: 150px;
                }

                .product-info {
                    padding: 1rem;
                }

                .product-name {
                    font-size: 0.9rem;
                    min-height: auto;
                }

                .price {
                    font-size: 1.2rem;
                }

                .Categories h2 {
                    font-size: 1.5rem;
                }
            }
        </style>
</head> 
<body>
    <!-- NAVBAR -->
    <nav id="navbar">
        <i id="bar" class="fa fa-bars" aria-hidden="true" onclick="opensidebar()"></i>
        <ul id="sidebar">
            <i class="fa fa-times" id="closebar" onclick="closesidebar()"></i>
            <li><a href="index.php">HOME</a></li>
            <li><a href="admin-logic.php">UPLOAD PRODUCT</a></li>
            <li><a href="dashboard.php">PROFILE</a></li>
            <li><a href="">CONTACT US</a></li>             
        </ul>
        <input type="text" placeholder="Search products..." id="search">
        <a href="#" class="logout-btn" title="Logout">
            <i class="fas fa-sign-out-alt"></i>
            Logout
        </a>
        <a href=""><i class="fa fa-shopping-cart" aria-hidden="true" id="cart"></i></a>
    </nav>
    
    <!-- HERO SECTION -->
    <div class="background-image" style="background-image: linear-gradient(135deg, rgba(0, 0, 0, 0.5), rgba(102, 126, 234, 0.3)), url('Images/1360-500.webp');">
        <div class="text">
            <h1>Premium Laptops</h1>
            <span>Get the best Laptops that suits your need</span>
        </div>
    </div>
    
    <!-- CATEGORY HEADER -->
    <div class="Categories">
        <h2><i class="fas fa-laptop"></i> LAPTOPS COLLECTION</h2>
    </div>

    <!-- PRODUCTS SECTION -->
    <div class="products">
        <div class="uploaded-products">
            <?php displaycategory();?>
        </div>
    </div>

    <script>
        function opensidebar() {
            document.getElementById('sidebar').classList.add('show');
        }

        function closesidebar() {
            document.getElementById('sidebar').classList.remove('show');
        }
    </script>
    <script src="owlcarousel/docs/assets/vendors/jquery.min.js"></script>
    <script src="owlcarousel/dist/owl.carousel.min.js"></script>
</body>
</html>


    

