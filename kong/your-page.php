<?php
if (isset($_GET['status']) && $_GET['status'] === 'success') {
    echo "
    <div class='position-fixed top-50 start-50 translate-middle animate-toast' style='z-index: 11; width: 400px;'>
        <div id='liveToast' class='toast align-items-center text-bg-success border-0 show p-4 shadow-lg rounded-4' role='alert' aria-live='assertive' aria-atomic='true'>
            <div class='d-flex flex-column align-items-center'>
                <i class='bi bi-check-circle-fill mb-3 text-white icon-bounce' style='font-size: 3rem;'></i>
                <p class='mb-0 fs-4 text-white'>ลบข้อมูลสำเร็จ!</p>
            </div>
        </div>
    </div>
    <script>
        setTimeout(() => {
            window.location.href = 'index.php'; // ย้อนกลับไปหน้า index.php
        }, 2000); // รอ 2 วินาที
    </script>
    ";
} elseif (isset($_GET['status']) && $_GET['status'] === 'error') {
    echo "
    <div class='position-fixed top-50 start-50 translate-middle animate-toast' style='z-index: 11; width: 400px;'>
        <div id='liveToast' class='toast align-items-center text-bg-danger border-0 show p-4 shadow-lg rounded-4' role='alert' aria-live='assertive' aria-atomic='true'>
            <div class='d-flex flex-column align-items-center'>
                <i class='bi bi-x-circle-fill mb-3 text-white icon-bounce' style='font-size: 3rem;'></i>
                <p class='mb-0 fs-4 text-white'>เกิดข้อผิดพลาดในการลบข้อมูล!</p>
            </div>
        </div>
    </div>
    <script>
        setTimeout(() => {
            window.location.href = 'index.php'; // ย้อนกลับไปหน้า index.php
        }, 2000); // รอ  วินาที
    </script>
    ";
}
?>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<!-- Animation Styles -->
<style>
    .animate-toast {
        animation: slide-in 0.5s ease-out, slide-out 0.5s ease-in 2.5s forwards;
    }

    @keyframes slide-in {
        from {
            transform: translate(-50%, -70%);
            opacity: 0;
        }
        to {
            transform: translate(-50%, -50%);
            opacity: 1;
        }
    }

    @keyframes slide-out {
        from {
            transform: translate(-50%, -50%);
            opacity: 1;
        }
        to {
            transform: translate(-50%, -30%);
            opacity: 0;
        }
    }

    /* Animation for icon movement */
    .icon-bounce {
        animation: bounce 1s infinite;
    }

    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }
</style>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
