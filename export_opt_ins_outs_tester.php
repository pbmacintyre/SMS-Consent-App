<?php

require_once('includes/ringcentral-functions.inc');
require_once('includes/ringcentral-php-functions.inc');

show_errors();

$controller = ringcentral_sdk();

try {
	$response = $controller['platform']->get("/restapi/v2/accounts/~/sms/consents/export");
	echo_spaces("API response", $response->text());

	$csv = $response->text() ;

	// ====================================
	$lines = explode("\n", trim($csv)); // Trim and split by line
	echo_spaces("lines", $lines);

	$csv_data = [];
	foreach ($lines as $line) {
		if (trim($line) === '') continue;  // skip empty lines
		$csv_data[] = str_getcsv($line);   // Parse CSV row
	}
	echo_spaces("csv_data", $csv_data);

} catch (Exception $e) {
	 echo_spaces("API Error Message", $e->getMessage(), 1);
	 echo_spaces("API Error Trace", $e->getTrace());
}