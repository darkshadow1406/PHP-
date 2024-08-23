<?php
include './model/pdo.php';
session_start();

if (isset($_GET['ma_sanPham'])) {
  $ma_sanPham = $_GET['ma_sanPham'];

  $sql = "UPDATE sanpham SET luot_xem = luot_xem + 1 WHERE ma_sanPham = :ma_sanPham";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':ma_sanPham', $ma_sanPham, PDO::PARAM_INT);
  $stmt->execute();

  $sql = "SELECT * FROM sanpham JOIN loai ON sanpham.ma_loai = loai.ma_loai WHERE ma_sanPham = $ma_sanPham";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $sanpham = $stmt->fetch(PDO::FETCH_ASSOC);

  $sql = "SELECT binhluan.*, thanhvien.ten_thanhVien FROM binhluan INNER JOIN thanhvien ON binhluan.ma_thanhVien = thanhvien.ma_thanhVien WHERE binhluan.ma_sanPham = $ma_sanPham";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $binhluan = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
if (isset($_GET['ma_loai'])) {
  $ma_loai = $_GET['ma_loai'];
  $sql = "SELECT * FROM sanpham WHERE ma_loai = $ma_loai";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $sanphamsame = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_POST['noiDung'])) {
  $noiDung = $_POST['noiDung'];
  $ma_sanPham = $_POST['ma_sanPham'];

  if (isset($_SESSION['user'])) {
    $userEmail = $_SESSION['user']['Email'];

    $sqlUser = "SELECT ma_thanhVien FROM thanhvien WHERE Email = :userEmail";
    $stmtUser = $conn->prepare($sqlUser);
    $stmtUser->bindParam(':userEmail', $userEmail);
    $stmtUser->execute();
    $userInfo = $stmtUser->fetch(PDO::FETCH_ASSOC);

    if ($userInfo) {
      $ma_thanhVien = $userInfo['ma_thanhVien'];
      $sql = "INSERT INTO binhluan (noiDung, ma_thanhVien, ma_sanPham) VALUES (:noiDung, :ma_thanhVien, :ma_sanPham)"; // Use prepared statement
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':noiDung', $noiDung);
      $stmt->bindParam(':ma_thanhVien', $ma_thanhVien);
      $stmt->bindParam(':ma_sanPham', $ma_sanPham);

      if ($stmt->execute()) {
        header("Location: #"); // Provide a valid URL for redirection
        exit();
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<style>
.content-page-product {
  width: 1170px;
  height: 682.33px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(2, 1fr);

}



.content-section-2-items {
  height: 855.94px;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 15px;
  text-align: center;
}

.text-comment {
  width: 99%;
  height: 27.2px;
  border: 1px #ebebeb solid;
  padding: 50px;
}

.show-comment {
  padding: 15px;
  width: 99%;
  height: 79%;
  border: 1px #ebebeb solid;
  border-top: 2px solid;
  overflow: hidden;
}
</style>

<body>
  <?php if ($sanpham) : ?>

  <div class="page-product">
    <div class="content-page-product">
      <div class="product-image">
        <img src="./image/<?= $sanpham['anh'] ?>" width="400px" height="400px" alt="">
      </div>
      <div class="product-details">
        <h2><?= $sanpham['ten_sanPham'] ?></h2>
        <div class="trademark-status">
          <p>Thương hiệu: <span style="color: #ffb700;"><?= $sanpham['thuong_hieu'] ?></span> <span>|</span> Tình trạng:
            <span style="color: #ffb700;"><?= $sanpham['tinh_trang'] ?></span>
          </p>
        </div>
        <div class="des-product">
          <h5>MÔ TẢ</h5>
          <p><?= $sanpham['mo_ta']  ?></p>
        </div>
        <div class="product-section-2-item-price price-big">
          <span class="price"
            style="color: #ffb700; font-weight: 700; font-size: 18px;"><?= number_format($sanpham['gia']) ?>đ</span>
          <span class="old-price"
            style="text-decoration: line-through ;font-size: 16px;"><?= number_format($sanpham['gia_cu']) ?>đ</span>
        </div>
        <div class="quantity-product">
          <form action="">
            <p>Số lượng <input value="1" min="1" type="number"> <button type="submit">MUA NGAY</button> </p>
          </form>
        </div>

      </div>
      <div class="comment">
        <div class="comment-product">
          Bình luận
        </div>

        <?php
          if (isset($_SESSION['user'])) {
          ?>
        <form action="#" method="POST">
          <input class="text-comment" placeholder="Bình luận" type="text" name="noiDung" required>
          <input type="hidden" name="ma_sanPham" value="<?= $sanpham['ma_sanPham'] ?>">
          <button class="submit"> Gửi bình luận</button>
        </form>
        <?php } else { ?>
        <form>
          <br>
          <p>vui lòng đăng nhập để bình luận</p>
        </form>
        <?php } ?>

      </div>

      <div class="show-comment">
        <?php foreach ($binhluan as $b) : ?>
        <div class="comment-item">
          <span class="comment-author"><?= $b['ten_thanhVien'] ?>:</span>
          <span class="comment-content"><?= $b['noiDung'] ?></span>
        </div>
        <?php endforeach ?>
      </div>
    </div>
    <section class="content-section-2 same-kind">
      <div class="container-content-section-2">
        <div class="title-module ">
          <h2>
            SẢN PHẨM CÙNG LOẠI
          </h2>
        </div>
        <div class="content-section-2-items ">
          <?php foreach ($sanphamsame as $s) : ?>
          <div class="content-section-2-item">
            <div class="product-section-2-item">
              <a href="?ma_loai=<?= $s['ma_loai'] ?>&ma_sanPham=<?= $s['ma_sanPham'] ?>&act=chitietsanpham"><img
                  src="./image/<?= $s['anh'] ?>" width="200px" height="200px" alt="" /></a>
            </div>
            <div class="product-section-2-item-bottom">
              <h3><a href=""><?= $s['ten_sanPham'] ?></a></h3>
              <div class="product-section-2-item-price">
                <span class="price" style="color: red; font-weight: 700"><?= number_format($s['gia']) ?>đ</span>
                <span class="old-price" style="text-decoration: line-through"><?= number_format($s['gia_cu']) ?>đ</span>
              </div>
            </div>
          </div>
          <?php endforeach ?>
        </div>
      </div>
    </section>
  </div>
  <?php endif ?>
</body>

</html>