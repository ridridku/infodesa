<?php

class Kabupaten extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('master/kabupaten_model');
        if ($this->input->post('cancel-button'))
            redirect('auth/user/index');

        $this->load->language('auth');
    }

    public function index()
    {
        $data['kabupaten'] = $this->kabupaten_model->get_data();
        $this->load->vars(array(
            'page_title' => 'Master Data Kabupaten',
            'page_icon' => (empty($data['kabupaten']) ? '<a class="btn btn-primary" href="' . site_url('master/kabupaten/add') . '"> <i class="fa fa-plus"></i> Tambah Data</a><br>'
                                        : '<a class="btn btn-primary" href="' . site_url('master/kabupaten/edit/') .$data['kabupaten']->id.'"> <i class="fa fa-plus"></i> Ubah Data</a><br>'),
            'ui_controller' => 'kabupaten',
        ));
        $this->template->build('master/kabupaten/index',$data);
    }


    public function add()
    {
        $this->load->vars(array(
            'page_title' => 'Tambah Data Kabupaten'
        ));
        $this->template
            ->set_js(bower_url('jquery-validation/dist/jquery.validate.min.js'))
            ->set_js(assets_url('js/app/master/kabupaten/add.js'))
            ->build('master/kabupaten/add');
    }

    public function edit($id)
    {
        $this->load->vars(array(
            'page_title' => 'Ubah Data Kabupaten'
        ));
        $data['kabupaten'] = $this->kabupaten_model->get_by_id($id);
        $this->template
            ->set_js(bower_url('jquery-validation/dist/jquery.validate.min.js'))
            ->set_js(assets_url('js/app/master/kabupaten/edit.js'))
            ->build('master/kabupaten/edit',$data);
    }

}