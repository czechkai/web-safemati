<?php
/**
 * AJAX Handler for Bookmark Toggle
 * Adds or removes a disaster guide from user's bookmarks
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
if (!isset($_POST['guide_id'])) {
    echo json_encode(array('success' => false, 'message' => 'Guide ID not provided'));
    exit;
}

$guide_id = intval($_POST['guide_id']);

// Check if bookmark exists
$check_query = "SELECT bookmark_id FROM user_bookmarked_guides WHERE user_id = ? AND guide_id = ?";
$check_stmt = $conn->prepare($check_query);
$check_stmt->bind_param("ii", $user_id, $guide_id);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows > 0) {
    // Bookmark exists, remove it
    $delete_query = "DELETE FROM user_bookmarked_guides WHERE user_id = ? AND guide_id = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param("ii", $user_id, $guide_id);
    
    if ($delete_stmt->execute()) {
        echo json_encode(array(
            'success' => true,
            'action' => 'removed',
            'message' => 'Guide removed from bookmarks'
        ));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Error removing bookmark'));
    }
} else {
    // Bookmark doesn't exist, add it
    $insert_query = "INSERT INTO user_bookmarked_guides (user_id, guide_id) VALUES (?, ?)";
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param("ii", $user_id, $guide_id);
    
    if ($insert_stmt->execute()) {
        echo json_encode(array(
            'success' => true,
            'action' => 'added',
            'message' => 'Guide added to bookmarks'
        ));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Error adding bookmark'));
    }
}

$conn->close();
?>
