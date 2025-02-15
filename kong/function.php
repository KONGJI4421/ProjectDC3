<?php
session_start();

function checkAuthenlogin(){
    if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])){
        header('Location: login.php');
        exit();
    }
}

function convertDateTime($datetime) {
    $months = [
        'January' => 'มกราคม', 'February' => 'กุมภาพันธ์', 'March' => 'มีนาคม',
        'April' => 'เมษายน', 'May' => 'พฤษภาคม', 'June' => 'มิถุนายน',
        'July' => 'กรกฎาคม', 'August' => 'สิงหาคม', 'September' => 'กันยายน',
        'October' => 'ตุลาคม', 'November' => 'พฤศจิกายน', 'December' => 'ธันวาคม'
    ];

    try {
        $dateObj = new DateTime($datetime);
    } catch (Exception $e) {
        return "Invalid date/time format";
    }

    $day = $dateObj->format('d');
    $month = $months[$dateObj->format('F')] ?? $dateObj->format('F');
    $year = $dateObj->format('Y');
    $time = $dateObj->format('H:i');

    return "{$day} {$month} {$year} เวลา {$time}";

    
}
?>
