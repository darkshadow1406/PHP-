<?php
include '../../model/pdo.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $ten_thanhVien = $_POST['ten_thanhVien'];
  $Email = $_POST['Email'];
  $mat_khau = password_hash($_POST['mat_khau'], PASSWORD_DEFAULT);
  $quyen = $_POST['quyen'];

  $sql = "INSERT INTO thanhvien (ten_thanhVien, Email, mat_khau, quyen) VALUES (:ten_thanhVien, :Email, :mat_khau, :quyen)";
  $stmt = $conn->prepare($sql);

  $stmt->bindParam(':ten_thanhVien', $ten_thanhVien);
  $stmt->bindParam(':Email', $Email);
  $stmt->bindParam(':mat_khau', $mat_khau);
  $stmt->bindParam(':quyen', $quyen);

  if ($stmt->execute()) {
    header("Location: ../?act=khachhang");
    exit();
  } else {
    echo "Có lỗi xảy ra khi thêm mới thành viên.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Edit Product</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>
<style>
  .form-group {
    width: 50%;
    margin: 0 auto;
  }
</style>

<body>

  <form method="POST">
    <div class="form-group">
      <h1>Thêm mới thành viên</h1>
      <label for="ten_thanhVien">Tên thành viên:</label>
      <input class="form-control" type="text" name="ten_thanhVien" required>
      <br>

      <label for="Email">Email:</label>
      <input class="form-control" type="email" name="Email" required>
      <br>

      <label for="mat_khau">Mật khẩu:</label>
      <input class="form-control" type="password" name="mat_khau" required>
      <br>

      <label for="quyen">Quyền:</label>
      <select name="quyen" id="">
        <option value="1">Admin</option>
        <option value="0">Người dùng</option>
      </select>
      <br>

      <button class="btn btn-primary" type="submit">Thêm mới</button>
    </div>
  </form>
</body>

</html>