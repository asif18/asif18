<?php

/**
 * Script
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Script extends CI_Controller {
	
	/**
	 * Var declaration
	 */
	private $data;
	
	/*
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * index
	 *
	 * @param null
	 */
	public function index() {
		
		$this->data['app'] = json_encode(array(
												'baseUrl'   	  => base_url(), 
												'assetsUrl' 	  => assets_url(),
												'assetsAbsUrl'    => assets_abs_url(),
												'gCaptchaSiteKey' => G_CAPTCHA_SITE_KEY, 
												'user'  		  => $this->session->userdata()
												)
										);
		
		$this->load->view('script', $this->data);
	}
}
