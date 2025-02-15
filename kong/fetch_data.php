<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];

$data = json_decode(file_get_contents("fetch_data.php"), true);
?>

<table border="1">
    <tr>
        <th>ชื่อเอกสาร</th>
        <th>วันที่อัปโหลด</th>
        <th>สถานะ</th>
        <?php if ($role === 'manager') { ?>
            <th>การจัดการ</th>
        <?php } ?>
    </tr>
    <?php foreach ($data as $row) { ?>
        <tr>
            <td><?= htmlspecialchars($row['document_name']) ?></td>
            <td><?= htmlspecialchars($row['upload_date']) ?></td>
            <td><?= htmlspecialchars($row['approval_status']) ?></td>
            <?php if ($role === 'manager') { ?>
                <td>
                    <button onclick="updateApproval(<?= $row['id'] ?>, 'approved')">อนุมัติ</button>
                    <button onclick="updateApproval(<?= $row['id'] ?>, 'rejected')">ไม่อนุมัติ</button>
                </td>
            <?php } ?>
        </tr>
    <?php } ?>
</table>

<script>
function updateApproval(documentId, status) {
    if (confirm("คุณต้องการ " + (status === 'approved' ? "อนุมัติ" : "ไม่อนุมัติ") + " เอกสารนี้หรือไม่?")) {
        fetch('update_approval.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'id=' + documentId + '&status=' + status
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload();
        });
    }
}
</script>
