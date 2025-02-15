<?php
session_start(); // ต้องใส่เพื่อดึง session

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $documentTitle = $_POST['document_title'] ?? '';
    $department = $_POST['department'] ?? '';
    $deadline = $_POST['deadline'] ?? '';
    $uploadDate = date("Y-m-d H:i:s");
    $senderName = $_SESSION['user_id'] ?? '';
    $fileName = basename($_FILES["file"]["name"]);
    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
    $targetDir = "uploads/";
    $newFileName = uniqid() . "." . $fileType;
    $targetFilePath = $targetDir . $newFileName;
    $isActive = 1;

    // ตรวจสอบโฟลเดอร์ uploads
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // ตรวจสอบประเภทไฟล์
    $allowedTypes = ['pdf', 'xls', 'xlsx'];
    if (!in_array(strtolower($fileType), $allowedTypes)) {
        echo "อนุญาตเฉพาะไฟล์ PDF และ Excel (.xls, .xlsx) เท่านั้น";
        exit;
    }

    // ตรวจสอบ MIME Type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $_FILES["file"]["tmp_name"]);
    finfo_close($finfo);
    
    if (!in_array($mimeType, ['application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])) {
        echo "ไฟล์ไม่ถูกต้อง กรุณาอัปโหลดเฉพาะ PDF หรือ Excel";
        exit;
    }

    // ตรวจสอบการอัปโหลดไฟล์
    if (!move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
        echo "เกิดข้อผิดพลาดในการอัปโหลดไฟล์. รหัสข้อผิดพลาด: " . $_FILES["file"]["error"];
        exit;
    }

    // Debug ตรวจสอบค่าที่จะบันทึก
    var_dump([
        'documentTitle' => $documentTitle,
        'department' => $department,
        'uploadDate' => $uploadDate,
        'deadline' => $deadline,
        'senderName' => $senderName,
        'fileName' => $newFileName,
        'isActive' => $isActive
    ]);

    // บันทึกลงฐานข้อมูล
    $sql = "INSERT INTO documents (document_content, department, upload_date, sender_name, deadline, file_name, isActive) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $documentTitle, $department, $uploadDate, $senderName, $deadline, $newFileName, $isActive);

    if ($stmt->execute()) {
        echo "อัปโหลดไฟล์สำเร็จ!";
    } else {
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "ไม่มีไฟล์ที่อัปโหลด หรือข้อมูลไม่ครบถ้วน.";
}
?>
