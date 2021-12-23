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
            ->join('tbl_jenis', 'tbl_jenis.kode_jenis = tbl_konsultasi.kode_jenis', 'left')
            ->where('id_konsultasi', $id_konsultasi);
        return $this->db->get()->row();
    }

    function listPilihDiagnosa($id_konsultasi)
    {
        $this->db->select('
                            tbl_diagnosa.*, 
                            tbl_gejala.nama_gejala
                            ')
            ->from('tbl_diagnosa')
            ->join('tbl_gejala', 'tbl_gejala.kode_gejala = tbl_diagnosa.kode_gejala', 'left')
            ->where('tbl_diagnosa.id_konsultasi', $id_konsultasi);
        return $this->db->get()->result();
    }

    function cekGejala($id_konsultasi, $kode_gejala)
    {
        return $this->db->select('*')
            ->from('tbl_diagnosa')
            ->where('id_konsultasi', $id_konsultasi)
            ->where('kode_gejala', $kode_gejala)->get()->row();
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

    function listPenanganan($kode_jenis, $tingkat)
    {
        $this->db->select('*')
            ->from('tbl_penanganan')
            ->where('kode_jenis', $kode_jenis)
            ->where('tingkat', $tingkat);
        return $this->db->get()->row();
    }

    function checkKonsultasi()
    {
        $query = $this->db->select('*')
            ->from('tbl_konsultasi')
            ->where('nama_konsultasi', '')
            ->where('akumulasi_cf', '0')
            ->where('kode_jenis', '')
            ->where('nama_jenis', '')
            ->get();
        return $query->row();
    }


    function listDiagnosaRole($id_konsultasi)
    {
        $this->db->select('
                            tbl_diagnosa.*, 
                            tbl_role.kode_jenis
                            ')
            ->from('tbl_diagnosa')
            ->join('tbl_role', 'tbl_role.kode_gejala = tbl_diagnosa.kode_gejala', 'left')
            ->where('tbl_diagnosa.id_konsultasi', $id_konsultasi);
        return $this->db->get()->result();
    }


    function listDiagnosaRoleByPenyakit($id_konsultasi, $kode_jenis)
    {
        $this->db->select('
                            tbl_diagnosa.*, 
                            tbl_role.kode_jenis
                            ')
            ->from('tbl_diagnosa')
            ->join('tbl_role', 'tbl_role.kode_gejala = tbl_diagnosa.kode_gejala', 'left')
            ->where('tbl_diagnosa.id_konsultasi', $id_konsultasi)
            ->where('tbl_diagnosa.kode_jenis', $kode_jenis);
        return $this->db->get()->result();
    }

    function dataDiagnosaByPasien($id_konsultasi, $kode_gejala)
    {
        $this->db->select('*')
            ->from('tbl_diagnosa')
            ->where('tbl_diagnosa.id_konsultasi', $id_konsultasi)
            ->where('kode_gejala', $kode_gejala);
        return $this->db->get()->row();
    }

    function groupPenyakit()
    {
        return $this->db->select('*')
            ->from('tbl_role')
            ->group_by('kode_jenis')
            ->get()->result();
    }
}
