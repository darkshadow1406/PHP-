<?php
include './view/header.php';

if (isset($_GET['act'])) {
  $act = $_GET['act'];
  switch ($act) {
    case 'trangchu':
      include "./view/home.php";
      break;
    case 'gioithieu':
      include "./view/gioithieu.php";
      break;
    case 'lienhe':
      include "./view/lienhe.php";
      break;
    case 'gopy':
      include "./view/gopy.php";
      break;
    case 'hoidap':
      include "./view/hoidap.php";
      break;
    case 'register':
      include "./view/register.php";
      break;
    case 'login':
      include "./view/login.php";
      break;
    case 'logout':
      include "./view/logout.php";
      break;
    case 'danhmuc':
      include "./view/danhmuc.php";
      break;
    case 'chitietsanpham':
      include './view/chitietsanpham.php';
      break;
    case 'timkiem':
      include './view/search.php';
      break;
    case 'quenmk':
      include './view/quenmk.php';
      break;
    default:
      include "./view/home.php";
      break;
  }
} else {
  include "./view/home.php";
}




include './view/footer.php';
