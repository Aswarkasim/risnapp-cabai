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

            <a href="<?= base_url() ?>home/diagnosa/ask" class="btn_1">Diagnosa Baru<span class="ti-angle-right"></span> </a><br>

        </div>
    </div>
</section>