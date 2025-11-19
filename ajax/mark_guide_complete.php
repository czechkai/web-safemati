<?php
/**
 * AJAX Handler: Mark Guide as Complete
 * Updates user_guide_progress table and increments completion counter
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
$guide_id = isset($_POST['guide_id']) ? intval($_POST['guide_id']) : 0;

if ($guide_id === 0) {
    echo json_encode(array('success' => false, 'message' => 'Invalid guide ID'));
    exit;
}

try {
    // Check if already marked as complete
    $check_query = "SELECT * FROM user_guide_progress WHERE user_id = ? AND guide_id = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("ii", $user_id, $guide_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Update existing record
        $update_query = "UPDATE user_guide_progress SET is_completed = 1, completed_at = NOW() WHERE user_id = ? AND guide_id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("ii", $user_id, $guide_id);
        $update_stmt->execute();
        $update_stmt->close();
    } else {
        // Insert new record
        $insert_query = "INSERT INTO user_guide_progress (user_id, guide_id, is_completed, completed_at) VALUES (?, ?, 1, NOW())";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("ii", $user_id, $guide_id);
        $insert_stmt->execute();
        $insert_stmt->close();
    }
    
    $check_stmt->close();
    
    // Get updated progress statistics
    $stats_query = "SELECT COUNT(*) as total_completed FROM user_guide_progress WHERE user_id = ? AND is_completed = 1";
    $stats_stmt = $conn->prepare($stats_query);
    $stats_stmt->bind_param("i", $user_id);
    $stats_stmt->execute();
    $stats_result = $stats_stmt->get_result();
    $stats = $stats_result->fetch_assoc();
    $stats_stmt->close();
    
    $conn->close();
    
    echo json_encode(array(
        'success' => true,
        'message' => 'Guide marked as complete!',
        'total_completed' => $stats['total_completed']
    ));
    
} catch (Exception $e) {
    echo json_encode(array(
        'success' => false,
        'message' => 'Error marking guide complete: ' . $e->getMessage()
    ));
}
?>
