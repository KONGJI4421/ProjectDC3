<?php
include 'db.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ตรวจสอบข้อมูลในฐานข้อมูล
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // ตรวจสอบรหัสผ่าน
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['role'] = $user['user_roles'];
            header('Location: index.php');
            exit;
        } else {
            echo htmlspecialchars("รหัสผ่านไม่ถูกต้อง");
        }
    } else {
        echo htmlspecialchars("ชื่อผู้ใช้ไม่ถูกต้อง"); 
    }
    /*
    โค้ดเข้ารหัส
    $new_password="123";
    $hash_password = password_hash( $new_password, PASSWORD_DEFAULT );
    $sql = $conn->prepare("UPDATE users SET password= ?");
    $sql -> execute([$hash_password]);
    */ 
} 
else {
    header("Location: login.php");
    exit;
}
?>
