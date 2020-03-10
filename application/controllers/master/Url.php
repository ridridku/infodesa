<?php

class Url extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('master/url_model');
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
            'page_title' => 'Data Url Desa',
            'page_icon' => '<a class="btn btn-primary" href="' . site_url('master/url/add') . '"> <i class="fa fa-plus"></i> Tambah</a><br>',
        ));
        $this->template
            ->build('master/url/index');
    }


    public function add()
    {
        $this->load->vars(array(
            'page_title' => 'Tambah Data Url Desa'
        ));
        $data['kecamatan'] = $this->user_model->get_kecamatan_user();
        $this->template
            ->set_js(assets_url('js/app/master/url/add.js'))
            ->build('master/url/add',$data);
    }

    public function edit($id)
    {
        $this->load->vars(array(
            'page_title' => 'Edit Data URL Desa'
        ));
        $data['desa'] = $this->url_model->get_by_id($id);
        $data['kecamatan'] = $this->user_model->get_kecamatan_user();
        $this->template
            ->set_js(assets_url('js/app/master/url/edit.js'))
            ->build('master/url/edit',$data);
    }

}