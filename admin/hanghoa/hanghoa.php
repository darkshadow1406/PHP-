<?php
include '.././model/pdo.php';
$sql = "SELECT * FROM sanpham LEFT JOIN loai ON sanpham.ma_loai = loai.ma_loai";
$stmt = $conn->prepare($sql);
$stmt->execute();
$sanpham = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<style>
  .table th:nth-child(1),
  th:nth-child(3),
  th:nth-child(4),
  th:nth-child(5),
  th:nth-child(6),
  th:nth-child(7) {
    width: 10%;
  }

  .table td:nth-child(2) {
    width: 20%;
  }
</style>
<table class="table">
  <thead>
    <tr>
      <th scope="col">mã sản phẩm</th>
      <th scope="col">Tên sản phẩm</th>
      <th scope="col">ảnh</th>
      <th scope="col">giá</th>
      <th scope="col">giá cũ</th>
      <th scope="col">thương hiệu</th>
      <th scope="col">tình trạng</th>
      <th scope="col">lượt xem</th>
      <th scope="col">mã loại</th>
      <th scope="col"><a class="btn btn-info" href="./hanghoa/add.php">Thêm mới</a></th>
    </tr>
  </thead>

  <tbody>
    <?php foreach ($sanpham as $s) : ?>

      <tr>
        <th scope="row"><?= $s['ma_sanPham'] ?></th>
        <td><?= $s['ten_sanPham'] ?></td>
        <td><img src="../image/<?= $s['anh'] ?>" width="50px" height="50px" alt=""></td>
        <td><?= number_format($s['gia']) ?></td>
        <td><?= number_format($s['gia_cu']) ?></td>
        <td><?= $s['thuong_hieu'] ?></td>
        <td><?= $s['tinh_trang'] ?></td>
        <td><?= $s['luot_xem'] ?></td>
        <td><?= $s['ma_loai'] ?></td>
        <td>
          <a class="btn btn-danger" href="./hanghoa/edit.php?id=<?= $s['ma_sanPham'] ?>">Sửa</a>
          <a class="btn btn-dark" onclick="return confirm('Bạn chắc chắn muốn xóa chứ?')" href="./hanghoa/delete.php?id=<?= $s['ma_sanPham'] ?>">xóa</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>