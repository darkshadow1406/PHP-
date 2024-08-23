<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  include './model/pdo.php';

  $ten_thanhVien = $_POST['ten_thanhVien'];
  $Email = $_POST['Email'];
  $mat_khau = password_hash($_POST['mat_khau'], PASSWORD_DEFAULT);

  $sql = "INSERT INTO `thanhvien` (`ten_thanhVien`, `Email`, `mat_khau`) VALUES (:ten_thanhVien, :Email, :mat_khau)";
  $stmt = $conn->prepare($sql);

  $stmt->bindParam(':ten_thanhVien', $ten_thanhVien);
  $stmt->bindParam(':Email', $Email);
  $stmt->bindParam(':mat_khau', $mat_khau);

  if ($stmt->execute()) {
    echo "Đăng ký thành công!";
  } else {
    echo "Lỗi khi đăng ký: " . $stmt->errorInfo()[2];
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Đăng Ký</title>
</head>
<style>
  .container-form-login {
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    width: 300px;
    padding: 20px;
    width: 100%;
  }

  /* Tiêu đề */
  .title-form-login-h2 {
    text-align: center;
    color: #333;
  }

  /* Form đăng ký */
  .form-input {
    margin-top: 20px;
  }

  form h2 {
    font-size: 18px;
    margin-bottom: 10px;
  }

  label {
    display: block;
    margin-bottom: 5px;
    color: #555;
  }

  input[type="text"],
  input[type="email"],
  input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
  }

  .active-btn {
    text-align: center;
  }

  .submit-btn {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }

  .submit-btn:hover {
    background-color: #0056b3;
  }
</style>

<body>

  <div class="container-form-login">
    <div class="title-form-login">
      <h2 class="title-form-login-h2">ĐĂNG KÝ TÀI KHOẢN</h2>
    </div>
    <div class="form-login form">
      <div class="form-input">
        <form action="" method="post">
          <h2>Khách hàng đăng ký</h2>
          <p>Nếu bạn chưa có tài khoản, xin vui lòng đăng ký</p>
          <label for="ten_thanhVien">Tên:</label><br>
          <input type="text" id="ten_thanhVien" name="ten_thanhVien" required><br>

          <label for="Email">Email:</label><br>
          <input type="email" id="Email" name="Email" required><br>

          <label for="mat_khau">Mật Khẩu:</label><br>
          <input type="password" id="mat_khau" name="mat_khau" required>

          <p class="active-btn">
            <button type="submit" class="submit-btn">ĐĂNG KÝ</button>
          </p>
        </form>
      </div>
    </div>
  </div>
</body>

</html>