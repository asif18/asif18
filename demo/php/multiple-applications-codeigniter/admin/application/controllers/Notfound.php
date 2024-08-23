<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notfound extends CI_Controller {
	
	/**
	 * Index
	 */
	public function index() {
		
		$this->load->view('notfound');
	}
}
