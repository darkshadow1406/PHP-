<?php
include "../model/pdo.php";
include "header.php";
//controller
if (isset($_GET['act'])) {
    $act = $_GET['act'];
    switch ($act) {

        case 'danhmuc':
            include "danhmuc/danhmuc.php";
            break;
        case 'hanghoa':
            include "hanghoa/hanghoa.php";
            break;
        case 'khachhang':
            include "khachhang/khachhang.php";
            break;
        case 'thongke':
            include "thongke/thongke.php";
            break;
        case 'binhluan':
            include './binhluan/binhluan.php';
            break;
        default:
            include "home.php";
            break;
    }
} else {
    include "home.php";
}


include "footer.php";
