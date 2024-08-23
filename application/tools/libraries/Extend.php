<?php

/**
 * Extend
 * @type Class (Library)
 * @name 'Extend'
 * @param null
 * @description: Helper conatons application helper components
 * 
 * Developed by: Mohamed Asif
 * Date: 20/08/2017
 * Email: asif18@asif18.com
 */

class Extend {
	
	/**
	 * Var declarations
	 */
	public $CI;
	
	/**
	 * Class Contructor
	 */
	public function __construct () {
		$this->CI =& get_instance();
		
		// Start the session
		
		if(isset($this->CI->session->userdata()['is_admin']) && $this->CI->session->userdata()['is_admin'] === true) {
			$this->CI->session->set_userdata(array('user_type' => 'admin'));
		} else {
			$this->CI->session->set_userdata(array('user_type' => 'user'));
		}
	}
	
	/**
	 * Time Now
	 *
	 * @param null
	 */
	public function timenow() {
		return date('Y-m-d H:i:s', now());
	}
	
	/**
	 * Send Email by phpmailer class
	 *
	 * @param $to, $subject, $message
	 * @type String, String, String
	 */
	public function sendEmail($to, $subject, $message) {
		
		try {
			$this->CI->phpmailer->IsSMTP(); 
			$this->CI->phpmailer->Host = SMTP_HOST;
			$this->CI->phpmailer->Port = SMTP_PORT;
			$this->CI->phpmailer->SMTPAuth = true;
			$this->CI->phpmailer->Username = SMTP_USERNAME;
			$this->CI->phpmailer->Password = SMTP_PASSWORD;
			$this->CI->phpmailer->AddReplyTo("noreply@asif18.com", "No Reply");
			$this->CI->phpmailer->SetFrom("mailer@asif18.com", ucfirst(SITE_NAME));
			$this->CI->phpmailer->Subject = $subject;
			$this->CI->phpmailer->AddAddress($to);
			$this->CI->phpmailer->MsgHTML($message);
			$this->CI->phpmailer->Send();
			$return = true;
		}
		catch (phpmailerException $e) {
			$return = $e->errorMessage(); //Pretty error messages from PHPMailer
		}
		catch (Exception $e) {
			$return = $e->getMessage(); //Boring error messages from anything else!
		}
		
		return $return;
	}
}
?>