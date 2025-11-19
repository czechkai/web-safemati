<?php
/**
 * AJAX Handler: Upload Profile Picture
 * Handles image upload, validation, and database update
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

// Check if file was uploaded
if (!isset($_FILES['profile_picture']) || $_FILES['profile_picture']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(array('success' => false, 'message' => 'No file uploaded or upload error'));
    exit;
}

$file = $_FILES['profile_picture'];

// Validate file type
$allowed_types = array('image/jpeg', 'image/png', 'image/jpg', 'image/gif');
$file_type = mime_content_type($file['tmp_name']);

if (!in_array($file_type, $allowed_types)) {
    echo json_encode(array('success' => false, 'message' => 'Invalid file type. Only JPG, PNG, and GIF allowed.'));
    exit;
}

// Validate file size (max 5MB)
$max_size = 5 * 1024 * 1024; // 5MB in bytes
if ($file['size'] > $max_size) {
    echo json_encode(array('success' => false, 'message' => 'File too large. Maximum size is 5MB.'));
    exit;
}

try {
    // Create uploads directory if it doesn't exist
    $upload_dir = __DIR__ . '/../uploads/profiles/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    // Generate unique filename
    $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $new_filename = 'profile_' . $user_id . '_' . time() . '.' . $file_extension;
    $upload_path = $upload_dir . $new_filename;
    $db_path = 'uploads/profiles/' . $new_filename;
    
    // Delete old profile picture if exists
    $old_pic_query = "SELECT profile_picture FROM users WHERE user_id = ?";
    $old_pic_stmt = $conn->prepare($old_pic_query);
    $old_pic_stmt->bind_param("i", $user_id);
    $old_pic_stmt->execute();
    $old_pic_result = $old_pic_stmt->get_result();
    $old_pic_data = $old_pic_result->fetch_assoc();
    $old_pic_stmt->close();
    
    if ($old_pic_data && !empty($old_pic_data['profile_picture'])) {
        $old_file_path = __DIR__ . '/../' . $old_pic_data['profile_picture'];
        if (file_exists($old_file_path)) {
            unlink($old_file_path);
        }
    }
    
    // Move uploaded file
    if (!move_uploaded_file($file['tmp_name'], $upload_path)) {
        throw new Exception('Failed to move uploaded file');
    }
    
    // Update database
    $update_query = "UPDATE users SET profile_picture = ? WHERE user_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("si", $db_path, $user_id);
    $update_stmt->execute();
    $update_stmt->close();
    
    $conn->close();
    
    echo json_encode(array(
        'success' => true,
        'message' => 'Profile picture updated successfully!',
        'image_url' => $db_path
    ));
    
} catch (Exception $e) {
    echo json_encode(array(
        'success' => false,
        'message' => 'Error uploading profile picture: ' . $e->getMessage()
    ));
}
?>
