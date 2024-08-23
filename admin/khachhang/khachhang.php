<?php
include '.././model/pdo.php';

$sql = "SELECT * FROM thanhvien";
$stmt = $conn->prepare($sql);
$stmt->execute();
$thanhvien = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<style>
.table th:nth-child(1),
th:nth-child(3),
th:nth-child(4),
th:nth-child(5),
th:nth-child(6),
th:nth-child(7) {
  width: 11%;
}

.table td:nth-child(2) {
  width: 20%;
}
</style>
<table class="table">
  <thead>
    <tr>
      <th scope="col">mã thành viên</th>
      <th scope="col">Tên thành viên</th>
      <th scope="col">Email</th>
      <th scope="col">Quyền</th>
      <th scope="col"><a class="btn btn-info" href="./khachhang/add.php">Thêm mới</a></th>
    </tr>
  </thead>

  <tbody>
    <?php foreach ($thanhvien as $t) : ?>

    <tr>
      <th scope="row"><?= $t['ma_thanhVien'] ?></th>
      <td><?= $t['ten_thanhVien'] ?></td>
      <td><?= $t['Email'] ?></td>
      <td><?= $t['quyen'] ?></td>

      <td>
        <a class="btn btn-danger" href="./khachhang/edit.php?id=<?= $t['ma_thanhVien'] ?>">Sửa</a>
        <a class="btn btn-dark" onclick="return confirm('Bạn chắc chắn muốn xóa chứ?')"
          href="./khachhang/delete.php?id=<?= $t['ma_thanhVien'] ?>">xóa</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>