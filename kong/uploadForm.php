<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $filePath = $_POST['filePath'];
    $newFile = $_FILES['newFile'];

    // ตรวจสอบข้อผิดพลาดการอัปโหลด
    if ($newFile['error'] === UPLOAD_ERR_OK) {
        $fileType = mime_content_type($newFile['tmp_name']); // ตรวจสอบ MIME Type
        $allowedTypes = [
            'application/pdf',                     // PDF
            'application/vnd.ms-excel',            // XLS (Excel เก่า)
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' // XLSX (Excel ใหม่)
        ];

        // ตรวจสอบว่าไฟล์ที่อัปโหลดอยู่ในประเภทที่อนุญาตหรือไม่
        if (in_array($fileType, $allowedTypes)) {
            $tempName = $newFile['tmp_name'];

            // ย้ายไฟล์ใหม่ไปยังตำแหน่งเดิม
            if (move_uploaded_file($tempName, $filePath)) {
                echo "ไฟล์ถูกอัปโหลดสำเร็จ!";
            } else {
                echo "เกิดข้อผิดพลาดในการบันทึกไฟล์.";
            }
        } else {
            echo "อนุญาตเฉพาะไฟล์ PDF และ Excel (.xls, .xlsx) เท่านั้น.";
        }
    } else {
        echo "เกิดข้อผิดพลาดในการอัปโหลดไฟล์.";
    }
}
?>
