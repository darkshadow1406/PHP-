<?php
include '../../model/pdo.php';

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $sql = "DELETE FROM sanpham WHERE ma_sanPham = $id";
  $stmt = $conn->prepare($sql);
  $stmt->execute();

  header("Location: ../?act=hanghoa");
  exit();
}
