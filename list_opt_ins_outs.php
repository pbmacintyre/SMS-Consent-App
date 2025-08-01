<?php

require_once('includes/ringcentral-functions.inc');
require_once('includes/ringcentral-php-functions.inc');

show_errors();

require('includes/vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/includes");
$dotenv->load();

$sendingMobile = $_ENV['RC_MOBILE_SENDING_NUMBER'] ;

echo_spaces("listing of all opted accounts showing IN / OUT status, if there is a blank display then there are no opted records.", "", 2);

$controller = ringcentral_sdk();

// list subscriptions then delete the one we don't need.

$queryParams = array(
	//'from' => array( $sendingMobile, ),
	'optStatus' => array( "OptOut", "OptIn" )
);

//$r = $platform->get("/restapi/v2/accounts/{$accountId}/sms/consents", $queryParams);

try {
	$response = $controller['platform']->get("/restapi/v2/accounts/~/sms/consents",
		$queryParams
	);
	$subscriptions = $response->json()->records;
} catch (Exception $e) {
	echo_spaces("catch error",  $e->getMessage());
}

echo_spaces("Opt Ins / Outs", $subscriptions);