<?php

/**
 * Article Model
 * @type Class (Model)
 * @name 'ArticleM'
 * @param null
 * @description: Model contains DB operation about 'Article' Controller
 * 
 * Developed by: Mohamed Asif
 * Date: 23/08/2017
 * Email: asif18@asif18.com
 */


class ArticleM extends CI_Model {
	
	/**
	 * Var declarations
	 */
	private $timenow;
	private $tblprefix;
	
	/**
	 * Class Contructor
	 */
	public function __construct() {
		$this->timenow   = $this->extend->timenow();
		$this->tblprefix = $this->db->tbprefix;
	}

	/**
	 * Get article by id
	 *
	 * @param $id
	 * @type Integer
	 */
	public function getArticleById($id) {
		$query = $this->db->query("SELECT * FROM `".$this->tblprefix."articles` WHERE article_id = '".$id."' ");
		if($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return 0;
		}
	}
	
	/**
	 * Get articles
	 *
	 * @param null
	 */
	public function getArticles() {
		$query = $this->db->query("SELECT
									a.article_id,
									a.article_topic,
									c.cat_name,
									a.article_status,
									DATE_FORMAT(a.posted_date, '%d/%m/%Y') AS posted_date
								   FROM ".$this->tblprefix."articles a 
								   LEFT JOIN ".$this->tblprefix."category c ON a.article_category = c.cat_id");
		if($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return 0;
		}
	}
	
	/**
	 * Add new article
	 *
	 * @param $data
	 * @type Array
	 */
	public function addArticle($data) {
		$this->db->insert($this->tblprefix."articles", $data);
	}
	
	/**
	 * Update article table
	 *
	 * @param $data, $where
	 * @type Array, Array
	 */
	public function updateArticle($data, $where) {
		$this->db->update($this->tblprefix."articles", $data, $where);
	}
}
