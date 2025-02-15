<?php
include 'db.php';

$sql = "SELECT 
            COUNT(*) AS total, 
            SUM(approval_status='approved') AS approved, 
            SUM(approval_status='rejected') AS rejected, 
            SUM(approval_status='pending' OR approval_status IS NULL) AS pending
        FROM documents WHERE isActive = 1";

$result = $conn->query($sql);
$summary = $result->fetch_assoc();
?>
<div class="row mb-3">
    <div class="col-md-3">
        <div class="alert alert-primary">เอกสารทั้งหมด: <?= $summary['total'] ?? 0; ?> รายการ</div>
    </div>
    <div class="col-md-3">
        <div class="alert alert-success">อนุมัติแล้ว: <?= $summary['approved'] ?? 0; ?> รายการ</div>
    </div>
    <div class="col-md-3">
        <div class="alert alert-danger">ไม่อนุมัติ: <?= $summary['rejected'] ?? 0; ?> รายการ</div>
    </div>
    <div class="col-md-3">
        <div class="alert alert-warning">รออนุมัติ: <?= $summary['pending'] ?? 0; ?> รายการ</div>
    </div>
</div>
