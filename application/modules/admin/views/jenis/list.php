<?php

$this->load->helper('text');

?>
<div class="box">
  <div class="box-header">
    <h3 class="box-title"></h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body no-padding">



    <div class="container-fluid">
      <p>
        <a href="<?= base_url($add) ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
      </p>



      <table class="table table table-bordered table-striped DataTable">
        <thead>
          <tr>
            <th width="30px">NO</th>
            <th width="40px">KODE</th>
            <th>NAMA</th>

            <th width="100px">ACTION</th>
          </tr>
        </thead>
        <tbody>

          <?php $no = 1;
          foreach ($jenis as $row) { ?>
            <tr>
              <td><?= $no ?></td>
              <td><?= $row->kode_jenis ?></td>
              <td><a href="#"><strong><?= $row->nama_jenis ?></strong></a></td>
              <td>
                <div class="btn-group">
                  <button type="button" class="btn btn-danger btn-flat"><i class="fa fa-cogs"></i></button>
                  <button type="button" class="btn btn-danger btn-flat dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="<?= base_url('admin/role/index/' . $row->kode_jenis) ?>"><i class="fa fa-exchange"></i> Atur Role</a></li>
                    <li><a href="<?= base_url($edit . $row->kode_jenis) ?>"><i class="fa fa-edit"></i> Edit</a></li>
                    <li><a href="<?= base_url($delete . $row->kode_jenis) ?>"><i class="fa fa-trash"></i>Hapus</a></li>
                  </ul>
                </div>
              </td>
            </tr>
          <?php $no++;
          } ?>
        </tbody>
      </table>
    </div>
  </div>
  <!-- /.box-body -->
</div>