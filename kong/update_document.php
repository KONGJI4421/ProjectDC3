<?php
// เชื่อมต่อฐานข้อมูล
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['file_name']) && isset($_FILES['file'])) {
    $targetDir = "uploads/";
    $fileName = basename($_POST['file_name']); // รับชื่อไฟล์และป้องกัน Directory Traversal
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); // ตรวจสอบนามสกุลไฟล์

    // ตรวจสอบประเภทไฟล์
    $allowedTypes = ['pdf', 'xls', 'xlsx'];
    if (!in_array(strtolower($fileType), $allowedTypes)) {
        echo "อนุญาตเฉพาะไฟล์ PDF และ Excel (.xls, .xlsx) เท่านั้น";
        exit;
    }

    // ตรวจสอบว่าไฟล์มีอยู่ในระบบหรือไม่
    if (file_exists($targetFilePath)) {
        // ตรวจสอบว่าไฟล์ที่อัปโหลดเป็นของแท้หรือไม่
        $fileTmpPath = $_FILES["file"]["tmp_name"];
        $mimeType = mime_content_type($fileTmpPath);

        if (!in_array($mimeType, ['application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])) {
            echo "ไฟล์ไม่ถูกต้อง กรุณาอัปโหลดไฟล์ที่ถูกต้อง";
            exit;
        }

        // ทับไฟล์เดิม
        if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
            $uploadDate = date("Y-m-d H:i:s");

            // ใช้ Prepared Statement ป้องกัน SQL Injection
            $sql = "UPDATE documents SET upload_date=? WHERE file_name=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $uploadDate, $fileName);

            if ($stmt->execute()) {
                echo "แก้ไขไฟล์สำเร็จ!";
            } else {
                error_log("เกิดข้อผิดพลาดในการอัปเดตฐานข้อมูล: " . $stmt->error);
                echo "เกิดข้อผิดพลาดในการอัปเดตฐานข้อมูล.";
            }

            $stmt->close();
        } else {
            error_log("เกิดข้อผิดพลาดในการทับไฟล์: " . $_FILES["file"]["error"]);
            echo "เกิดข้อผิดพลาดในการทับไฟล์.";
        }
    } else {
        echo "ไม่พบไฟล์ที่ต้องการแก้ไข.";
    }
} else {
    echo "ข้อมูลไม่ครบถ้วน.";
}

header("Location: index.php");
exit;
?>
