<?php

/**
 * Article Controller
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Article extends CI_Controller {
	
	/**
	 * Var declaration
	 */
	private $data;
	private $timenow;
	
	/*
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
		$this->timenow   = $this->extend->timenow();
		$this->load->model('ArticleM');
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
	 * Get Article By ID
	 *
	 * @param null
	 */
	public function getArticleById() {
		
		$rawData  = json_decode(file_get_contents('php://input'), true);
		$data	  = $rawData;
		$response = array();
		$dc 	  = array('articleId');
		
		checkDC($dc, $rawData);
		
		$result = $this->ArticleM->getArticleById($data['articleId']);
			
		// If no article available for the ID
		if($result == 0) {
			
			$responseData = array(
								'data' 		=> null,
								'exception' => array(
													'status' => true,
													'msg'	 => 'Invalid Article'
												)
							);
		} else {
			
			// Load Category Model
			$this->load->model('CategoryM');
			
			$responseData = array(
								'data' 		=> array(
													'status' 		=> true,
													'categories'	=> $this->CategoryM->getCategories(),
													'articleData'	=> array(
																			'articleId' 	=> $result['article_id'],
																			'topic' 		=> $result['article_topic'],
																			'category' 		=> $result['article_category'],
																			'content' 		=> $result['article_content'],
																			'demoLink' 		=> $result['article_demolink'],
																			'downloadFile' 	=> $result['article_downloadfile'],
																			'breadCrumbs' 	=> $result['article_breadcrumbs'],
																			'keywords' 	 	=> $result['article_keywords'],
																			'description'  	=> $result['article_description'],
																			'status' 		=> $result['article_status'],
																			'postedDate' 	=> $result['posted_date'],
																		)
												),
								'exception' => null
							);
		}
		
		$this->data['responseData'] = json_encode($responseData);
		$this->load->view('responder', $this->data);
	}
	
	
	/**
	 * Save Article
	 *
	 * @param null
	 */
	public function saveArticle() {
		
		$rawData  = json_decode(file_get_contents('php://input'), true);
		$data	  = $rawData;
		$response = array();
		$dc 	  = array('articleId', 'topic', 'category', 'breadCrumbs', 'keywords', 'description', 'demoLink', 'downloadFile', 'content', 'postedBy');
		
		checkDC($dc, $rawData);
		
		// Edit Mode
		if($data['articleId'] != '') {
			
			$result = $this->ArticleM->getArticleById($data['articleId']);
			
			// If no category available for the ID
			if($result == 0) {
				
				$responseData = array(
									'data' 		=> null,
									'exception' => array(
														'status' => true,
														'msg'	 => 'Invalid Article'
													)
								);
			} else {
				
				// Updated the article
				$dbData = array(
								'article_topic' 		=> $data['topic'],
								'article_category' 		=> $data['category'],
								'article_content' 		=> $data['content'],
								'article_demolink' 		=> $data['demoLink'],
								'article_downloadfile' 	=> $data['downloadFile'],
								'article_breadcrumbs' 	=> $data['breadCrumbs'],
								'article_keywords' 		=> $data['keywords'],
								'article_description' 	=> $data['description'],
								'article_postedby' 		=> $data['postedBy'],
								'last_updated_date' 	=> $this->timenow
							);
				$where  = array(
								'article_id' => $data['articleId']
							);
				$this->ArticleM->updateArticle($dbData, $where);
				
				$responseData = array(
								'data' 		=> array(
													'status' => true,
													'msg'	 => 'Article updated successfully'
												),
								'exception' => null
							);
				
			}
			
		} 
		// Add Mode
		else {
			
			// Add the article
			$dbData = array(
								'article_topic' 		=> $data['topic'],
								'article_category' 		=> $data['category'],
								'article_content' 		=> $data['content'],
								'article_demolink' 		=> $data['demoLink'],
								'article_downloadfile' 	=> $data['downloadFile'],
								'article_breadcrumbs' 	=> $data['breadCrumbs'],
								'article_keywords' 		=> $data['keywords'],
								'article_description' 	=> $data['description'],
								'article_postedby' 		=> $data['postedBy'],
								'last_updated_date'		=> $this->timenow, 
								'posted_date' 			=> $this->timenow
							);
			
			$this->ArticleM->addArticle($dbData);
			
			$responseData = array(
								'data' 		=> array(
													'status' => true,
													'msg'	 => 'Article added successfully'
												),
								'exception' => null
							);
			
		}
		
		$this->data['responseData'] = json_encode($responseData);
		$this->load->view('responder', $this->data);
	}
	
	/**
	 * get Articles
	 *
	 * @param null
	 */
	public function getArticles() {
		
		$responseData = array(
								'data' 		=> array(
													'status' 	 => true,
													'articles'   => ($this->ArticleM->getArticles() != 0) ? $this->ArticleM->getArticles() : null
												),
								'exception' => null
							);
		
		$this->data['responseData'] = json_encode($responseData);
		$this->load->view('responder', $this->data);
	}
	
	/**
	 * Update Article Status
	 *
	 * @param null
	 */
	public function updateArticleStatus() {
		
		$rawData  = json_decode(file_get_contents('php://input'), true);
		$data	  = $rawData;
		$response = array();
		$dc 	  = array('articleId', 'status');
		
		checkDC($dc, $rawData);
		
		// Check for valid acrticle
		if($data['articleId'] != '') {
			
			$result = $this->ArticleM->getArticleById($data['articleId']);
			
			// If no category available for the ID
			if($result == 0) {
				
				$responseData = array(
									'data' 		=> null,
									'exception' => array(
														'status' => true,
														'msg'	 => 'Invalid Article'
													)
								);
			} else {
				
				switch($data['status']) {
					
					case 'activate':
						$article_status = 'A';
					break;
					
					
					case 'deactivate':
						$article_status = 'D';
					break;
				};
				
				// Updated the article status
				$dbData = array('article_status' => $article_status);
				$where  = array('article_id' 	 => $data['articleId']);
				
				$this->ArticleM->updateArticle($dbData, $where);
				
				$responseData = array(
								'data' 		=> array(
													'status' => true,
													'msg'	 => 'Article '.$data['status'].'d successfully'
												),
								'exception' => null
							);
				
			}
			
		}
		
		$this->data['responseData'] = json_encode($responseData);
		$this->load->view('responder', $this->data);
	}
}
