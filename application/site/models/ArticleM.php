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
		$query = $this->db->query("SELECT
									a.article_id,
									a.article_keywords,
									a.article_description,
									a.article_topic,
									a.article_content,
									a.article_breadcrumbs, 
									a.article_downloadfile, 
									a.article_demolink, 
									a.last_updated_date, 
									a.posted_date, 
									c.cat_id, 
									c.cat_name, 
									(SELECT COUNT(cm.id) FROM ".$this->tblprefix."comments cm WHERE cm.article_id = a.article_id AND cm.status = 'A' ) AS commentCount 
								   FROM ".$this->tblprefix."articles a 
								   LEFT JOIN ".$this->tblprefix."category c ON a.article_category = c.cat_id 
								   WHERE a.article_status = 'A' AND a.article_id = '".$id."' ");
								   
		if($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return 0;
		}
	}
	
	/**
	 * Get articles
	 *
	 * @param $condition
	 * @type String
	 */
	public function getArticles($condition = '') {
		
		$query = $this->db->query("SELECT
									a.article_id,
									a.article_topic,
									a.article_content,
									a.article_breadcrumbs, 
									a.article_demolink,
									a.posted_date, 
									a.last_updated_date, 
									c.cat_id, 
									c.cat_name, 
									(SELECT COUNT(cm.id) FROM ".$this->tblprefix."comments cm WHERE cm.article_id = a.article_id AND cm.status = 'A' ) AS commentCount 
								   FROM ".$this->tblprefix."articles a 
								   LEFT JOIN ".$this->tblprefix."category c ON a.article_category = c.cat_id 
								   WHERE a.article_status = 'A' ". $condition);
		if($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return 0;
		}
	}
	
	/**
	 * Get related articles
	 *
	 * @param $condition
	 * @type String
	 */
	public function getRelatedArticles($condition = '') {
		$query = $this->db->query("SELECT
									a.article_id,
									a.article_topic, 
									a.article_breadcrumbs, 
									c.cat_name 
								   FROM ".$this->tblprefix."articles a 
								   LEFT JOIN ".$this->tblprefix."category c ON a.article_category = c.cat_id 
								   WHERE a.article_status = 'A' ". $condition);
		if($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return 0;
		}
	}
	
	/**
	 * Get latest article
	 *
	 * @param null
	 */
	public function getLatestArticle() {
		$query = $this->db->query("SELECT
									a.article_id,
									a.article_topic,
									c.cat_name,
									a.article_status,
									a.last_updated_date, 
									a.posted_date
								   FROM ".$this->tblprefix."articles a 
								   LEFT JOIN ".$this->tblprefix."category c ON a.article_category = c.cat_id 
								   ORDER BY a.article_id DESC LIMIT 1");
		if($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return 0;
		}
	}
	
	/**
	 * Get total articles count
	 *
	 * @param null
	 */
	public function getTotalArticleCount() {
		$query = $this->db->query("SELECT 
									COUNT(a.article_id) AS articleCount 
								   FROM ".$this->tblprefix."articles a 
								   WHERE a.article_status = 'A'");
		return $query->row_array()['articleCount'];
	}
}
