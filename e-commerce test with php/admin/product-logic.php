<?php    
    // session_start();


    function displayproducts(){


        include 'fruitkha_db.php';

        
        $select = "SELECT * FROM products ORDER BY id DESC";
        
        $qry = mysqli_query($conn, $select);
        
        // $array = mysqli_fetch_assoc($qry);
        
        $num_rows = mysqli_num_rows($qry);
        
        
        while($num_rows--){
            $row = mysqli_fetch_assoc($qry);
            // print_r($row)
            
           ?>

               <div class="each-products">
                   <div class="product-image-container">
                       <img src="uploads/<?php echo $row['picture'] ?>" alt="<?php echo $row['p_name'] ?>" name="<?php echo $row['picture']; ?>">
                    </div>
                    <div class="product-info">
                        <div class="product-name" name="<?php echo htmlspecialchars($row['p_name']) ?>"><?php echo htmlspecialchars($row['p_name']) ?></div>
                        <div class="product-rating">
                            <span class="stars">★★★★★</span>
                            <span class="rating-count">(0 reviews)</span>
                        </div>
                        <div class="product-availability">                        </div>
                        <div class="product-price-section">
                            <div class="price-container">
                                <span class="price">$<?php echo htmlspecialchars($row['price']) ?></span>
                            </div>
                        </div>
                        
                    <button class="btns" data-id = "<?php echo $row['id']; ?>">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Add To Cart
                    </button>
                </div>
            </div>
     

            

               <?php 

                
            }

    }

    function categories(){        
        
        
        include 'fruitkha_db.php';
        
        $select  = "SELECT * FROM categories";
        
        $qry = mysqli_query($conn,$select);
        
        
        while($array = mysqli_fetch_assoc($qry)){

            
        
                ?>
                
                <a href="categories.php ?category_name=<?php echo $array['category_name'] ;?>" class="category-box">
                    <div>
                        <img src='images/<?php echo $array['picture'];?>' alt="Phones">
                        <span><?php echo $array['category_name']; ?></span>
                    </div>
                </a>
                <?php
                
                }
                
                }
                
  function categories_section(){


                 include 'fruitkha_db.php';

              if(isset($_GET['category_name'])){
                      $category = $_GET['category_name'];
                    // echo $category;        
       
                        
                        $select = "SELECT * FROM products WHERE category = '$category' ";
                        $qry = mysqli_query($conn, $select);
                        while($array = mysqli_fetch_assoc($qry)){
                            // print_r($array);   
                        ?>


                        <div class="each-products">                
                            <div class="product-image-container">
                                <img src="uploads/<?php echo $array['picture'] ?>" alt="<?php echo $array['p_name'] ?>">
                            </div>
                            <div class="product-info">
                                <div class="product-name"><?php echo $array['p_name'] ?></div>
                                <div class="product-rating">
                                    <span class="stars">★★★★★</span>
                                    <span class="rating-count">(0 reviews)</span>
                                </div>
                                <div class="product-availability">
                                    <span class="in-stock">✓ In Stock</span>
                                </div>
                                <div class="product-price-section">
                                    <div class="price-container">
                                        <span class="price">$<?php echo $array['price'] ?></span>
                                    </div>
                                </div>
                                <button type="button" class="btns add-to-cart" data-id="<?= htmlspecialchars($array['id']) ?>">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> Add To Cart
                                </button>
                            </div>
                        </div>
                        <?php
        
        
        
        }
        
    
}
}



?>

     


