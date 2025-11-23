<?php
session_start();
require_once '../db_connect.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);
$report_id = isset($data['report_id']) ? intval($data['report_id']) : 0;

if ($report_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid report ID']);
    exit;
}

// Verify the report belongs to this user
$check_query = "SELECT report_id, photo_path FROM user_reports WHERE report_id = ? AND user_id = ?";
$check_stmt = $conn->prepare($check_query);
$check_stmt->bind_param("ii", $report_id, $user_id);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Report not found or unauthorized']);
    exit;
}

$report = $result->fetch_assoc();

// Delete photo file if exists
if (!empty($report['photo_path']) && file_exists('../' . $report['photo_path'])) {
    unlink('../' . $report['photo_path']);
}

// Delete the report (this will cascade delete admin_notifications due to foreign key)
$delete_query = "DELETE FROM user_reports WHERE report_id = ? AND user_id = ?";
$delete_stmt = $conn->prepare($delete_query);
$delete_stmt->bind_param("ii", $report_id, $user_id);

if ($delete_stmt->execute()) {
    echo json_encode([
        'success' => true, 
        'message' => 'Emergency report deleted successfully'
    ]);
} else {
    echo json_encode([
        'success' => false, 
        'message' => 'Error deleting report. Please try again.'
    ]);
}

$delete_stmt->close();
$conn->close();
?>
