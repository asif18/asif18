<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sample extends CI_Controller {
	
	private $data;
	
	/**
	 * Index
	 */
	public function index() {
		$this->data['someVar'] = '';
		$this->load->view('sample', $this->data);
	}
	
	/**
	 * param
	 */
	public function param() {
		$this->data['someVar'] = 'Some Param';
		$this->load->view('sample', $this->data);
	}
}
