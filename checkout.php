<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <title>Checkout - STARCOFFEE</title>
    <style>
        .checkout-container {
            max-width: 1200px;
            margin: 120px auto 50px;
            padding: 20px;
        }
        
        .checkout-header {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .checkout-header h1 {
            color: var(--white-color);
            font-size: 2.5rem;
            font-family: var(--second-font);
            margin-bottom: 10px;
        }
        
        .checkout-header p {
            color: var(--text-color);
            font-size: 1rem;
        }
        
        .checkout-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        
        .checkout-section {
            background: var(--dark-color);
            border-radius: 20px;
            padding: 30px;
        }
        
        .section-title {
            color: var(--white-color);
            font-size: 1.5rem;
            font-weight: var(--font-semi-bold);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--first-color);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            color: var(--white-color);
            font-size: 0.9rem;
            margin-bottom: 8px;
            font-weight: var(--font-semi-bold);
        }
        
        .form-input,
        .form-textarea {
            width: 100%;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: var(--white-color);
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-input:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--first-color);
            background: rgba(255, 255, 255, 0.08);
        }
        
        .form-textarea {
            resize: vertical;
            min-height: 80px;
        }
        
        .payment-methods {
            display: grid;
            gap: 15px;
            margin-top: 15px;
        }
        
        .payment-option {
            position: relative;
        }
        
        .payment-option input[type="radio"] {
            position: absolute;
            opacity: 0;
        }
        
        .payment-label {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 20px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .payment-option input[type="radio"]:checked + .payment-label {
            background: rgba(26, 188, 156, 0.1);
            border-color: var(--first-color);
        }
        
        .payment-icon {
            width: 50px;
            height: 50px;
            background: var(--first-color);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--white-color);
        }
        
        .payment-info {
            flex: 1;
        }
        
        .payment-name {
            color: var(--white-color);
            font-size: 1.1rem;
            font-weight: var(--font-semi-bold);
            margin-bottom: 3px;
        }
        
        .payment-desc {
            color: var(--text-color);
            font-size: 0.85rem;
        }
        
        .order-summary-item {
            display: flex;
            justify-content: space-between;
            padding: 15px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            margin-bottom: 10px;
        }
        
        .item-details {
            flex: 1;
        }
        
        .item-name {
            color: var(--white-color);
            font-weight: var(--font-semi-bold);
            margin-bottom: 5px;
        }
        
        .item-qty {
            color: var(--text-color);
            font-size: 0.9rem;
        }
        
        .item-price {
            color: var(--first-color);
            font-weight: var(--font-semi-bold);
        }
        
        .summary-totals {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 2px solid rgba(255, 255, 255, 0.1);
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            color: var(--white-color);
        }
        
        .summary-row.total {
            font-size: 1.3rem;
            font-weight: var(--font-semi-bold);
            color: var(--first-color);
            padding-top: 15px;
            border-top: 2px solid var(--first-color);
            margin-top: 15px;
        }
        
        .checkout-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        
        .btn {
            flex: 1;
            padding: 15px;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: var(--font-semi-bold);
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .btn-back {
            background: rgba(255, 255, 255, 0.1);
            color: var(--white-color);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }
        
        .btn-back:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--first-color);
        }
        
        .btn-submit {
            background: var(--first-color);
            color: var(--white-color);
        }
        
        .btn-submit:hover {
            background: var(--first-color-alt);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(26, 188, 156, 0.3);
        }
        
        .btn-submit:disabled {
            background: rgba(255, 255, 255, 0.2);
            cursor: not-allowed;
            transform: none;
        }
        
        .error-message {
            background: rgba(255, 59, 48, 0.1);
            border: 2px solid rgba(255, 59, 48, 0.3);
            color: #ff3b30;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: none;
        }
        
        .error-message.show {
            display: block;
        }
        
        @media (max-width: 968px) {
            .checkout-content {
                grid-template-columns: 1fr;
            }
            
            .checkout-actions {
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
        <div class="checkout-container">
            <div class="checkout-header">
                <h1>Checkout</h1>
                <p>Complete your order by filling in the details below</p>
            </div>

            <div class="error-message" id="errorMessage">
                <i class="ri-error-warning-line"></i>
                <span id="errorText">Please fill in all required fields</span>
            </div>

            <form id="checkoutForm">
                <div class="checkout-content">
                    <!-- Customer Information -->
                    <div>
                        <div class="checkout-section">
                            <h2 class="section-title">
                                <i class="ri-user-line"></i>
                                Customer Information
                            </h2>
                            
                            <div class="form-group">
                                <label class="form-label">Full Name *</label>
                                <input type="text" class="form-input" name="customer_name" id="customer_name" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Email Address *</label>
                                <input type="email" class="form-input" name="customer_email" id="customer_email" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Phone Number *</label>
                                <input type="tel" class="form-input" name="customer_phone" id="customer_phone" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Delivery Address *</label>
                                <textarea class="form-textarea" name="customer_address" id="customer_address" required></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Special Instructions (Optional)</label>
                                <textarea class="form-textarea" name="special_instructions" id="special_instructions" placeholder="Any special requests or notes..."></textarea>
                            </div>
                        </div>
                        
                        <div class="checkout-section" style="margin-top: 20px;">
                            <h2 class="section-title">
                                <i class="ri-bank-card-line"></i>
                                Payment Method
                            </h2>
                            
                            <div class="payment-methods">
                                <div class="payment-option">
                                    <input type="radio" name="payment_method" id="gcash" value="gcash" required>
                                    <label for="gcash" class="payment-label">
                                        <div class="payment-icon">
                                            <i class="ri-smartphone-line"></i>
                                        </div>
                                        <div class="payment-info">
                                            <div class="payment-name">GCash</div>
                                            <div class="payment-desc">Pay securely via GCash</div>
                                        </div>
                                    </label>
                                </div>
                                
                                <div class="payment-option">
                                    <input type="radio" name="payment_method" id="paymaya" value="paymaya">
                                    <label for="paymaya" class="payment-label">
                                        <div class="payment-icon">
                                            <i class="ri-wallet-line"></i>
                                        </div>
                                        <div class="payment-info">
                                            <div class="payment-name">PayMaya</div>
                                            <div class="payment-desc">Pay securely via PayMaya</div>
                                        </div>
                                    </label>
                                </div>
                                
                                <div class="payment-option">
                                    <input type="radio" name="payment_method" id="cod" value="cash_on_delivery">
                                    <label for="cod" class="payment-label">
                                        <div class="payment-icon">
                                            <i class="ri-money-dollar-circle-line"></i>
                                        </div>
                                        <div class="payment-info">
                                            <div class="payment-name">Cash on Delivery</div>
                                            <div class="payment-desc">Pay when you receive your order</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div>
                        <div class="checkout-section">
                            <h2 class="section-title">
                                <i class="ri-file-list-line"></i>
                                Order Summary
                            </h2>
                            
                            <div id="orderItems">
                                <!-- Order items will be populated here -->
                            </div>
                            
                            <div class="summary-totals">
                                <div class="summary-row">
                                    <span>Subtotal:</span>
                                    <span>₱<span id="subtotal">0.00</span></span>
                                </div>
                                <div class="summary-row">
                                    <span>Delivery Fee:</span>
                                    <span>₱<span id="deliveryFee">50.00</span></span>
                                </div>
                                <div class="summary-row total">
                                    <span>Total:</span>
                                    <span>₱<span id="totalAmount">0.00</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="checkout-actions">
                    <button type="button" class="btn btn-back" onclick="goBack()">
                        <i class="ri-arrow-left-line"></i>
                        Back to Cart
                    </button>
                    <button type="submit" class="btn btn-submit" id="submitBtn">
                        <i class="ri-check-line"></i>
                        Place Order
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script src="assets/js/main.js"></script>
    <script>
        const cart = JSON.parse(localStorage.getItem('coffeeCart')) || [];
        const DELIVERY_FEE = 50.00;
        
        function displayOrderSummary() {
            if (cart.length === 0) {
                window.location.href = 'order.php';
                return;
            }
            
            const orderItemsDiv = document.getElementById('orderItems');
            let itemsHTML = '';
            let subtotal = 0;
            
            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;
                
                itemsHTML += `
                    <div class="order-summary-item">
                        <div class="item-details">
                            <div class="item-name">${item.name}</div>
                            <div class="item-qty">Quantity: ${item.quantity} × ₱${item.price.toFixed(2)}</div>
                        </div>
                        <div class="item-price">₱${itemTotal.toFixed(2)}</div>
                    </div>
                `;
            });
            
            orderItemsDiv.innerHTML = itemsHTML;
            
            const total = subtotal + DELIVERY_FEE;
            document.getElementById('subtotal').textContent = subtotal.toFixed(2);
            document.getElementById('totalAmount').textContent = total.toFixed(2);
        }
        
        function goBack() {
            window.location.href = 'order.php';
        }
        
        function showError(message) {
            const errorDiv = document.getElementById('errorMessage');
            document.getElementById('errorText').textContent = message;
            errorDiv.classList.add('show');
            
            setTimeout(() => {
                errorDiv.classList.remove('show');
            }, 5000);
            
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        
        document.getElementById('checkoutForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="ri-loader-4-line"></i> Processing...';
            
            const formData = new FormData(this);
            const cart = JSON.parse(localStorage.getItem('coffeeCart')) || [];
            
            // Validate form
            if (!formData.get('customer_name') || !formData.get('customer_email') || 
                !formData.get('customer_phone') || !formData.get('customer_address') ||
                !formData.get('payment_method')) {
                showError('Please fill in all required fields');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="ri-check-line"></i> Place Order';
                return;
            }
            
            if (cart.length === 0) {
                showError('Your cart is empty');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="ri-check-line"></i> Place Order';
                return;
            }
            
            // Prepare order data
            const orderData = {
                customer_name: formData.get('customer_name'),
                customer_email: formData.get('customer_email'),
                customer_phone: formData.get('customer_phone'),
                customer_address: formData.get('customer_address'),
                special_instructions: formData.get('special_instructions'),
                payment_method: formData.get('payment_method'),
                items: cart,
                subtotal: parseFloat(document.getElementById('subtotal').textContent),
                delivery_fee: DELIVERY_FEE,
                total: parseFloat(document.getElementById('totalAmount').textContent)
            };
            
            try {
                const response = await fetch('process_order.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(orderData)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // Store order details for receipt page
                    localStorage.setItem('lastOrder', JSON.stringify(result.order));
                    localStorage.removeItem('coffeeCart');
                    
                    // Redirect to order confirmation
                    window.location.href = 'order_confirmation.php?order=' + result.order_number;
                } else {
                    showError(result.message || 'Failed to process order. Please try again.');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="ri-check-line"></i> Place Order';
                }
            } catch (error) {
                console.error('Error:', error);
                showError('An error occurred. Please try again.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="ri-check-line"></i> Place Order';
            }
        });
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            displayOrderSummary();
        });
    </script>
</body>
</html>