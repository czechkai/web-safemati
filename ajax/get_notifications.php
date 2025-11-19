<?php
/**
 * AJAX Handler: Get User Notifications
 * Returns unread notifications for dropdown display
 */

session_start();
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(array('success' => false, 'message' => 'User not logged in'));
    exit;
}

require_once __DIR__ . '/../db_connect.php';

$user_id = $_SESSION['user_id'];
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 5;

try {
    // Get unread notifications
    $query = "SELECT notification_id, title, message, type, created_at, is_read 
              FROM user_notifications 
              WHERE user_id = ? 
              ORDER BY created_at DESC 
              LIMIT ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $user_id, $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $notifications = array();
    $unread_count = 0;
    
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
        if ($row['is_read'] == 0) {
            $unread_count++;
        }
    }
    
    $stmt->close();
    
    // Get total unread count
    $count_query = "SELECT COUNT(*) as total FROM user_notifications WHERE user_id = ? AND is_read = 0";
    $count_stmt = $conn->prepare($count_query);
    $count_stmt->bind_param("i", $user_id);
    $count_stmt->execute();
    $count_result = $count_stmt->get_result();
    $count_row = $count_result->fetch_assoc();
    $total_unread = $count_row['total'];
    $count_stmt->close();
    
    $conn->close();
    
    echo json_encode(array(
        'success' => true,
        'notifications' => $notifications,
        'unread_count' => $total_unread
    ));
    
} catch (Exception $e) {
    echo json_encode(array(
        'success' => false,
        'message' => 'Error fetching notifications: ' . $e->getMessage()
    ));
}
?>
