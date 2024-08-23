<?php

/**
 * Login.php
 *
 * Index controller of the admin folder
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	/**
	 * Var declaration
	 */
	private $data;
	
	/*
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
		
		$this->load->model('LoginM');
	}
	
	/**
	 * index
	 *
	 * @param null
	 */
	public function index() {
		
		$responseData = array(
							'data' 		=> null,
							'exception' => array(
												'status' => true,
												'msg'	 => 'No direct script access allowed'
											)
						);
		
		$this->data['responseData'] = json_encode($responseData);
		$this->load->view('responder', $this->data);
	}
	
	/**
	 * Auth
	 *
	 * @param null
	 */
	public function Auth() {
		
		$rawData  = json_decode(file_get_contents('php://input'), true);
		$data	  = $rawData;
		$response = array();
		$dc 	  = array('username', 'password');
		
		checkDC($dc, $rawData);
		
		$result = $this->LoginM->getUser($data['username'], userPassword($data['username']));
		
		if($result == 0) {
			$responseData = array(
								'data' 		=> null,
								'exception' => array(
													'status' => true,
													'msg'	 => 'Invalid login access provided'
												)
							);
		} else {
			
			// Start the session
			$userdata			  	= $result;
			$userdata['user_email'] = $data['username'];
			$userdata['user_type'] 	= 'admin';
			$userdata['is_admin'] 	= true;
			$userdata['loggedin'] 	= true;
			$this->session->set_userdata($userdata);
			
			$responseData = array(
								'data' 		=> array(
														'status' => true,
														'user'	 => $userdata
													),
								'exception' => null
							);
		}
		
		
		$this->data['responseData'] = json_encode($responseData);
		$this->load->view('responder', $this->data);
	}
	
	/**
	 * Session Check
	 *
	 * @param null
	 */
	public function sessionCheck() {
		
		if($this->session->userdata('loggedin') === true) {
			$responseData = array(
								'data' 		=> array(
														'status' => true,
														'user'	 => $this->session->userdata()
													),
								'exception' => null
							);
		} else {
			$responseData = array(
								'data' 		=> array(
														'status' => false,
														'user'	 => null
													),
								'exception' => null
							);
		}
		
		$this->data['responseData'] = json_encode($responseData);
		$this->load->view('responder', $this->data);
	}
}
