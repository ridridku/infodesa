<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->language('welcome');
	}
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 * 	- or -
	 * 		http://example.com/index.php/welcome/index
	 * 	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->model('pendapatan/M_pendapatan');
                $this->load->model('master/M_pendapatan');
                     $this->load->model('auth/User_model');
		$data['data'] = $this->M_pendapatan->get_data()->result();
		$data['kec_'] = $this->user_model->get_kecamatan();
                
              
            // $x['jumlah_user'] = $this->M_pendapatan->get_all_data();

		$data_desa=array();
		$data_kategori = array();
		$data_realisasi = array();
                $data_kec=array();
                
                
                       
                foreach ($this->M_pendapatan->getChartData_Angkatan()->result_array() as $row)
                {

                    $data_desa[] = (string)$row['desa'];
                    $data_anggaran[] = (float) $row['anggaran'];
                    $data_realisasi[] = (float) $row['realisasi'];


                } 
                
                $belanja_desa=array();
                $belanja_kategori = array();
                $belanja_realisasi = array();
                $kecamatan= array();

            //$data['kecamatan'] = $this->user_model->get_kecamatan();

                foreach ($this->M_pendapatan->get_chart_belanja()->result_array() as $row) 
                {

                    $belanja_desa[] = (string)$row['desa'];
                    $belanja_anggaran[] = (float)$row['anggaran'];
                    $belanja_realisasi[] = (float)$row['realisasi'];
                                        
                 }
                 
              foreach ($this->M_pendapatan->get_chart_belanja()->result_array() as $row) 
                {
                    $belanja_desa[] = (string)$row['desa'];
                    $belanja_anggaran[] = (float)$row['anggaran'];
                    $belanja_realisasi[] = (float)$row['realisasi'];                  
                 }     
                 
                 
                 
                 
                 
                            $this->template
                            ->set_css('../bower_components/morrisjs/morris')
                            ->set_js('../bower_components/raphael/raphael.min', TRUE)
                            ->set_js('../bower_components/morrisjs/morris.min', TRUE)
                            ->build('welcome/welcome_message',array(
                            'data'=>$data['data'],'data_kec'=> $data['kec_'], 
                            'data_desa'=>$data_desa, 
                            'data_anggaran'=>$data_anggaran,
                            'data_realisasi'=>$data_realisasi,
                            'belanja_desa'=>$belanja_desa, 
                            'belanja_anggaran'=>$belanja_anggaran,
                            'belanja_realisasi'=>$belanja_realisasi
                                
                                    ));
	
            
                                   
                                    //var_dump($data) or die();
	}

}
