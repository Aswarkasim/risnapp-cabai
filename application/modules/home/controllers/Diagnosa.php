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
            'nama_Konsultasi',
            'Nama Konsultasi',
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
                'nama_Konsultasi'     => $i->post('nama_Konsultasi'),
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
        $this->load->helper('string');


        $cek = $this->HM->checkKonsultasi();

        $id_konsultasi = '';

        if ($cek == null) {
            $dataKonsul = [
                'id_konsultasi'     => random_string('numeric', '15'),
            ];
            $this->Crud_model->add('tbl_konsultasi', $dataKonsul);
            $id_konsultasi = $dataKonsul['id_konsultasi'];
        } else {
            $id_konsultasi = $cek->id_konsultasi;
        }

        $ask = $this->HM->listPengetahuan();
        $data = array(
            'ask'             => $ask,
            'id_konsultasi'    => $id_konsultasi,
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

    public function proses($id_konsultasi)
    {


        $i = $this->input;

        $ask = $this->HM->listPengetahuan();
        foreach ($ask as $row) {
            $kode_pengetahuan = 'kode_pengetahuan' . $row->kode_pengetahuan;
            $jawab = 'jawabKonsultasi' . $row->kode_pengetahuan;
            $postJawab = $i->post($jawab);
            $cf_hasil_kali = $postJawab * $row->cf_root;
            $diagnosa = [
                'id_konsultasi'     => $id_konsultasi,
                'kode_pengetahuan' => $i->post($kode_pengetahuan),
                'nilai_cf'      => $postJawab,
                'kode_jenis'      => $row->kode_jenis,
                'cf_hasil'      => $cf_hasil_kali
            ];
            $this->Crud_model->add('tbl_diagnosa', $diagnosa);
        }

        redirect('home/diagnosa/rekapJawaban/' . $id_konsultasi);
    }

    function rekapJawaban($id_konsultasi)
    {
        $dataDiagnosa = $this->HM->listDiagnosaKonsultasi($id_konsultasi);
        $dataKonsultasi = $this->Crud_model->listingOne('tbl_Konsultasi', 'id_konsultasi', $id_konsultasi);
        $jenis = $this->Crud_model->listing('tbl_jenis');

        $cf_max = 0;
        $kode_jenis = '';

        // die;
        foreach ($jenis as $key => $row) {
            $jenis = $this->Crud_model->listingOneAll('tbl_diagnosa', 'kode_jenis', $row->kode_jenis);
            $cf_hasil = $this->hitung_cf($jenis);


            // echo $key . ' ' . $cf_hasil . '<br>';

            if ($cf_max <= $cf_hasil) {
                $cf_max = $cf_hasil;
                $kode_jenis = $row->kode_jenis;
            }
        }

        // echo $cf_max;
        // echo $kode_jenis;

        $penyakit = $this->Crud_model->listingOne('tbl_jenis', 'kode_jenis', $kode_jenis);

        // die;

        $data = [
            'id_konsultasi' => $id_konsultasi,
            'penyakit'      => $penyakit,
            'persentase'        => $cf_max,
            'data'      => $dataDiagnosa,
            'dataKonsultasi' => $dataKonsultasi,
            // 'kode_penyakit' => $kode_penyakit,
            'content' => 'diagnosa/proses'
        ];
        $this->load->view('layout/wrapper', $data);
    }

    private function hitung_cf($data)
    {

        $i = 0;
        $cf_1 = 0;
        $cf_2 = 0;
        $cf_old = 0;
        foreach ($data as $key => $value) {

            if ($key == 0) {
                $cf_1 = $value->cf_hasil;
            }
            if ($key == 1) {
                $cf_2 = $value->cf_hasil;
            }
        }
        $cf_old = $cf_1 + $cf_2 * (1 - $cf_1);
        //echo $cf_old . '</br>';

        foreach ($data as $key => $value) {
            $cf_old = $cf_old + $value->cf_hasil * (1 - $cf_old);
            //echo $cf_old . '</br>';
        }
        // echo $cf_old . '</br>';

        $persentase = $cf_old * 100;
        // echo $persentase;
        return $persentase;
    }

    function simpanDiagnosaKonsultasi($id_konsultasi, $kode_penyakit)
    {
        $data = [
            'id_konsultasi'         => $id_konsultasi,
            'akumulasi_cf'      => $this->input->post('akumulasi_cf'),
            'kode_penyakit'     => $this->input->post('kode_penyakit'),
            'tingkat'     => $this->input->post('tingkat'),
            'nama_penyakit'     => $this->input->post('nama_penyakit')
        ];
        $this->Crud_model->edit('tbl_Konsultasi', 'id_konsultasi', $id_konsultasi, $data);

        $this->session->set_flashdata('msg', 'Data disimpan');

        redirect('home/diagnosa/rekapJawaban/' . $id_konsultasi . '/' . $kode_penyakit);
    }

    function hapusData($id_konsultasi)
    {
        $this->Crud_model->delete('tbl_Konsultasi', 'id_konsultasi', $id_konsultasi);
        $Konsultasi = $this->Crud_model->listingOneAll('tbl_diagnosa', 'id_konsultasi', $id_konsultasi);
        foreach ($Konsultasi as $row) {
            $this->Crud_model->delete('tbl_diagnosa', 'id_konsultasi', $id_konsultasi);
        }
        $this->session->set_flashdata('msg', 'Data dihapus');
        redirect('home/diagnosa');
    }



    function cetak($id_konsultasi)
    {
        $data['data'] = $this->HM->Konsultasi($id_konsultasi);
        $data['konfigurasi'] = $this->Crud_model->listingOne('tbl_konfigurasi', 'id_konfigurasi', '1');
        $this->load->view('home/diagnosa/cetak', $data, FALSE);
    }
}
