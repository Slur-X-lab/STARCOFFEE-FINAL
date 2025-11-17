<?php
require_once 'config.php';

header('Content-Type: application/json');

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['order_id']) || !isset($data['order_status'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

$order_id = intval($data['order_id']);
$order_status = $data['order_status'];

$allowed_statuses = ['pending', 'processing', 'out_for_delivery', 'completed', 'cancelled'];

if (!in_array($order_status, $allowed_statuses)) {
    echo json_encode(['success' => false, 'message' => 'Invalid order status']);
    exit;
}

try {
    $stmt = $conn->prepare("UPDATE orders SET order_status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
    $stmt->bind_param("si", $order_status, $order_id);
    
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Order status updated successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to update order status'
        ]);
    }
    
    $stmt->close();
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}

$conn->close();
?>