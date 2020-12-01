<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('api_model');
		$this->load->library('form_validation');
	}

	function index()
	{
		$data = $this->api_model->fetch_all();
		echo json_encode($data->result_array());
	}

	function insert()
	{
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('age', 'Age', 'required');
		$this->form_validation->set_rules('dob', 'DOB', 'required');
		$this->form_validation->set_rules('profession', 'Profession', 'required|in_list[employed,student]');
		$this->form_validation->set_rules('locality', 'Locality', 'required');
		$this->form_validation->set_rules('no_of_guest', 'No.of Guest', 'required|less_than_equal_to[2]');
		$this->form_validation->set_rules('address', 'Address', 'required|max_length[50]');
		if($this->form_validation->run())
		{
			$data = array(
				'name'	=>	$this->input->post('name'),
				'age'		=>	$this->input->post('age'),
				'dob'		=>	$this->input->post('dob'),
				'profession'		=>	$this->input->post('profession'),
				'locality'		=>	$this->input->post('locality'),
				'no_of_guest'		=>	$this->input->post('no_of_guest'),
				'address'		=>	$this->input->post('address')
			);

			$this->api_model->insert_api($data);

			$array = array(
				'success'		=>	true
			);
		}
		else
		{
			$array = array(
				'error'					=>	true,
				'name_error'		=>	form_error('first_name'),
				'age_error'			=>	form_error('age'),
				'dob_error'		=>	form_error('dob'),
				'profession_error'		=>	form_error('profession'),
				'locality_error'		=>	form_error('locality'),
				'guest_error'		=>	form_error('no_of_guest'),
				'address_error'		=>	form_error('address')
				
			);
		}
		echo json_encode($array);
	}
	
	function fetch_single()
	{
		if($this->input->post('id'))
		{
			$data = $this->api_model->fetch_single_user($this->input->post('id'));

			foreach($data as $row)
			{
				$output['name'] = $row['name'];
				$output['age'] = $row['age'];
				$output['dob'] = $row['dob'];
				$output['profession'] = $row['profession'];
				$output['locality'] = $row['locality'];
				$output['no_of_guest'] = $row['no_of_guest'];
				$output['address'] = $row['address'];
			}
			echo json_encode($output);
		}
	}

	function update()
	{
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('age', 'Age', 'required');
		$this->form_validation->set_rules('dob', 'DOB', 'required');
		$this->form_validation->set_rules('profession', 'Profession', 'required|in_list[employed,student]');
		$this->form_validation->set_rules('locality', 'Locality', 'required');
		$this->form_validation->set_rules('no_of_guest', 'No.of Guest', 'required|less_than_equal_to[2]');
		$this->form_validation->set_rules('address', 'Address', 'required|max_length[50]');
		if($this->form_validation->run())
		{	
			$data = array(
				'name'	=>	$this->input->post('name'),
				'age'		=>	$this->input->post('age'),
				'dob'		=>	$this->input->post('dob'),
				'profession'		=>	$this->input->post('profession'),
				'locality'		=>	$this->input->post('locality'),
				'no_of_guest'		=>	$this->input->post('no_of_guest'),
				'address'		=>	$this->input->post('address')
			);

			$this->api_model->update_api($this->input->post('id'), $data);

			$array = array(
				'success'		=>	true
			);
		}
		else
		{
			$array = array(
				'error'				=>	true,
				'name_error'		=>	form_error('first_name'),
				'age_error'			=>	form_error('age'),
				'dob_error'		=>	form_error('dob'),
				'profession_error'		=>	form_error('profession'),
				'locality_error'		=>	form_error('locality'),
				'guest_error'		=>	form_error('no_of_guest'),
				'address_error'		=>	form_error('address')
			);
		}
		echo json_encode($array);
	}

	function delete()
	{
		if($this->input->post('id'))
		{
			if($this->api_model->delete_single_user($this->input->post('id')))
			{
				$array = array(

					'success'	=>	true
				);
			}
			else
			{
				$array = array(
					'error'		=>	true
				);
			}
			echo json_encode($array);
		}
	}

}


?>