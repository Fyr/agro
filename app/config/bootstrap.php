<?php
define('TEST_ENV', $_SERVER['SERVER_ADDR'] == '192.168.1.22');

define('DOMAIN_NAME', 'agromotors.dev');
define('DOMAIN_TITLE', 'AgroMotors.dev');

define('EMAIL_ADMIN', 'fyr.work@gmail.com');
define('EMAIL_ADMIN_CC', 'fyr.work@gmail.com');

define('_SALT', '_MSTL_');

define('PATH_FILES_UPLOAD', $_SERVER['DOCUMENT_ROOT'].'/files/');

require_once('extra.php');

function ___($string) {
	return __($string, true);
}

function fdebug($data, $logFile = 'tmp.log', $lAppend = true) {
	file_put_contents($logFile, mb_convert_encoding(print_r($data, true), 'cp1251', 'utf8'), ($lAppend) ? FILE_APPEND : null);
}