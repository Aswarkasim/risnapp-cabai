<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cf_home extends CI_Model
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('home/Home_model', 'HM');
  }

  function getValuePenyakit($id_pasien)
  {
    $jenis = $this->HM->groupPenyakit();

    $keputusan = [
      'P001'    => 0,
      'P002'    => 0,
      'P003'    => 0,
      'P004'    => 0,
      'P005'    => 0,
      'H001'    => 0,
      'H002'    => 0,
      'H003'    => 0,
      'H004'    => 0,
      'H005'   => 0,
    ];
    foreach ($jenis as $row) {
      // echo $row->kode_jenis . '<br>';
      $roles = $this->Crud_model->listingOneAll('tbl_role', 'kode_jenis', $row->kode_jenis);
      foreach ($roles as $role) {
        $diagnosa = $this->HM->dataDiagnosaByPasien($id_pasien, $role->kode_gejala);

        if (isset($diagnosa)) {
          if ($role->kode_gejala == $diagnosa->kode_gejala) {
            // echo $role->kode_jenis . '<br>';
            switch ($role->kode_jenis) {
              case 'P001':
                $keputusan['P001'] = $keputusan['P001'] + 1;
                break;

              case 'P002':
                $keputusan['P002'] = $keputusan['P002'] + 1;
                break;

              case 'P003':
                $keputusan['P003'] = $keputusan['P003'] + 1;
                break;

              case 'P004':
                $keputusan['P004'] = $keputusan['P004'] + 1;
                break;

              case 'P005':
                $keputusan['P005'] = $keputusan['P005'] + 1;
                break;

              case 'H001':
                $keputusan['H001'] = $keputusan['H001'] + 1;
                break;

              case 'H002':
                $keputusan['H002'] = $keputusan['H002'] + 1;
                break;

              case 'H003':
                $keputusan['H003'] = $keputusan['H003'] + 1;
                break;

              case 'H004':
                $keputusan['H004'] = $keputusan['H004'] + 1;
                break;

              case 'H005':
                $keputusan['H005'] = $keputusan['H005'] + 1;
                break;

              default:
                break;
            }
          }
        }
      }
    }

    $value = max($keputusan);
    $key = array_search($value, $keputusan);
    return $key;

    // return $keputusan;
  }

  function hitung_cf($data)
  {
    $cf_old = 0;

    // printr_pretty($cf_last['cf_hasil']);
    foreach ($data as $key => $value) {
      if ($key == 0) {
        $cf_old = $value->cf_hasil;
      } else {
        $cf_old = $cf_old + $value->cf_hasil * (1 - $cf_old);
      }
    }
    $persentase = $cf_old * 100;
    return $persentase;
  }


  // Formula Default
  function hitung_cf_backup($data)
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
}


/* End of file ModelName.php */
