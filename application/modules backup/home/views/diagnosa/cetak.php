<!DOCTYPE html>
<html lang="en">

<head>
  <title>Cetak Data</title>
  <link rel=" stylesheet" href="<?= base_url('assets/home/') ?>css/bootstrap.css">
  <style type="text/css">
    /* body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        } */

    @page {
      size: portrait;
      margin-left: 100px;
      margin-right: 100px;
      margin-top: 50px;
      margin-bottom: 50px;
    }

    .pembungkus {
      position: relative;
    }

    #qrCode {
      position: absolute;
      top: 10px;
      left: 10px;
    }

    /* h2 {
            position: absolute;
            left: 410px;
            top: 320px;
        }

        p {
            position: absolute;
            left: 220px;
            top: 380px;
            width: 600px
        } */
  </style>
</head>

<body>
  <div class="container-fluid">
    <div class="text-center">
      <h3><?= $konfigurasi->nama_instansi; ?></h3>
    </div>
    <table class="table">
      <tr>
        <td align="right" width="200px">Nama :</td>
        <td><?= $data->nama_konsultasi; ?></td>
      </tr>

      <tr>
        <td align="right" width="200px">Diagnosa :</td>
        <td><?= $data->nama_penyakit; ?></td>
      </tr>

      <tr>
        <td align="right" width="200px">Keakuratan :</td>
        <td><?= $data->akumulasi_cf . ' %'; ?></td>
      </tr>


    </table>
  </div>

  <script>
    window.print()
  </script>
</body>

</html>