<?php

$name = "";
$email = "";
$subject = "";
$content = "";
$avatar = "";

$errors = [];
$success = "";


$allowedSubjects = [
    "Hỏi bài / hỗ trợ học tập",
    "Báo lỗi",
    "Góp ý",
    "Đăng ký tư vấn",
    "Khác"
];

 KIỂM TRA KHI NGƯỜI DÙNG NHẤN "GỬI"


if ($_SERVER["REQUEST_METHOD"] === "POST") {

   

    // trim() loại bỏ khoảng trắng dư thừa ở đầu và cuối
    $name    = trim($_POST["name"] ?? "");
    $email   = trim($_POST["email"] ?? "");
    $subject = trim($_POST["subject"] ?? "");
    $content = trim($_POST["content"] ?? "");

    // Chuẩn hóa email về dạng chữ thường
    $email = strtolower($email);


   
    if ($name === "") {
        $errors["name"] = "Họ tên không được để trống.";
    } elseif (mb_strlen($name) < 2) {
        $errors["name"] = "Họ tên phải có ít nhất 2 ký tự.";
    } elseif (mb_strlen($name) > 50) {
        $errors["name"] = "Họ tên không được vượt quá 50 ký tự.";
    }




    if ($email === "") {
        $errors["email"] = "Email không được để trống.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Email không đúng định dạng (VD: example@gmail.com).";
    } elseif (mb_strlen($email) > 100) {
        $errors["email"] = "Email không được vượt quá 100 ký tự.";
    }


    

    if ($subject === "") {
        $errors["subject"] = "Vui lòng chọn chủ đề.";
    } elseif (!in_array($subject, $allowedSubjects, true)) {
        $errors["subject"] = "Chủ đề được chọn không hợp lệ.";
    }


    

    if ($content === "") {
        $errors["content"] = "Nội dung không được để trống.";
    } elseif (mb_strlen($content) < 10) {
        $errors["content"] = "Nội dung phải có ít nhất 10 ký tự.";
    } elseif (mb_strlen($content) > 1000) {
        $errors["content"] = "Nội dung không được vượt quá 1000 ký tự.";
    }


    /

    if (isset($_FILES["avatar"]) && $_FILES["avatar"]["error"] !== UPLOAD_ERR_NO_FILE) {

        $file = $_FILES["avatar"];

        // 1. Kiểm tra mã lỗi upload từ PHP
        if ($file["error"] !== UPLOAD_ERR_OK) {
            $errors["avatar"] = "Có lỗi xảy ra trong quá trình tải tệp lên.";
        } else {

            // 2. Kiểm tra dung lượng (Tối đa 2MB)
            if ($file["size"] > 2 * 1024 * 1024) {
                $errors["avatar"] = "Ảnh đại diện không được vượt quá 2MB.";
            }

            // 3. Kiểm tra MIME Type thực tế từ nội dung tệp (Tránh giả mạo extension)
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $file["tmp_name"]);
            finfo_close($finfo);

            $allowedTypes = [
                "image/jpeg" => "jpg",
                "image/png"  => "png",
                "image/gif"  => "gif"
            ];

            if (!array_key_exists($mimeType, $allowedTypes)) {
                $errors["avatar"] = "Chỉ chấp nhận định dạng ảnh JPG, PNG hoặc GIF.";
            }

            // 4. Kiểm tra xem file có thực sự là tệp hình ảnh không
            if (@getimagesize($file["tmp_name"]) === false) {
                $errors["avatar"] = "Tệp tải lên không phải là tệp ảnh hợp lệ.";
            }

            // 5. Lưu tệp nếu không có lỗi
            if (!isset($errors["avatar"])) {
                $uploadDir = "uploads/";

                // Tạo thư mục lưu trữ với quyền an toàn (0755)
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                // Đặt lại đuôi tệp dựa trên MIME type thực tế để loại bỏ nguy cơ thực thi mã độc
                $extension = $allowedTypes[$mimeType];
                $fileName = uniqid("avatar_", true) . "." . $extension;
                $uploadPath = $uploadDir . $fileName;

                if (move_uploaded_file($file["tmp_name"], $uploadPath)) {
                    $avatar = $uploadPath;
                } else {
                    $errors["avatar"] = "Không thể lưu tệp ảnh lên máy chủ.";
                }
            }
        }
    }


  

    if (empty($errors)) {
        $success = "Gửi thông tin liên hệ thành công!";

        // Reset lại form dữ liệu sau khi gửi thành công
        $name = "";
        $email = "";
        $subject = "";
        $content = "";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form liên hệ</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f4f7;
            padding: 40px;
        }

        .container {
            width: 500px;
            max-width: 100%;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            box-sizing: border-box;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        textarea {
            height: 120px;
            resize: vertical;
        }

        input[type="file"] {
            border: none;
            padding-left: 0;
        }

        button {
            width: 100%;
            margin-top: 20px;
            padding: 12px;
            border: none;
            border-radius: 6px;
            background: #007bff;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        .success {
            background: #e5ffe9;
            color: #2e7d32;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 15px;
            border: 1px solid #a5d6a7;
        }

        .field-error {
            color: #d32f2f;
            font-size: 13px;
            margin-top: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>FORM LIÊN HỆ</h2>

    <!-- Thông báo thành công -->
    <?php if ($success !== ""): ?>
        <div class="success">
            ✅ <?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?>
        </div>
    <?php endif; ?>

    <!-- Form sử dụng novalidate để vô hiệu hóa kiểm tra mặc định của trình duyệt, ưu tiên kiểm tra phía server -->
    <form method="POST" enctype="multipart/form-data" novalidate>

        <!-- Họ tên -->
        <label for="name">Họ tên</label>
        <input 
            type="text" 
            id="name"
            name="name" 
            value="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>" 
            placeholder="Nhập họ tên"
        >
        <?php if (isset($errors["name"])): ?>
            <div class="field-error">❌ <?php echo htmlspecialchars($errors["name"], ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>

        <!-- Email -->
        <label for="email">Email</label>
        <input 
            type="email" 
            id="email"
            name="email" 
            value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>" 
            placeholder="example@gmail.com"
        >
        <?php if (isset($errors["email"])): ?>
            <div class="field-error">❌ <?php echo htmlspecialchars($errors["email"], ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>

        <!-- Chủ đề -->
        <label for="subject">Chủ đề</label>
        <select id="subject" name="subject">
            <option value="">-- Chọn chủ đề --</option>
            <?php foreach ($allowedSubjects as $item): ?>
                <option 
                    value="<?php echo htmlspecialchars($item, ENT_QUOTES, 'UTF-8'); ?>"
                    <?php echo ($subject === $item) ? 'selected' : ''; ?>
                >
                    <?php echo htmlspecialchars($item, ENT_QUOTES, 'UTF-8'); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors["subject"])): ?>
            <div class="field-error">❌ <?php echo htmlspecialchars($errors["subject"], ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>

        <!-- Nội dung -->
        <label for="content">Nội dung</label>
        <textarea 
            id="content"
            name="content" 
            placeholder="Nhập nội dung cần gửi..."
        ><?php echo htmlspecialchars($content, ENT_QUOTES, 'UTF-8'); ?></textarea>
        <?php if (isset($errors["content"])): ?>
            <div class="field-error">❌ <?php echo htmlspecialchars($errors["content"], ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>

        <!-- Ảnh đại diện -->
        <label for="avatar">Ảnh đại diện</label>
        <input 
            type="file" 
            id="avatar"
            name="avatar" 
            accept="image/jpeg,image/png,image/gif"
        >
        <?php if (isset($errors["avatar"])): ?>
            <div class="field-error">❌ <?php echo htmlspecialchars($errors["avatar"], ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>

        <!-- Nút gửi -->
        <button type="submit">Gửi thông tin</button>

    </form>
</div>

</body>
</html>