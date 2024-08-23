<?php

/**
 * Verify
 *
 * Verify Email
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Verify extends CI_Controller {
	
	/**
	 * Var declaration
	 */
	private $data;
	
	/*
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model('UserM');
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
		
		exit(json_encode($responseData));
	}
	
	/**
	 * Verify
	 *
	 * @param $hash
	 * @type String
	 */
	public function email($hash) {
		
		// Validation
		if($hash == '') {
			redirect('/');
		}
		
		$email = decrypt($hash);
		
		$user = $this->UserM->getUserByEmail($email);
		
		if($user == 0) {
			
			$this->data['msg']   = 'Invalid email verification';
			$this->data['class'] = 'text-danger';
			$this->load->view('verify', $this->data);
			exit;
		}
		
		switch($user['user_status']) {
			
			case 'A':
				$this->data['msg']   = 'Email verified already';
				$this->data['class'] = 'text-info';
			break;
			
			case 'B':
				$this->data['msg']   = 'Your account has been blocked';
				$this->data['class'] = 'text-warning';
			break;
			
			case 'P':
				$this->UserM->updateUser(array('user_status' => 'A'), array('user_email' => $email));
				$this->data['msg']   = 'Email verified successfully. Your comments will be shown.';
				$this->data['class'] = 'text-info';
			break;
			
			default:
				redirect('/');
			break;
		}
		
		$this->data['title'] 		 = ucfirst(SITE_NAME)." PHP Tutorials, Facebook connect, facebook login, google plus login, g share"; 
		$this->data['keywords'] 	 = "asif18, programming blog, web tutorials, facebook login, facebook connect, facebook share, autopost in facbook, google plus, gshare, fplus button, twitter widgets, paypal integration, integrate paypal in php"; 
		$this->data['description']	 = "asif18.com is a programming blog that describes web tutorials such as facebook components, google coponents, paypal integration. Tutorials related to web languages and libraries such as jquery, ajax, css, html, php, mysql, json, curl, javascript. Describes the funtions, classes, libraries, how to integrate and work in facebook apps, google apps, twitter apps, working with paypal, working with multiple databases and mysql quiries, simple php classes and funtions";
		
		if($this->data['msg']) {
			$this->load->view('verify', $this->data);
		} else {
			redirect('/');
		}
			
	}
	 
}
