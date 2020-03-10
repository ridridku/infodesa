<?php

class Kecamatan extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('master/kecamatan_model');
        $this->load->model('master/kabupaten_model');
        if ($this->input->post('cancel-button'))
            redirect('auth/user/index');

        $this->load->language('auth');
        $this->template
                    ->set_js(bower_url('datatables/media/js/jquery.dataTables.min'))
                    ->set_js(bower_url('jquery-validation/dist/jquery.validate.min.js'));
    }

    public function index()
    {
        $this->load->vars(array(
            'page_title' => 'Master Data Kecamatan',
            'page_icon' => '<a class="btn btn-primary" href="' . site_url('master/kecamatan/add') . '"> <i class="fa fa-plus"></i> Tambah</a><br>',
            'ui_controller' => 'kecamatan',
        ));
        $this->template->build('master/kecamatan/index');
    }


    public function add()
    {
        $this->load->vars(array(
            'page_title' => 'Tambah Data Kecamatan'
        ));
        $data['kabupaten'] = $this->kabupaten_model->get_data();
        $this->template
            ->set_js(assets_url('js/app/master/kecamatan/add.js'))
            ->build('master/kecamatan/add',$data);
    }

    public function edit($id)
    {
        $this->load->vars(array(
            'page_title' => 'Edit Data Kecamatan'
        ));
        $data['kecamatan'] = $this->kecamatan_model->get_by_id($id);
        $this->template
            ->set_js(assets_url('js/app/master/kecamatan/edit.js'))
            ->build('master/kecamatan/edit',$data);
    }

}