<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pasien extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    is_logged_in_user();
    $this->load->model('CF_model', 'CF');
  }


  public function index()
  {
    $pasien = $this->CF->listDataPasien('tbl_pasien');
    $data = array(
      'title'     => 'Manjemen pasien',
      'add'       => 'admin/pasien/add',
      'cetak'      => 'admin/pasien/cetak/',
      'delete'    => 'admin/pasien/delete/',
      'pasien'    => $pasien,
      'content'       => 'admin/pasien/list',
    );
    $this->load->view('layout/wrapper', $data, FALSE);
  }

  function delete($id_pasien)
  {
    $this->Crud_model->delete('tbl_pasien', 'id_pasien', $id_pasien);

    $this->session->set_flashdata('msg', 'Data dihapus');

    redirect('admin/pasien', 'refresh');
  }

  function cetakTabulasi()
  {
    $start = $this->input->post('date_start');
    $end = $this->input->post('date_end');

    $data['pasien'] = $this->CF->printTabulasi($start, $end);
    $this->load->view('admin/pasien/cetak_page', $data, FALSE);
  }
}
