<?php

require_once('includes/ringcentral-functions.inc');
require_once('includes/ringcentral-php-functions.inc');

ob_start();

//show_errors();

$controller = ringcentral_sdk();

try {
	$response = $controller['platform']->get("/restapi/v2/accounts/~/sms/consents/export");
	$csv = $response->text() ;
// ====================================
	$lines = explode("\n", trim($csv)); // Trim and split by line
	$csv_data = [];
	foreach ($lines as $line) {
		if (trim($line) === '') continue;  // skip empty lines
		$csv_data[] = str_getcsv($line);   // Parse CSV row
	}
// ====================================
	// Set headers to prompt file download
	header('Content-Type: text/csv');
	header('Content-Disposition: attachment;filename="data.csv"');
	// Open output stream
	$output = fopen('php://output', 'w');
	// Write each row to the CSV
	foreach ($csv_data as $row) {
		fputcsv($output, $row);
	}

// Close output stream
	fclose($output);

} catch (Exception $e) {
	 echo_spaces("API Error Message", $e->getMessage(), 1);
	 echo_spaces("API Error Trace", $e->getTrace());
}

ob_end_flush();