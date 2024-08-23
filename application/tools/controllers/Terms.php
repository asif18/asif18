<?php

/**
 * Terms and Conditions
 *
 * 404 Page
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class terms extends CI_Controller {
	
	/**
	 * Var declaration
	 */
	private $data;
	
	/*
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
		
		$this->load->model('ArticleM');
		
		$this->data['title'] 		 = ucfirst(SITE_NAME)." php tutorials, facebook login, google plus login, paypal integration, load more data on scroll"; 
		$this->data['keywords'] 	 = "asif18, programming blog, web tutorials, facebook login, paypal integration, autopost in facebook wall, wall script, load more data on scroll, upload image in php"; 
		$this->data['description']	 = "asif18.com is a programming blog that describes web tutorials such as facebook integration, google API integration, paypal integration ect., Tutorials related to web languages and libraries such as jQuery, angular JS, Ajax, CSS3, HTML5, PHP5+, MySql, JSON, JSONP, Javascript, Oracle. Describes how to integrate and work in facebook apps, google apps, twitter apps, working with paypal, working with multiple databases and MySql queries";
		$this->data['canonicalUrl'] = base_url();
		$this->data['section']  	= ucfirst(SITE_NAME);
		$latestArticle 				= $this->ArticleM->getLatestArticle();
		
		$this->data['publishedDate'] = '2017-09-06 15:31:00';
		$this->data['updatedDate']   = $latestArticle['last_updated_date'];
		$this->data['imageHeight'] 	 = '100';
		$this->data['imageWidth'] 	 = '200';
	}
	
	/**
	 * index
	 *
	 * @param null
	 */
	public function index() {
		$this->load->view('terms', $this->data);
	}
	
	public function cookies() {
		$this->load->view('cookies', $this->data);
	}
}
