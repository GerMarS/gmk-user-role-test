<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class users extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->database();
		
		$this->load->model('users_model');
		
	}
	
	public function index()
	{
		
		$active_user = '';
		if (!empty($this->session->userdata('active_user')))
			$active_user = $this->session->userdata('active_user');
		
		$left_data = [];
		$left_data['user_list'] = $this->users_model->get_user_list();
		$left_data['active_user'] = $active_user;
		
		$left_data['roles'] = $this->users_model->get_roles();
		
		if(!empty($active_user) && $this->users_model->can_create($active_user))
			$left_data['can_create'] = true;
		
		$right_data = [];
		if (!empty($active_user) && $this->users_model->can_read($active_user))
			$right_data['all_users'] = $this->users_model->get_users_and_roles();
		if (!empty($active_user) && $this->users_model->can_update($active_user))
			$right_data['can_update'] = true;
		if (!empty($active_user) && $this->users_model->can_delete($active_user))
			$right_data['can_delete'] = true;
			
		$this->load->view('header');
		$this->load->view('left', $left_data);
		$this->load->view('right', $right_data);
		$this->load->view('footer');
	}
	
	public function activate_user()
	{
		$session_data['active_user'] = $this->input->post('active_user');

		if (!empty($this->users_model->get_user_id($session_data['active_user'])))
			$this->session->set_userdata($session_data);
		
		redirect('users/index');
	}
	
	public function update_user()
	{	
	
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$this->output->set_status_header('500');
			$this->data['message'] = 'Error: No se ha podido validar el formulario';
			echo json_encode($this->data);
			die();
		}
		
		
		$active_user = $this->session->userdata('active_user');
		$new_user = [
			'name' => $this->input->post('name'),
			'email' => $this->input->post('email'),
			'phone' => $this->input->post('phone'),
			'age' => $this->input->post('age'),
		];
		
		$roles = [];
		$role_list = $this->users_model->get_roles();
		foreach ($role_list as $key => $role)
		{
			if (!empty($this->input->post('role'.$key)))
				$roles[] = $key; 
		}
		
		
		if (!empty($this->input->post('mode')) && $this->input->post('mode') == 'create' &&  $this->users_model->can_create($active_user))
		{
			if (!empty($this->users_model->get_user_id($new_user['email'])))
			{
				$this->output->set_status_header('500');
				$this->data['message'] = 'Error: El email ya existe';
				echo json_encode($this->data);
				die();
			}
			
			if ($new_user['email'] == '')
			{
				$this->output->set_status_header('500');
				$this->data['message'] = 'Error: El email no puede estar vacio';
				echo json_encode($this->data);
				die();
			}
			
			if ($this->users_model->create_user($new_user, $roles))
			{
				$this->data['message'] = 'El usuario se ha creado correctamente';
				echo json_encode($this->data);
				die();
			}
		}
		
		if (!empty($this->input->post('mode')) && $this->input->post('mode') == 'update' &&  $this->users_model->can_update($active_user))
		{
			if ($this->users_model->update_user($new_user, $roles))
			{
				$this->data['message'] = 'El usuario se ha actualizado correctamente';
				echo json_encode($this->data);
				die();
			}
		}
		
		$this->output->set_status_header('500');
		$this->data['message'] = 'Error: Ha ocurrido un problema';
		echo json_encode($this->data);
	}
	
	public function delete_user()
	{
		$active_user = $this->session->userdata('active_user');
		
		if (!empty($this->input->post('email')) && $this->users_model->can_delete($active_user))
		{
			if ($this->users_model->delete_user($this->input->post('email')))
			{
				$this->data['message'] = 'El usuario se ha borrado correctamente';
				echo json_encode($this->data);
				die();
			}
		}
		$this->output->set_status_header('500');
		$this->data['message'] = 'Error: Ha ocurrido un problema';
		echo json_encode($this->data);
	}
}