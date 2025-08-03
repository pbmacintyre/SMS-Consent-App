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

	echo_spaces("lines output ", $lines, 2);

	$csv_data = [];
	$headers = str_getcsv(array_shift($lines)); // Get header line

	echo_spaces("headers output ", $headers, 3);

	foreach ($lines as $line) {
		if (trim($line) === '') continue; // skip empty lines
		$row = str_getcsv($line);         // Parse CSV row
		$csv_data[] = array_combine($headers, $row); // Merge with headers
	}
	// ====================================

	foreach ($csv_data as $key => $row) {
//		echo_spaces("From", $row);
		echo_spaces("From", $row['FROM']);
		echo_spaces("To", $row['TO']);
		echo_spaces("Status", $row['STATUS']);
		echo_spaces("Source", $row['SOURCE'], 2);
	}

} catch (Exception $e) {
	 echo_spaces("API Error Message", $e->getMessage(), 1);
	 echo_spaces("API Error Trace", $e->getTrace());
}