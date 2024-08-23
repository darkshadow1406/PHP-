<?php
include '.././model/pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $sql = "SELECT loai.ma_loai, loai.ten_loai, COUNT(sanpham.ma_sanPham) AS so_luong_san_pham
  FROM loai
  LEFT JOIN sanpham ON loai.ma_loai = sanpham.ma_loai
  GROUP BY loai.ma_loai, loai.ten_loai";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $productStatistics = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Thống kê sản phẩm</title>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<style>
  .container {
    margin-top: 20px;
  }
</style>

<body>
  <div class="container">
    <div id="pieChart" style="width: 600px; height: 600px;"></div>
  </div>

  <script type="text/javascript">
    google.charts.load('current', {
      'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Loại sản phẩm');
      data.addColumn('number', 'Số lượng');

      data.addRows([
        <?php
        foreach ($productStatistics as $row) {
          echo "['" . $row['ten_loai'] . "', " . $row['so_luong_san_pham'] . "],";
        }
        ?>
      ]);

      var options = {
        title: 'Thống kê sản phẩm theo loại',
        is3D: true,
      };

      var chart = new google.visualization.PieChart(document.getElementById('pieChart'));

      chart.draw(data, options);
    }
  </script>


</body>

</html>