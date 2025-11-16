<?php
// Simple JSON endpoint returning active hotlines (for polling/SSE clients)
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../db.php';

$out = [];
try {
    if (isset($pdo) && $pdo) {
        $stmt = $pdo->query("SELECT id, name, phone, category, icon, color, is_active FROM hotlines WHERE is_active=1 ORDER BY sort_order, created_at DESC");
        $out = $stmt->fetchAll();
    }
} catch (Exception $e) {
    // log and return empty
    error_log('API hotlines error: ' . $e->getMessage());
}

echo json_encode(['hotlines' => $out]);

?>
