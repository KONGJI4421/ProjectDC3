<?php
include 'function.php';
checkAuthenlogin();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requesting documents</title>
    <?php include 'assets/scriptheader.php'; ?>
</head>
<body>
    <?php include 'component/navbar.php'; ?>

    <section class="intro mt-5">
        <div class="mask d-flex align-items-center h-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6">
                                <h3 class="text-dark">Requesting Documents</h3>
                            </div>
                            <div class="col-lg-6 text-end">
                                <button class="btn btn-success" id="openUploadModal" data-bs-toggle="modal" data-bs-target="#uploadDocumentModal">
                                    + เพิ่มเอกสาร
                                        </button>
                                    <!--  Modal เพิ่มเอกสาร -->
                                        <div class="modal fade" id="uploadDocumentModal" tabindex="-1" aria-labelledby="uploadDocumentModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">เพิ่มเอกสาร</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="uploadDocumentForm" method="post" enctype="multipart/form-data" action="upload.php">
                                                            <div class="mb-3">
                                                                <label for="document_title" class="form-label text-start w-100">หัวข้อเอกสาร:</label>
                                                                <input type="text" class="form-control" id="document_title" name="document_title" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="department" class="form-label text-start w-100">แผนก:</label>
                                                                <select class="form-select" id="department" name="department" required>
                                                                    <option value="ฝ่ายไอที">IT</option>
                                                                    <option value="ฝ่ายบัญชี">ACC</option>
                                                                    <option value="ฝ่ายQA">QA</option>
                                                                    <option value="ฝ่ายช่าง">Maintenance</option>
                                                                    <option value="ฝ่ายผลิต">Production</option>
                                                                    <option value="ฝ่ายความปลอดภัย">Safety</option>
                                                                </select>
                                                                <div class="mb-3">
                                                                    <label for="fileUpload" class="form-label text-start w-100">เลือกไฟล์ (PDF หรือ Excel):</label>
                                                                    <input type="file" class="form-control" name="newFile" id="fileUpload" accept=".pdf, .xls, .xlsx" required>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="deadline" class="form-label text-start w-100">กำหนดส่ง:</label>
                                                                    <input type="datetime-local" class="form-control" id="deadline" name="deadline" required>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ยกเลิก</button>
                                                                    <button type="submit" class="btn btn-primary">อัปโหลด</button>
                                                                </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- สรุปเอกสาร -->
                                <?php include 'summary.php'; ?>
                                
                                <!-- ฟอร์มค้นหา -->
                                <?php include 'filter_form.php'; ?>

                                <div class="col-12 mt-4">
                                <div class="col-12 mt-4">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <!-- ✅ ใช้ table-container ควบคุม scroll -->
                                    <div class="table-container">
                                        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                                            <table class="table table-striped table-bordered">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th>หัวข้อเอกสาร</th>
                                                        <th>แผนก</th>
                                                        <th>วันที่อัพโหลด</th>
                                                        <th>อัพโหลดโดย</th>
                                                        <th>วันกำหนดส่ง</th>
                                                        <th>ดูไฟล์</th>
                                                        <th>สถานะ</th>
                                                        <?php if ($_SESSION['role'] == "user"): ?>
                                                            <th>แก้ไข</th>
                                                        <?php endif; ?>
                                                        <?php if ($_SESSION['role'] == "manager"): ?>
                                                            <th>อนุมัติ</th>
                                                            <th>ไม่อนุมัติ</th>
                                                            <th>ส่ง</th>
                                                            <th>ลบ</th>
                                                        <?php endif; ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include 'db.php';
                                                    $role = $_SESSION['role'];
                                                    $user_id = $_SESSION['user_id'];

                                                    $query = ($role === "manager") 
                                                        ? "SELECT doc.id, doc.document_content, doc.department, doc.upload_date, users.username AS sender_name, doc.deadline, doc.file_name, doc.approval_status
                                                        FROM documents doc
                                                        INNER JOIN users ON doc.sender_name = users.id
                                                        WHERE doc.isActive = 1
                                                        ORDER BY doc.upload_date DESC"
                                                        : "SELECT * FROM documents WHERE sender_name = ? AND isActive = 1 ORDER BY upload_date DESC";

                                                    $stmt = $conn->prepare($query);
                                                    if ($role !== "manager") {
                                                        $stmt->bind_param("s", $user_id);
                                                    }
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();

                                                    while ($row = $result->fetch_assoc()) { 
                                                        $filePath = "uploads/" . $row['file_name'];
                                                    ?>
                                                    <tr id="row-<?= $row['id']; ?>">
                                                        <td><?= htmlspecialchars($row['document_content']); ?></td>
                                                        <td><?= htmlspecialchars($row['department']); ?></td>
                                                        <td><?= htmlspecialchars($row['upload_date']); ?></td>
                                                        <td><?= htmlspecialchars($row['sender_name']); ?></td>
                                                        <td><?= htmlspecialchars($row['deadline']); ?></td>
                                                        <td>
                                                            <a href="<?= $filePath; ?>" target="_blank" class="btn btn-sm btn-primary">เปิดดู</a>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-<?= $row['approval_status'] === 'approved' ? 'success' : ($row['approval_status'] === 'rejected' ? 'danger' : 'warning'); ?>">
                                                                <?= $row['approval_status'] ?: 'pending'; ?>
                                                            </span>
                                                        </td>
                                                        <?php if ($_SESSION['role'] == "user"): ?>
                                                        <td>
                                                            <button class="btn btn-sm btn-warning">✏️ แก้ไข</button>
                                                        </td>
                                                        <?php endif; ?>
                                                        <?php if ($_SESSION['role'] == "manager"): ?>
                                                        <td>
                                                            <button class="btn btn-sm btn-success" onclick="updateApproval(<?= $row['id']; ?>, 'approved')">อนุมัติ</button>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-sm btn-danger" onclick="updateApproval(<?= $row['id']; ?>, 'rejected')">ไม่อนุมัติ</button>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-sm btn-info" onclick="sendDocument(<?= $row['id']; ?>)">📩 ส่ง</button>
                                                        </td>
                                                        <td>
                                                        <button class="btn btn-sm btn-danger delete-btn" data-id="deleteDocument(<?= $row['id']; ?>">🗑️ ลบ</button>

                                                        </td>
                                                        <?php endif; ?>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div> <!--  ปิด table-responsive -->
                                    </div> <!-- ปิด table-container -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
    function updateApproval(documentId, status) {
                $.post('update_approval.php', { id: documentId, status: status }, function(response) {
                    Swal.fire({
                        icon: "success",
                        title: "สำเร็จ!",
                        text: response,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => location.reload());
                }).fail(function() {
                    Swal.fire({
                        icon: "error",
                        title: "เกิดข้อผิดพลาด!",
                        text: "ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้"
                        
                    });
                });
            }
            </script>
            <script>
            $(document).ready(function() {
                $(".delete-btn").click(function() {
                    let documentId = $(this).data("id");

                    Swal.fire({
                        title: "ยืนยันการลบ?",
                        text: "คุณต้องการลบเอกสารนี้หรือไม่?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "ลบ!",
                        cancelButtonText: "ยกเลิก"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.post("delete.php", { document_id: documentId }, function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: "success",
                                        title: "ลบสำเร็จ!",
                                        text: response.message,
                                        timer: 1500,
                                        showConfirmButton: false
                                    }).then(() => {
                                        location.reload(); // รีเฟรชหน้าหลังจากลบ
                                    });
                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: "เกิดข้อผิดพลาด!",
                                        text: response.message
                                    });
                                }
                            }, "json");
                        }
                    });
                });
            });
            </script>
            </body>
            </html>
