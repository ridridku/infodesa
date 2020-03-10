<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User management controller.
 *
 * @package App
 * @category Controller
 * @author Ardi Soebrata
 */
class User extends Admin_Controller
{
	/**
	 * User form definition.
	 *
	 * @var array
	 */
	protected $user_form = array(
		'first_name' => array(
			'label' => 'lang:first_name',
			'rules' => 'trim|max_length[50]',
			'helper' => 'form_inputlabel'
		),
		'last_name' => array(
			'label'	=> 'lang:last_name',
			'rules' => 'trim|max_length[50]',
			'helper' => 'form_inputlabel'
		),
		'id' => array(
			'helper' => 'form_hidden'
		),
		'nip' => array(
			'label' => 'lang:NIP',
			'rules' => 'trim|required|max_length[255]',
			'helper' => 'form_inputlabel'
		),
		'username' => array(
			'label' => 'lang:username',
			'rules' => 'trim|required|max_length[255]|callback_unique_username',
			'helper' => 'form_inputlabel'
		),
		'email' => array(
			'label' => 'lang:email',
			'rules' => 'trim|required|max_length[255]|valid_email|callback_unique_email',
			'helper' => 'form_emaillabel'
		),
		'password' => array(
			'label' => 'lang:password',
			'rules' => 'trim|required|matches[confirm-password]',
			'helper' => 'form_passwordlabel',
			'value' => ''
		),
		'confirm-password' => array(
			'label' => 'lang:Konfirmasi_Password',
			'rules' => 'trim|required',
			'helper' => 'form_passwordlabel',
			'value' => ''
		),
		'level_id' => array(
			'label' => 'lang:Level',
			'rules' => 'trim',
			'helper' => 'form_dropdownlabel'
		),
		'kec_id' => array(
			'label' => 'lang:Kecamatan',
			'rules' => 'trim',
			'helper' => 'form_dropdownlabel'
		),
		'desa_id' => array(
			'label' => 'lang:Desa',
			'rules' => 'trim',
			'helper' => 'form_dropdownlabel'
		),
		'role_id' => array(
			'label' => 'lang:Role',
			'rules' => 'trim',
			'helper' => 'form_dropdownlabel'
		),
		'lang' => array(
			'label'	=> 'lang:language',
			'rules' => 'trim',
			'helper' => 'form_dropdownlabel'
		)
	);

	protected $edit_form = array(
		'id' => array(
			'helper' => 'form_hidden'
		),
		'username' => array(
			'label' => 'lang:username',
			'rules' => 'trim|required|max_length[255]|callback_unique_username',
			'helper' => 'form_inputlabel'
		),
		'password' => array(
			'label' => 'lang:password',
			'rules' => 'trim|required|matches[confirm-password]',
			'helper' => 'form_passwordlabel',
			'value' => ''
		),
		'confirm-password' => array(
			'label' => 'lang:confirm_password',
			'rules' => 'trim|required',
			'helper' => 'form_passwordlabel',
			'value' => ''
		)
	);

	/**
	 * Redirect to index if cancel-button clicked.
	 */
	function __construct()
	{
		parent::__construct();

		if ($this->input->post('cancel-button'))
			redirect ('auth/user/index');

		$this->load->language('auth');
		$this->load->model('User_model');
		$this->template
                ->set_css(bower_url('select2/dist/css/select2.min'))
                ->set_js(bower_url('datatables/media/js/jquery.dataTables.min'))
                ->set_js(bower_url('datatables/media/js/dataTables.bootstrap4.min'))
		->set_js(bower_url('select2/dist/js/select2.min'));
	}

	/**
	 * Display User list.
	 */
	function index()
	{
		$this->data['users'] = $this->user_model->datatable(site_url('auth/user/index'));
               
		$this->template
				->set_css('../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap')
				->set_js('../bower_components/datatables/media/js/jquery.dataTables.min', TRUE)
				->set_js('../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min')
				->set_js_script('')
				->build('auth/index', $this->data);
	}

	/**data
	 * Edit User
	 *
	 * @param integer $id
	 */
	function edit($id)
	{
		$this->_updatedata($id);
	}

	function edit_profile($id)
	{
		$this->profile_updatedata($id);
	}


	/**
	 * Add a new User.
	 */
	function add()
	{
		$this->_updatedata();
	}

	/**
	 * Update profile.
	 */
	function profile()
	{
		//$this->data['redirect'] = 'auth/user/profile';
		//$this->edit($this->auth->userid());
              $this->load->vars(array(
            'page_title' => 'Profile User',
//           'page_icon' => '<a class="btn btn-primary" href="' . site_url('rt_rw/add') . '"> <i class="icon-arrow-right14 position-right"></i> Tambah</a>',
            'ui_controller' => 'MasterProfile',
        ));

            $this->data['users'] = $this->user_model->get_list(site_url('auth/user/profile'));
		$this->template
				->set_css('../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap')
				->set_js('../bower_components/datatables/media/js/jquery.dataTables.min', TRUE)
				->set_js('../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min')
				->set_js_script('

				')
				->build('auth/profile', $this->data);
	}

	/**
	 * Update user data
	 *
	 * @param int $id
	 */
	function _updatedata($id = 0)
	{
		$this->load->library('form_validation');
		$user_form = $this->user_form;

		// Update rules for update data
		if ($id > 0)
		{
			$user_form['username']['rules']	= "trim|required|max_length[255]|callback_unique_username[$id]";
			$user_form['email']['rules']	= "trim|required|max_length[255]|valid_email|callback_unique_email[$id]";
			$user_form['password']['rules']	= "trim|matches[confirm-password]";
			$user_form['confirm-password']['rules']	= "trim";
		}

		// Add language options
		$languages = $this->config->item('languages', 'template');
		foreach($languages as $code => $language)
			$user_form['lang']['options'][$code] = $language['name'];

		// Add level id
		$user_form['level_id']['options'][] = '-- Pilih Level --';
		$user_form['level_id']['options'][3] = 'Desa';
		$user_form['level_id']['options'][1] = 'Kabupaten';
		$user_form['level_id']['options'][2] = 'Kecamatan';

		// Add Keceamatan
		$kecamatan = $this->user_model->get_kecamatan_user();
		foreach($kecamatan as $nama){
			$user_form['kec_id']['options'][0] = "-- Pilih Kecamatan --";
			$user_form['kec_id']['options'][(int)$nama->Kd_Kec] = $nama->Nama_Kecamatan;
		}

		$role_tree = $this->role_model->get_tree();
		$user_form['role_id']['options'] = array(0 => '(' . lang('none') . ')') + $this->role_model->generate_options($role_tree);

		$this->form_validation->init($user_form);
		// Set default value for update data
		if ($id > 0)
			$this->form_validation->set_default($this->user_model->get_by_id($id));
		if ($this->form_validation->run())
		{
			if ($id > 0)
			{
				$this->user_model->update($id, $this->form_validation->get_values());
				$this->template->set_flashdata('info', lang('user_updated'));
			}
			else
			{
				$this->user_model->insert($this->form_validation->get_values());
				$this->template->set_flashdata('info', lang('user_added'));
			}

			if (isset($this->data['redirect']))
				redirect($this->data['redirect']);
			else
				redirect('auth/user');
		}

		$this->data['form'] = $this->form_validation;
	$this->template->build('auth/user-form', $this->data);
	}


	function profile_updatedata($id = 0)
	{
		$this->load->library('form_validation');
		$edit_form = $this->edit_form;

		// Update rules for update data
		if ($id > 0)
		{
			$edit_form['username']['rules']	= "trim|required|max_length[255]|callback_unique_username[$id]";
			$edit_form['password']['rules']	= "trim|matches[confirm-password]";
			$edit_form['confirm-password']['rules']	= "trim";
		}

		$this->form_validation->init($edit_form);
		// Set default value for update data
		if ($id > 0)
			$this->form_validation->set_default($this->user_model->get_by_id($id));
		if ($this->form_validation->run())
		{
			if ($id > 0)
			{
				if($id == $this->session->userdata('id')){
					$this->user_model->update($id, $this->form_validation->get_values());
					$this->template->set_flashdata('info', lang('user_updated'));
				}else{
					redirect('auth/user/edit_profile/'.$id);
				}
			}
			else
			{
				$this->user_model->insert($this->form_validation->get_values());
				$this->template->set_flashdata('info', lang('user_added'));
			}

			if (isset($this->data['redirect']))
				redirect($this->data['redirect']);
			else
				redirect('dashboard/home');
		}

		$this->data['form'] = $this->form_validation;
		$this->template->build('auth/user-form', $this->data);
	}

	/**
	 * Delete a User
	 *
	 * @param integer $id
	 */
	function delete($id)
	{
		$user = $this->user_model->get_by_id($id);
		if ($user)
			$this->user_model->delete($id);

		redirect('auth/user');
	}

	/**
	 * Validation callback function to check whether the username is unique
	 *
	 * @param string $value Username to check
	 * @param int $id Don't check if the username has this ID
	 * @return boolean
	 */
	function unique_username($value, $id = 0)
	{
		if ($this->user_model->is_username_unique($value, $id))
			return TRUE;
		else
		{
			$this->form_validation->set_message('unique_username', lang('already_taken'));
			return FALSE;
		}
	}

	/**
	 * Validation callback function to check whether the email is unique
	 *
	 * @param string $value Email to check
	 * @param int $id Don't check if the email has this ID
	 * @return boolean
	 */
	function unique_email($value, $id = 0)
	{
		if ($this->user_model->is_email_unique($value, $id))
			return TRUE;
		else
		{
			$this->form_validation->set_message('unique_email', lang('already_taken'));
			return FALSE;
		}
	}

}

/* End of file user.php */
/* Location: ./application/modules/auth/controllers/user.php */