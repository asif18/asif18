<?php

/**
 * Feed
 *
 * Feed for RSS
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Feed extends CI_Controller {
	
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
		
		$this->load->model('ArticleM');
		$this->data['articles'] 	 = $this->ArticleM->getArticles();
		$this->data['latestArticle'] = $this->ArticleM->getLatestArticle();
		$this->load->view('feed', $this->data);
	}
}
