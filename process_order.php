<?php
require_once 'config.php';

header('Content-Type: application/json');

// Get JSON input
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Validate input
if (!$data || !isset($data['customer_name']) || !isset($data['customer_email']) || 
    !isset($data['customer_phone']) || !isset($data['customer_address']) || 
    !isset($data['payment_method']) || !isset($data['items']) || empty($data['items'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input data']);
    exit;
}

try {
    // Generate unique order number
    $order_number = 'SC-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    
    // Calculate totals
    $subtotal = 0;
    foreach ($data['items'] as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }
    
    $delivery_fee = isset($data['delivery_fee']) ? floatval($data['delivery_fee']) : 50.00;
    $total = $subtotal + $delivery_fee;
    
    // Begin transaction
    $conn->begin_transaction();
    
    // Insert order
    $stmt = $conn->prepare("INSERT INTO orders (order_number, customer_name, customer_email, customer_phone, customer_address, payment_method, subtotal, delivery_fee, total_amount, special_instructions, order_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
    
    $special_instructions = isset($data['special_instructions']) ? $data['special_instructions'] : null;
    
    $stmt->bind_param("ssssssddds", 
        $order_number,
        $data['customer_name'],
        $data['customer_email'],
        $data['customer_phone'],
        $data['customer_address'],
        $data['payment_method'],
        $subtotal,
        $delivery_fee,
        $total,
        $special_instructions
    );
    
    if (!$stmt->execute()) {
        throw new Exception('Failed to create order');
    }
    
    $order_id = $stmt->insert_id;
    $stmt->close();
    
    // Insert order items
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_name, product_price, quantity, subtotal) VALUES (?, ?, ?, ?, ?)");
    
    foreach ($data['items'] as $item) {
        $item_subtotal = $item['price'] * $item['quantity'];
        $stmt->bind_param("isdid", 
            $order_id,
            $item['name'],
            $item['price'],
            $item['quantity'],
            $item_subtotal
        );
        
        if (!$stmt->execute()) {
            throw new Exception('Failed to add order items');
        }
    }
    
    $stmt->close();
    
    // Commit transaction
    $conn->commit();
    
    // Prepare response
    $response = [
        'success' => true,
        'message' => 'Order placed successfully',
        'order_number' => $order_number,
        'order' => [
            'order_number' => $order_number,
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'],
            'customer_address' => $data['customer_address'],
            'payment_method' => $data['payment_method'],
            'special_instructions' => $special_instructions,
            'items' => $data['items'],
            'subtotal' => $subtotal,
            'delivery_fee' => $delivery_fee,
            'total' => $total,
            'order_date' => date('Y-m-d H:i:s')
        ]
    ];
    
    echo json_encode($response);
    
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    
    echo json_encode([
        'success' => false,
        'message' => 'Failed to process order: ' . $e->getMessage()
    ]);
}

$conn->close();
?>