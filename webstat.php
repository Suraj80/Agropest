<?php
require 'vendor/autoload.php';

use Google\Client;
use Google\Service\AnalyticsReporting;

// Load the service account JSON key file
$KEY_FILE_LOCATION = 'path/to/your-service-account.json';

$client = new Client();
$client->setAuthConfig($KEY_FILE_LOCATION);
$client->addScope(AnalyticsReporting::ANALYTICS_READONLY);

$analytics = new AnalyticsReporting($client);

// Define the request
$request = new Google_Service_AnalyticsReporting_ReportRequest();
$request->setViewId('YOUR_VIEW_ID'); // Replace with your GA View ID
$request->setDateRanges([new Google_Service_AnalyticsReporting_DateRange([
    'startDate' => '7daysAgo',
    'endDate' => 'today'
])]);
$request->setMetrics([new Google_Service_AnalyticsReporting_Metric([
    'expression' => 'ga:pageviews'
])]);

$body = new Google_Service_AnalyticsReporting_GetReportsRequest();
$body->setReportRequests([$request]);

$response = $analytics->reports->batchGet($body);

// Print response
foreach ($response->getReports() as $report) {
    foreach ($report->getData()->getRows() as $row) {
        echo "Page Views: " . $row->getMetrics()[0]->getValues()[0];
    }
}
?>
