<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Konsultasi extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    is_logged_in_user();
    $this->load->model('CF_model', 'CF');
  }


  public function index()
  {
    $konsultasi = $this->CF->listDataKonsultasi('tbl_konsultasi');
    $data = array(
      'title'     => 'Manjemen konsultasi',
      'add'       => 'admin/konsultasi/add',
      'cetak'      => 'admin/konsultasi/cetak/',
      'delete'    => 'admin/konsultasi/delete/',
      'konsultasi'    => $konsultasi,
      'content'       => 'admin/konsultasi/list',
    );
    $this->load->view('layout/wrapper', $data, FALSE);
  }

  function delete($id_konsultasi)
  {
    $this->Crud_model->delete('tbl_konsultasi', 'id_konsultasi', $id_konsultasi);

    $this->session->set_flashdata('msg', 'Data dihapus');

    redirect('admin/konsultasi', 'refresh');
  }

  function cetakTabulasi()
  {
    $start = $this->input->post('date_start');
    $end = $this->input->post('date_end');

    $data['konsultasi'] = $this->CF->printTabulasi($start, $end);
    $this->load->view('admin/konsultasi/cetak_page', $data, FALSE);
  }
}
