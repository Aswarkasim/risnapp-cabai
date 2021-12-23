<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Role extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // if ($this->session->userdata('id_admin') == "") {

        //     redirect('error', 'refresh');
        // }


        $this->load->model('CF_model', 'CF');
    }

    public function index($kode_jenis)
    {
        $role = $this->CF->listRole($kode_jenis);
        $gejala = $this->Crud_model->listing('tbl_gejala');
        $data = array(
            'title'     => 'Manjemen Role',
            'add'       => 'role/add',
            'edit'      => 'role/edit/',
            'delete'    => 'role/delete/',
            'role'    => $role,
            'kode_jenis'    => $kode_jenis,
            'gejala'    => $gejala,
            'content'       => 'role/list',
        );
        $this->load->view('layout/wrapper', $data, FALSE);
    }

    public function add()
    {


        $this->load->helper('string');

        $i = $this->input;
        $data = array(
            'id_role'       => random_string(),
            'kode_gejala'   => $i->post('kode_gejala'),
            'kode_jenis'   => $i->post('kode_jenis'),
        );
        $this->Crud_model->add('tbl_role', $data);
        $this->session->set_flashdata('msg', ' Data telah ditambah');
        redirect('role/index/' . $data['kode_jenis'], 'refresh');
    }

    public function edit($id_role)
    {
        $this->load->helper('string');

        $i = $this->input;
        $data = array(
            'kode_gejala'       => $i->post('kode_gejala'),
            'kode_jenis'     => $i->post('kode_jenis'),
        );
        $this->Crud_model->edit('tbl_role', 'id_role', $id_role, $data);
        $this->session->set_flashdata('msg', ' Data telah ditambah');
        redirect('role/index/' . $data['kode_jenis'], 'refresh');
    }

    function delete($kode_jenis, $id_role)
    {
        $this->Crud_model->delete('tbl_role', 'id_role', $id_role);
        $this->session->set_flashdata('msg', 'Data telah dihapus');
        redirect('role/index/' . $kode_jenis, 'refresh');
    }
}
