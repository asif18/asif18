<?php

/**
 * Category Controller
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {
	
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
		$this->load->model('CategoryM');
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
	 * Get Category By ID
	 *
	 * @param null
	 */
	public function getCategoryById() {
		
		$rawData  = json_decode(file_get_contents('php://input'), true);
		$data	  = $rawData;
		$response = array();
		$dc 	  = array('categoryId');
		
		checkDC($dc, $rawData);
		
		$result = $this->CategoryM->getCategoryById($data['categoryId']);
			
		// If no category available for the ID
		if($result == 0) {
			
			$responseData = array(
								'data' 		=> null,
								'exception' => array(
													'status' => true,
													'msg'	 => 'Invalid Category'
												)
							);
		} else {
			$responseData = array(
								'data' 		=> array(
													'status' 		=> true,
													'categoryData'	=> array(
																			'categoryId' 	=> $result['cat_id'],
																			'categoryName' 	=> $result['cat_name'],
																			'title' 		=> $result['cat_title'],
																			'keyword' 		=> $result['cat_keywords'],
																			'description' 	=> $result['cat_description'],
																		)
												),
								'exception' => null
							);
		}
		
		$this->data['responseData'] = json_encode($responseData);
		$this->load->view('responder', $this->data);
	}
	
	
	/**
	 * Save Category
	 *
	 * @param null
	 */
	public function saveCategory() {
		
		$rawData  = json_decode(file_get_contents('php://input'), true);
		$data	  = $rawData;
		$response = array();
		$dc 	  = array('categoryId', 'categoryName', 'title', 'keyword', 'description');
		
		checkDC($dc, $rawData);
		
		// Edit Mode
		if($data['categoryId'] != '') {
			
			$result = $this->CategoryM->getCategoryById($data['categoryId']);
			
			// If no category available for the ID
			if($result == 0) {
				
				$responseData = array(
									'data' 		=> null,
									'exception' => array(
														'status' => true,
														'msg'	 => 'Invalid Category'
													)
								);
			} else {
				
				// Updated the category
				$dbData = array(
								'cat_name' 			=> $data['categoryName'],
								'cat_title' 		=> $data['title'],
								'cat_keywords' 		=> $data['keyword'],
								'cat_description' 	=> $data['description']
							);
				$where  = array(
								'cat_id' => $data['categoryId']
							);
				$this->CategoryM->updateCategory($dbData, $where);
				
				$responseData = array(
								'data' 		=> array(
													'status' => true,
													'msg'	 => 'Category updated successfully'
												),
								'exception' => null
							);
				
			}
			
		} 
		// Add Mode
		else {
			
			// Add the category
			$dbData = array(
							'cat_name' 			=> $data['categoryName'],
							'cat_title' 		=> $data['title'],
							'cat_keywords' 		=> $data['keyword'],
							'cat_description' 	=> $data['description'],
							'cat_status'		=> 'A',
							'post_date'			=> $this->timenow
						);
			
			$this->CategoryM->addCategory($dbData);
			
			$responseData = array(
								'data' 		=> array(
													'status' => true,
													'msg'	 => 'Category added successfully'
												),
								'exception' => null
							);
			
		}
		
		$this->data['responseData'] = json_encode($responseData);
		$this->load->view('responder', $this->data);
	}
	
	/**
	 * get Categories
	 *
	 * @param null
	 */
	public function getCategories() {
		
		$responseData = array(
								'data' 		=> array(
													'status' 	 => true,
													'categories' => ($this->CategoryM->getCategories() != 0) ? $this->CategoryM->getCategories() : null
												),
								'exception' => null
							);
		
		$this->data['responseData'] = json_encode($responseData);
		$this->load->view('responder', $this->data);
	}
}
