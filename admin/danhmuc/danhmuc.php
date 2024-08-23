<?php

include '.././model/pdo.php';
$sql = "SELECT * FROM loai";
$stmt = $conn->prepare($sql);
$stmt->execute();
$loai = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<style>
  .table th:nth-child(1) {
    width: 10%;
  }

  .table th:nth-child(2) {
    width: 75%;
  }
</style>
<table class="table">
  <thead>
    <tr>
      <th scope="col">mã loại</th>
      <th scope="col">Tên loại</th>
      <th scope="col"><a class="btn btn-info" href="./danhmuc/add.php">Thêm mới</a></th>
    </tr>
  </thead>

  <tbody>
    <?php foreach ($loai as $l) : ?>

      <tr>
        <th scope="row"><?= $l['ma_loai'] ?></th>
        <td><?= $l['ten_loai'] ?></td>
        <td>
          <a class="btn btn-danger" href="./danhmuc/edit.php?id=<?= $l['ma_loai'] ?>">Sửa</a>
          <a class="btn btn-dark" onclick="return confirm('Bạn chắc chắn muốn xóa chứ?')" href="./danhmuc/delete.php?id=<?= $l['ma_loai'] ?>">xóa</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>