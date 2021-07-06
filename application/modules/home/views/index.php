<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
    <!-- <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div> -->
    <div class="carousel-inner">
        <?php foreach ($banner as $key => $row) { ?>
            <div class="carousel-item <?= $key == 0 ? 'active' : '' ?>">
                <img src="<?= base_url($row->gambar); ?>" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5><?= $row->topik; ?></h5>
                    <p><?= $row->deskripsi; ?></p>
                    <a href="<?= base_url() ?>home/diagnosa/ask" class="btn btn-primary">Mulai Diagnosa <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
        <?php } ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<div class="container mt-4 mr-5 ml-5">
    <center>
        <h3><b>Tentang</b></h3>
    </center>

    <div class="row">
        <div class="col-md-5"></div>
        <div class="col-md-6">
            <p class=""><?= $konfigurasi->tentang; ?></p>
        </div>
    </div>

</div>

<section id="contact" class="bg-light mt-5">
    <div class="container">
        <div class="row pt-5">

            <h3><b> Kontak Kami</b></h3>

        </div>
        <img src="<?= base_url($konfigurasi->logo) ?>" width="300px" alt="">
        <hr>
        <div class="row">

            <div class="col-md-4">
                <p><strong><?= $konfigurasi->nama_instansi; ?></strong><br>
                    Nama Pimpinan : <?= $konfigurasi->nama_pimpinan; ?> <br>
                    Alamat : <?= $konfigurasi->alamat; ?> <br>

                </p>
            </div>
            <div class="col-md-4">
                Kontak Person : <?= $konfigurasi->kontak_person; ?> <br>
                Email : <?= $konfigurasi->email; ?> <br>
                <a href="<?= base_url('admin/auth'); ?>">Admin Log</a>
            </div>

            <div class="col-md-4">
                <?= $konfigurasi->deskripsi; ?>
            </div>

        </div>
    </div>
</section>