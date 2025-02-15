<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัติการส่งเอกสาร</title>
    <?php 
        include 'assets/scriptheader.php';
    ?>
    <style>
        /* Updated Background Styling */
        body {
            margin: 0;
            padding: 0;
            font-family: "Roboto", sans-serif;
            background: linear-gradient(135deg, #1e3c72, #2a5298, #ffcc00);
            background-size: 300% 300%;
            animation: gradientBG 12s ease infinite;
            color: #fff;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            margin: 20px auto;
            padding: 20px;
            max-width: 1200px;
            background: rgba(0, 0, 0, 0.6);
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 2rem;
            color: #ffcc00;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .btn-upload {
            background: #ffcc00;
            color: #1e3c72;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            transition: background 0.3s ease, color 0.3s ease;
        }

        .btn-upload:hover {
            background: #ffd633;
            color: #2a5298;
        }

        .tableFixHead {
            overflow-y: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table thead {
            background: linear-gradient(90deg, #1e3c72, #2a5298);
            color: #fff;
        }

        .table th, .table td {
            padding: 10px;
            text-align: center;
        }

        .table tbody tr {
            background: rgba(255, 255, 255, 0.1);
            transition: background 0.3s ease;
        }

        .table tbody tr:hover {
            background: rgba(255, 204, 0, 0.2);
        }

        .chart-container {
            margin-top: 30px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .chart-container h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #ffcc00;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>ประวัติการส่งเอกสาร</h1>
            <a href="index.php" class="btn-upload">ย้อนกลับ</a>
        </div>

        <!-- ตาราง -->
        <div class="container chart-container">
            <div class="table-responsive tableFixHead" style="height:350px;">
            <?php
                include 'db.php'; // เชื่อมต่อกับฐานข้อมูล
                $result = $conn->query("SELECT * FROM documents ORDER BY upload_date DESC");
            ?>
                <table class="table text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>ชื่อผู้ส่ง</th>
                            <th>แผนก</th>
                            <th>เนื้อหาของเอกสาร</th>
                            <th>เวลาที่กำหนดส่ง</th>
                            <th>วันที่ส่ง</th>
                            <th>ดูไฟล์</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['sender_name']; ?></td>
                                <td><?php echo $row['department']; ?></td>
                                <td><?php echo $row['document_content']; ?></td>
                                <td><?php echo $row['deadline']; ?></td>
                                <td><?php echo $row['upload_date']; ?></td>
                                <td><a href="uploads/<?php echo $row['file_name']; ?>" target="_blank" class="btn btn-sm btn-primary">เปิดดู</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

                <!-- กราฟ -->
                <div class="chart-container">
                    <h2>จำนวนไฟล์ที่ส่งต่อวัน</h2>
                    <canvas id="documentChart"></canvas>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
    // ดึงข้อมูลจาก PHP
    fetch('fetch_data.php') // ไฟล์ PHP ที่ดึงข้อมูลจากฐานข้อมูล
        .then(response => response.json())
        .then(data => {
            // ใช้ข้อมูลที่ได้แสดงกราฟ
            const ctx = document.getElementById('documentChart').getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(229, 26, 53, 0.8)');
            gradient.addColorStop(1, 'rgba(30, 60, 114, 0.8)');

            new Chart(ctx, {
                type: 'bar', // กราฟแท่ง
                data: {
                    labels: data.labels, // วันที่จาก PHP
                    datasets: [{
                        label: 'จำนวนไฟล์ที่ส่ง',
                        data: data.values, // จำนวนไฟล์จาก PHP
                        backgroundColor: gradient,
                        borderColor: 'rgba(250, 209, 44, 0.48)',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: '#fff',
                                font: {
                                    size: 14
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: '#ffcc00',
                            titleColor: '#1e3c72',
                            bodyColor: '#1e3c72',
                            borderColor: '#ffd633',
                            borderWidth: 1
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: '#fff',
                                font: {
                                    size: 12
                                }
                            },
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#fff',
                                font: {
                                    size: 12
                                },
                                callback: function(value) {
                                    return value + ' ไฟล์';
                                }
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.2)'
                            }
                        }
                    }
                }
            });
        });
</script>

</body>
</html>