<?php
include '../../model/pdo.php';

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $sql = "DELETE FROM loai WHERE ma_loai = $id";
  $stmt = $conn->prepare($sql);
  $stmt->execute();

  header("Location: ../?act=adddm");
  exit();
}
