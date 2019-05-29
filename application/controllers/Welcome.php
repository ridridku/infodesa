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
            $this->template
				->set_css('timeline')
				->set_css('../bower_components/morrisjs/morris')
				->set_js('../bower_components/raphael/raphael.min', TRUE)
				->set_js('../bower_components/morrisjs/morris.min', TRUE)
				->set_js('morris-data', TRUE)
				->build('welcome/welcome_message');
	
            
                $this->load->model('pendapatan/M_pendapatan');
                $data2 = $this->M_pendapatan->get_data()->result();
              //  var_dump($data)or die();
                $x['data'] = json_encode($data2);
                $this->load->view('welcome/welcome_message',$x);
      
//            $this->load->model('pendapatan/M_pendapatan');
////		$this->load->model('auth/user_model');
//		$data['pendapatan'] = $this->inventaris_model->get_data()->result();
//		$data['get_all_data'] = $this->inventaris_model->get_all_data();
//		$data['get_day_data'] = $this->inventaris_model->get_day_data();
//		$data['jumlah_user'] = $this->user_model->get_all_data();
                
              
   
        //  $this->load->view('welcome/welcome_message',$y);
                
              // $data[] = array();
		$data_kategori = array();
                $data_realisasi = array();
                
                foreach ($this->M_pendapatan->getChartData_Angkatan()->result_array() as $row){
                    
                   
			$data[] = (string)$row['desa'];
			$data_kategori[] = (int) $row['anggaran'];
                        $data_realisasi[] = (int) $row['realisasi'];
		}
                
                
                $this->load->view('welcome/welcome_message', array(
			'data'=>$data, 
			'data_kategori'=>$data_kategori
                        ,'data_realisasi'=>$data_realisasi)
		);
               //var_dump($data[])or die();
	}

}
