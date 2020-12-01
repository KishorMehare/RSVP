<?php
class Api_model extends CI_Model
{
	function fetch_all()
	{
		$this->db->order_by('id', 'DESC');
		return $this->db->get('participants');
	}

	function insert_api($data)
	{
		$this->db->insert('participants', $data);
	}

	function fetch_single_user($user_id)
	{
		$this->db->where('id', $user_id);
		$query = $this->db->get('participants');
		return $query->result_array();
	}

	function update_api($user_id, $data)
	{
		$this->db->where('id', $user_id);
		$this->db->update('participants', $data);
	}

	function delete_single_user($user_id)
	{
		$this->db->where('id', $user_id);
		$this->db->delete('participants');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

?>