
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cf extends CI_Controller
{

  public function index()
  {


    // $gejala = $this->Crud_model->listing('tbl_diagnosa');
    // printr_pretty($gejala);
  }

  function hitung_cf($data)
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

/* End of file Controllername.php */
