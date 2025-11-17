<?php
require_once 'config.php';

// Define all products
$products = [
    ['name' => 'VANILLA LATTE', 'price' => 89.90, 'image' => 'popular-coffee-1.png', 'description' => 'Smooth vanilla blend with espresso'],
    ['name' => 'CLASSIC COFFEE', 'price' => 69.90, 'image' => 'popular-coffee-2.png', 'description' => 'Traditional black coffee perfection'],
    ['name' => 'MOCHA COFFEE', 'price' => 109.90, 'image' => 'popular-coffee-3.png', 'description' => 'Rich chocolate coffee delight'],
    ['name' => 'ICED COFFEE MOCHA', 'price' => 49.90, 'image' => 'products-coffee-1.png', 'description' => 'Refreshing iced mocha blend'],
    ['name' => 'COFFEE WITH CREAM', 'price' => 59.90, 'image' => 'products-coffee-2.png', 'description' => 'Creamy smooth coffee experience'],
    ['name' => 'CAPPUCCINO COFFEE', 'price' => 69.90, 'image' => 'products-coffee-3.png', 'description' => 'Italian style cappuccino'],
    ['name' => 'COFFEE WITH MILK', 'price' => 79.90, 'image' => 'products-coffee-4.png', 'description' => 'Perfect milk coffee balance'],
    ['name' => 'CLASSIC ICED COFFEE', 'price' => 89.90, 'image' => 'products-coffee-5.png', 'description' => 'Cold brew perfection'],
    ['name' => 'ICED COFFEE FRAPPE', 'price' => 99.90, 'image' => 'products-coffee-6.png', 'description' => 'Blended iced coffee treat'],
    ['name' => 'CARAMEL MACCHIATO', 'price' => 95.90, 'image' => 'popular-coffee-1.png', 'description' => 'Sweet caramel espresso layers'],
    ['name' => 'ESPRESSO SHOT', 'price' => 45.90, 'image' => 'popular-coffee-2.png', 'description' => 'Pure concentrated coffee'],
    ['name' => 'HAZELNUT LATTE', 'price' => 92.90, 'image' => 'popular-coffee-3.png', 'description' => 'Nutty aromatic latte blend']
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/order.css">
    <title>Order - STARCOFFEE</title>
    <style>
        .order-container {
            max-width: 1400px;
            margin: 120px auto 50px;
            padding: 20px;
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .page-header h1 {
            color: var(--white-color);
            font-size: 3rem;
            margin-bottom: 10px;
            font-family: var(--second-font);
        }
        
        .page-header p {
            color: var(--white-color);
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }
        
        .product-card {
            background: var(--dark-color);
            border-radius: 20px;
            padding: 25px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
        }
        
        .product-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--first-color), var(--first-color-alt));
        }
        
        .product-image-wrapper {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
            height: 180px;
        }
        
        .product-shape {
            width: 140px;
            height: 140px;
            background-color: var(--first-color);
            border-radius: 50%;
            clip-path: inset(50% 0 0 0);
            position: absolute;
        }
        
        .product-coffee-img {
            width: 110px;
            position: relative;
            z-index: 2;
            filter: drop-shadow(0 8px 16px rgba(0,0,0,0.3));
            transition: transform 0.3s ease;
        }
        
        .product-card:hover .product-coffee-img {
            transform: scale(1.1) rotate(5deg);
        }
        
        .product-ice {
            position: absolute;
            width: 25px;
            opacity: 0.7;
            animation: float 3s ease-in-out infinite;
        }
        
        .product-ice-1 {
            left: 20px;
            bottom: 20px;
            animation-delay: 0s;
        }
        
        .product-ice-2 {
            right: 20px;
            top: 40px;
            rotate: 60deg;
            animation-delay: 1.5s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .product-info {
            text-align: center;
        }
        
        .product-name {
            color: var(--white-color);
            font-size: 1.3rem;
            font-weight: var(--font-semi-bold);
            margin-bottom: 8px;
            font-family: var(--second-font);
        }
        
        .product-description {
            color: var(--text-color);
            font-size: 0.9rem;
            margin-bottom: 15px;
            line-height: 1.4;
        }
        
        .product-price {
            color: var(--first-color);
            font-size: 1.5rem;
            font-weight: var(--font-semi-bold);
            margin-bottom: 20px;
            display: block;
        }
        
        .quantity-control {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 15px;
            gap: 15px;
        }
        
        .quantity-btn {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--first-color);
            color: var(--white-color);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }
        
        .quantity-btn:hover {
            background: var(--first-color-alt);
            transform: scale(1.1);
        }
        
        .quantity-input {
            width: 60px;
            text-align: center;
            background: rgba(255,255,255,0.1);
            border: 2px solid var(--first-color);
            border-radius: 8px;
            padding: 8px;
            color: var(--white-color);
            font-size: 1.1rem;
            font-weight: var(--font-semi-bold);
        }
        
        .add-to-cart-btn {
            width: 100%;
            padding: 12px;
            background: var(--first-color);
            color: var(--white-color);
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: var(--font-semi-bold);
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .add-to-cart-btn:hover {
            background: var(--first-color-alt);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(26, 188, 156, 0.3);
        }
        
        .add-to-cart-btn:active {
            transform: translateY(0);
        }
        
        /* Cart Modal Styles */
        .cart-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .cart-modal.active {
            display: flex;
        }
        
        .cart-modal-content {
            background: var(--dark-color);
            border-radius: 20px;
            max-width: 800px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            animation: slideUp 0.3s ease;
        }
        
        @keyframes slideUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        .cart-modal-header {
            background: linear-gradient(135deg, var(--first-color), var(--first-color-alt));
            padding: 25px;
            border-radius: 20px 20px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .cart-modal-header h2 {
            color: var(--white-color);
            font-size: 1.8rem;
            font-family: var(--second-font);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .cart-close-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            color: var(--white-color);
            font-size: 1.5rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .cart-close-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }
        
        .cart-modal-body {
            padding: 25px;
        }
        
        .cart-item {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            transition: all 0.3s ease;
        }
        
        .cart-item:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateX(5px);
        }
        
        .cart-item-info {
            flex: 1;
        }
        
        .cart-item-name {
            color: var(--white-color);
            font-size: 1.2rem;
            font-weight: var(--font-semi-bold);
            margin-bottom: 5px;
        }
        
        .cart-item-price {
            color: var(--first-color);
            font-size: 1rem;
        }
        
        .cart-item-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .cart-item-qty-control {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.1);
            padding: 5px 10px;
            border-radius: 10px;
        }
        
        .cart-item-qty-btn {
            background: var(--first-color);
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 6px;
            color: var(--white-color);
            font-size: 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .cart-item-qty-btn:hover {
            background: var(--first-color-alt);
            transform: scale(1.1);
        }
        
        .cart-item-qty {
            color: var(--white-color);
            font-weight: var(--font-semi-bold);
            min-width: 30px;
            text-align: center;
        }
        
        .cart-item-delete {
            background: rgba(255, 59, 48, 0.2);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            color: #ff3b30;
            font-size: 1.2rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .cart-item-delete:hover {
            background: rgba(255, 59, 48, 0.3);
            transform: scale(1.1);
        }
        
        .cart-empty {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-color);
        }
        
        .cart-empty i {
            font-size: 5rem;
            color: var(--first-color);
            margin-bottom: 20px;
            opacity: 0.5;
        }
        
        .cart-empty p {
            font-size: 1.2rem;
            margin-bottom: 25px;
        }
        
        .cart-modal-footer {
            background: rgba(255, 255, 255, 0.05);
            padding: 25px;
            border-radius: 0 0 20px 20px;
        }
        
        .cart-total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        }
        
        .cart-total-label {
            color: var(--white-color);
            font-size: 1.3rem;
            font-weight: var(--font-semi-bold);
        }
        
        .cart-total-amount {
            color: var(--first-color);
            font-size: 1.8rem;
            font-weight: var(--font-semi-bold);
        }
        
        .cart-modal-actions {
            display: flex;
            gap: 15px;
        }
        
        .cart-summary {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--dark-color);
            padding: 20px;
            box-shadow: 0 -5px 20px rgba(0,0,0,0.3);
            transform: translateY(100%);
            transition: transform 0.3s ease;
            z-index: 100;
        }
        
        .cart-summary.active {
            transform: translateY(0);
        }
        
        .cart-summary-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .cart-info {
            color: var(--white-color);
        }
        
        .cart-count {
            font-size: 1.2rem;
            margin-bottom: 5px;
        }
        
        .cart-total {
            color: var(--first-color);
            font-size: 1.5rem;
            font-weight: var(--font-semi-bold);
        }
        
        .cart-actions {
            display: flex;
            gap: 15px;
        }
        
        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: var(--font-semi-bold);
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-view-cart {
            background: rgba(255,255,255,0.1);
            color: var(--white-color);
            border: 2px solid var(--first-color);
        }
        
        .btn-view-cart:hover {
            background: rgba(255,255,255,0.2);
        }
        
        .btn-checkout {
            background: var(--first-color);
            color: var(--white-color);
        }
        
        .btn-checkout:hover {
            background: var(--first-color-alt);
            box-shadow: 0 8px 20px rgba(26, 188, 156, 0.3);
        }
        
        .btn-continue {
            flex: 1;
            background: rgba(255, 255, 255, 0.1);
            color: var(--white-color);
            border: 2px solid var(--first-color);
        }
        
        .btn-continue:hover {
            background: rgba(255, 255, 255, 0.15);
        }
        
        .btn-checkout-modal {
            flex: 1;
            background: var(--first-color);
            color: var(--white-color);
        }
        
        .btn-checkout-modal:hover {
            background: var(--first-color-alt);
        }
        
        .notification {
            position: fixed;
            top: 100px;
            right: 20px;
            background: var(--first-color);
            color: var(--white-color);
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
            transform: translateX(400px);
            transition: transform 0.3s ease;
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .notification.show {
            transform: translateX(0);
        }
        
        @media (max-width: 768px) {
            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 20px;
            }
            
            .page-header h1 {
                font-size: 2rem;
            }
            
            .cart-summary-content {
                flex-direction: column;
                text-align: center;
            }
            
            .cart-actions {
                width: 100%;
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
            
            .cart-item {
                flex-direction: column;
                text-align: center;
            }
            
            .cart-item-controls {
                width: 100%;
                justify-content: center;
            }
            
            .cart-modal-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <header class="header" id="header">
        <nav class="nav container">
            <a href="index.php" class="nav--logo">STARCOFFEE</a>
            <div class="nav--menu" id="nav-menu">
                <ul class="nav--list">
                    <li><a href="index.php#home" class="nav--link">HOME</a></li>
                    <li><a href="index.php#popular" class="nav--link">POPULAR</a></li>
                    <li><a href="index.php#about" class="nav--link">ABOUT US</a></li>
                    <li><a href="index.php#products" class="nav--link">PRODUCTS</a></li>
                    <li><a href="index.php#contact" class="nav--link">CONTACT</a></li>
                </ul>
                <div class="nav--close" id="nav-close">
                    <i class="ri-close-large-line"></i>
                </div>
            </div>
            <div class="nav--toggle" id="nav-toggle">
                <i class="ri-apps-2-fill"></i>
            </div>
        </nav>
    </header>

    <main class="main">
        <div class="order-container">
            <div class="page-header">
                <h1>OUR COFFEE MENU</h1>
                <p>Choose your favorite coffee and customize your order</p>
            </div>

            <div class="product-grid">
                <?php foreach ($products as $index => $product): ?>
                <div class="product-card">
                    <div class="product-image-wrapper">
                        <div class="product-shape"></div>
                        <img src="assets/img/ice-img.png" alt="ice" class="product-ice product-ice-1">
                        <img src="assets/img/ice-img.png" alt="ice" class="product-ice product-ice-2">
                        <img src="assets/img/<?php echo $product['image']; ?>" 
                             alt="<?php echo htmlspecialchars($product['name']); ?>" 
                             class="product-coffee-img">
                    </div>
                    
                    <div class="product-info">
                        <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p class="product-description"><?php echo htmlspecialchars($product['description']); ?></p>
                        <span class="product-price">₱<?php echo number_format($product['price'], 2); ?></span>
                        
                        <div class="quantity-control">
                            <button type="button" class="quantity-btn" onclick="decreaseQty(<?php echo $index; ?>)">
                                <i class="ri-subtract-line"></i>
                            </button>
                            <input type="number" id="qty-<?php echo $index; ?>" class="quantity-input" value="1" min="1" max="10" readonly>
                            <button type="button" class="quantity-btn" onclick="increaseQty(<?php echo $index; ?>)">
                                <i class="ri-add-line"></i>
                            </button>
                        </div>
                        
                        <button class="add-to-cart-btn" onclick="addToCart(<?php echo $index; ?>, '<?php echo htmlspecialchars($product['name']); ?>', <?php echo $product['price']; ?>)">
                            <i class="ri-shopping-cart-line"></i>
                            Add to Cart
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Cart Summary Bar -->
        <div class="cart-summary" id="cartSummary">
            <div class="cart-summary-content">
                <div class="cart-info">
                    <div class="cart-count">
                        <i class="ri-shopping-cart-2-line"></i>
                        <span id="cartItemCount">0</span> item(s) in cart
                    </div>
                    <div class="cart-total">Total: ₱<span id="cartTotal">0.00</span></div>
                </div>
                <div class="cart-actions">
                    <button class="btn btn-view-cart" onclick="openCartModal()">
                        <i class="ri-eye-line"></i>
                        View Cart
                    </button>
                    <button class="btn btn-checkout" onclick="proceedToCheckout()">
                        <i class="ri-check-line"></i>
                        Checkout
                    </button>
                </div>
            </div>
        </div>

        <!-- Cart Modal -->
        <div class="cart-modal" id="cartModal">
            <div class="cart-modal-content">
                <div class="cart-modal-header">
                    <h2>
                        <i class="ri-shopping-cart-2-line"></i>
                        Your Cart
                    </h2>
                    <button class="cart-close-btn" onclick="closeCartModal()">
                        <i class="ri-close-line"></i>
                    </button>
                </div>
                
                <div class="cart-modal-body" id="cartModalBody">
                    <!-- Cart items will be populated here -->
                </div>
                
                <div class="cart-modal-footer" id="cartModalFooter" style="display: none;">
                    <div class="cart-total-row">
                        <span class="cart-total-label">Total Amount:</span>
                        <span class="cart-total-amount">₱<span id="modalCartTotal">0.00</span></span>
                    </div>
                    <div class="cart-modal-actions">
                        <button class="btn btn-continue" onclick="closeCartModal()">
                            <i class="ri-arrow-left-line"></i>
                            Continue Shopping
                        </button>
                        <button class="btn btn-checkout-modal" onclick="proceedToCheckout()">
                            <i class="ri-check-line"></i>
                            Proceed to Checkout
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notification -->
        <div class="notification" id="notification">
            <i class="ri-check-circle-line"></i>
            <span id="notificationText">Added to cart!</span>
        </div>
    </main>

    <script src="assets/js/main.js"></script>
    <script>
        let cart = JSON.parse(localStorage.getItem('coffeeCart')) || [];
        
        function updateCartDisplay() {
            const itemCount = cart.reduce((sum, item) => sum + item.quantity, 0);
            const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            
            document.getElementById('cartItemCount').textContent = itemCount;
            document.getElementById('cartTotal').textContent = total.toFixed(2);
            document.getElementById('modalCartTotal').textContent = total.toFixed(2);
            
            const cartSummary = document.getElementById('cartSummary');
            if (itemCount > 0) {
                cartSummary.classList.add('active');
            } else {
                cartSummary.classList.remove('active');
            }
            
            updateCartModal();
        }
        
        function updateCartModal() {
            const cartModalBody = document.getElementById('cartModalBody');
            const cartModalFooter = document.getElementById('cartModalFooter');
            
            if (cart.length === 0) {
                cartModalBody.innerHTML = `
                    <div class="cart-empty">
                        <i class="ri-shopping-cart-line"></i>
                        <p>Your cart is empty</p>
                        <button class="btn btn-continue" onclick="closeCartModal()">
                            <i class="ri-arrow-left-line"></i>
                            Start Shopping
                        </button>
                    </div>
                `;
                cartModalFooter.style.display = 'none';
            } else {
                let cartHTML = '';
                cart.forEach((item, index) => {
                    const itemTotal = item.price * item.quantity;
                    cartHTML += `
                        <div class="cart-item">
                            <div class="cart-item-info">
                                <div class="cart-item-name">${item.name}</div>
                                <div class="cart-item-price">₱${item.price.toFixed(2)} each</div>
                            </div>
                            <div class="cart-item-controls">
                                <div class="cart-item-qty-control">
                                    <button class="cart-item-qty-btn" onclick="updateCartItemQty(${index}, -1)">
                                        <i class="ri-subtract-line"></i>
                                    </button>
                                    <span class="cart-item-qty">${item.quantity}</span>
                                    <button class="cart-item-qty-btn" onclick="updateCartItemQty(${index}, 1)">
                                        <i class="ri-add-line"></i>
                                    </button>
                                </div>
                                <button class="cart-item-delete" onclick="removeFromCart(${index})" title="Remove item">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </div>
                    `;
                });
                cartModalBody.innerHTML = cartHTML;
                cartModalFooter.style.display = 'block';
            }
        }
        
        function openCartModal() {
            document.getElementById('cartModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        
        function closeCartModal() {
            document.getElementById('cartModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }
        
        function updateCartItemQty(index, change) {
            if (cart[index].quantity + change > 0 && cart[index].quantity + change <= 10) {
                cart[index].quantity += change;
                localStorage.setItem('coffeeCart', JSON.stringify(cart));
                updateCartDisplay();
                showNotification('Cart updated!');
            }
        }
        
        function removeFromCart(index) {
            const itemName = cart[index].name;
            cart.splice(index, 1);
            localStorage.setItem('coffeeCart', JSON.stringify(cart));
            updateCartDisplay();
            showNotification(`${itemName} removed from cart!`);
        }
        
        function increaseQty(index) {
            const input = document.getElementById(`qty-${index}`);
            if (parseInt(input.value) < 10) {
                input.value = parseInt(input.value) + 1;
            }
        }
        
        function decreaseQty(index) {
            const input = document.getElementById(`qty-${index}`);
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }
        
        function addToCart(index, name, price) {
            const quantity = parseInt(document.getElementById(`qty-${index}`).value);
            
            const existingItemIndex = cart.findIndex(item => item.name === name);
            
            if (existingItemIndex > -1) {
                const newQty = cart[existingItemIndex].quantity + quantity;
                if (newQty <= 10) {
                    cart[existingItemIndex].quantity = newQty;
                } else {
                    cart[existingItemIndex].quantity = 10;
                    showNotification('Maximum quantity (10) reached!');
                    return;
                }
            } else {
                cart.push({
                    name: name,
                    price: price,
                    quantity: quantity
                });
            }
            
            localStorage.setItem('coffeeCart', JSON.stringify(cart));
            updateCartDisplay();
            showNotification(`${name} added to cart!`);
            
            document.getElementById(`qty-${index}`).value = 1;
        }
        
        function showNotification(message) {
            const notification = document.getElementById('notification');
            document.getElementById('notificationText').textContent = message;
            notification.classList.add('show');
            
            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
        }
        
        function proceedToCheckout() {
            if (cart.length === 0) {
                showNotification('Your cart is empty!');
                return;
            }
            
            localStorage.setItem('coffeeCart', JSON.stringify(cart));
            window.location.href = 'checkout.php';
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            updateCartDisplay();
        });
        
        // Close modal when clicking outside
        document.getElementById('cartModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCartModal();
            }
        });
    </script>
</body>
</html>