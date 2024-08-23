<?php

/**
 * Category Model
 * @type Class (Model)
 * @name 'CategoryM'
 * @param null
 * @description: Model contains DB operation about 'Category' Controller
 * 
 * Developed by: Mohamed Asif
 * Date: 22/08/2017
 * Email: asif18@asif18.com
 */


class CategoryM extends CI_Model {
	
	/**
	 * Var declarations
	 */
	private $timenow;
	private $tblprefix;
	
	/**
	 * Class Contructor
	 */
	public function __construct() {
		$this->timenow   = $this->extend->timenow();
		$this->tblprefix = $this->db->tbprefix;
	}

	/**
	 * Get user id
	 *
	 * @param $id
	 * @type Integer
	 */
	public function getCategoryById($id) {
		$query = $this->db->query("SELECT * FROM `".$this->tblprefix."category` WHERE cat_id = '".$id."' ");
		if($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return 0;
		}
	}
	
	/**
	 * Get categories
	 *
	 * @param null
	 */
	public function getCategories() {
		$query = $this->db->query("SELECT 
									cat_id, 
									cat_name, 
									cat_title, 
									cat_keywords, 
									cat_description, 
									DATE_FORMAT(post_date, '%d/%m/%Y') AS post_date
									FROM `".$this->tblprefix."category` ");
		if($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return 0;
		}
	}
	
	/**
	 * Add new category
	 *
	 * @param $data
	 * @type Array
	 */
	public function addCategory($data) {
		$this->db->insert($this->tblprefix."category", $data);
	}
	
	/**
	 * Update category table
	 *
	 * @param $data, $where
	 * @type Array, Array
	 */
	public function updateCategory($data, $where) {
		$this->db->update($this->tblprefix."category", $data, $where);
	}
}
