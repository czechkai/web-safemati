<?php
/**
 * AJAX Handler for Favorite Hotline Toggle
 * Adds or removes a hotline from user's favorites
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
if (!isset($_POST['hotline_id'])) {
    echo json_encode(array('success' => false, 'message' => 'Hotline ID not provided'));
    exit;
}

$hotline_id = intval($_POST['hotline_id']);

// Check if favorite exists
$check_query = "SELECT favorite_id FROM user_favorite_hotlines WHERE user_id = ? AND hotline_id = ?";
$check_stmt = $conn->prepare($check_query);
$check_stmt->bind_param("ii", $user_id, $hotline_id);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows > 0) {
    // Favorite exists, remove it
    $delete_query = "DELETE FROM user_favorite_hotlines WHERE user_id = ? AND hotline_id = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param("ii", $user_id, $hotline_id);
    
    if ($delete_stmt->execute()) {
        echo json_encode(array(
            'success' => true,
            'action' => 'removed',
            'message' => 'Hotline removed from favorites'
        ));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Error removing favorite'));
    }
} else {
    // Favorite doesn't exist, add it
    $insert_query = "INSERT INTO user_favorite_hotlines (user_id, hotline_id) VALUES (?, ?)";
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param("ii", $user_id, $hotline_id);
    
    if ($insert_stmt->execute()) {
        echo json_encode(array(
            'success' => true,
            'action' => 'added',
            'message' => 'Hotline added to favorites'
        ));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Error adding favorite'));
    }
}

$conn->close();
?>
