<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Jenis extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in_user();
    }

    public function index()
    {
        $jenis = $this->Crud_model->listing('tbl_jenis');
        $data = array(
            'title'     => 'Manjemen Jenis',
            'add'       => 'admin/jenis/add',
            'edit'      => 'admin/jenis/edit/',
            'delete'    => 'admin/jenis/delete/',
            'jenis'    => $jenis,
            'content'       => 'admin/jenis/list',
        );
        $this->load->view('layout/wrapper', $data, FALSE);
    }

    public function add()
    {

        $this->load->helper('string');


        $valid = $this->form_validation;
        $valid->set_rules(
            'kode',
            'Kode Jenis',
            'required|max_length[5]|is_unique[tbl_jenis.kode_jenis]',
            array(
                'required' => ' %s harus diisi',
                'is_unique' => 'Kode telah ada. Masukkan kode yang lain',
                'max_length' => 'panjang maksimal kode jenis adalah 3 karakter'
            )
        );
        $valid->set_rules(
            'nama',
            'Nama Jenis',
            'required',
            array('required' => ' %s harus diisi')
        );
        if ($valid->run()) {
            if (!empty($_FILES['gambar']['name'])) {
                $config['upload_path']   = './assets/uploads/images/';
                $config['allowed_types'] = 'gif|jpg|png|svg|jpeg';
                $config['max_size']      = '24000'; // KB 
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('gambar')) {
                    $data = [
                        'title'     => 'Manjemen Jenis',
                        'add'       => 'admin/jenis/add',
                        'back'      => 'admin/jenis',
                        'error'     => $this->upload->display_errors(),
                        'content'       => 'admin/jenis/add',
                    ];
                    $this->load->view('admin/layout/wrapper', $data, FALSE);
                } else {
                    $upload_data = ['uploads' => $this->upload->data()];

                    $i = $this->input;

                    $data = [
                        'kode_jenis'   => $i->post('kode'),
                        'nama_jenis'   => $i->post('nama'),
                        'deskripsi'   => $i->post('deskripsi'),
                        'penanganan'   => $i->post('penanganan'),
                        'gambar'          => $config['upload_path'] . $upload_data['uploads']['file_name']
                    ];
                    $this->Crud_model->add('tbl_jenis', $data);
                    $this->session->set_flashdata('msg', ' Data telah ditambah');
                    redirect('admin/jenis/add', 'refresh');
                }
            }
        }
        $data = [
            'title'     => 'Manjemen Jenis',
            'add'       => 'admin/jenis/add',
            'back'      => 'admin/jenis',
            'content'   => 'admin/jenis/add',
        ];
        $this->load->view('admin/layout/wrapper', $data, FALSE);
    }


    public function edit($kode_jenis)
    {
        $jenis = $this->Crud_model->listingOne('tbl_jenis', 'kode_jenis', $kode_jenis);
        $valid = $this->form_validation;
        $valid->set_rules(
            'kode',
            'Kode Jenis',
            'required|max_length[5]',
            array(
                'required' => ' %s harus diisi',
                'max_length' => 'panjang maksimal kode jenis adalah 3 karakter'
            )
        );
        $valid->set_rules(
            'nama',
            'Nama Jenis',
            'required',
            array('required' => ' %s harus diisi')
        );

        if ($valid->run()) {
            if (!empty($_FILES['gambar']['name'])) {
                $config['upload_path']   = './assets/uploads/images/';
                $config['allowed_types'] = 'gif|jpg|png|svg|jpeg';
                $config['max_size']      = '24000'; // KB 
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('gambar')) {
                    $data = [
                        'title'     => 'Manjemen Jenis',
                        'edit'       => 'admin/jenis/edit/',
                        'back'      => 'admin/jenis',
                        'jenis'      => $jenis,
                        'error'     => $this->upload->display_errors(),
                        'content'       => 'admin/jenis/edit',
                    ];
                    $this->load->view('admin/layout/wrapper', $data, FALSE);
                } else {

                    if ($jenis->gambar != '') {
                        unlink($jenis->gambar);
                    }
                    $upload_data = ['uploads' => $this->upload->data()];
                    $i = $this->input;

                    $data = [
                        'kode_jenis'   => $i->post('kode'),
                        'nama_jenis'   => $i->post('nama'),
                        'deskripsi'   => $i->post('deskripsi'),
                        'penanganan'   => $i->post('penanganan'),
                        'gambar'          => $config['upload_path'] . $upload_data['uploads']['file_name']
                    ];
                    $this->Crud_model->edit('tbl_jenis', 'kode_jenis', $kode_jenis, $data);
                    $this->session->set_flashdata('msg', ' Data telah diedit');
                    redirect('admin/jenis/edit/' . $kode_jenis, 'refresh');
                }
            } else {
                $i = $this->input;

                $data = [
                    'kode_jenis'   => $i->post('kode'),
                    'nama_jenis'   => $i->post('nama'),
                    'penanganan'   => $i->post('penanganan'),
                    'deskripsi'   => $i->post('deskripsi')
                ];
                $this->Crud_model->edit('tbl_jenis', 'kode_jenis', $kode_jenis, $data);
                $this->session->set_flashdata('msg', ' Data telah diedit');
                redirect('admin/jenis/edit/' . $kode_jenis, 'refresh');
            }
        }
        $data = [
            'title'     => 'Manjemen Jenis',
            'jenis'      => $jenis,
            'edit'       => 'admin/jenis/edit/',
            'back'      => 'admin/jenis',
            'content'   => 'admin/jenis/edit',
        ];
        $this->load->view('admin/layout/wrapper', $data, FALSE);
    }

    function detail($kode_jenis)
    {

        $penanganan = $this->Crud_model->listingOneAll('tbl_penanganan', 'kode_jenis', $kode_jenis);
        $data = [
            'penanganan' => $penanganan,
            'content'  => 'admin/jenis/detail'
        ];
        $this->load->view('admin/layout/wrapper', $data, FALSE);
    }

    function delete($kode_jenis)
    {
        $jenis = $this->Crud_model->listingOne('tbl_jenis', 'kode_jenis', $kode_jenis);
        if ($jenis->gambar != '') {
            unlink($jenis->gambar);
        }

        $this->Crud_model->delete('tbl_jenis', 'kode_jenis', $kode_jenis);
        redirect('admin/jenis', 'refresh');
    }

    function ubahPenanganan($id_penanganan, $kode_jenis)
    {
        $data = array(
            'deskripsi'   => $this->input->post('deskripsi')
        );
        $this->Crud_model->edit('tbl_penanganan', 'id_penanganan', $id_penanganan, $data);
        $this->session->set_flashdata('msg', ' Data telah diedit');
        redirect('admin/jenis/detail/' . $kode_jenis, 'refresh');
    }
}
