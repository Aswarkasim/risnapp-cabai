<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{

		// $this->load->view('welcome_message');

		$data = [
			[
				'nilai_cf'	=> 0.4,
				'cf_hasil'	=> 0.4,
			],

			[
				'nilai_cf'	=> 0.4,
				'cf_hasil'	=> 0.4,
			],
			[
				'nilai_cf'	=> 0.4,
				'cf_hasil'	=> 0.32,
			],
		];

		echo $this->hitung_cf($data);
	}

	function hitung_cf($data)
	{
		$cf_old = 0;

		// printr_pretty($cf_last['cf_hasil']);
		foreach ($data as $key => $value) {
			if ($key == 0) {
				$cf_old = $value['cf_hasil'];
			} else {
				$cf_old = $cf_old + $value['cf_hasil'] * (1 - $cf_old);
			}
		}
		return $cf_old;
	}
}
