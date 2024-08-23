<?php
function encrypt($data) {
	return base64_encode(base64_encode(base64_encode(strrev($data))));
}
function decrypt($data) {
	return strrev(base64_decode(base64_decode(base64_decode($data))));
}
?>