<?php
include '../../model/pdo.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $errors = [];

  $ten_loai = $_POST['ten_loai'];

  if (empty($ten_loai)) {
    $errors[] = "Danh mục không được để trống";
  }

  if (empty($errors)) {
    $sql = "INSERT INTO `loai` (`ma_loai`, `ten_loai`) VALUES (NULL, :ten_loai)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':ten_loai', $ten_loai);
    $stmt->execute();

    header("Location: ../?act=adddm");
    exit();
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Edit danh mục</title>
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
    <div class="form-group">

      <h2>Thêm danh mục</h2>
      <label for="ten_loai" class="form-label">Tên danh mục:</label>
      <input class="form-control" type="text" name="ten_loai"><br>
      <input type="submit" class="btn btn-primary" value="Thêm">
    </div>
  </form>
</body>

</html>