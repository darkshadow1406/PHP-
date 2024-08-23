<?php
include '.././model/pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $sql = "SELECT binhluan.ma_binhLuan, binhluan.noiDung, thanhvien.ten_thanhVien, sanpham.anh
            FROM binhluan
            INNER JOIN thanhvien ON binhluan.ma_thanhVien = thanhvien.ma_thanhVien
            INNER JOIN sanpham ON binhluan.ma_sanPham = sanpham.ma_sanPham";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $binhluan = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_b'])) {
  $ma_binhLuan = $_POST['delete_b'];
  $sql = "DELETE FROM binhluan WHERE ma_binhLuan = :ma_binhLuan";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':ma_binhLuan', $ma_binhLuan);

  if ($stmt->execute()) {
    header("Location: ?act=binhluan");
    exit();
  } else {
    echo "Có lỗi xảy ra khi xóa bình luận.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Quản lý bình luận</title>
</head>

<body>
  <div class="container">
    <h1>Quản lý bình luận</h1>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nội dung</th>
          <th>Thành viên</th>
          <th>Sản phẩm</th>
          <th>Thao tác</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($binhluan as $b) : ?>
          <tr>
            <td><?= $b['ma_binhLuan'] ?></td>
            <td><?= $b['noiDung'] ?></td>
            <td><?= $b['ten_thanhVien'] ?></td>
            <td><img src=".././image/<?= $b['anh'] ?>" width="100px " height="100px" alt=""></td>
            <td>
              <form method="POST">
                <input type="hidden" name="delete_b" value="<?= $b['ma_binhLuan'] ?>">
                <button type="submit" onclick="return confirm('bạn có muốn xóa không ?')" class="btn btn-danger">Xóa</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>

</html>