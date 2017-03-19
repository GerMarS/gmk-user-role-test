<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class users_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function get_users_and_roles()
	{
		$query = $this->db->query("select * from users");
		$user_list = [];
		foreach ($query->result() as $row)
		{
			$query_roles = $this->db->query("select * from user_role where user_id =".$row->user_id);
			$roles_list = [];
			foreach ($query_roles->result() as $row_role)
				$roles_list[] = $row_role->role_id;
			$user_list[] = [
				'user_id' => $row->user_id,
				'name' => $row->name,
				'email' => $row->email,
				'phone' => $row->phone,
				'age' => $row->age,
				'roles' => $roles_list,
			];
		}
		return $user_list;
	}
	
	function get_roles()
	{
		$query = $this->db->query("select * from roles");
		$roles = [];
		foreach ($query->result() as $row)
			$roles[$row->role_id] = $row->role;
		return $roles;
	}
	
	function get_user_list()
	{
		$query = $this->db->query("select email from users");
		
		$users = [];
		foreach ($query->result() as $row)
			$users[] = $row->email;
		
		return $users;
	}
	
	function get_user_id($email)
	{
		$sql = "select user_id from users where email = " . $this->db->escape($email);
		$query = $this->db->query($sql);
		$row = $query->row();
		if (!empty($row->user_id))
			return $row->user_id;
		return 0;
	}
	
	function can_read($email)
	{
		$sql = "select * from users as u
		inner join user_role as ur using (user_id)
		inner join roles as r using (role_id)
		where r.r = 1 and email = ". $this->db->escape($email);
		
		$query = $this->db->query($sql);
		if (!empty($query->num_rows()))
			return true;
		return false;
	}
	
	function can_create($email)
	{
		$sql = "select * from users as u
		inner join user_role as ur using (user_id)
		inner join roles as r using (role_id)
		where r.c = 1 and email = ". $this->db->escape($email);
		
		$query = $this->db->query($sql);
		if (!empty($query->num_rows()))
			return true;
		return false;
	}
	
	function can_update($email)
	{
		$sql = "select * from users as u
		inner join user_role as ur using (user_id)
		inner join roles as r using (role_id)
		where r.u = 1 and email = ". $this->db->escape($email);
		
		$query = $this->db->query($sql);
		if (!empty($query->num_rows()))
			return true;
		return false;
	}
	
	function can_delete($email)
	{
		$sql = "select * from users as u
		inner join user_role as ur using (user_id)
		inner join roles as r using (role_id)
		where r.d = 1 and email = ". $this->db->escape($email);
		
		$query = $this->db->query($sql);
		if (!empty($query->num_rows()))
			return true;
		return false;
	}
	
	function create_user($user, $roles)
	{
		try
		{
			$this->db->insert('users', $user);
			$user_id = $this->db->insert_id();
			
			foreach ($roles as $role)
			{
				$data_roles = [
					'user_id' => $user_id,
					'role_id' => $role,
				];
				$this->db->insert('user_role', $data_roles);
			}
		}
		catch (Exception $e)
		{
			return false;
		}
		
		return true;
	}
	
	function update_user($user, $roles)
	{
		try
		{
			$user_data = [
				'name' => $user['name'],
				'phone' => $user['phone'],
				'age' => $user['age'],
			];
			
			$user_id = $this->get_user_id($user['email']);
			$this->db->where('user_id', $user_id);
			$this->db->update('users', $user_data);
			
			$this->db->where('user_id', $user_id);
			$this->db->delete('user_role');
			foreach ($roles as $role)
			{
				$data_roles = [
					'user_id' => $user_id,
					'role_id' => $role,
				];
				$this->db->insert('user_role', $data_roles);
			}
		}
		catch (Exception $e)
		{
			return false;
		}
		return true;
	}
	
	function delete_user($email)
	{
		try
		{
			$user_id = $this->get_user_id($email);
			$this->db->where('user_id', $user_id);
			$this->db->delete('users');
		}
		catch (Exception $e)
		{
			return false;
		}
		return true;
	}
}