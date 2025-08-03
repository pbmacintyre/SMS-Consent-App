<?php
/** Copyright (C) 2019-2025 Paladin Business Solutions */

/* ================= */
/* Generic functions */
/* ================= */

function app_name() {
	return "SMS Consent App";
}

/* ================== */
/* Get RingCental SDK */
/* ================== */
function ringcentral_sdk() {
	// Include Libraries
	require('includes/vendor/autoload.php');

	$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
	$dotenv->load();

	$jwt_key = $_ENV['RC_JWT_KEY'];

	$sdk = new RingCentral\SDK\SDK(
		$_ENV['RC_APP_CLIENT_ID'],
		$_ENV['RC_APP_CLIENT_SECRET'],
		$_ENV['RC_SERVER_URL']);

	$platform = $sdk->platform();

	// Login via API
	if (!$sdk->platform()->loggedIn()) {
		try {
			$platform->login(["jwt" => $jwt_key]);
		} catch (\RingCentral\SDK\Http\ApiException $e) {
			echo_spaces("SDK Failure", $e->getMessage());
		}
	}
	$controller = array('SDK' => $sdk, 'platform' => $platform);
	return $controller;
}

function set_opt_in_out($mobile, $process) {
	require('includes/vendor/autoload.php');
	$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ );
	$dotenv->load();

	$sendingMobile = $_ENV['RC_MOBILE_SENDING_NUMBER'] ;

	$controller = ringcentral_sdk();

	$queryParams = array(
		'from' => array( $sendingMobile, ),
		'to' => array( $mobile, ),
		'optStatus' => array( $process ),
		'source' => array( "api" )
	);

	try {
		$response = $controller['platform']->patch("/restapi/v2/accounts/~/sms/consents",
			$queryParams
		);
		$success = true;
	} catch (Exception $e) {
		$success = false;
	}
	return $success;
}
