<div class="flash-data" data-flashdata="<?= $this->session->flashdata('msg') ?>"></div>

<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-cogs"></i> <?= $title ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                <?php
                echo validation_errors('<div class="alert alert-warning"><i class="fa fa-warning"></i> ', '</div>');
                ?>

                <form action="<?= base_url('admin/konfigurasi') ?>" method="post">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="" class="pull-right">Nama Instansi</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" value="<?= $konfigurasi->nama_instansi ?>" name="nama_instansi" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="" class="pull-right">Nama Pimpinan</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" value="<?= $konfigurasi->nama_pimpinan ?>" name="nama_pimpinan" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="" class="pull-right">Kontak Person</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" value="<?= $konfigurasi->kontak_person ?>" name="kontak_person" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="" class="pull-right">Email</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" value="<?= $konfigurasi->email ?>" name="email" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="" class="pull-right">Provinsi</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" value="<?= $konfigurasi->provinsi ?>" name="provinsi" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="" class="pull-right">Kota/Kabupaten</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" value="<?= $konfigurasi->kabupaten ?>" name="kabupaten" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="" class="pull-right">Kecamatan</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" value="<?= $konfigurasi->kecamatan ?>" name="kecamatan" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="" class="pull-right">Alamat Lengkap</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" value="<?= $konfigurasi->alamat ?>" name="alamat" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="" class="pull-right">Deskripsi Singkat</label>
                            </div>
                            <div class="col-md-9">
                                <textarea name="deskripsi" class="form-control" id="" cols="30" rows="10"><?= $konfigurasi->deskripsi; ?></textarea>
                            </div>
                        </div>
                    </div>



                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">

                            </div>
                            <div class="col-md-9">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </div>

                </form>



            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>