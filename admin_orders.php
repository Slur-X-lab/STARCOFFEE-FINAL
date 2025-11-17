<?php
require_once 'config.php';

// Fetch all orders
$query = "SELECT o.*, 
          (SELECT COUNT(*) FROM order_items WHERE order_id = o.id) as item_count
          FROM orders o 
          ORDER BY o.created_at DESC";
$result = $conn->query($query);
$orders = $result->fetch_all(MYSQLI_ASSOC);

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
    <title>Admin - Orders Management - STARCOFFEE</title>
    <style>
        .admin-container {
            max-width: 1400px;
            margin: 120px auto 50px;
            padding: 20px;
        }
        
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }
        
        .admin-title {
            color: var(--white-color);
            font-size: 2.5rem;
            font-family: var(--second-font);
        }
        
        .admin-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        
        .stat-card {
            background: var(--dark-color);
            padding: 25px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            background: var(--first-color);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: var(--white-color);
        }
        
        .stat-info {
            flex: 1;
        }
        
        .stat-label {
            color: var(--text-color);
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        
        .stat-value {
            color: var(--white-color);
            font-size: 1.8rem;
            font-weight: var(--font-semi-bold);
        }
        
        .orders-table-container {
            background: var(--dark-color);
            border-radius: 20px;
            padding: 30px;
            overflow-x: auto;
        }
        
        .orders-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .orders-table thead {
            background: rgba(26, 188, 156, 0.1);
        }
        
        .orders-table th {
            padding: 15px;
            text-align: left;
            color: var(--first-color);
            font-weight: var(--font-semi-bold);
            font-size: 0.9rem;
            text-transform: uppercase;
        }
        
        .orders-table td {
            padding: 15px;
            color: var(--white-color);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .orders-table tbody tr {
            transition: background 0.3s ease;
        }
        
        .orders-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.05);
        }
        
        .order-status {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: var(--font-semi-bold);
            text-transform: uppercase;
        }
        
        .status-pending {
            background: rgba(255, 193, 7, 0.2);
            border: 2px solid #ffc107;
            color: #ffc107;
        }
        
        .status-processing {
            background: rgba(33, 150, 243, 0.2);
            border: 2px solid #2196f3;
            color: #2196f3;
        }
        
        .status-out_for_delivery {
            background: rgba(156, 39, 176, 0.2);
            border: 2px solid #9c27b0;
            color: #9c27b0;
        }
        
        .status-completed {
            background: rgba(76, 175, 80, 0.2);
            border: 2px solid #4caf50;
            color: #4caf50;
        }
        
        .status-cancelled {
            background: rgba(244, 67, 54, 0.2);
            border: 2px solid #f44336;
            color: #f44336;
        }
        
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        
        .btn-action {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }
        
        .btn-view {
            background: rgba(33, 150, 243, 0.2);
            color: #2196f3;
        }
        
        .btn-view:hover {
            background: rgba(33, 150, 243, 0.3);
            transform: scale(1.1);
        }
        
        .btn-edit {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
        }
        
        .btn-edit:hover {
            background: rgba(255, 193, 7, 0.3);
            transform: scale(1.1);
        }
        
        .btn-delete {
            background: rgba(244, 67, 54, 0.2);
            color: #f44336;
        }
        
        .btn-delete:hover {
            background: rgba(244, 67, 54, 0.3);
            transform: scale(1.1);
        }
        
        .modal {
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
        
        .modal.active {
            display: flex;
        }
        
        .modal-content {
            background: var(--dark-color);
            border-radius: 20px;
            max-width: 700px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .modal-header {
            background: linear-gradient(135deg, var(--first-color), var(--first-color-alt));
            padding: 25px;
            border-radius: 20px 20px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .modal-title {
            color: var(--white-color);
            font-size: 1.5rem;
            font-weight: var(--font-semi-bold);
        }
        
        .modal-close {
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
        }
        
        .modal-body {
            padding: 30px;
        }
        
        .detail-row {
            margin-bottom: 20px;
        }
        
        .detail-label {
            color: var(--text-color);
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        
        .detail-value {
            color: var(--white-color);
            font-size: 1.1rem;
            font-weight: var(--font-semi-bold);
        }
        
        .form-select {
            width: 100%;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: var(--white-color);
            font-size: 1rem;
            cursor: pointer;
        }
        
        .form-select:focus {
            outline: none;
            border-color: var(--first-color);
        }
        
        .btn-save {
            width: 100%;
            padding: 15px;
            background: var(--first-color);
            color: var(--white-color);
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: var(--font-semi-bold);
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
        }
        
        .btn-save:hover {
            background: var(--first-color-alt);
            transform: translateY(-2px);
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-color);
        }
        
        .empty-state i {
            font-size: 5rem;
            color: var(--first-color);
            opacity: 0.5;
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .admin-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
            }
            
            .orders-table-container {
                padding: 15px;
            }
            
            .orders-table {
                font-size: 0.85rem;
            }
            
            .orders-table th,
            .orders-table td {
                padding: 10px;
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
        <div class="admin-container">
            <div class="admin-header">
                <h1 class="admin-title">Orders Management</h1>
            </div>

            <!-- Statistics -->
            <div class="admin-stats">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="ri-shopping-bag-line"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-label">Total Orders</div>
                        <div class="stat-value"><?php echo count($orders); ?></div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="ri-time-line"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-label">Pending</div>
                        <div class="stat-value"><?php echo count(array_filter($orders, fn($o) => $o['order_status'] === 'pending')); ?></div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="ri-check-line"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-label">Completed</div>
                        <div class="stat-value"><?php echo count(array_filter($orders, fn($o) => $o['order_status'] === 'completed')); ?></div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="ri-money-dollar-circle-line"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-label">Total Revenue</div>
                        <div class="stat-value">₱<?php echo number_format(array_sum(array_column($orders, 'total_amount')), 2); ?></div>
                    </div>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="orders-table-container">
                <?php if (empty($orders)): ?>
                <div class="empty-state">
                    <i class="ri-inbox-line"></i>
                    <p>No orders yet</p>
                </div>
                <?php else: ?>
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['order_number']); ?></td>
                            <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                            <td><?php echo $order['item_count']; ?> item(s)</td>
                            <td>₱<?php echo number_format($order['total_amount'], 2); ?></td>
                            <td><?php echo ucwords(str_replace('_', ' ', $order['payment_method'])); ?></td>
                            <td>
                                <span class="order-status status-<?php echo $order['order_status']; ?>">
                                    <?php echo ucwords(str_replace('_', ' ', $order['order_status'])); ?>
                                </span>
                            </td>
                            <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-action btn-view" onclick="viewOrder(<?php echo $order['id']; ?>)" title="View Details">
                                        <i class="ri-eye-line"></i>
                                    </button>
                                    <button class="btn-action btn-edit" onclick="editOrder(<?php echo $order['id']; ?>)" title="Edit Status">
                                        <i class="ri-edit-line"></i>
                                    </button>
                                    <button class="btn-action btn-delete" onclick="deleteOrder(<?php echo $order['id']; ?>)" title="Delete Order">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </div>

        <!-- View Order Modal -->
        <div class="modal" id="viewModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Order Details</h2>
                    <button class="modal-close" onclick="closeModal('viewModal')">
                        <i class="ri-close-line"></i>
                    </button>
                </div>
                <div class="modal-body" id="viewModalBody">
                    <!-- Content will be loaded dynamically -->
                </div>
            </div>
        </div>

        <!-- Edit Order Modal -->
        <div class="modal" id="editModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Update Order Status</h2>
                    <button class="modal-close" onclick="closeModal('editModal')">
                        <i class="ri-close-line"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editOrderForm">
                        <input type="hidden" id="editOrderId" name="order_id">
                        <div class="detail-row">
                            <div class="detail-label">Order Number</div>
                            <div class="detail-value" id="editOrderNumber"></div>
                        </div>
                        <div class="detail-row">
                            <label class="detail-label">Order Status</label>
                            <select class="form-select" name="order_status" id="editOrderStatus">
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="out_for_delivery">Out for Delivery</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-save">
                            <i class="ri-save-line"></i>
                            Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script src="assets/js/main.js"></script>
    <script>
        const orders = <?php echo json_encode($orders); ?>;
        
        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
        }
        
        async function viewOrder(orderId) {
            try {
                const response = await fetch(`get_order_details.php?id=${orderId}`);
                const data = await response.json();
                
                if (data.success) {
                    const order = data.order;
                    const items = data.items;
                    
                    let itemsHTML = '';
                    items.forEach(item => {
                        itemsHTML += `
                            <div style="background: rgba(255,255,255,0.05); padding: 15px; border-radius: 10px; margin-bottom: 10px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="color: var(--white-color); font-weight: 600;">${item.product_name}</span>
                                    <span style="color: var(--first-color); font-weight: 600;">₱${parseFloat(item.subtotal).toFixed(2)}</span>
                                </div>
                                <div style="color: var(--text-color); font-size: 0.9rem;">
                                    ${item.quantity} × ₱${parseFloat(item.product_price).toFixed(2)}
                                </div>
                            </div>
                        `;
                    });
                    
                    document.getElementById('viewModalBody').innerHTML = `
                        <div class="detail-row">
                            <div class="detail-label">Order Number</div>
                            <div class="detail-value">${order.order_number}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Customer Name</div>
                            <div class="detail-value">${order.customer_name}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Email</div>
                            <div class="detail-value">${order.customer_email}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Phone</div>
                            <div class="detail-value">${order.customer_phone}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Delivery Address</div>
                            <div class="detail-value">${order.customer_address}</div>
                        </div>
                        ${order.special_instructions ? `
                        <div class="detail-row">
                            <div class="detail-label">Special Instructions</div>
                            <div class="detail-value">${order.special_instructions}</div>
                        </div>
                        ` : ''}
                        <div class="detail-row">
                            <div class="detail-label">Payment Method</div>
                            <div class="detail-value">${order.payment_method.replace(/_/g, ' ').toUpperCase()}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Order Status</div>
                            <div class="detail-value">
                                <span class="order-status status-${order.order_status}">
                                    ${order.order_status.replace(/_/g, ' ').toUpperCase()}
                                </span>
                            </div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Items Ordered</div>
                            <div style="margin-top: 10px;">
                                ${itemsHTML}
                            </div>
                        </div>
                        <div style="border-top: 2px solid rgba(255,255,255,0.1); padding-top: 20px; margin-top: 20px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px; color: var(--white-color);">
                                <span>Subtotal:</span>
                                <span>₱${parseFloat(order.subtotal).toFixed(2)}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px; color: var(--white-color);">
                                <span>Delivery Fee:</span>
                                <span>₱${parseFloat(order.delivery_fee).toFixed(2)}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; font-size: 1.3rem; font-weight: 600; color: var(--first-color); padding-top: 15px; border-top: 2px solid var(--first-color); margin-top: 15px;">
                                <span>Total:</span>
                                <span>₱${parseFloat(order.total_amount).toFixed(2)}</span>
                            </div>
                        </div>
                    `;
                    
                    document.getElementById('viewModal').classList.add('active');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Failed to load order details');
            }
        }
        
        function editOrder(orderId) {
            const order = orders.find(o => o.id == orderId);
            if (order) {
                document.getElementById('editOrderId').value = order.id;
                document.getElementById('editOrderNumber').textContent = order.order_number;
                document.getElementById('editOrderStatus').value = order.order_status;
                document.getElementById('editModal').classList.add('active');
            }
        }
        
        document.getElementById('editOrderForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = {
                order_id: formData.get('order_id'),
                order_status: formData.get('order_status')
            };
            
            try {
                const response = await fetch('update_order_status.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    alert('Order status updated successfully!');
                    location.reload();
                } else {
                    alert('Failed to update order status');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred');
            }
        });
        
        async function deleteOrder(orderId) {
            if (!confirm('Are you sure you want to delete this order?')) {
                return;
            }
            
            try {
                const response = await fetch('delete_order.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ order_id: orderId })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    alert('Order deleted successfully!');
                    location.reload();
                } else {
                    alert('Failed to delete order');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred');
            }
        }
    </script>
</body>
</html>