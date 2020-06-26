<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Settingmodel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function batch_update($tbl,$key,$data)
    {
        try
        {
            $this->db->update_batch($tbl, $data, $key);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /*Fetch data*/
    function get_all($tbl,$keyname,$val)
    {
        $query = $this->db->select("*")
                      ->from($tbl)
                      ->get();
        $result = $query->result_array();
        $config = array();
        foreach ($result as $key => $value) {
            $config[$value[$keyname]] = $value[$val];
        }
        return $config;
    }

    /*Fetch one value*/
    function get_one_value($tbl,$wh = array(),$val)
    {
        $query = $this->db->select("*")
                      ->from($tbl) 
                      ->where($wh)
                      ->get();
        $result = $query -> result_array();
        return $result[0][$val];
    }

    /*Update data*/
    public function updateRow($table,$data,$where) {
        $this->db->where($where);
        $this->db->update($table,$data);
        return true;
    }
}