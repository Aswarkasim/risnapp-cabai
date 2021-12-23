<section class="jumbotron">
    <div class="container-fluid mb-3">
        <form action="<?= base_url('home/diagnosa/proses/' . $id_konsultasi) ?>" method="post" class="form-signin">


            <!-- <a href="">Buat Konsultasi Baru</a> -->

            <hr>
            <h3><b>Pilih Gejala</b></h3>


            <?php //printr_pretty($gejala) 
            ?>

            <div class="row">
                <div class="col-md-6">


                    <table class="table table table-bordered table-striped dataTables">
                        <thead>
                            <tr>
                                <th width="10px">NO</th>
                                <th>KODE</th>
                                <th>NAMA</th>
                                <th>PILIH</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php


                            $this->load->model('Home_model', 'HM');

                            $no = 1;
                            foreach ($gejala as $row) {
                                $pilih = $this->HM->cekGejala($id_konsultasi, $row->kode_gejala);

                                if ($pilih == null) {
                            ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= $row->kode_gejala ?></td>
                                        <td><?= $row->nama_gejala ?></td>
                                        <td>

                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Pilih
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item" href="<?= base_url('home/diagnosa/pilih/' . $id_konsultasi . '/' . $row->kode_gejala . '/1'); ?>">Mungkin</a></li>
                                                    <li><a class="dropdown-item" href="<?= base_url('home/diagnosa/pilih/' . $id_konsultasi . '/' . $row->kode_gejala . '/2'); ?>">Kemungkinan Besar</a></li>
                                                    <li><a class="dropdown-item" href="<?= base_url('home/diagnosa/pilih/' . $id_konsultasi . '/' . $row->kode_gejala . '/3'); ?>">Pasti</a></li>
                                                </ul>
                                            </div>


                                        </td>
                                    </tr>
                            <?php $no++;
                                }
                            } ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-6">
                    <a href="<?= base_url('home/diagnosa/proses/' . $id_konsultasi); ?>" class="btn btn-primary btn-lg"><i class="fa fa-refresh"></i> Diagnosa</a><br><br>
                    <table class="table table table-bordered table-striped dataTables">
                        <thead>
                            <tr>
                                <th width="10px">NO</th>
                                <th>KODE</th>
                                <th>NAMA</th>
                                <th>PILIH</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $no = 1;
                            foreach ($pilihGejala as $row) { ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $row->kode_gejala ?></td>
                                    <td><?= $row->nama_gejala ?></td>
                                    <td>
                                        <a href="<?= base_url('home/diagnosa/batal/' . $id_konsultasi . '/' . $row->id_diagnosa); ?>" class="btn btn-danger"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                            <?php $no++;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</section>

<script src="<?= base_url('assets/admin/') ?>bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?= base_url('assets/admin/') ?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/admin/') ?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script>
    $(function() {
        $('.dataTable').DataTable();
    })
</script>