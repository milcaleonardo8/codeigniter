<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productmodel extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/*Fetch Product*/
	public function getproduct($wh = array())
	{
		$this->db->select('td.*,tc.Name,tc.CateId,tsc.Name as SubCateName');
		$this->db->from('tblcard as td');
		$this->db->join('tblsubcategory as tsc','td.SubCateId=tsc.CateId','left');
		$this->db->join('tblcategory as tc','td.CId=tc.CateId');
		if(count($wh) > 0)
			$this->db->where($wh);
		$res 		= $this->db->get();
		$result 	= $res->result_array();
		return !empty($result)?$result:array();
	}

}
