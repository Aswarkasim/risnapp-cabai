<section class="jumbotron">
    <div class="container mb-3">
        <form action="<?= base_url('home/diagnosa/proses/' . $id_konsultasi) ?>" method="post" class="form-signin">


            <hr>
            <h3><b>Pilih Gejala</b></h3>



            <?php $no = 1;
            foreach ($ask as $row) { ?>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <span><?= $no++ . '. ' . $row->nama_gejala ?></span>
                        <p><?= $row->pertanyaan ?></p>
                        <input type="hidden" name="kode_pengetahuan<?= $row->kode_pengetahuan ?>" value="<?= $row->kode_pengetahuan ?>">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" required name="jawabKonsultasi<?= $row->kode_pengetahuan ?>" id="inlineRadio<?= $row->kode_pengetahuan ?>1" value="0">
                            <label class="form-check-label" for="inlineRadio<?= $row->kode_pengetahuan ?>1">Tidak</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" required name="jawabKonsultasi<?= $row->kode_pengetahuan ?>" id="inlineRadio<?= $row->kode_pengetahuan ?>2" value="0.4">
                            <label class="form-check-label" for="inlineRadio<?= $row->kode_pengetahuan ?>2">Mungkin</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" required name="jawabKonsultasi<?= $row->kode_pengetahuan ?>" id="inlineRadio<?= $row->kode_pengetahuan ?>3" value="0.8">
                            <label class="form-check-label" for="inlineRadio<?= $row->kode_pengetahuan ?>3">Kemungkinan Besar</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" required name="jawabKonsultasi<?= $row->kode_pengetahuan ?>" id="inlineRadio<?= $row->kode_pengetahuan ?>4" value="1">
                            <label class="form-check-label" for="inlineRadio<?= $row->kode_pengetahuan ?>4">Pasti</label>
                        </div>
                    </div>
                </div>

                <hr>

            <?php } ?>


            <!-- <a href="<?= base_url('home/diagnosa/proses') ?>" class="btn btn-primary text-white float-right">Test Proses Diagnosa</a> -->
            <button type="submit" class="btn btn-warning text-white float-right">Proses Diagnosa</button>
        </form>
    </div>
</section>