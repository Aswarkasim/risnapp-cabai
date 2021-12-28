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
        $gejala = $this->Crud_model->listing('tbl_gejala');

        $pilihGejala = $this->HM->listPilihDiagnosa($id_konsultasi);
        $data = array(
            'pilihGejala'             => $pilihGejala,
            'gejala'             => $gejala,
            'id_konsultasi'    => $id_konsultasi,
            'content'         => 'diagnosa/ask'
        );
        $this->load->view('layout/wrapper', $data);
    }

    function pilih($id_konsultasi, $kode_gejala, $value)
    {

        switch ($value) {
            case '1':
                $value = 0.4;
                break;

            case '2':
                $value = 0.8;
                break;
            case '3':
                $value = 1;
                break;

            default:
                $value = 0;
                break;
        }
        $gejala = $this->Crud_model->listingOne('tbl_gejala', 'kode_gejala', $kode_gejala);
        // print_r($value * $gejala->nilai_cf);
        // die;
        $role = $this->Crud_model->listingOneAll('tbl_role', 'kode_gejala', $kode_gejala);
        foreach ($role as $row) {
            $data = [
                'id_konsultasi'         => $id_konsultasi,
                'kode_gejala'           => $row->kode_gejala,
                'kode_jenis'           => $row->kode_jenis,
                'nilai_cf'            => $value,
                'cf_hasil'            => $value * $gejala->nilai_cf
            ];
            $this->Crud_model->add('tbl_diagnosa', $data);
        }
        redirect('home/diagnosa/ask/' . $id_konsultasi);
    }

    function batal($id_konsultasi, $id_diagnosa)
    {
        $this->Crud_model->delete('tbl_diagnosa', 'id_diagnosa', $id_diagnosa);
        redirect('home/diagnosa/ask/' . $id_konsultasi);
    }


    function simpan($id)
    {
        //$id = $this->uri->segment(4);
        $this->session->set_flashdata('msg', 'Data disimpan');
        redirect('home/diagnosa/rekapJawaban/' . $id);
    }

    function proses($id_konsultasi)
    {

        $this->load->model('home/CF_home', 'CF');

        $diagnosa = $this->HM->listDiagnosaRole($id_konsultasi);
        // printr_pretty($diagnosa);


        $max_cf = 0;
        $kp = '';
        foreach ($diagnosa as $d) {
            // echo $d->kode_jenis . '<br>';

            $role = $this->Crud_model->listing('tbl_role');

            foreach ($role as $r) {
                $cek = $this->HM->dataDiagnosaByPasien($id_konsultasi, $r->kode_gejala);
                if (empty($cek)) {
                    if ($r->kode_gejala != $d->kode_gejala) {
                        $data = [
                            'id_konsultasi'     => $id_konsultasi,
                            'kode_gejala'   => $r->kode_gejala,
                            'kode_jenis'   => $r->kode_jenis,
                            'nilai_cf'      => 0,
                            'cf_hasil'      => 0
                        ];
                        $this->Crud_model->add('tbl_diagnosa', $data);
                    }
                }
            }

            $jenis = $this->HM->listDiagnosaRoleByPenyakit($id_konsultasi, $d->kode_jenis);

            // $cf = $this->CF->hitung_cf($jenis);
            // printr_pretty($jenis);

            $cf = $this->CF->hitung_cf($jenis);
            // printr_pretty($cf);
            if ($max_cf <= $cf) {
                $max_cf = $cf;
                $kp = $d->kode_jenis;
            }
        }

        // print_r($max_cf);
        // die();

        // die;
        $dataDiagnosa = $this->HM->listPilihDiagnosa($id_konsultasi);

        // $kode_jenis = $this->CF->getValuePenyakit($id_konsultasi);


        // printr_pretty($kode_jenis);
        // die();

        $konsultasi = $this->Crud_model->listingOne('tbl_konsultasi', 'id_konsultasi', $id_konsultasi);
        $jenis = $this->Crud_model->listingOne('tbl_jenis', 'kode_jenis', $konsultasi->kode_jenis);

        // $cf = $this->CF->hitung_cf($dataDiagnosa);

        $dataPasien = [
            'akumulasi_cf'     => $max_cf,
            'kode_jenis'    => $kp,
            'nama_jenis'    => $jenis->nama_jenis,
        ];

        $this->Crud_model->edit('tbl_konsultasi', 'id_konsultasi', $id_konsultasi, $dataPasien);




        $data = array(
            'title'         => 'Hasil Diagnosa',
            'jenis'      => $jenis,
            'id_konsultasi' => $id_konsultasi,
            'konsultasi'      => $konsultasi,
            'dataDiagnosa'  => $dataDiagnosa,
            'diagnosa'      => $diagnosa,
            'content'           => 'diagnosa/proses',
        );
        $this->load->view('layout/wrapper', $data, FALSE);
    }

    // public function proses($id_konsultasi)
    // {


    //     $i = $this->input;

    //     $ask = $this->HM->listPengetahuan();
    //     foreach ($ask as $row) {
    //         $kode_pengetahuan = 'kode_pengetahuan' . $row->kode_pengetahuan;
    //         $jawab = 'jawabKonsultasi' . $row->kode_pengetahuan;
    //         $postJawab = $i->post($jawab);
    //         $cf_hasil_kali = $postJawab * $row->cf_root;
    //         $diagnosa = [
    //             'id_konsultasi'     => $id_konsultasi,
    //             'kode_pengetahuan' => $i->post($kode_pengetahuan),
    //             'nilai_cf'      => $postJawab,
    //             'kode_jenis'      => $row->kode_jenis,
    //             'cf_hasil'      => $cf_hasil_kali
    //         ];
    //         $this->Crud_model->add('tbl_diagnosa', $diagnosa);
    //     }

    //     redirect('home/diagnosa/rekapJawaban/' . $id_konsultasi);
    // }

    // function rekapJawaban($id_konsultasi)
    // {
    //     $dataDiagnosa = $this->HM->listDiagnosaKonsultasi($id_konsultasi);
    //     $konsultasi = $this->Crud_model->listingOne('tbl_konsultasi', 'id_konsultasi', $id_konsultasi);
    //     $jenis = $this->Crud_model->listing('tbl_jenis');

    //     $cf_max = 0;
    //     $kode_jenis = '';

    //     // die;
    //     foreach ($jenis as $key => $row) {
    //         $jenis = $this->Crud_model->listingOneAll('tbl_diagnosa', 'kode_jenis', $row->kode_jenis);
    //         $cf_hasil = $this->hitung_cf($jenis);


    //         // echo $key . ' ' . $cf_hasil . '<br>';

    //         if ($cf_max <= $cf_hasil) {
    //             $cf_max = $cf_hasil;
    //             $kode_jenis = $row->kode_jenis;
    //         }

    //         // echo $cf_hasil;
    //     }

    //     // echo $cf_max;
    //     // echo $kode_jenis;

    //     $jenis = $this->Crud_model->listingOne('tbl_jenis', 'kode_jenis', $kode_jenis);

    //     // die;

    //     $dataKonsultasi = [
    //         'akumulasi_cf' => $cf_max,
    //         'kode_jenis' => $jenis->kode_jenis,
    //         'nama_jenis' => $jenis->nama_jenis
    //     ];
    //     $this->Crud_model->edit('tbl_konsultasi', 'id_konsultasi', $id_konsultasi, $dataKonsultasi);

    //     $data = [
    //         'id_konsultasi' => $id_konsultasi,
    //         'jenis'      => $jenis,
    //         'persentase'        => $cf_max,
    //         'data'      => $dataDiagnosa,
    //         'dataKonsultasi' => $dataKonsultasi,
    //         'konsultasi' => $konsultasi,
    //         // 'kode_jenis' => $kode_jenis,
    //         'content' => 'diagnosa/proses'
    //     ];
    //     $this->load->view('layout/wrapper', $data);
    // }

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

    // function simpanDiagnosaKonsultasi($id_konsultasi, $kode_jenis)
    // {
    //     $data = [
    //         'id_konsultasi'         => $id_konsultasi,
    //         'akumulasi_cf'      => $this->input->post('akumulasi_cf'),
    //         'kode_jenis'     => $this->input->post('kode_jenis'),
    //         'tingkat'     => $this->input->post('tingkat'),
    //         'nama_jenis'     => $this->input->post('nama_jenis')
    //     ];
    //     $this->Crud_model->edit('tbl_konsultasi', 'id_konsultasi', $id_konsultasi, $data);

    //     $this->session->set_flashdata('msg', 'Data disimpan');

    //     redirect('home/diagnosa/rekapJawaban/' . $id_konsultasi . '/' . $kode_jenis);
    // }

    function simpanHasil($id_konsultasi)
    {
        $data = [
            'nama_konsultasi'   => $this->input->post('nama_konsultasi')
        ];
        $this->Crud_model->edit('tbl_konsultasi', 'id_konsultasi', $id_konsultasi, $data);
        $this->session->set_flashdata('msg', 'Data Disimpan');
        redirect('home/diagnosa/proses/' . $id_konsultasi);
    }

    function hapusData($id_konsultasi)
    {
        $this->Crud_model->delete('tbl_konsultasi', 'id_konsultasi', $id_konsultasi);
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
