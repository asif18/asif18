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
	}
	
	/**
	 * Time Now
	 *
	 * @param null
	 */
	public function timenow() {
		return date('Y-m-d H:i:s', now());
	}
}
?>