<?php include('./model/pdo.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
  .content-section-2-items {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
  }
  </style>
</head>

<body>

</body>

</html>
<section class="content-section-2 section-2-items-search">
  <div class="container-content-section-2">
    <div class="title-module">
      <h2>
        <a href="" title="">TÌM KIẾM : <?= $_GET['keyword'] ?></a>
      </h2>
    </div>

    <?php
    if (isset($_GET['keyword'])) {
      $keyword = $_GET['keyword'];
      $itemsPerPage = 10;
      $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
      $startFrom = ($currentPage - 1) * $itemsPerPage;

      $sql = "SELECT * FROM sanpham WHERE ten_sanPham LIKE :keyword OR mo_ta LIKE :keyword LIMIT $startFrom, $itemsPerPage";
      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);
      $stmt->execute();
      $countSql = "SELECT COUNT(*) FROM sanpham WHERE ten_sanPham LIKE :keyword OR mo_ta LIKE :keyword";
      $stmtCount = $conn->prepare($countSql);
      $stmtCount->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);
      $stmtCount->execute();
      $totalItems = $stmtCount->fetchColumn();

      if ($stmt->rowCount() > 0) {
    ?>
    <div class="content-section-2-items">
      <?php
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          ?>
      <div class="content-section-2-item">
        <div class="product-section-2-item">
          <a href="?ma_loai=<?= $row['ma_loai'] ?>&ma_sanPham=<?= $row['ma_sanPham'] ?>&act=chitietsanpham">
            <img src="./image/<?= $row['anh'] ?>" width="200px" height="200px" alt="" />
          </a>
        </div>
        <div class="product-section-2-item-bottom">
          <h3><a href=""><?= $row['ten_sanPham'] ?></a></h3>
          <div class="product-section-2-item-price">
            <span class="price" style="color: #e45d15; font-weight: 700"><?= number_format($row['gia']) ?>đ</span>
            <span class="old-price" style="text-decoration: line-through"><?= number_format($row['gia_cu']) ?>đ</span>
          </div>
        </div>
      </div>
      <?php
          }
          ?>
    </div>
    <?php

        $totalItems =
          $totalPages = ceil($totalItems / $itemsPerPage);

        echo '<div class="pagination">';
        for ($i = 1; $i <= $totalPages; $i++) {
        }
        echo '</div>';
      } else {
        echo 'Không tìm thấy sản phẩm nào.';
      }
    }
    ?>
  </div>
</section>