<?php

require_once('includes/ringcentral-functions.inc');
require_once('includes/ringcentral-php-functions.inc');

show_errors();

require('includes/vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/includes");
$dotenv->load();

$sendingMobile = $_ENV['RC_MOBILE_SENDING_NUMBER'] ;

$controller = ringcentral_sdk();

$queryParams = array(
	'from' => array( $sendingMobile, ),
	'to' => array( "+19029405827", ),
	'optStatus' => array( "OptIn" ),
//	'optStatus' => array( "OptOut" ),
	'source' => array( "api" )
);

try {
	$response = $controller['platform']->patch(
		"/restapi/v2/accounts/~/sms/consents",
		$queryParams
	);
	echo_spaces("API response", $response);
} catch (Exception $e) {
	 echo_spaces("API Error Message", $e->getMessage(), 1);
	 echo_spaces("API Error Trace", $e->getTrace());
}