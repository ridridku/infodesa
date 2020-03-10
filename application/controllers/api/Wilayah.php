<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Wilayah extends Admin_Controller
{
    public function desa()
    {
        header('Content-type: application/json');
        $parent_id = $_GET['desaId'];

        $this->db->select('Kd_Desa, Nama_Desa as text');
        $this->db->from('master_desa');
        if($this->session->userdata['level_id'] == 3){
			$this->db->where('master_desa.Kd_Desa',$this->session->userdata['desa_id']);
		}else if($this->session->userdata['level_id'] == 2 || $this->session->userdata['level_id'] == 1){
            $this->db->where('Kd_Kec', $parent_id);
		}

        if ($this->input->get('q')) {
            $this->db->where("Nama_Desa LIKE '%" . $this->input->get('q') . "%'");
        }
        $data = $this->db->order_by('Nama_Desa', 'asc');
        echo json_encode($data->get()->result());
    }

}
