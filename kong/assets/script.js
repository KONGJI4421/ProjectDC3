// ตรวจสอบฟอร์มก่อนส่ง
document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");
    const fileInput = document.getElementById("file");
    const departmentInput = document.getElementById("department");
    const contentInput = document.getElementById("document_content");
    const deadlineInput = document.getElementById("deadline");


    form.addEventListener("submit", function(event) {
        let isValid = true;

        // ตรวจสอบว่าผู้ใช้เลือกไฟล์แล้ว
        if (!fileInput.value) {
            alert("กรุณาเลือกไฟล์ PDF");
            isValid = false;
        }
        if (!departmentInput.value) {
            alert("กรุณาเลือกแผนก");
            isValid = false;
        }
        if (!contentInput.value.trim()) {
            alert("กรุณากรอกเนื้อหาของเอกสาร");
            isValid = false;
        }
        if (!deadlineInput.value) {
            alert("กรุณาเลือกเวลาที่กำหนดส่ง");
            isValid = false;
        }

        // ถ้ามีข้อผิดพลาด หยุดการส่งฟอร์ม
        if (!isValid) {
            event.preventDefault();
            return;
        }
        document.addEventListener("DOMContentLoaded", function() {
            const uploadForm = document.getElementById("uploadForm");
        
            uploadForm.addEventListener("submit", function(event) {
                event.preventDefault();
        
                let formData = new FormData(uploadForm);
        
                fetch("upload.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: 'อัปโหลดสำเร็จ!',
                        text: data,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => location.reload());
                })
                .catch(error => {
                    console.error("Error:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด!',
                        text: 'ไม่สามารถอัปโหลดไฟล์ได้'
                    });
                });
            });
        });
        
    });
});

