<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัติการส่งเอกสาร</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>ประวัติการส่งเอกสาร</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ชื่อไฟล์</th>
                <th>แผนก</th>
                <th>วันที่ส่ง</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'db.php';
            $result = $conn->query("SELECT * FROM documents ORDER BY upload_date DESC");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['file_name']}</td>
                        <td>{$row['department']}</td>
                        <td>{$row['upload_date']}</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
