<?php

    if(isset($_SESSION['productid'])){
        $get = $_SESSION['productid'];
        echo $get;
    }
    // print_r($fetch);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <title>Cart</title>

    <style>
        *{box-sizing: border-box;margin:0;padding:0}
        body{font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;background:#f5f7fa;color:#222;min-height:100vh;display:flex;flex-direction:column}

        .profile-header{background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);color:#fff;padding:1.25rem 1.5rem;text-align:center;box-shadow:0 6px 18px rgba(0,0,0,0.06);display:flex;align-items:center;justify-content:center;min-height:64px}
        .profile-header h1{font-size:1.9rem;margin:0;line-height:1}
        .profile-header .fa{margin-right:10px}

        .container{max-width:1100px;margin:18px auto;padding:0 16px}
        .cart-grid{display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start}

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
       
        /* Items list */
        .cart-items{background:#fff;border-radius:12px;padding:18px;box-shadow:0 6px 18px rgba(0,0,0,0.04)}
        .cart-item{display:flex;gap:14px;padding:14px 8px;border-bottom:1px solid #f0f0f0;align-items:center}
        .cart-item:last-child{border-bottom:none}
        .item-image{width:110px;height:110px;flex:0 0 110px;border-radius:8px;overflow:hidden;background:#fafafa;display:flex;align-items:center;justify-content:center}
        .item-image img{width:100%;height:100%;object-fit:contain}

        .item-body{flex:1}
        .item-title{font-size:1.05rem;margin-bottom:6px;color:#222}
        .item-meta{display:flex;gap:12px;align-items:center;color:#666;font-size:0.95rem}

        .price{font-weight:700;color:#1f2937}

        .controls{display:flex;align-items:center;gap:10px;margin-top:8px}
        .qty-btn{background:#667eea;color:#fff;border:none;padding:6px 10px;border-radius:6px;cursor:pointer}
        .qty-input{width:48px;text-align:center;border:1px solid #e2e8f0;padding:6px;border-radius:6px}
        .remove-btn{background:transparent;border:none;color:#ef4444;cursor:pointer;font-weight:600}

        /* Summary */
        .summary{background:#fff;border-radius:12px;padding:20px;box-shadow:0 6px 18px rgba(0,0,0,0.04)}
        .summary h3{margin:0 0 10px 0}
        .summary-row{display:flex;justify-content:space-between;padding:8px 0;color:#374151}
        .summary .checkout{display:block;margin-top:14px;width:100%;padding:12px;border-radius:10px;border:none;background:linear-gradient(90deg,#667eea,#764ba2);color:#fff;font-weight:700;cursor:pointer}
        .summary small{color:#6b7280}

        .shipping-options{display:flex;flex-direction:column;gap:8px;margin-top:8px}
        .shipping-options label{display:flex;align-items:center;gap:8px;padding:8px;border-radius:8px;border:1px solid #eef2ff}

        @media (max-width:880px){.cart-grid{grid-template-columns:1fr}.item-image{width:90px;height:90px}}

      

        /* Narrow phones: improve quantity layout and touch targets */
        @media (max-width:440px){
            .item-image{width:70px;height:70px}
            .cart-item{gap:10px;padding:10px}
            .item-title{font-size:0.98rem}
            .item-meta{flex-direction:column;align-items:flex-start;gap:8px}
            .controls{flex-direction:row;align-items:center;gap:8px}
            .controls > div{display:flex;gap:6px;align-items:center}
            .qty-btn{padding:6px 8px;font-size:14px}
            .qty-input{width:56px}
            .remove-btn{padding:6px 8px;font-size:0.95rem}
        }
        /* Extra-small phones: reduce header and container spacing to avoid top white space */
        @media (max-width:400px){
            .profile-header{padding:8px 10px;min-width:400px}
            .profile-header h1{font-size:1.0rem}
            /* .profile-header .fa{display:none} */

            .container{max-width:100%;margin:8px auto;padding:0 10px}
            .cart-grid{gap:10px}
            .cart-items{padding:10px}
            .summary{padding:12px}
            .cart-item{padding:8px 6px}
        }
           @media (max-width: 1100px) {
            #navbar {
                flex-wrap: wrap;
                min-width: 400px;
                
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
        }
        
    </style>
</head>
<body>
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
        <a href="?logout=true" class="logout-btn" title="Logout" name="logout">
            <i class="fa fa-sign-out"></i>
            Logout
        </a>
        <a id="cart" href="cart.html">
            <i class="fa fa-shopping-cart"></i>
            <sup id="cart-number"></sup>
        </a>
    </nav>
    
    <div class="profile-header">
        <h1> <i class="fa fa-shopping-cart"></i>Cart</h1>
        <!-- <p>Manage your account and personal information</p> -->
    </div>

    <div class="container">
        <div class="cart-grid">
            <section class="cart-items" aria-label="Cart items">
                <!-- cart item (example) -->
                <div class="cart-item" data-id="1" data-price="250">
                    <div class="item-image">
                        <img src="images/cam2-removebg-preview.png" alt="Product image">
                    </div>
                    <div class="item-body">
                        <div class="item-title">Samsung S24 — sleek display and great battery</div>
                        <div class="item-meta">
                            <div class="price">$<span class="unit-price">250</span></div>
                            <div class="controls">
                                <div>
                                    <button class="qty-btn" data-action="decrease" aria-label="Decrease quantity">-</button>
                                    <input class="qty-input" type="number" min="1" value="1" aria-label="Quantity">
                                    <button class="qty-btn" data-action="increase" aria-label="Increase quantity">+</button>
                                </div>
                                <button class="remove-btn" data-action="remove">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="cart-item" data-id="1" data-price="250">
                    <div class="item-image">
                        <img src="images/cam2-removebg-preview.png" alt="Product image">
                    </div>
                    <div class="item-body">
                        <div class="item-title">Samsung S24 — sleek display and great battery</div>
                        <div class="item-meta">
                            <div class="price">$<span class="unit-price">250</span></div>
                            <div class="controls">
                                <div>
                                    <button class="qty-btn" data-action="decrease" aria-label="Decrease quantity">-</button>
                                    <input class="qty-input" type="number" min="1" value="1" aria-label="Quantity">
                                    <button class="qty-btn" data-action="increase" aria-label="Increase quantity">+</button>
                                </div>
                                <button class="remove-btn" data-action="remove">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cart-item" data-id="1" data-price="250">
                    <div class="item-image">
                        <img src="images/cam2-removebg-preview.png" alt="Product image">
                    </div>
                    <div class="item-body">
                        <div class="item-title">Samsung S24 — sleek display and great battery</div>
                        <div class="item-meta">
                            <div class="price">$<span class="unit-price">250</span></div>
                            <div class="controls">
                                <div>
                                    <button class="qty-btn" data-action="decrease" aria-label="Decrease quantity">-</button>
                                    <input class="qty-input" type="number" min="1" value="1" aria-label="Quantity">
                                    <button class="qty-btn" data-action="increase" aria-label="Increase quantity">+</button>
                                </div>
                                <button class="remove-btn" data-action="remove">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add more .cart-item blocks as needed -->
            </section>

            <aside class="summary" aria-label="Order summary">
                <h3>Order Summary</h3>
                <div class="summary-row"><span>Subtotal</span><span>$<span id="subtotal">0</span></span></div>
                <div class="shipping-options">
                    <label><input type="radio" name="shipping" value="0" checked data-cost="0"> Pickup (Free)</label>
                    <label><input type="radio" name="shipping" value="5" data-cost="5"> Home delivery ($5)</label>
                </div>
                <div class="summary-row"><small>Shipping</small><span>$<span id="shipping">0</span></span></div>
                <div class="summary-row" style="font-size:1.15rem;font-weight:700"><span>Total</span><span>$<span id="total">0</span></span></div>
                <button class="checkout" id="checkoutBtn">Checkout</button>
                <small id="emptyNote" style="display:none;color:#6b7280">Your cart is empty.</small>
            </aside>
        </div>
    </div>
    <script src="script.js" defer></script>
    <script>
        // ============================================
        // CART LOGIC - Client-side quantity, remove, and totals
        // (No backend needed - all logic runs in the browser)
        // ============================================

        // IIFE (Immediately Invoked Function Expression)
        // This wraps everything in a private scope so variables don't pollute global scope
        (function(){
            
            // STEP 1: Get references to HTML elements we need to work with
            // These are pointers to elements in the DOM (Document Object Model)
            const cartItems = document.querySelectorAll('.cart-item')
            const subtotalEl = document.getElementById('subtotal')
            const shippingEl = document.getElementById('shipping')
            const totalEl = document.getElementById('total')
            const checkoutBtn = document.getElementById('checkoutBtn')
            const emptyNote = document.getElementById('emptyNote')

            // ============================================
            // HELPER FUNCTION: Format numbers to 2 decimal places
            // ============================================
            // Takes any number and formats it like money (e.g., 250.00)
            function format(n){
                return parseFloat(n).toFixed(2)
            }

            // ============================================
            // MAIN FUNCTION: Update the order summary totals
            // ============================================
            function updateSummary(){
                
                // STEP 1: Calculate subtotal
                // Loop through each cart item and multiply price × quantity
                let subtotal = 0
                document.querySelectorAll('.cart-item').forEach(item=>{
                    // Get the price from the item's data attribute
                    const price = parseFloat(item.dataset.price || 0)
                    // Get the quantity from the input field (default to 1 if empty)
                    const qty = Math.max(1, parseInt(item.querySelector('.qty-input').value || 1))
                    // Add this item's total to the subtotal
                    subtotal += price * qty
                })
                // Display the formatted subtotal on the page
                subtotalEl.textContent = format(subtotal)
                
                // STEP 2: Get shipping cost
                // Find which shipping option is selected (the checked radio button)
                const shipping = parseFloat(
                    document.querySelector('input[name="shipping"]:checked').dataset.cost || 0
                )
                // Display the formatted shipping cost
                shippingEl.textContent = format(shipping)
                
                // STEP 3: Calculate and display total
                // Total = subtotal + shipping
                totalEl.textContent = format(subtotal + shipping)
                
                // STEP 4: Show/hide empty cart message and disable checkout if needed
                // Check if there are any items in the cart
                const hasItems = document.querySelectorAll('.cart-item').length > 0
                // Disable the checkout button if cart is empty
                checkoutBtn.disabled = !hasItems
                // Show "empty cart" message only if there are no items
                emptyNote.style.display = hasItems ? 'none' : 'block'
            }

            // ============================================
            // Call updateSummary once when page loads
            // ============================================
            updateSummary()

            // ============================================
            // LISTEN FOR BUTTON CLICKS (increase, decrease, remove)
            // ============================================
            document.addEventListener('click', function(e){
                // Find the button that was clicked
                // .closest() searches up the DOM tree for an element with [data-action]
                const btn = e.target.closest('[data-action]')
                // If no button with data-action was clicked, exit
                if(!btn) return
                
                // Get what action the button should perform
                const action = btn.dataset.action
                // Find the cart item that contains this button
                const item = btn.closest('.cart-item')
                
                // INCREASE quantity
                if(action === 'increase'){
                    const input = item.querySelector('.qty-input')
                    // Add 1 to current value, but don't go below 1
                    input.value = Math.max(1, parseInt(input.value || 0) + 1)
                    updateSummary()
                } 
                // DECREASE quantity
                else if(action === 'decrease'){
                    const input = item.querySelector('.qty-input')
                    // Subtract 1 from current value, but don't go below 1
                    input.value = Math.max(1, parseInt(input.value || 1) - 1)
                    updateSummary()
                } 
                // REMOVE item from cart
                else if(action === 'remove'){
                    // Delete the entire item from the DOM
                    item.remove()
                    // Recalculate totals
                    updateSummary()
                }
            })

            // ============================================
            // LISTEN FOR MANUAL QUANTITY CHANGES
            // ============================================
            // When user types directly into a quantity input
            document.addEventListener('input', function(e){
                // Check if the input field being changed is a quantity input
                if(e.target.classList && e.target.classList.contains('qty-input')){
                    // Make sure value is never empty or less than 1
                    if(e.target.value === '' || parseInt(e.target.value) < 1) {
                        e.target.value = 1
                    }
                    // Update totals after each keystroke
                    updateSummary()
                }
            })

            // ============================================
            // LISTEN FOR SHIPPING METHOD CHANGES
            // ============================================
            // When user clicks on "Pickup" or "Home delivery" radio buttons
            document.querySelectorAll('input[name="shipping"]').forEach(radio=>{
                radio.addEventListener('change', updateSummary)
            })

            // ============================================
            // MUTATION OBSERVER - Watch for external changes
            // ============================================
            // In case cart items are added/removed by external code (like from another PHP page)
            // This automatically updates totals when the DOM structure changes
            const observer = new MutationObserver(updateSummary)
            // Watch the .cart-items container for added/removed child items
            observer.observe(document.querySelector('.cart-items'), {
                childList: true,      // Watch for added/removed children
                subtree: false        // Only watch direct children, not nested
            })
        })()

        // function opensidebar(){
        //     document.getElementById('bar').classList.add('show')
        // }
    </script>
    
    
</body>
</html>