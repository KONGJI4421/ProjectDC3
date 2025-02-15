<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <?php 
        include 'assets/scriptheader.php';
    ?>
    <style>
        
        /* พื้นหลัง */
        body {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: #fff;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* เพิ่มเลเยอร์แสง */
        .background-layer {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1), rgba(0, 0, 0, 0) 70%);
        }

        .blur-light {
            position: absolute;
            top: 20%;
            left: 20%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.3);
            filter: blur(100px);
            border-radius: 50%;
            animation: move-light 8s infinite alternate;
        }

        .blur-light-2 {
            top: 60%;
            left: 60%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
        }

        @keyframes move-light {
            0% {
                transform: translate(0, 0);
            }
            100% {
                transform: translate(50px, 50px);
            }
        }

        /* จัดรูปแบบการ์ด */
        .card {
            background: rgba(30, 44, 74, 0.7); /* โปร่งแสงมากขึ้น */
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            animation: fadeIn 1s ease-in-out;
        }

        /* เอฟเฟกต์ Fade-in */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

    </style>
</head>
<body>

<!-- เลเยอร์แสง -->
<div class="background-layer"></div>
<div class="blur-light"></div>
<div class="blur-light blur-light-2"></div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-3 col-md-6 col-sm-12" >
            <div class="card p-4">
                <div class="card-body">
                    <h2 class="text-center mb-4 text-warning">เข้าสู่ระบบ</h2>
                    <form action="authenticate.php" method="post" id="loginForm">
                        <div class="mb-3">
                            <label for="username" class="form-label text-light">ชื่อผู้ใช้:</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                            <div class="invalid-feedback">โปรดกรอกชื่อผู้ใช้</div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label text-light">รหัสผ่าน:</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                            <div class="invalid-feedback">โปรดกรอกรหัสผ่าน</div>
                        </div>
                        <input type="submit" name='login' class="btn btn-primary w-100" value="เข้าสู่ระบบ">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
