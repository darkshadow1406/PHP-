<?php
include '../../model/pdo.php';

$errors = [];
$sanpham = null;

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $sql = "SELECT * FROM sanpham WHERE ma_sanPham = :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->execute();
  $sanpham = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Data Validation
  $required_fields = ['ten_sanPham', 'gia', 'tinh_trang', 'ma_loai'];
  foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
      $errors[] = "The field '$field' is required.";
    }
  }

  if (!is_numeric($_POST['gia'])) {
    $errors[] = "Price (gia) must be a numeric value.";
  }

  if (!is_numeric($_POST['gia_cu'])) {
    $errors[] = "Old price (gia_cu) must be a numeric value.";
  }

  if (empty($errors)) {
    // File Upload Validation
    if ($_FILES['new_image']['error'] === UPLOAD_ERR_OK) {
      $new_image_name = $_FILES['new_image']['name'];
      $new_image_tmp = $_FILES['new_image']['tmp_name'];

      $image_info = getimagesize($new_image_tmp);
      if (!$image_info) {
        $errors[] = "Uploaded file is not an image.";
      }

      $image_size = $_FILES['new_image']['size'];
      if ($image_size > 1048576) {  // Adjust the size limit as needed (1MB in this example).
        $errors[] = "Image size exceeds the limit.";
      }

      // Rename the uploaded file to avoid overwriting
      $target_directory = '../../image/';
      $target_path = $target_directory . uniqid() . '_' . $new_image_name;

      if (!move_uploaded_file($new_image_tmp, $target_path)) {
        $errors[] = "Failed to move the uploaded image.";
      }
    } else {
      // No new image uploaded, retain the existing image
      $new_image_name = $sanpham['anh'];
    }

    if (empty($errors)) {
      // Database Validation
      $ma_loai = $_POST['ma_loai'];
      $stmt = $conn->prepare("SELECT ma_loai FROM loai WHERE ma_loai = :ma_loai");
      $stmt->bindParam(':ma_loai', $ma_loai, PDO::PARAM_INT);
      $stmt->execute();
      $category = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$category) {
        $errors[] = "Invalid category selected.";
      }

      if (empty($errors)) {
        $newData = [
          'id' => $id,
          'ten_sanPham' => $_POST['ten_sanPham'],
          'anh' => $new_image_name, // Use the new or existing image
          'gia' => $_POST['gia'],
          'gia_cu' => $_POST['gia_cu'],
          'thuong_hieu' => $_POST['thuong_hieu'],
          'tinh_trang' => $_POST['tinh_trang'],
          'ma_loai' => $ma_loai,
        ];

        $sql = "UPDATE sanpham SET ten_sanPham = :ten_sanPham, anh = :anh, gia = :gia, gia_cu = :gia_cu, thuong_hieu = :thuong_hieu, tinh_trang = :tinh_trang, ma_loai = :ma_loai WHERE ma_sanPham = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute($newData);

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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
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
    <div class="form-group ">
      <h2>Sửa sản phẩm</h2>
      <input type="hidden" name="id" value="<?php echo $sanpham['ma_sanPham'] ?>">
      <input class="form-control" type="text" name="ten_sanPham" value="<?php echo $sanpham['ten_sanPham'] ?>"><br>

      <img class="product-image" src="../../image/<?php echo $sanpham['anh'] ?>" width="200px" height="250px" alt="">
      <input class="form-control" type="file" name="new_image"><br>

      <input class="form-control" type="text" name="gia" value="<?php echo $sanpham['gia'] ?>"><br>

      <input class="form-control" type="text" name="gia_cu" value="<?php echo $sanpham['gia_cu'] ?>"><br>

      <input class="form-control" type="text" name="thuong_hieu" value="<?php echo $sanpham['thuong_hieu'] ?>"><br>

      <input class="form-control" type="text" name="tinh_trang" value="<?php echo $sanpham['tinh_trang'] ?>"><br>


      <label for="ma_loai">Mã loại:</label>
      <select class="form-control" id="inlineFormCustomSelect" name="ma_loai">
        <?php
        $sql = "SELECT ma_loai, ten_loai FROM loai";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($categories as $category) {
          echo '<option value="' . $category['ma_loai'] . '"';
          if ($category['ma_loai'] == $sanpham['ma_loai']) {
            echo ' selected';
          }
          echo '>' . $category['ten_loai'] . '</option>';
        }
        ?>
      </select>


      <input type="submit" class="btn btn-primary" value="Sửa">

    </div>
  </form>
</body>

</html>