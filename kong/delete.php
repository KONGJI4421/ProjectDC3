<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// เชื่อมต่อฐานข้อมูล
include 'db.php';

$response = ['success' => false, 'message' => 'ไม่สามารถลบเอกสารได้'];

// ตรวจสอบว่าได้รับค่า document_id หรือไม่
if (!isset($_POST['document_id']) || empty($_POST['document_id'])) {
    $response['message'] = 'Document ID ไม่ถูกต้อง';
    echo json_encode($response);
    exit;
}

$doc_id = intval($_POST['document_id']); // แปลงค่าให้เป็นตัวเลข

// ตรวจสอบว่าเอกสารนี้มีอยู่จริงหรือไม่
$check_stmt = $conn->prepare("SELECT id FROM documents WHERE id = ?");
$check_stmt->bind_param("i", $doc_id);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows === 0) {
    $response['message'] = 'ไม่พบเอกสารในระบบ';
    echo json_encode($response);
    exit;
}

// ลบเอกสารออกจากฐานข้อมูล
$delete_stmt = $conn->prepare("DELETE FROM documents WHERE id = ?");
$delete_stmt->bind_param("i", $doc_id);

if ($delete_stmt->execute()) {
    $response = [
        'success' => true,
        'message' => 'ลบข้อมูลเรียบร้อยแล้ว'
    ];
} else {
    $response['message'] = 'เกิดข้อผิดพลาดในการลบเอกสาร';
}

echo json_encode($response);
?>
