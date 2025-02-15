<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar สีพาสเทล</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* กำหนดสีพื้นหลังและสีตัวอักษรที่สามารถแก้ไขได้ */
        body {
            background-color:#E8E8E9; /* สีฟ้าอ่อน */
        }
        .navbar-custom {
            background-color:#2A505A!important; /* สีพาสเทลฟ้า */
        }
        .navbar-text-custom {
            color:rgb(253, 255, 250) !important; /* สีตัวอักษรเข้ม */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <div class="logo-container">
                <img src="img/logo.png" alt="โลโก้" class="logo">
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-lg-0 mt-1">
                    <li class="nav-item">
                        <a class="nav-link navbar-text-custom" href="index01.php">Dashboard</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle navbar-text-custom" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            จัดการระบบ
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">จัดการผู้ใช้งาน</a></li>
                            <li><a class="dropdown-item" href="#">จัดการแผนก</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">อื่นๆ</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <span class="navbar-text me-3 navbar-text-custom">
                        ยินดีต้อนรับ คุณ: <span class="fw-bold"> <?= htmlspecialchars($_SESSION['first_name']); ?> </span>
                    </span>
                    <a href="logout.php" class="btn btn-danger">ออกจากระบบ</a>
                </div>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
