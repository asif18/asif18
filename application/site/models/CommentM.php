<?php

/**
 * Comment Model
 * @type Class (Model)
 * @name 'CommentM'
 * @param null
 * @description: Model contains DB operation about 'Comment' Controller
 * 
 * Developed by: Mohamed Asif
 * Date: 16/09/2017
 * Email: asif18@asif18.com
 */


class CommentM extends CI_Model {
	
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
	 * Get comments
	 *
	 * @param $where
	 * @type String
	 */
	public function getComments($where) {
		$query = $this->db->query("SELECT 
									c.id, 
									c.article_id, 
									c.parent_comment_id, 
									CASE 
										WHEN c.parent_comment_id IS NULL THEN 'parent' 
										ELSE 'child'
									END AS commentType, 
									u.name,  
									c.comment, 
									c.posted_by,  
									DATE_FORMAT(c.posted_on, '%W %eth %M %Y') AS postDate 
									FROM ".$this->tblprefix."comments c 
									LEFT JOIN ".$this->tblprefix."users u ON u.user_id = c.user_id 
									".$where);
		if($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return 0;
		}
	}
	
	/**
	 * Add new comment
	 *
	 * @param $data
	 * @type Array
	 */
	public function saveComment($data) {
		$this->db->insert($this->tblprefix."comments", $data);
	}
}
