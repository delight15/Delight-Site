// alert('script.js');

function cart_message(){
        let cart = document.getElementById('addtocart');
        const icon = document.getElementById('carts')
        cart.style.left = "50px";

        setTimeout(function(){
            cart.style.left = "-1000px";
         }, 4000)
         
       
}   


// let cartitems = [];
// function addtocart(products){


//     cartitems.push(products)

//     console.log(cartitems);

//     localStorage.setItem("products", JSON.stringify(cartitems));

//     document.getElementById('cart-number').innerHTML = cartitems.length


// }

const navbar = document.getElementById("sidebar")
                        
    function opensidebar(){
        navbar.classList.add("show")
    };
                            
    function closesidebar(){
        navbar.classList.remove("show")
    };




    //   var owl = $('.background-image');
    //     owl.owlCarousel({
    //     items:2,
    //     loop:true,
    //     margin:10,
    //     autoplay:true,
    //     autoplayTimeout:2000,
    //     autoplayHoverPause:false
    // });
    // $('.play').on('click',function(){
    //     owl.trigger('play.owl.autoplay',[1000])
    // })
    // $('.stop').on('click',function(){
    //     owl.trigger('stop.owl.autoplay')
    // })

function checkmark(){
    const icon = document.getElementById('carts')


        if (icon) {
            if (icon.classList.contains('fa-cart-plus')) {
                icon.classList.replace('fa-cart-plus', 'fa-check');
            }
            } else if (icon.classList.contains('fa-check')) {
                    icon.classList.replace('fa-check', 'fa-cart-plus');
                } else {
                        icon.classList.add('fa', 'fa-check');
                    }
}

// Put this at the bottom of script.js (or inside DOMContentLoaded)
// script.js

// Notification element
// const notification = document.getElementById('addtocart');
// const cartBadge     = document.getElementById('cart-number');

// // Show notification
// function showNotification(message = 'Added to cart!') {
//     notification.textContent = message;
//     notification.classList.add('show');
//     setTimeout(() => {
//         notification.classList.remove('show');
//     }, 3000);
// }

// // Update cart badge
// function updateCartCount(count) {
//     cartBadge.textContent = count;
//     cartBadge.style.display = count > 0 ? 'flex' : 'none';
// }

// // Handle all add-to-cart clicks
// document.addEventListener('click', async function(e) {
//     const btn = e.target.closest('.add-to-cart');
//     if (!btn) return;

//     e.preventDefault();

//     const productId = btn.dataset.id;
//     if (!productId) {
//         console.warn('Missing data-id on button');
//         return;
//     }

//     // Optional: disable button temporarily
//     btn.disabled = true;
//     const originalText = btn.innerHTML;
//     btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Adding...';

//     try {
//         const response = await fetch('index.php', {   // or 'add-to-cart.php'
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json'
//             },
//             body: JSON.stringify({
//                 action: 'add_to_cart',
//                 product_id: productId,
//                 quantity: 1   // you can make this dynamic later
//             })
//         });

//         // Read response as text first so we can detect non-JSON (HTML error pages)
//         const text = await response.text();
//         let data;
//         try {
//             data = JSON.parse(text);
//         } catch (parseErr) {
//             console.error('Add to cart: server returned non-JSON response:', text);
//             showNotification('Server error — check console');
//             // restore button state
//             btn.disabled = false;
//             btn.innerHTML = originalText;
//             return;
//         }

//         if (!response.ok) {
//             console.error('Add to cart failed:', response.status, data);
//             showNotification(data.error || 'Server error');
//             // restore button state
//             btn.disabled = false;
//             btn.innerHTML = originalText;
//             return;
//         }

//         if (data.success) {
//             const id = data.product_id ?? 'N/A';
//             showNotification(`${data.message || 'Added!'} (ID: ${id})`);
//             console.log('Add to cart successful, product_id:', id);
//             updateCartCount(data.cart_count || 0);

//             // Show a visible small badge with the last added ID
//             const lastAdded = document.getElementById('last-added');
//             const lastAddedId = document.getElementById('last-added-id');
//             if (lastAdded && lastAddedId) {
//                 lastAddedId.textContent = id;
//                 lastAdded.style.display = 'block';
//                 // Hide after 5s
//                 setTimeout(() => { lastAdded.style.display = 'none'; }, 5000);
//             }

//             // Optional: visual feedback on button
//             const icon = btn.querySelector('i');
//             if (icon) {
//                 icon.classList.replace('fa-shopping-cart', 'fa-check');
//                 setTimeout(() => icon.classList.replace('fa-check', 'fa-shopping-cart'), 2000);
//             }
//         } else {
//             showNotification(data.error || 'Something went wrong');
//         }

//     } catch (err) {
//         console.error('Add to cart failed:', err);
//         showNotification('Error — please try again');
//     } finally {
//         btn.disabled = false;
//         btn.innerHTML = originalText;
//     }
// });

// // Optional: load initial cart count when page loads
// document.addEventListener('DOMContentLoaded', () => {
//     // You can add an extra endpoint later to get current count
//     // For now we can leave it or fake it from session if you output it in PHP
// });


document.addEventListener("click", function (e){
    if(!e.target.classList.contains("btns")) return;

    const productid = e.target.dataset.id;
    console.log("clicked ID:", productid);


    fetch("fetchproduct.php",{
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            product_id:productid
        })
    })
    .then(res => res.json())
    .then(data =>{
        document.getElementById("selectedproduct").innerHTML = "Product ID from php:" +data.product_id;
    });
})





cartItems = [];
function passid(id){

    cartItems.push(id)
    console.log(cartItems);

}




            



