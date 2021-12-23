<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Konfigurasi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in_user();
    }


    public function index()
    {
        $konfigurasi = $this->Crud_model->listingOne('tbl_konfigurasi', 'id_konfigurasi', '1');
        $valid = $this->form_validation;
        $valid->set_rules('nama_instansi', 'Nama Instansi', 'required', array('required' => '%s tidak boleh kosong'));

        if ($valid->run() === FALSE) {
            $data = [
                'title'     => 'konfigurasi ',
                'back'      => 'barang/konfigurasi',
                'konfigurasi'    => $konfigurasi,
                'content'   => 'admin/konfigurasi/edit'
            ];
            $this->load->view('admin/layout/wrapper', $data, FALSE);
        } else {
            $i = $this->input;
            $data = [
                'nama_instansi'   => $i->post('nama_instansi'),
                'nama_pimpinan'   => $i->post('nama_pimpinan'),
                'kontak_person'   => $i->post('kontak_person'),
                'provinsi'   => $i->post('provinsi'),
                'kabupaten'   => $i->post('kabupaten'),
                'kecamatan'   => $i->post('kecamatan'),
                'email'   => $i->post('email'),
                'deskripsi'   => $i->post('deskripsi'),
                'alamat'   => $i->post('alamat')
            ];
            $this->Crud_model->edit('tbl_konfigurasi', 'id_konfigurasi', '1', $data);
            $this->session->set_flashdata('msg', 'Konfigurasi diubah');
            redirect('admin/konfigurasi');
        }
    }

    function panduan()
    {
        $konfigurasi = $this->Crud_model->listingOne('tbl_konfigurasi', 'id_konfigurasi', '1');
        $valid = $this->form_validation;
        $valid->set_rules('head_panduan', 'Judul', 'required', array('required' => '%s tidak boleh kosong'));

        if ($valid->run() === FALSE) {
            $data = [
                'title'     => 'konfigurasi ',
                'back'      => 'barang/konfigurasi',
                'konfigurasi'    => $konfigurasi,
                'content'   => 'admin/konfigurasi/panduan'
            ];
            $this->load->view('admin/layout/wrapper', $data, FALSE);
        } else {
            $i = $this->input;
            $data = [
                'head_panduan'   => $i->post('head_panduan'),
                'panduan'   => $i->post('panduan'),
                'alamat'   => $i->post('alamat')
            ];
            $this->Crud_model->edit('tbl_konfigurasi', 'id_konfigurasi', '1', $data);
            $this->session->set_flashdata('msg', 'Konfigurasi diubah');
            redirect('admin/konfigurasi/panduan');
        }
    }

    // public function banner()
    // {
    //     $konfigurasi = $this->Crud_model->listingOne('tbl_konfigurasi', 'id_konfigurasi', '1');
    //     $required = '%s tidak boleh kosong';
    //     $valid = $this->form_validation;
    //     $valid->set_rules('topik_banner', 'Topik', 'required', ['required' => $required]);
    //     if ($valid->run()) {
    //         if (!empty($_FILES['banner']['name'])) {
    //             $config['upload_path']   = './assets/uploads/';
    //             $config['allowed_types'] = 'gif|jpg|png|svg|jpeg';
    //             $config['max_size']      = '2048'; // KB 
    //             $this->upload->initialize($config);
    //             if (!$this->upload->do_upload('banner')) {
    //                 $data = [
    //                     'konfigurasi' => $konfigurasi,
    //                     'error'     => $this->upload->display_errors(),
    //                     'content'   => 'admin/konfigurasi/banner'
    //                 ];
    //                 $this->load->view('admin/layout/wrapper', $data, FALSE);
    //             } else {
    //                 if ($konfigurasi->banner != "") {
    //                     unlink('assets/uploads/' . $konfigurasi->banner);
    //                 }
    //                 $upload_data = ['uploads' => $this->upload->data()];

    //                 $data = [
    //                     'topik_banner'      => $this->input->post('topik_banner'),
    //                     'deskripsi_banner'  => $this->input->post('deskripsi_banner'),
    //                     'banner'            => $upload_data['uploads']['file_name']
    //                 ];
    //                 $this->Crud_model->edit('tbl_konfigurasi', 'id_konfigurasi', '1', $data);
    //                 $this->session->set_flashdata('msg', 'Banner diubah');
    //                 redirect('admin/konfigurasi/banner/');
    //             }
    //         } else {
    //             $data = [
    //                 'topik_banner'      => $this->input->post('topik_banner'),
    //                 'deskripsi_banner'  => $this->input->post('deskripsi_banner')
    //             ];
    //             $this->Crud_model->edit('tbl_konfigurasi', 'id_konfigurasi', '1', $data);
    //             $this->session->set_flashdata('msg', 'Banner diubah');
    //             redirect('admin/konfigurasi/banner/');
    //         }
    //     }
    //     $data = [
    //         'konfigurasi'   => $konfigurasi,
    //         'content'       => 'admin/konfigurasi/banner'
    //     ];
    //     $this->load->view('admin/layout/wrapper', $data, FALSE);
    // }


    public function banner()
    {
        $this->load->helper('string');

        $banner = $this->Crud_model->listing('tbl_banner');
        $required = '%s tidak boleh kosong';
        $valid = $this->form_validation;
        $valid->set_rules('urutan', 'Urutan', 'required|is_unique[tbl_banner.urutan]', ['required' => $required, 'is_unique' => 'Urutan <strong>' . $this->input->post('urutan') . '</strong> telah ada. silakan masukkan angka urutan yang lain']);
        if (empty($_FILES['gambar']['name'])) {
            $valid->set_rules('gambar', 'Gambar', 'required');
        }
        if ($valid->run()) {
            if (!empty($_FILES['gambar']['name'])) {
                $config['upload_path']   = './assets/uploads/banner/';
                $config['allowed_types'] = 'gif|jpg|png|svg|jpeg';
                $config['max_size']      = '24000'; // KB 
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('gambar')) {
                    $data = [
                        'banner'    => $banner,
                        'error'     => $this->upload->display_errors(),
                        'content'   => 'admin/banner/index'
                    ];
                    $this->load->view('admin/layout/wrapper', $data, FALSE);
                } else {
                    $upload_data = ['uploads' => $this->upload->data()];

                    $data = [
                        'id_banner'      => random_string('numeric', '5'),
                        'topik'        => $this->input->post('topik'),
                        'deskripsi'        => $this->input->post('deskripsi'),
                        'urutan'        => $this->input->post('urutan'),
                        'gambar'        => $config['upload_path'] . $upload_data['uploads']['file_name']
                    ];
                    $this->Crud_model->add('tbl_banner', $data);
                    $this->session->set_flashdata('msg', 'Banner ditambahkan');
                    redirect('admin/konfigurasi/banner/index');
                }
            }
        }
        $data = [
            'banner'    => $banner,
            'content'   => 'admin/banner/index'
        ];
        $this->load->view('admin/layout/wrapper', $data, FALSE);
    }

    public function BannerEdit($id_banner)
    {

        $banner = $this->Crud_model->listingOne('tbl_banner', 'id_banner', $id_banner);
        $required = '%s tidak boleh kosong';
        $valid = $this->form_validation;
        $valid->set_rules('topik', 'Topik', 'required', ['required' => $required]);
        // if (empty($_FILES['gambar']['name'])) {
        //     $valid->set_rules('gambar', 'Gambar', 'required');
        // }
        if ($valid->run()) {
            if (!empty($_FILES['gambar']['name'])) {
                $config['upload_path']   = './assets/uploads/banner/';
                $config['allowed_types'] = 'gif|jpg|png|svg|jpeg';
                $config['max_size']      = '24000'; // KB 
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('gambar')) {
                    $data = [
                        'banner'    => $banner,
                        'error'     => $this->upload->display_errors(),
                        'content'   => 'admin/banner/edit'
                    ];
                    $this->load->view('admin/layout/wrapper', $data, FALSE);
                } else {
                    if ($banner->gambar != "") {
                        unlink('assets/uploads/banner/' . $banner->gambar);
                    }
                    $upload_data = ['uploads' => $this->upload->data()];

                    $data = [
                        'id_banner'      => $id_banner,
                        'topik'        => $this->input->post('topik'),
                        'deskripsi'        => $this->input->post('deskripsi'),
                        'gambar'        => $config['upload_path'] . $upload_data['uploads']['file_name']
                    ];
                    $this->Crud_model->edit('tbl_banner', 'id_banner', $id_banner, $data);
                    $this->session->set_flashdata('msg', 'Banner ditambahkan');
                    redirect('admin/konfigurasi/banner/index');
                }
            } else {
                $data = [
                    'id_banner'      => $id_banner,
                    'topik'        => $this->input->post('topik'),
                    'deskripsi'        => $this->input->post('deskripsi'),
                    'urutan'        => $this->input->post('urutan')
                ];
                $this->Crud_model->edit('tbl_banner', 'id_banner', $id_banner, $data);
                $this->session->set_flashdata('msg', 'Banner ditambahkan');
                redirect('admin/konfigurasi/banner/index');
            }
        }
        $data = [
            'banner'    => $banner,
            'content'   => 'admin/banner/edit'
        ];
        $this->load->view('admin/layout/wrapper', $data, FALSE);
    }

    function Bannerdelete($id_banner)
    {
        $gambar = $this->Crud_model->listingOne('tbl_banner', 'id_banner', $id_banner);
        unlink($gambar->gambar);
        $this->Crud_model->delete('tbl_banner', 'id_banner', $id_banner);
        $this->session->set_flashdata('msg', 'Gambar telah dihapus');

        redirect('admin/konfigurasi/banner', 'refresh');
    }


    function tentang()
    {
        $konfigurasi = $this->Crud_model->listingOne('tbl_konfigurasi', 'id_konfigurasi', '1');
        $valid = $this->form_validation;
        $valid->set_rules('tentang', 'Tentang', 'required', array('required' => '%s tidak boleh kosong'));

        if ($valid->run() === FALSE) {
            $data = [
                'title'     => 'konfigurasi ',
                'back'      => 'barang/konfigurasi',
                'konfigurasi'    => $konfigurasi,
                'content'   => 'admin/konfigurasi/tentang'
            ];
            $this->load->view('admin/layout/wrapper', $data, FALSE);
        } else {
            $i = $this->input;
            $data = [
                'tentang'   => $i->post('tentang')
            ];
            $this->Crud_model->edit('tbl_konfigurasi', 'id_konfigurasi', '1', $data);
            $this->session->set_flashdata('msg', 'Konfigurasi diubah');
            redirect('admin/konfigurasi/tentang');
        }
    }
}
