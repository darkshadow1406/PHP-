<?php
// Start a session to manage session data
session_start();

// Include the database connection
include '../../model/pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $errors = [];

  // Define an array of required fields
  $required_fields = ['ten_sanPham', 'gia', 'tinh_trang', 'ma_loai'];

  // Check if the required fields are empty
  foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
      $errors[] = "The field '$field' is required.";
    }
  }

  // Check if 'gia' and 'gia_cu' are numeric
  if (!is_numeric($_POST['gia']) || !is_numeric($_POST['gia_cu'])) {
    $errors[] = "Price (gia) and old price (gia_cu) must be numeric values.";
  }

  // Check for image upload errors
  if (empty($errors)) {
    $target_directory = '../../image/';

    if ($_FILES['new_image']['error'] === UPLOAD_ERR_OK) {
      $new_image_name = $_FILES['new_image']['name'];
      $new_image_tmp = $_FILES['new_image']['tmp_name'];

      $image_info = getimagesize($new_image_tmp);

      // Check if the uploaded file is a valid image and within size limit
      if (!$image_info || $_FILES['new_image']['size'] > 1048576) {
        $errors[] = "Uploaded file is not a valid image or the image size exceeds the limit.";
      } else {
        $target_path = $target_directory . uniqid() . '_' . basename($new_image_name);

        // Move the uploaded image to the target directory
        if (!move_uploaded_file($new_image_tmp, $target_path)) {
          $errors[] = "Failed to move the uploaded image.";
        }
      }
    }

    if (empty($errors)) {
      $ma_loai = $_POST['ma_loai'];

      // Check if the selected category exists in the database
      $stmt = $conn->prepare("SELECT ma_loai FROM loai WHERE ma_loai = :ma_loai");
      $stmt->bindParam(':ma_loai', $ma_loai, PDO::PARAM_INT);
      $stmt->execute();
      $category = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$category) {
        $errors[] = "Invalid category selected.";
      }

      if (empty($errors)) {
        // Prepare the data for insertion
        $newData = [
          'ten_sanPham' => $_POST['ten_sanPham'],
          'anh' => basename($target_path),
          'gia' => $_POST['gia'],
          'gia_cu' => $_POST['gia_cu'],
          'thuong_hieu' => $_POST['thuong_hieu'],
          'tinh_trang' => $_POST['tinh_trang'],
          'ma_loai' => $ma_loai,
        ];

        // Insert the data into the database
        $sql = "INSERT INTO sanpham (ten_sanPham, anh, gia, gia_cu, thuong_hieu, tinh_trang, ma_loai) VALUES (:ten_sanPham, :anh, :gia, :gia_cu, :thuong_hieu, :tinh_trang, :ma_loai)";
        $stmt = $conn->prepare($sql);
        $stmt->execute($newData);

        // Set a success message in the session and redirect
        $_SESSION['success_message'] = "Product added successfully.";
        header("Location: ../?act=hanghoa");
        exit();
      }
    }
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
  <form method="POST" action="" enctype="multipart/form-data">
    <?php if (!empty($errors)) : ?>
      <ul>
        <?php foreach ($errors as $error) : ?>
          <li style="color: red;"><?= $error; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
    <div class="form-group">
      <h2>Thêm sản phẩm</h2>
      <label for="ten_sanPham" class="form-label">Tên sản phẩm:</label>
      <input class="form-control" type="text" name="ten_sanPham"><br>

      <label for="anh" class="form-label">Ảnh:</label>
      <input class="form-control" type="file" name="new_image"><br>

      <label for="gia" class="form-label">Giá:</label>
      <input class="form-control" type="text" name="gia"><br>

      <label for="gia_cu" class="form-label">Giá cũ:</label>
      <input class="form-control" type="text" name="gia_cu"><br>

      <label for="thuong_hieu" class="form-label">Thương hiệu:</label>
      <input class="form-control" type="text" name="thuong_hieu"><br>

      <label for="tinh_trang" class="form-label">Tình trạng:</label>
      <input class="form-control" type="text" name="tinh_trang"><br>

      <label for="ma_loai" class="form-label">Mã loại:</label>
      <select name="ma_loai">
        <?php
        // Fetch and display categories from the database
        $sql = "SELECT ma_loai, ten_loai FROM loai";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($categories as $category) {
          echo '<option value="' . $category['ma_loai'] . '">' . $category['ten_loai'] . '</option>';
        }
        ?>
      </select>

      <input type="submit" class="btn btn-primary" value="Thêm">
    </div>
  </form>
</body>

</html>