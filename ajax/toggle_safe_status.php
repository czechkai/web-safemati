<?php
/**
 * AJAX Handler for Mark as Safe Toggle
 * Updates user safety status for a specific alert
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

// Check if required data is provided
if (!isset($_POST['alert_id']) || !isset($_POST['is_safe'])) {
    echo json_encode(array('success' => false, 'message' => 'Missing required data'));
    exit;
}

$alert_id = intval($_POST['alert_id']);
$is_safe = $_POST['is_safe'] === 'true' ? 'safe' : 'unmarked';

// Check if safety status exists
$check_query = "SELECT safety_id FROM alert_safety_status WHERE user_id = ? AND alert_id = ?";
$check_stmt = $conn->prepare($check_query);
$check_stmt->bind_param("ii", $user_id, $alert_id);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows > 0) {
    // Update existing status
    $update_query = "UPDATE alert_safety_status SET status = ?, updated_at = NOW() WHERE user_id = ? AND alert_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("sii", $is_safe, $user_id, $alert_id);
    
    if ($update_stmt->execute()) {
        echo json_encode(array(
            'success' => true,
            'status' => $is_safe,
            'message' => 'Safety status updated'
        ));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Error updating status'));
    }
} else {
    // Insert new status
    $insert_query = "INSERT INTO alert_safety_status (user_id, alert_id, status) VALUES (?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param("iis", $user_id, $alert_id, $is_safe);
    
    if ($insert_stmt->execute()) {
        echo json_encode(array(
            'success' => true,
            'status' => $is_safe,
            'message' => 'Safety status saved'
        ));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Error saving status'));
    }
}

$conn->close();
?>
