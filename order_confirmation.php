<?php
require_once 'config.php';

// Get order number from URL
$order_number = isset($_GET['order']) ? $_GET['order'] : '';

if (empty($order_number)) {
    header('Location: order.php');
    exit;
}

// Fetch order details from database
$stmt = $conn->prepare("SELECT * FROM orders WHERE order_number = ?");
$stmt->bind_param("s", $order_number);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();
$stmt->close();

if (!$order) {
    header('Location: order.php');
    exit;
}

// Fetch order items
$stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
$stmt->bind_param("i", $order['id']);
$stmt->execute();
$items_result = $stmt->get_result();
$order_items = $items_result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <title>Order Confirmed - STARCOFFEE</title>
    <style>
        .confirmation-container {
            max-width: 900px;
            margin: 120px auto 50px;
            padding: 20px;
        }
        
        .success-animation {
            text-align: center;
            margin-bottom: 40px;
            animation: fadeInUp 0.6s ease;
        }
        
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
        
        .success-icon {
            width: 100px;
            height: 100px;
            background: var(--first-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            animation: scaleIn 0.5s ease 0.2s both;
        }
        
        @keyframes scaleIn {
            from {
                transform: scale(0);
            }
            to {
                transform: scale(1);
            }
        }
        
        .success-icon i {
            font-size: 3rem;
            color: var(--white-color);
        }
        
        .success-title {
            color: var(--white-color);
            font-size: 2rem;
            font-family: var(--second-font);
            margin-bottom: 10px;
        }
        
        .success-message {
            color: var(--text-color);
            font-size: 1.1rem;
        }
        
        .order-number-display {
            background: linear-gradient(135deg, var(--first-color), var(--first-color-alt));
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .order-number-label {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        
        .order-number-value {
            color: var(--white-color);
            font-size: 1.8rem;
            font-weight: var(--font-semi-bold);
            font-family: var(--second-font);
            letter-spacing: 2px;
        }
        
        .receipt-card {
            background: var(--dark-color);
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 30px;
        }
        
        .receipt-header {
            text-align: center;
            padding-bottom: 30px;
            border-bottom: 2px dashed rgba(255, 255, 255, 0.2);
            margin-bottom: 30px;
        }
        
        .receipt-logo {
            color: var(--first-color);
            font-size: 2rem;
            font-family: var(--second-font);
            margin-bottom: 10px;
        }
        
        .receipt-title {
            color: var(--white-color);
            font-size: 1.5rem;
            font-weight: var(--font-semi-bold);
            margin-bottom: 5px;
        }
        
        .receipt-date {
            color: var(--text-color);
            font-size: 0.9rem;
        }
        
        .receipt-section {
            margin-bottom: 30px;
        }
        
        .receipt-section-title {
            color: var(--first-color);
            font-size: 1.1rem;
            font-weight: var(--font-semi-bold);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .receipt-info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            color: var(--white-color);
        }
        
        .receipt-info-label {
            color: var(--text-color);
        }
        
        .receipt-info-value {
            font-weight: var(--font-semi-bold);
            text-align: right;
        }
        
        .receipt-item {
            background: rgba(255, 255, 255, 0.05);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 10px;
        }
        
        .receipt-item-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        
        .receipt-item-name {
            color: var(--white-color);
            font-weight: var(--font-semi-bold);
        }
        
        .receipt-item-total {
            color: var(--first-color);
            font-weight: var(--font-semi-bold);
        }
        
        .receipt-item-details {
            color: var(--text-color);
            font-size: 0.9rem;
        }
        
        .receipt-totals {
            border-top: 2px dashed rgba(255, 255, 255, 0.2);
            padding-top: 20px;
            margin-top: 20px;
        }
        
        .receipt-total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            color: var(--white-color);
        }
        
        .receipt-total-row.final {
            font-size: 1.3rem;
            font-weight: var(--font-semi-bold);
            color: var(--first-color);
            padding-top: 15px;
            border-top: 2px solid var(--first-color);
            margin-top: 15px;
        }
        
        .receipt-footer {
            text-align: center;
            padding-top: 30px;
            border-top: 2px dashed rgba(255, 255, 255, 0.2);
            margin-top: 30px;
        }
        
        .receipt-footer-text {
            color: var(--text-color);
            font-size: 0.9rem;
            margin-bottom: 10px;
        }
        
        .receipt-footer-note {
            color: var(--first-color);
            font-weight: var(--font-semi-bold);
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
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
            text-decoration: none;
        }
        
        .btn-print {
            background: var(--first-color);
            color: var(--white-color);
        }
        
        .btn-print:hover {
            background: var(--first-color-alt);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(26, 188, 156, 0.3);
        }
        
        .btn-home {
            background: rgba(255, 255, 255, 0.1);
            color: var(--white-color);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }
        
        .btn-home:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--first-color);
        }
        
        .payment-badge {
            display: inline-block;
            padding: 5px 15px;
            background: rgba(26, 188, 156, 0.2);
            border: 2px solid var(--first-color);
            border-radius: 20px;
            color: var(--first-color);
            font-size: 0.85rem;
            font-weight: var(--font-semi-bold);
            text-transform: uppercase;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            background: rgba(255, 193, 7, 0.2);
            border: 2px solid #ffc107;
            border-radius: 20px;
            color: #ffc107;
            font-size: 0.85rem;
            font-weight: var(--font-semi-bold);
            text-transform: uppercase;
        }
        
        @media print {
            body {
                background: white;
            }
            
            .header, .action-buttons, .success-animation, .order-number-display {
                display: none;
            }
            
            .confirmation-container {
                margin: 0;
                padding: 20px;
            }
            
            .receipt-card {
                background: white;
                color: black;
                box-shadow: none;
                padding: 20px;
            }
            
            .receipt-logo, .receipt-title, .receipt-section-title, 
            .receipt-item-name, .receipt-item-total, .receipt-total-row {
                color: black !important;
            }
            
            .receipt-date, .receipt-info-label, .receipt-info-value, 
            .receipt-item-details, .receipt-footer-text {
                color: #666 !important;
            }
            
            .payment-badge, .status-badge {
                border-color: black !important;
                color: black !important;
            }
        }
        
        @media (max-width: 768px) {
            .action-buttons {
                flex-direction: column;
            }
            
            .receipt-card {
                padding: 25px;
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
        <div class="confirmation-container">
            <!-- Success Animation -->
            <div class="success-animation">
                <div class="success-icon">
                    <i class="ri-check-line"></i>
                </div>
                <h1 class="success-title">Order Confirmed!</h1>
                <p class="success-message">Thank you for your order. We'll prepare it with care!</p>
            </div>

            <!-- Order Number Display -->
            <div class="order-number-display">
                <div class="order-number-label">Your Order Number</div>
                <div class="order-number-value"><?php echo htmlspecialchars($order['order_number']); ?></div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <button class="btn btn-print" onclick="window.print()">
                    <i class="ri-printer-line"></i>
                    Print Receipt
                </button>
                <a href="index.php" class="btn btn-home">
                    <i class="ri-home-line"></i>
                    Back to Home
                </a>
            </div>

            <!-- Receipt Card -->
            <div class="receipt-card" id="receipt">
                <div class="receipt-header">
                    <div class="receipt-logo">STARCOFFEE</div>
                    <div class="receipt-title">Order Receipt</div>
                    <div class="receipt-date"><?php echo date('F d, Y - h:i A', strtotime($order['created_at'])); ?></div>
                </div>

                <!-- Customer Information -->
                <div class="receipt-section">
                    <h3 class="receipt-section-title">
                        <i class="ri-user-line"></i>
                        Customer Information
                    </h3>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">Name:</span>
                        <span class="receipt-info-value"><?php echo htmlspecialchars($order['customer_name']); ?></span>
                    </div>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">Email:</span>
                        <span class="receipt-info-value"><?php echo htmlspecialchars($order['customer_email']); ?></span>
                    </div>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">Phone:</span>
                        <span class="receipt-info-value"><?php echo htmlspecialchars($order['customer_phone']); ?></span>
                    </div>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">Delivery Address:</span>
                        <span class="receipt-info-value"><?php echo htmlspecialchars($order['customer_address']); ?></span>
                    </div>
                </div>

                <!-- Order Details -->
                <div class="receipt-section">
                    <h3 class="receipt-section-title">
                        <i class="ri-file-list-line"></i>
                        Order Details
                    </h3>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">Order Number:</span>
                        <span class="receipt-info-value"><?php echo htmlspecialchars($order['order_number']); ?></span>
                    </div>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">Order Status:</span>
                        <span class="receipt-info-value">
                            <span class="status-badge"><?php echo ucwords(str_replace('_', ' ', $order['order_status'])); ?></span>
                        </span>
                    </div>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">Payment Method:</span>
                        <span class="receipt-info-value">
                            <span class="payment-badge"><?php echo ucwords(str_replace('_', ' ', $order['payment_method'])); ?></span>
                        </span>
                    </div>
                    <?php if (!empty($order['special_instructions'])): ?>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">Special Instructions:</span>
                        <span class="receipt-info-value"><?php echo htmlspecialchars($order['special_instructions']); ?></span>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Order Items -->
                <div class="receipt-section">
                    <h3 class="receipt-section-title">
                        <i class="ri-shopping-bag-line"></i>
                        Items Ordered
                    </h3>
                    <?php foreach ($order_items as $item): ?>
                    <div class="receipt-item">
                        <div class="receipt-item-header">
                            <span class="receipt-item-name"><?php echo htmlspecialchars($item['product_name']); ?></span>
                            <span class="receipt-item-total">₱<?php echo number_format($item['subtotal'], 2); ?></span>
                        </div>
                        <div class="receipt-item-details">
                            <?php echo $item['quantity']; ?> × ₱<?php echo number_format($item['product_price'], 2); ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Totals -->
                <div class="receipt-totals">
                    <div class="receipt-total-row">
                        <span>Subtotal:</span>
                        <span>₱<?php echo number_format($order['subtotal'], 2); ?></span>
                    </div>
                    <div class="receipt-total-row">
                        <span>Delivery Fee:</span>
                        <span>₱<?php echo number_format($order['delivery_fee'], 2); ?></span>
                    </div>
                    <div class="receipt-total-row final">
                        <span>Total Amount:</span>
                        <span>₱<?php echo number_format($order['total_amount'], 2); ?></span>
                    </div>
                </div>

                <!-- Footer -->
                <div class="receipt-footer">
                    <p class="receipt-footer-text">Thank you for choosing STARCOFFEE!</p>
                    <p class="receipt-footer-text">We hope you enjoy your coffee experience.</p>
                    <p class="receipt-footer-note">For inquiries, please contact us through our website.</p>
                </div>
            </div>
        </div>
    </main>

    <script src="assets/js/main.js"></script>
</body>
</html>