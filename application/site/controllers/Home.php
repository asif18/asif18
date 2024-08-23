<?php

/**
 * Home
 *
 * Home page of the front-end
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	/**
	 * Var declaration
	 */
	private $data;
	private $currentArticles;
	
	/*
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model('ArticleM');
		$this->load->model('CategoryM');
	}
	
	/**
	 * index
	 *
	 * @param null
	 */
	public function index() {
		
		// Show all the articles
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
		
		$this->load->library('pagination');
		$config 	= $this->paginationConfig();
		$this->pagination->initialize($config);
		$articles 	= $this->ArticleM->getArticles(' ORDER BY a.posted_date DESC LIMIT 0, '.$config["per_page"]);
		
		// Load currentArticles()
		$this->loadCurrentArticles($articles);
		$relatedArticles 				= $this->relatedArticles();
		
		// Load Bread Crumbs
		$this->data['breadCrumbs'] 		= $this->loadBreadCrumbs($relatedArticles);
		$this->data['pagination'] 		= $this->pagination->create_links();
		$this->data['view'] 			= 'allArticles';
		$this->data['articles']			= $articles;
		$this->data['relatedArticles']	= $relatedArticles;
		$this->load->view('home', $this->data);
	}
	
	/**
	 * Category
	 *
	 * @param $category
	 * @type String
	 */
	public function category($category = null) {
		
		if($category !== null) {
			$category_fetch = $this->CategoryM->getCategoryByName($category);
			
			if(is_array($category_fetch) && count($category_fetch) > 0) {
				
				$this->data['title'] 		 = $category_fetch['cat_title'].' - '.ucfirst(SITE_NAME); 
				$this->data['keywords'] 	 = $category_fetch['cat_keywords']; 
				$this->data['description']	 = $category_fetch['cat_description'];
				$this->data['canonicalUrl']  = base_url('category/'.$category);
				$this->data['section']  	 = $category;
				$latestArticle 				 = $this->ArticleM->getLatestArticle();
				
				$this->data['publishedDate'] = '2017-09-06 15:31:00';
				$this->data['updatedDate']   = $latestArticle['last_updated_date'];
				$this->data['imageHeight'] 	 = '100';
				$this->data['imageWidth'] 	 = '200';
				
				$articles 	 				 = $this->ArticleM->getArticles(' AND a.article_category = '.$category_fetch['cat_id']);
				
				// Load currentArticles()
				$this->loadCurrentArticles($articles);
				$relatedArticles 				= $this->relatedArticles();
				
				// Load Bread Crumbs
				$this->data['breadCrumbs'] 		= $this->loadBreadCrumbs($relatedArticles);
				
				$this->data['articles']			= $articles;
				$this->data['relatedArticles']	= $relatedArticles;
			} else {
				redirect('/');
			}
		} else {
			redirect('/');
		}
		
		$this->data['category']	= $category;
		$this->load->view('home', $this->data);
	}
	
	/**
	 * Page
	 *
	 * @param $page
	 * @type Int
	 */
	public function page($page = null) {
		
		if($page === null) {
			redirect('/');
		}
		
		// Show all the articles
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
		
		$this->load->library('pagination');
		$config 	= $this->paginationConfig();
		$this->pagination->initialize($config);
		$page 		= ($this->uri->segment(2))? $this->uri->segment(2) : 0;
		$articles 	= $this->ArticleM->getArticles(' ORDER BY a.posted_date DESC LIMIT '.$page.', '.$config["per_page"]);
		
		// Load currentArticles()
		$this->loadCurrentArticles($articles);
		$relatedArticles 				= $this->relatedArticles();
		
		// Load Bread Crumbs
		$this->data['breadCrumbs'] 		= $this->loadBreadCrumbs($relatedArticles);
		$this->data['pagination'] 		= $this->pagination->create_links();
		$this->data['view'] 			= 'allArticles';
		$this->data['articles']			= $articles;
		$this->data['relatedArticles']	= $relatedArticles;
		
		$this->load->view('home', $this->data);
	}
	
	/**
	 * Paginationn config
	 *
	 * @param null
	 */
	private function paginationConfig() {
		
		$config['full_tag_open'] 	= "<ul class='pagination'>";
		$config['full_tag_close'] 	= "</ul>";
		$config['num_tag_open'] 	= "<li>";
		$config['num_tag_close'] 	= "</li>";
		$config['cur_tag_open'] 	= "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] 	= "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] 	= "<li>";
		$config['next_tagl_close'] 	= "</li>";
		$config['prev_tag_open'] 	= "<li>";
		$config['prev_tagl_close'] 	= "</li>";
		$config['first_tag_open'] 	= "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] 	= "<li>";
		$config['last_tagl_close'] 	= "</li>";

		$config['first_url'] 		= base_url();
		$config['base_url'] 		= base_url('page');
		$config['total_rows'] 		= $this->ArticleM->getTotalArticleCount();
		$config['per_page'] 		= 6;
		
		return $config;
	}
	
	/**
	 * Load Current articles
	 *
	 * @param $articles
	 * @type Array
	 */
	private function loadCurrentArticles($articles) {
		foreach($articles as $article) {
			$this->currentArticles .= $article['article_id'].',';
		}
		
		$this->currentArticles = rtrim($this->currentArticles, ',');
	}
	
	/**
	 * Relates articles
	 *
	 * @param null
	 */
	private function relatedArticles() {
		
		$condition = " AND a.article_id NOT IN ('".$this->currentArticles."') ";
		return $this->ArticleM->getRelatedArticles($condition);
	}
	
	/**
	 * Load Related Articles Bread Crumbs
	 *
	 * @param $articles
	 * @type Array
	 */
	private function loadBreadCrumbs($articles) {
		
		$breadCrumbs = '';
		
		foreach($articles as $article) {
			$article_id				= $article["article_id"];
			$category 				= $article["cat_name"];
			$article_url_compressed	= cleanString($article['article_topic']);
			$article_url 			= base_url('article/'.$article_id."/".$article_url_compressed."/");
			
			$breadCrumbs .= strtolower(str_replace (',', '|'.$article_url.',', $article['article_breadcrumbs'])).',';
		}
		
		$breadCrumbs = rtrim(str_replace(", ", ",", $breadCrumbs), ",");
		$breadCrumbs = array_unique(array_filter(explode(",", $breadCrumbs)));
		
		return $breadCrumbs;
	}
	
	/**
	 * Show single article
	 *
	 * @param $articleId
	 * @type Int
	 */
	public function article($articleId = null, $category = null, $topic = null) {
		
		if($articleId !== null) {
			
			$articles = $this->ArticleM->getArticleById($articleId);
			
			if(is_array($articles) && count($articles) > 0) {
				
				$this->data['title'] 		 = $articles['article_topic'] .' - '. ucfirst(SITE_NAME);
				$this->data['keywords'] 	 = $articles['article_keywords']; 
				$this->data['description']	 = $articles['article_description'];
				
				$article_url 			= base_url('article/'.$articles['article_id']."/".cleanString($articles['article_topic'])."/");
				$this->data['canonicalUrl']  = $article_url;
				$this->data['section']  	 = ucfirst(SITE_NAME);
			
				$this->data['publishedDate'] = $articles['posted_date'];
				$this->data['updatedDate']   = $articles['last_updated_date'];
				$this->data['imageHeight'] 	 = '585';
				$this->data['imageWidth'] 	 = '300';
				
				// Load currentArticles()
				$this->currentArticles			= $articles['article_id'];
				$relatedArticles 				= $this->relatedArticles();
				
				// Load Bread Crumbs
				$this->data['breadCrumbs'] 		= $this->loadBreadCrumbs($relatedArticles);
				$this->data['view'] 			= 'singleArticle';
				$this->data['article']			= $articles;
				$this->data['relatedArticles']	= $relatedArticles;
				$this->load->view('article', $this->data);
			} else {
				redirect('/');
			}
		} else {
			redirect('/');
		}
	}
}
