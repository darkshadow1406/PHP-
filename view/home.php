<?php
include './model/pdo.php';
$sql = "SELECT * FROM sanpham ORDER BY luot_xem DESC LIMIT 8";
$stmt = $conn->prepare($sql);
$stmt->execute();
$sanphamLuotxemcao = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT * FROM sanpham");
$stmt->execute();
$sanpham = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT * FROM loai");
$stmt->execute();
$danhmuc = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  include './model/pdo.php';

  $ten_thanhVien = $_POST['ten_thanhVien'];
  $mat_khau = $_POST['mat_khau'];

  $sql = "SELECT * FROM `thanhvien` WHERE `ten_thanhVien` = :ten_thanhVien";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':ten_thanhVien', $ten_thanhVien);
  $stmt->execute();
  $thanhvien = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($thanhvien && password_verify($mat_khau, $thanhvien['mat_khau'])) {
    $_SESSION['user'] = $thanhvien;
    header('Location: index.php');
    exit();
  } else {
    echo "Đăng nhập thất bại. Vui lòng kiểm tra lại thông tin đăng nhập.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<style>
  .grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
  }

  .width {
    width: 100%;
  }

  .content-section-2-item {
    text-align: center;
  }
</style>

<body>

</body>

</html>
<div class="row mb">
  <div class="boxtrai mr">
    <div class="row">
      <div class="banner">
        <img src="https://inkythuatso.com/uploads/images/2022/01/banner-quan-ao-inkythuatso-13-10-16-26.jpg" width="100%" alt="" />
      </div>
    </div>

    <div class="row grid">
      <?php foreach ($sanpham as $s) : ?>
        <div class="content-section-2-item">
          <div class="product-section-2-item">
            <a href="?ma_loai=<?= $s['ma_loai'] ?>&ma_sanPham=<?= $s['ma_sanPham'] ?>&act=chitietsanpham"><img src="./image/<?= $s['anh'] ?>" width="230px" height="200px" alt="" /></a>
          </div>
          <div class="product-section-2-item-bottom">
            <h3><a href=""><?= $s['ten_sanPham'] ?></a></h3>
            <div class="product-section-2-item-price">
              <span class="price" style="color: #e45d15; font-weight: 700"><?= number_format($s['gia']) ?>đ</span>
              <span class="old-price" style="text-decoration: line-through"><?= number_format($s['gia_cu']) ?>đ</span>
            </div>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  </div>
  <?php

  ?>
  <div class="boxphai">
    <div class="row mb">
      <div class="row boxtitle">TÀI KHOẢN</div>
      <div class="boxcontent formtaikhoan">

        <form action="" method="post">

          <?php
          if (isset($_SESSION['user']) && !empty($_SESSION['user'])) { ?>
            <?php
            $quyen = $_SESSION['user']['quyen'];
            if ($quyen == 1) { ?>
              <div class="row mb10">
                <p>Truy cập <a style="color: red;" href="./admin/?act=admin">trang quản trị</a></p>
              </div>
              <a href="?act=logout">Đăng xuất</a>
            <?php } else { ?>
              <a href="?act=logout">Đăng xuất</a>
            <?php } ?>

          <?php   } else { ?>
            <div class="row mb10">
              Tên đăng nhập
              <input type="text" name="ten_thanhVien" id="" />
            </div>
            <div class="row mb10">
              Mật khẩu <br />
              <input type="password" name="mat_khau" id="" />
            </div>
            <div class="row mb10">
              <input type="checkbox" name="" id="" />Ghi nhớ tài khoản
            </div>
            <div class="row mb10">
              <input type="submit" value="Đăng nhập" />
            </div>
            <div class="row mb10">
              <li>
                <a href="?act=quenmk">Quên mật khẩu ?</a>
              </li>
              <li>
                <a href="?act=register">Đăng kí thành viên</a>
              </li>
            </div>
          <?php   } ?>
        </form>


      </div>
    </div>
    <div class="row mb">
      <div class="boxtitle">DANH MỤC</div>
      <div class="boxcontent2 menudoc">
        <ul class="main-cate">
          <?php foreach ($danhmuc as $d) : ?>
            <li class="list-main-cate">
              <a href="?ma_loai=<?php echo $d['ma_loai']; ?>&act=danhmuc" class="link"><?php echo $d['ten_loai']; ?></a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="boxfooter searbox">
        <form action="" method="GET">
          <input class="search-header" type="text" name="keyword" placeholder="Tìm kiếm..." />
          <input type="hidden" name="act" value="timkiem">
          </button>
        </form>
      </div>
    </div>
    <div class="row">
      <div class="boxtitle">TOP YÊU THÍCH</div>
      <div class="row boxcontent">
        <?php foreach ($sanphamLuotxemcao as $s) : ?>

          <div class="row mb10 top10">
            <a href="?ma_loai=<?= $s['ma_loai'] ?> &ma_sanPham=<?= $s['ma_sanPham'] ?>&act=chitietsanpham"><img width="230px" height="100px" src="./image/<?= $s['anh'] ?>" alt="" /></a>
            <p><?= $s['ten_sanPham'] ?></p>
          </div>

        <?php endforeach ?>
      </div>
    </div>
  </div>
</div>