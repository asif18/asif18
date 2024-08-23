<?php

/**
 * App.php
 *
 * Parent page of the admin module where all the view/controllers/services/directives will be shown
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {
	
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
		
		$appConfig = array(
							'appName'  	=> 'Asif 18 Admin panel',
							'version'  	=> '1.0.0',
							'baseUrl'  	=> base_url(),
							'assetsUrl'	=> assets_url()
						);
		
		$this->data['appConfig'] = $appConfig;
		$this->load->view('app', $this->data);
	}
}
