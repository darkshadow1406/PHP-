<?php
include './model/pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['Email'];

  $sql = "SELECT * FROM `thanhvien` WHERE `Email` = :email";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':email', $email);
  $stmt->execute();
  $thanhvien = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($thanhvien) {
    // Tạo mã xác minh ngẫu nhiên
    $verificationCode = rand(100000, 999999);

    // Lưu mã xác minh vào cơ sở dữ liệu
    $sql = "UPDATE `thanhvien` SET `verification_code` = :code WHERE `Email` = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':code', $verificationCode);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // // Gửi email chứa mã xác minh đến địa chỉ email của người dùng
    // $subject = "Yêu cầu đặt lại mật khẩu";
    // $message = "Mã xác minh của bạn là: " . $verificationCode;
    // mail($email, $subject, $message);

    echo "Đã gửi mã xác minh thành công. Vui lòng kiểm tra email của bạn.";
  } else {
    echo "Email không tồn tại trong hệ thống.";
  }
}
?>

<!-- Biểu mẫu HTML -->
<!DOCTYPE html>
<html>

<head>
  <title>Quên mật khẩu</title>
</head>

<body>
  <div class="container-form-forgot-password">
    <div class="title-form-forgot-password">
      <h2 class="title-form-forgot-password-h2">Quên mật khẩu</h2>
    </div>
    <div class="form-forgot-password form">
      <div class="form-input">
        <form action="" method="post">
          <label for="Email">Email</label><br />
          <input type="text" name="Email" id="Email" />
          <br />
          <p class="active-btn">
            <button type="submit" class="submit-btn">Gửi mã xác minh</button>
          </p>
        </form>
      </div>
    </div>
  </div>
</body>

</html>