<?php

/**
 * Login Model
 * @type Class (Model)
 * @name 'LoginM'
 * @param null
 * @description: Model contains DB operation about 'Login' Controller
 * 
 * Developed by: Mohamed Asif
 * Date: 20/08/2017
 * Email: asif18@asif18.com
 */


class LoginM extends CI_Model {
	
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
	 * @param $username, $password
	 * @type String, String
	 */
	public function getUser($username, $password) {
		$query = $this->db->query("SELECT user_id, name FROM `".$this->tblprefix."users` WHERE user_email = '".$username."' AND user_password = '".$password."' AND user_status = 'A'");
		if($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return 0;
		}
	}
	
	/**
	 * Is Valid User
	 *
	 * @param $username
	 * @type String
	 */
	public function isValidUser($username) {
		$query = $this->db->query("SELECT id FROM `".$this->tblprefix."users` WHERE username = '".$username."' AND status = 'A'");
		if($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return 0;
		}
	}

	/**
	 * Get user by id
	 *
	 * @param $id
	 * @type Integer
	 */
	public function getUserById($id) {
		$query = $this->db->query("SELECT username, name, email, usertype, status FROM `".$this->tblprefix."users` WHERE id = '".$id."'");
		
		if($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return 0;
		}
	}
	
	/**
	 * Get last inserted ID(Primary Key) from ticket table
	 *
	 * @param $null
	 */
	public function lastInsertId() {

		$lastid = '';
		$query = $this->db->query("SELECT id FROM ".$this->tblprefix."tickets ORDER BY id DESC LIMIT 1");
		if($query->num_rows() > 0) {

			$row	= $query->last_row('array'); 
			$lastid = $row['id'];
		} else {
			$lastid = 1;
		}
		return $lastid;
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
