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
		//$this->template->build('welcome/welcome_message');
	}

}
