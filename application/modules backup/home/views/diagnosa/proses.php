<section class="jumbotron bg-white">
    <div class="container">
        <hr>




        <div class="offset-md-3 col-md-6">


            <div class="form-group">
                <label for=""><strong>JENIS PENYAKIT</strong></label><br>
                <strong class="text-danger"><?= $penyakit->nama_jenis; ?></strong>
            </div>
            <hr>
            <div class="form-group">
                <label for=""><strong>PERSENTASE KEAKURATAN</strong></label><br>
                <span class="text-danger"><?= $persentase . '%' ?></span>
            </div>
            <hr>

            <div class="form-group">
                <label for=""><strong>DESKRIPSI</strong></label><br>
                <span class=""><?= $penyakit->deskripsi ?></span>
            </div>
            <hr>

            <div class="form-group">
                <label for=""><strong>PENANGANAN</strong></label><br>
                <span class=""><?= $penyakit->penanganan ?></span>
            </div>
            <hr>

            <div class="form-group">
                <label for=""><strong>GAMBAR</strong></label><br>
                <span class="">
                    <img src="<?= base_url($penyakit->gambar); ?>" width="300px" alt="">
                </span>
            </div>
            <hr>



            <!-- <div class="float-right">
                <form action="<?= base_url('home/diagnosa/simpanDiagnosaKonsultasi/' . $id_konsultasi . '/' . $kode_penyakit); ?>" method="post">
                    <input type="hidden" value="<?= $persentase; ?>" name="akumulasi_cf">
                    <input type="hidden" value="<?= $tingkat; ?>" name="tingkat">

                    <a href="<?= base_url('home/diagnosa/hapusData/' . $id_konsultasi); ?>" class="btn btn-secondary text-white tombol-hapus"><i class="fa fa-trash"></i> Buang</a>

                    <?php if ($dataKonsultasi->tingkat == '') { ?>
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                    <?php } else { ?>
                        <a href="<?= base_url('home/diagnosa/cetak/' . $id_konsultasi); ?>" class="btn btn-warning text-white" target="blank"><i class="fa fa-save"></i> Cetak</a>
                    <?php } ?>
                </form>

            </div> -->

            <a href="<?= base_url() ?>home/diagnosa/ask" class="btn btn-warning" class="btn_1">Diagnosa Baru<span class="ti-angle-right"></span> </a>

            <?php //print_r($dataKonsultasi) 
            ?>
            <?php if ($konsultasi->nama_konsultasi != '') { ?>
                <a href="<?= base_url('home/diagnosa/cetak/' . $id_konsultasi); ?>" class="btn btn-success" target="blank"><i class="fa fa-save"></i> Cetak</a>
            <?php } else { ?>

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="fa fa-save"></i> Simpan
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Masukkan Title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="<?= base_url('home/diagnosa/simpanHasil/' . $id_konsultasi); ?>" method="POST">
                                <div class="modal-body">
                                    <label for="">Title</label>
                                    <input type="text" placeholder="Title" class="form-control" name="nama_konsultasi">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</section>