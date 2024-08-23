<?php

/**
 * Site Helper
 * @type helper
 * @description - Contains extra functions and methods
 *
 * Developer: Mohamed Asif
 * Date: 20/08/2017
 * Email: asif18@asif18.com
 */

 
/**
 * DC Validation
 */
if(!function_exists('checkDC')) {
	function checkDC($dc, $postedArray) {
		
		$rawData  = $postedArray;
		$data	  = $rawData;
		
		/**
		 * Check Data Contract
		 */
		$invalidDc = array();
		
		if(count($dc) != count($rawData)) {

			$errCode = 'ASE00001';
			$msg	 = $errCode.' - No parameters passed or invalid parameter length';

			$response['data']		= null;
			$response['exception']	= array(
										'status' => TRUE,
										'code'	 => $errCode,
										'msg'	 => $msg
									 );
			exit(json_encode($response));
		}

		$i=0;
		foreach($rawData as $key => $value) {
			if($key != $dc[$i]) {
				$invalidDc[] = $key;
			}
			$i++;
		}

		if(count($invalidDc) > 0) {
			$errCode = 'ASE00002';
			$msg	 = $errCode.' - Invalid parameters passed - ' . implode($invalidDc, ',');

			$response['data']		= null;
			$response['exception']	= array(
										'status' => TRUE,
										'code'	 => $errCode,
										'msg'	 => $msg
									 );
			exit(json_encode($response));
		}
		
	}
}

/**
 * User password
 *
 * @param $string
 */
function userPassword($string) {
	return md5(base64_encode($string.'Sas1f8#$CBg'));
}

/**
 * Assets URL
 *
 * @param $string
 */
function assets_url($string = '') {
	
	return ASSETS_URL.$string;
}

?>