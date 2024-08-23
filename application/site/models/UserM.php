<?php

/**
 * User Model
 * @type Class (Model)
 * @name 'UserM'
 * @param null
 * @description: Model contains DB operation about 'User' Controller
 * 
 * Developed by: Mohamed Asif
 * Date: 17/09/2017
 * Email: asif18@asif18.com
 */


class UserM extends CI_Model {
	
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
	 * Add new user
	 *
	 * @param $data
	 * @type Array
	 */
	public function saveUser($data) {
		$this->db->insert($this->tblprefix."users", $data);
	}
	
	/**
	 * Get user by email
	 *
	 * @param $email
	 * @type String
	 */
	public function getUserByEmail($email) {
		$query = $this->db->query("SELECT * FROM `".$this->tblprefix."users` WHERE user_email = '".$email."' AND user_type = 'user' ");
		if($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return 0;
		}
	}
	
	/**
	 * Update user table
	 *
	 * @param $data, $where
	 * @type Array, Array
	 */
	public function updateUser($data, $where) {
		$this->db->update($this->tblprefix."users", $data, $where);
	}
}
