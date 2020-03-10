<?php

/**
 * User: Didik Kurniawan
 * Date: 11/14/17
 * Time: 07:26
 */
class Api_inventaris_keuangan extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
         $this->load->model('inventaris/inventaris_model');
    }
     public function index($kec,$desa,$tahun,$jenis)
    {
        $data = $this->inventaris_model->datatables_laporan($kec,$desa,$tahun,$jenis);
        echo json_encode(array('data' => $data));
    }
    public function add()
    {
        $data = $this->desa_model->add(array(
            'Kd_Kec' => $this->input->post('Kd_Kec'),
            'Kd_Desa' => $this->input->post('Kd_Desa'),
            'Nama_Desa' => $this->input->post('Nama_Desa'),
                ));
            echo json_encode($data);
    }
    public function delete($id)
    {
        echo json_encode($this->visi_model->delete($id));

        redirect(site_url('perencanaan/renstra/visi'));
    }


}