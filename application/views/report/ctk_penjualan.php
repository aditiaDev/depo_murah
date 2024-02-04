<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan</title>
    <style>
      @page { margin: 5px; }
      body { margin: 5px; }
      p{
        font-size:14px;
        font-weight: bold;
        margin: 0px;
      }

      table tr td{
        padding-left: 5px;
        padding-right: 5px;
      }
    </style>
</head>
<body>

<div id="container">
	<h1 style="text-align:center;">Laporan Penjualan</h1>
  <p>Period : <?= $from ?> sampai <?= $to ?></p>
    <table border="1" style="width:100%;font-size:10px;border: 1px solid #ddd;border-collapse: collapse;">
      <thead>
        <tr>
          <th>ID Penjualan</th>
          <th>Tanggal</th>
          <th>Cabang</th>
          <th>Pelanggan</th>
          <th>Barang</th>
          <th>jumlah</th>
          <th>Harga</th>
          <th>Sub Total</th>
        </tr>
      </thead>
      <tbody>
      <?php 
        $no=1;
        foreach($data as $row): 
      ?>
        <tr>
          <td><?= $row['id_penjualan']; ?></td>
          <td ><?= $row['tgl_penjualan']; ?></td>
          <td ><?= $row['nm_cabang']; ?></td>
          <td ><?= $row['id_pelanggan']."</br>".$row['nm_pelanggan']; ?></td>
          <td ><?= $row['id_barang']."</br>".$row['nm_barang']; ?></td>
          <td  style="text-align:right;"><?= number_format($row['jumlah'],0,',','.'); ?></td>
          <td style="text-align:right;"><?= number_format($row['harga_barang'],0,',','.'); ?></td>
          <td style="text-align:right;"><?= number_format($row['subtotal'],0,',','.'); ?></td>
        </tr>
        <?php 
          endforeach; 
        ?>
      </tbody>
    </table>

</div>
 
</body>
</html>
