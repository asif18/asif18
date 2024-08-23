<?php

/**
 * Comments
 *
 * Comment page
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Comments extends CI_Controller {
	
	/**
	 * Var declaration
	 */
	private $timenow;
	private $data;
	private $currentArticles;
	
	/*
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
		$this->timenow = $this->extend->timenow();
		$this->load->model('ArticleM');
		$this->load->model('CategoryM');
		$this->load->model('CommentM');
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
		
		$this->data['responseData'] = json_encode($responseData);
		$this->load->view('responder', $this->data);
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
			$category_url_compressed= cleanString($category);
			$article_url 			= base_url('article/'.$article_id."/".$category_url_compressed."/".$article_url_compressed);
			
			$breadCrumbs .= strtolower(str_replace (',', '|'.$article_url.',', $article['article_breadcrumbs'])).',';
		}
		
		$breadCrumbs = rtrim(str_replace(", ", ",", $breadCrumbs), ",");
		$breadCrumbs = array_unique(array_filter(explode(",", $breadCrumbs)));
		
		return $breadCrumbs;
	}
	
	/**
	 * Show comments for the article
	 *
	 * @param $articleId, $topic
	 * @type Int, String
	 */
	public function showcomments($articleId = null, $topic = null) {
		
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
				$this->load->view('comments', $this->data);
			} else {
				redirect('/');
			}
		} else {
			redirect('/');
		}
	}
	
	/**
	 * Get comments
	 *
	 * @param null
	 */
	public function getComments() {
		
		$rawData  = json_decode(file_get_contents('php://input'), true);
		$data	  = $rawData;
		$response = array();
		$dc 	  = array('articleId');
		
		checkDC($dc, $rawData);
		
		$where	  = ' WHERE article_id = "'.$data['articleId'].'" AND status = "A" ORDER BY id DESC';
		
		$comments = $this->CommentM->getComments($where);
		$commentsData = [];
		
		$i = 0;
		foreach($comments as $comment) {
			
			if($comment['commentType'] == 'parent') {
				
				$parentComments[$i] = $comment;
				$where = ' WHERE parent_comment_id = "'.$comment['id'].'" AND status = "A" ORDER BY id ASC';
				$parentComments[$i]['replies'] = $this->CommentM->getComments($where);
			}
			
			$i++;
		}
		
		$responseData = array(
							'data' 		=> $parentComments,
							'exception' => null
						);
		
		$this->data['responseData'] = json_encode($responseData);
		$this->load->view('responder', $this->data);
	}
	
	/**
	 * Save comment
	 *
	 * @param null
	 */
	public function saveComment() {
		
		$rawData  = json_decode(file_get_contents('php://input'), true);
		$data	  = $rawData;
		$response = array();
		$dc 	  = array('articleId', 'commentId', 'name', 'email', 'comments', 'captcha');
		
		checkDC($dc, $rawData);
		
		// Validation
		if($data['articleId'] =='' || !is_numeric($data['articleId']) ) {
			
			$responseData = array(
							'data' 		=> null,
							'exception' => array(
												'status' => true,
												'msg'	 => 'Invalid comment action'
											)
						);
		
			exit(json_encode($responseData));
		}
		
		if($data['name'] == '' || !strlen($data['name']) > 50 ) {
			
			$responseData = array(
							'data' 		=> null,
							'exception' => array(
												'status' => true,
												'msg'	 => 'Name should not be more than 50 characters'
											)
						);
		
			exit(json_encode($responseData));
		}
		
		if($data['email'] == '' || !strlen($data['email']) > 50 || !filter_var($data['email'], FILTER_VALIDATE_EMAIL) ) {
			
			$responseData = array(
							'data' 		=> null,
							'exception' => array(
												'status' => true,
												'msg'	 => 'Email should not be more than 50 characters'
											)
						);
		
			exit(json_encode($responseData));
		}
		
		/*
		$domain = explode('@', $data['email']);
		if (!checkdnsrr($domain[1], 'MX')) {
			$responseData = array(
							'data' 		=> null,
							'exception' => array(
												'status' => true,
												'msg'	 => 'Email domain is not valid'
											)
						);
		
			exit(json_encode($responseData));
		}
		*/
		if($data['comments'] == '') {
			
			$responseData = array(
							'data' 		=> null,
							'exception' => array(
												'status' => true,
												'msg'	 => 'Enter comments'
											)
						);
		
			exit(json_encode($responseData));
		}
		
		if($data['captcha'] == '') {
			
			$responseData = array(
							'data' 		=> null,
							'exception' => array(
												'status' => true,
												'msg'	 => 'Captcha is not checked'
											)
						);
		
			exit(json_encode($responseData));
		}
		
		$captchaResponse=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".G_CAPTCHA_SECRET_KEY."&response=".$data['captcha']."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
		
        if($captchaResponse['success'] == false) {
			$responseData = array(
							'data' 		=> null,
							'exception' => array(
												'status' => true,
												'msg'	 => 'We found you are trying to spam'
											)
						);
		
			exit(json_encode($responseData));
		}
		
		// Duplication check
		$where	  = ' WHERE c.article_id = "'.$data['articleId'].'" AND u.user_email = "'.$data['email'].'" AND c.comment = "'.$data['comments'].'" ';
		
		if($this->CommentM->getComments($where) != 0) {
			
			$responseData = array(
							'data' 		=> null,
							'exception' => array(
												'status' => true,
												'msg'	 => 'Duplicate comment found'
											)
						);
		
			exit(json_encode($responseData));
		}
		
		// Manage comments content
		$comment = $data['comments'];
		$comment = htmlentities($comment);
		$comment = str_replace(array("&lt;pre&gt;", "&lt;/pre&gt;"), array("<pre>", "</pre>"), $comment);
		
		
		// Save user
		
		// Duplicate check
		$user 		= $this->UserM->getUserByEmail($data['email']);
		$isNewUser 	= false;
		
		if($user == 0) {
			
			$isNewUser = true;
			
			$password = userPassword(randomString());
			
			// Add new user
			$userData = array(
							'name' 			=> $data['name'],
							'user_email' 	=> $data['email'],
							'user_password' => $password,
							'user_status' 	=> 'P',
							'user_type' 	=> 'user',
							'posted_date' 	=> $this->timenow
						);
			$this->UserM->saveUser($userData);
			$user = $this->UserM->getUserByEmail($data['email']);
			
			$this->sendWelcomeEmail($user);
			
		}
		
		// Save comment
		$insertData = array(
							'article_id' 		=> $data['articleId'],
							'parent_comment_id' => $data['commentId'],
							'user_id'			=> $user['user_id'],
							'comment' 			=> $comment,
							'posted_by' 		=> $this->session->userdata()['user_type'],
							'ip_address' 		=> $this->input->ip_address(),
							'posted_on' 		=> $this->timenow
						);
		
		$this->CommentM->saveComment($insertData);
		
		if($isNewUser) {
			$responseData = array(
								'data' 		=> array(
													'status' => true,
													'msg'	 => 'Your comment added successfully. Please verify your email for the first time to display your comments.'
												),
								'exception' => null
							);
		} 
		else {				
			$responseData = array(
								'data' 		=> array(
													'status' => true,
													'msg'	 => 'Your comment added successfully'
												),
								'exception' => null
							);
		}
		
		$this->data['responseData'] = json_encode($responseData);
		$this->load->view('responder', $this->data);
	}
		
	/**
	 * Send welcome email
	 *
	 * @param $user
	 * @type Array
	 */
	private function sendWelcomeEmail($user) {
		
		extract($user);
		
		$hash 		= encrypt($user_email);
		$verifyLink = base_url('verify/email/'.$hash);
		
		// Set the email template
		$body = '<div style="background: #FFFFFF; width: 100%!important; height: 100%; font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif;" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<!-- HEADER -->
<table bgcolor="#FFF" style="border-bottom: #FF0059 solid 4px; width:100%;">
<tr>
	<td></td>
	<td>
		<div style="display: block; margin: 0 auto; max-width: 600px; padding: 15px;">
		<table bgcolor="#FFF">
			<tr>
				<td><img src="'.assets_url().'site/img/asif18-logo.png" alt="'.ucfirst(SITE_NAME).'" /></td>
			</tr>
		</table>
		</div>
	</td>
	<td></td>
</tr>
</table><!-- /HEADER -->

<!-- BODY -->
<table style="width:100%;">
<tr>
	<td></td>
	<td style="display:block!important;	max-width:600px!important; margin:0 auto!important; clear:both!important;" bgcolor="#FFFFFF">
		<div style="padding:0!important; margin:0 auto; max-width:600px!important;">
			<table>
			<tr>
				<td>
					<h4 style="font-weight:500; font-size: 23px; margin-top:30px;">Hola, '.$name.'</h4>				
					<p style="font-size: 14px; font-weight: normal; line-height: 1.6; margin-bottom: 10px;">Thank you for you comments. Please click on the below "verify" button to verify your email address to enable your comments.</p>
				</td>
			</tr>
			</table>
		</div>
		
		<!-- Callout Panel -->
		<table style="background-color:#ECF8FF;">
		<tr>
			<td><p style="padding:15px;	background-color:#ECF8FF; margin-bottom: 15px; line-height: 1.3; word-wrap: break-word; width:565px;">
			<br/>
			<a href="'.$verifyLink.'" style="text-decoration: none; font-weight:bold; padding:10px 15px; background-color:#2EBAE6; color:#FFF;">Verify</a><br/><br/>
			<small style="font-size:12px;">If the above button is not clickable please click on the below link</small><br/>
			<small style="font-size:12px;">'.$verifyLink.'</small>
		</p><!-- /Callout Panel --></td>
		</tr>
		</table>
		<table>
		<tr>
			<td><p style="color:#FF007E; font-size:24px; line-height: 1.6; margin-bottom: 10px;">printf("Thank you..!");</p></td>
		</tr>
		<tr>
			<td><p style="font-size:14px; margin-bottom: 15px;">Happy Coding,<br/>'.ucfirst(SITE_NAME).'.</td>
		</tr>
		<tr>
			<td><small style="font-size:10px;">Please do not reply to this email because we are not monitoring this email. To get in touch with us for any queries, email to asif18@asif18.com. </small><br/><small style="font-size:10px;">Copyright &copy; '.date('Y').' '.ucfirst(SITE_NAME).'. All rights reserved.</small></td>
		</tr>
		</table>
	</td>
	<td></td>
</tr>
</table><!-- /BODY -->
</div>';

		return $this->extend->sendEmail($user_email, ucfirst(SITE_NAME).' - Email Verification', $body);
	}
}
