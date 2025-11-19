<?php
/**
 * AJAX Handler for User Settings Update
 * Updates user preference settings
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
if (!isset($_POST['setting_key']) || !isset($_POST['setting_value'])) {
    echo json_encode(array('success' => false, 'message' => 'Missing required data'));
    exit;
}

$setting_key = $_POST['setting_key'];
$setting_value = $_POST['setting_value'];

// Validate setting key (whitelist)
$valid_settings = array(
    'notifications_push',
    'notifications_email',
    'notifications_sms',
    'public_profile',
    'show_location',
    'activity_status'
);

if (!in_array($setting_key, $valid_settings)) {
    echo json_encode(array('success' => false, 'message' => 'Invalid setting key'));
    exit;
}

// Check if setting exists
$check_query = "SELECT setting_id FROM user_settings WHERE user_id = ? AND setting_key = ?";
$check_stmt = $conn->prepare($check_query);
$check_stmt->bind_param("is", $user_id, $setting_key);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows > 0) {
    // Update existing setting
    $update_query = "UPDATE user_settings SET setting_value = ?, updated_at = NOW() WHERE user_id = ? AND setting_key = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("sis", $setting_value, $user_id, $setting_key);
    
    if ($update_stmt->execute()) {
        echo json_encode(array(
            'success' => true,
            'message' => 'Setting updated'
        ));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Error updating setting'));
    }
} else {
    // Insert new setting
    $insert_query = "INSERT INTO user_settings (user_id, setting_key, setting_value) VALUES (?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param("iss", $user_id, $setting_key, $setting_value);
    
    if ($insert_stmt->execute()) {
        echo json_encode(array(
            'success' => true,
            'message' => 'Setting saved'
        ));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Error saving setting'));
    }
}

$conn->close();
?>
