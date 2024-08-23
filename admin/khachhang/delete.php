<?php
include '../../model/pdo.php';

if (isset($_GET['id'])) {
  $ma_thanhVien = $_GET['id'];

  $sql_check_quyen = "SELECT quyen FROM thanhvien WHERE ma_thanhVien = :ma_thanhVien";
  $stmt_check_quyen = $conn->prepare($sql_check_quyen);
  $stmt_check_quyen->bindParam(':ma_thanhVien', $ma_thanhVien);
  $stmt_check_quyen->execute();
  $result_quyen = $stmt_check_quyen->fetch(PDO::FETCH_ASSOC);

  if ($result_quyen['quyen'] == 1) {
    echo "<script>alert('Không thể xóa tài khoản admin.'); window.location = '../?act=khachhang';</script>";
  } else {
    $sql_delete = "DELETE FROM thanhvien WHERE ma_thanhVien = :ma_thanhVien";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bindParam(':ma_thanhVien', $ma_thanhVien);

    if ($stmt_delete->execute()) {
      header("Location: ../?act=khachhang");
      exit();
    } else {
      echo "Có lỗi xảy ra khi xóa thành viên.";
    }
  }
} else {
  echo "ID không hợp lệ.";
}
