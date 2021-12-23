<?php



defined('BASEPATH') or exit('No direct script access allowed');

class Home_model extends CI_Model
{
    public function listPengetahuan()
    {
        $this->db->select('tbl_pengetahuan.*, tbl_jenis.*, tbl_gejala.nama_gejala, tbl_gejala.nilai_cf as cf_root')
            ->from('tbl_pengetahuan')
            ->join('tbl_jenis', 'tbl_jenis.kode_jenis = tbl_pengetahuan.kode_jenis', 'left')
            ->join('tbl_gejala', 'tbl_gejala.kode_gejala = tbl_pengetahuan.kode_gejala', 'left');
        return $this->db->get()->result();
    }

    public function konsultasi($id_konsultasi)
    {
        $this->db->select('tbl_konsultasi.*, tbl_jenis.*')
            ->from('tbl_konsultasi')
            ->join('tbl_jenis', 'tbl_jenis.kode_jenis = tbl_konsultasi.kode_penyakit', 'left')
            ->where('id_konsultasi', $id_konsultasi);
        return $this->db->get()->row();
    }

    public function listDiagnosaKonsultasi($id_konsultasi)
    {
        $this->db->select(
            'tbl_diagnosa.*, 
            tbl_pengetahuan.*, 
            tbl_jenis.*,
            tbl_gejala.nama_gejala, 
            tbl_gejala.nilai_cf as cf_root'
        )
            ->from('tbl_diagnosa')
            ->join('tbl_pengetahuan', 'tbl_pengetahuan.kode_pengetahuan = tbl_diagnosa.kode_pengetahuan', 'left')
            ->join('tbl_jenis', 'tbl_jenis.kode_jenis = tbl_pengetahuan.kode_jenis', 'left')
            ->join('tbl_gejala', 'tbl_gejala.kode_gejala = tbl_pengetahuan.kode_gejala', 'left')
            ->where('tbl_diagnosa.id_konsultasi', $id_konsultasi);
        return $this->db->get()->result_array();
    }

    function listJenisDiagnosa()
    {
        $this->db->select('*')
            ->from('tbl_jenis')
            ->where('parameter', '== 74');
        return $this->db->get()->row();
    }

    function listPenanganan($kode_penyakit, $tingkat)
    {
        $this->db->select('*')
            ->from('tbl_penanganan')
            ->where('kode_jenis', $kode_penyakit)
            ->where('tingkat', $tingkat);
        return $this->db->get()->row();
    }

    function checkKonsultasi()
    {
        $query = $this->db->select('*')
            ->from('tbl_konsultasi')
            ->where('nama_konsultasi', '')
            ->where('akumulasi_cf', '0')
            ->where('kode_penyakit', '')
            ->where('nama_penyakit', '')
            ->get();
        return $query->row();
    }
}
