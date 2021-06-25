<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Diagnosa extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('home/Home_model', 'HM');
    }


    public function index()
    {
        $data = [
            'content' => 'diagnosa/index'
        ];

        $this->load->view('layout/wrapper', $data);
    }

    public function klasifikasi()
    {
        $valid = $this->form_validation;
        $valid->set_rules(
            'nama_pasien',
            'Nama Pasien',
            'required',
            array('required' => ' %s harus diisi')
        );
        $valid->set_rules(
            'umur',
            'Umur',
            'required',
            array('required' => ' %s harus diisi')
        );

        if ($valid->run() === FALSE) {

            $data = [

                'content' => 'diagnosa/index'
            ];

            $this->load->view('layout/wrapper', $data);
        } else {
            $i = $this->input;
            $data = array(
                'nama_pasien'     => $i->post('nama_pasien'),
                'jenis_kelamin'   => $i->post('jenis_kelamin'),
                'tgl_lahir'            => $i->post('tgl_lahir'),
                'umur'            => $i->post('umur'),
                'content' => 'diagnosa/klasifikasi'
            );
            $this->load->view('layout/wrapper', $data);
        }
    }


    public function ask()
    {



        $ask = $this->HM->listPengetahuan();
        $data = array(
            'ask'             => $ask,
            'content'         => 'diagnosa/ask'
        );
        $this->load->view('layout/wrapper', $data);
    }

    function simpan($id)
    {
        //$id = $this->uri->segment(4);
        $this->session->set_flashdata('msg', 'Data disimpan');
        redirect('home/diagnosa/rekapJawaban/' . $id);
    }

    public function proses($kode_penyakit)
    {
        $this->load->helper('string');

        $i = $this->input;
        $dataPasien = [
            'id_pasien'     => random_string('numeric', '15'),
            'nama_pasien'   => $i->post('nama_pasien'),
            'umur'          => $i->post('umur'),
            'kode_penyakit'          => $i->post('kode_penyakit'),
            'jenis_kelamin' => $i->post('jenis_kelamin')
        ];
        $this->Crud_model->add('tbl_pasien', $dataPasien);

        $ask = $this->HM->listPengetahuan($kode_penyakit);
        // $penyakit = $this->Crud_model->listingOne('tbl_jenis', 'kode_penyakit', $kode_penyakit);

        foreach ($ask as $row) {
            $kode_pengetahuan = 'kode_pengetahuan' . $row->kode_pengetahuan;
            $jawab = 'jawabPasien' . $row->kode_pengetahuan;
            $postJawab = $i->post($jawab);
            $cf_hasil_kali = $postJawab * $row->cf_root;
            $diagnosa = [
                'id_pasien'     => $dataPasien['id_pasien'],
                'kode_pengetahuan' => $i->post($kode_pengetahuan),
                'nilai_cf'      => $postJawab,
                'cf_hasil'      => $cf_hasil_kali
            ];
            $this->Crud_model->add('tbl_diagnosa', $diagnosa);
        }

        redirect('home/diagnosa/rekapJawaban/' . $dataPasien['id_pasien'] . '/' . $kode_penyakit);
    }

    function rekapJawaban($id_pasien, $kode_penyakit)
    {
        $dataInput = $this->HM->listDiagnosaPasien($id_pasien);
        $dataPasien = $this->Crud_model->listingOne('tbl_pasien', 'id_pasien', $id_pasien);
        $penyakit = $this->Crud_model->listingOne('tbl_jenis', 'kode_jenis', $kode_penyakit);
        $data = [
            'id_pasien' => $id_pasien,
            'penyakit'      => $penyakit,
            'data'      => $dataInput,
            'dataPasien' => $dataPasien,
            'kode_penyakit' => $kode_penyakit,
            'content' => 'diagnosa/proses'
        ];
        $this->load->view('layout/wrapper', $data);
    }

    function simpanDiagnosaPasien($id_pasien, $kode_penyakit)
    {
        $data = [
            'id_pasien'         => $id_pasien,
            'akumulasi_cf'      => $this->input->post('akumulasi_cf'),
            'kode_penyakit'     => $this->input->post('kode_penyakit'),
            'tingkat'     => $this->input->post('tingkat'),
            'nama_penyakit'     => $this->input->post('nama_penyakit')
        ];
        $this->Crud_model->edit('tbl_pasien', 'id_pasien', $id_pasien, $data);

        $this->session->set_flashdata('msg', 'Data disimpan');

        redirect('home/diagnosa/rekapJawaban/' . $id_pasien . '/' . $kode_penyakit);
    }

    function hapusData($id_pasien)
    {
        $this->Crud_model->delete('tbl_pasien', 'id_pasien', $id_pasien);
        $pasien = $this->Crud_model->listingOneAll('tbl_diagnosa', 'id_pasien', $id_pasien);
        foreach ($pasien as $row) {
            $this->Crud_model->delete('tbl_diagnosa', 'id_pasien', $id_pasien);
        }
        $this->session->set_flashdata('msg', 'Data dihapus');
        redirect('home/diagnosa');
    }



    function cetak($id_pasien)
    {
        $data['data'] = $this->HM->pasien($id_pasien);
        $data['konfigurasi'] = $this->Crud_model->listingOne('tbl_konfigurasi', 'id_konfigurasi', '1');
        $this->load->view('home/diagnosa/cetak', $data, FALSE);
    }
}
