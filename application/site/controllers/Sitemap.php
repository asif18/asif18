<?php

/**
 * Sitemap
 *
 * Sitemap
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemap extends CI_Controller {
	
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
		$this->load->model('CategoryM');
		$this->data['articles']   = $this->ArticleM->getArticles();
		$this->data['categories'] = $this->CategoryM->getCategories();
		$this->load->view('sitemap', $this->data);
	}
}
