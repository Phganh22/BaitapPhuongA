<?php

$lichHen = [];

function xepLoaiLichHen($ngayHen)
{
    $homNay = date("Y-m-d");

    if ($ngayHen >= $homNay) {
        return "Còn hiệu lực";
    } else {
        return "Đã quá hạn";
    }
}

if (isset($_POST['dat_lich'])) {

    $sinhVien = $_POST['sinh_vien'];
    $giangVien = $_POST['giang_vien'];
    $ngayHen = $_POST['ngay_hen'];
    $noiDung = $_POST['noi_dung'];

    $lichHen[] = [
        "sinh_vien" => $sinhVien,
        "giang_vien" => $giangVien,
        "ngay_hen" => $ngayHen,
        "noi_dung" => $noiDung
    ];
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Đặt lịch tư vấn với giảng viên</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            color: #1f2937;
        }

        .header {
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .header h1 {
            font-size: 30px;
            margin-bottom: 8px;
        }

        .header p {
            font-size: 15px;
            opacity: 0.9;
        }

        .container {
            width: 90%;
            max-width: 1100px;
            margin: 35px auto;
        }

        .card {
            background: white;
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.07);
        }

        .card-title {
            font-size: 21px;
            font-weight: bold;
            margin-bottom: 25px;
            color: #1e3a8a;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full {
            grid-column: 1 / 3;
        }

        label {
            font-weight: bold;
            margin-bottom: 8px;
            color: #374151;
        }

        input,
        textarea {
            width: 100%;
            padding: 13px 15px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: 15px;
            outline: none;
            transition: 0.2s;
        }

        input:focus,
        textarea:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        textarea {
            resize: vertical;
            min-height: 110px;
        }

        .button-area {
            margin-top: 25px;
            text-align: right;
        }

        button {
            border: none;
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            color: white;
            padding: 13px 28px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(37, 99, 235, 0.3);
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 10px;
        }

        th {
            background: #2563eb;
            color: white;
            padding: 14px;
            text-align: left;
            font-size: 14px;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }

        tr:hover td {
            background: #f8fafc;
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
            background: #dcfce7;
            color: #166534;
        }

        .empty {
            text-align: center;
            color: #6b7280;
            padding: 25px;
        }

        .footer {
            text-align: center;
            padding: 25px;
            color: #6b7280;
            font-size: 14px;
        }

        @media (max-width: 700px) {

            .header h1 {
                font-size: 23px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full {
                grid-column: auto;
            }

            .card {
                padding: 20px;
            }

            .button-area {
                text-align: center;
            }

            button {
                width: 100%;
            }
        }

    </style>
</head>

<body>

    <header class="header">
        <h1> Đặt lịch tư vấn với giảng viên</h1>
        <p>Hệ thống hỗ trợ sinh viên đăng ký lịch hẹn và tư vấn học tập</p>
    </header>

    <main class="container">

        <section class="card">

            <div class="card-title">
                 Đăng ký lịch hẹn
            </div>

            <form method="POST">

                <div class="form-grid">

                    <div class="form-group">
                        <label>Tên sinh viên</label>
                        <input
                            type="text"
                            name="sinh_vien"
                            placeholder="Nhập tên sinh viên"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Tên giảng viên</label>
                        <input
                            type="text"
                            name="giang_vien"
                            placeholder="Nhập tên giảng viên"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Ngày hẹn</label>
                        <input
                            type="date"
                            name="ngay_hen"
                            required>
                    </div>

                    <div class="form-group full">
                        <label>Nội dung tư vấn</label>
                        <textarea
                            name="noi_dung"
                            placeholder="Nhập nội dung bạn muốn trao đổi với giảng viên..."
                            required></textarea>
                    </div>

                </div>

                <div class="button-area">
                    <button type="submit" name="dat_lich">
                         Đặt lịch hẹn
                    </button>
                </div>

            </form>

        </section>


        <?php if (!empty($lichHen)): ?>

            <section class="card">

                <div class="card-title">
                     Danh sách lịch hẹn
                </div>

                <div class="table-wrapper">

                    <table>

                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Sinh viên</th>
                                <th>Giảng viên</th>
                                <th>Ngày hẹn</th>
                                <th>Nội dung tư vấn</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php $stt = 1; ?>

                            <?php foreach ($lichHen as $lich): ?>

                                <tr>

                                    <td>
                                        <?= $stt ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($lich['sinh_vien']) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($lich['giang_vien']) ?>
                                    </td>

                                    <td>
                                        <?= $lich['ngay_hen'] ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($lich['noi_dung']) ?>
                                    </td>

                                    <td>
                                        <span class="status">
                                            <?= xepLoaiLichHen($lich['ngay_hen']) ?>
                                        </span>
                                    </td>

                                </tr>

                                <?php $stt++; ?>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            </section>

        <?php endif; ?>

    </main>

    <footer class="footer">
        Hệ thống đặt lịch hẹn / tư vấn với giảng viên 2026
    </footer>

</body>

</html>