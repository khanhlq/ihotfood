<?php

class Review_Model extends CI_Model{
	public function create_review($resId) {
		$this->load->helper('date');
		$datetime = date('Y-m-d H:i:s'); 

		$data=array(
			'user_id' => $this->session->userdata('id'),
			'restaurant_id' => $resId,
			'title' => $this->input->post('title'),
			'content' => $this->input->post('content'),
			'rating' => $this->input->post('score-add'),
			'publish_time' => $datetime,
		);

		$q = $this->db->insert('reviews', $data);
		return $q;
	} 

	public function get_restaurant_reviews($resId, $offset=0, $perPage=0) {
		$reviews = array();
		$this->db->where('restaurant_id', $resId);
		$this->db->order_by("publish_time", "desc");
		if($perPage > 0 ) {
			$query = $this->db->get('reviews', $perPage, $offset);
		}
		else {
			$query = $this->db->get('reviews');	
		}
		foreach ($query->result() as $row) {
			array_push($reviews, $row);
		}
		return $reviews;
	}

	public function get_review($reviewId) {
		$this->db->where('id', $reviewId);
		$query = $this->db->get('reviews');
		if($query->num_rows == 1){
			return $query->row();
		} 
		return null;
	}

	public function delete_review($reviewId) {
		$this->db->where('id', $reviewId);
		$q = $this->db->delete('reviews');
		return $q;
	}

	public function update_review($reviewId) {
		$this->db->where('id', $reviewId);
		$data=array(
			'title' => $this->input->post('title'),
			'content' => $this->input->post('content'),
			'rating' => $this->input->post('score-edit'),
		);
		$q = $this->db->update("reviews", $data);
		return $q;
	}
}