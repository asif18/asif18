<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Logout
 * @type Class (Controller)
 * @name 'Logout'
 * @param null
 * @description: logout user from the application (C-S)
 * 
 * Developed by: Mohamed Asif
 * Date: 20/08/2017
 * Email: asif18@asif18.com
 */

class Logout extends CI_Controller {
	
	public $data;
	
	public function __construct() {
		parent::__construct();
		if(!$this->session->userdata('loggedin') == TRUE) {
			redirect('/');
			exit;
		}
	}
	
	public function index() {
		$this->session->sess_destroy();
		redirect('/');
	}
}
