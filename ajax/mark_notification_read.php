<?php
/**
 * AJAX Handler for Mark Notification as Read
 * Marks a single notification or all notifications as read
 */

session_start();
require_once '../db_connect.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(array('success' => false, 'message' => 'User not logged in'));
    exit;
}

$user_id = $_SESSION['user_id'];

// Check if marking all or single notification
if (isset($_POST['mark_all']) && $_POST['mark_all'] == '1') {
    // Mark all notifications as read
    $update_query = "UPDATE user_notifications SET is_read = 1, read_at = NOW() WHERE user_id = ? AND is_read = 0";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("i", $user_id);
    
    if ($update_stmt->execute()) {
        $affected_rows = $update_stmt->affected_rows;
        echo json_encode(array(
            'success' => true,
            'count' => $affected_rows,
            'message' => 'All notifications marked as read'
        ));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Error marking notifications as read'));
    }
} elseif (isset($_POST['notification_id'])) {
    // Mark single notification as read
    $notification_id = intval($_POST['notification_id']);
    
    $update_query = "UPDATE user_notifications SET is_read = 1, read_at = NOW() WHERE notification_id = ? AND user_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ii", $notification_id, $user_id);
    
    if ($update_stmt->execute()) {
        echo json_encode(array(
            'success' => true,
            'message' => 'Notification marked as read'
        ));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Error marking notification as read'));
    }
} else {
    echo json_encode(array('success' => false, 'message' => 'No notification ID provided'));
}

$conn->close();
?>
