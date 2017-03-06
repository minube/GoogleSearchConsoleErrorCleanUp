<?php
error_reporting(E_ALL);

defined('APPLICATION_PATH')
|| define('APPLICATION_PATH', realpath(dirname(__FILE__)));

putenv('GOOGLE_APPLICATION_CREDENTIALS=/path/to/service-account.json';

require_once APPLICATION_PATH . '/vendor/autoload.php';

$client = new Google_Client();
$client->useApplicationDefaultCredentials();
$client->addScope(Google_Service_Webmasters::WEBMASTERS);

$service = new Google_Service_Webmasters($client);

$siteUrl = $argv[1];
$errorType = $argv[2];
$environment = $argv[3];
$urls = $service->urlcrawlerrorssamples->listUrlcrawlerrorssamples($siteUrl, $errorType, $environment);
$Guzzle = new GuzzleHttp\Client();

foreach ($urls as $url) {
    $fullUrl = $siteUrl . $url->pageUrl;
    $response = $Guzzle->get($fullUrl, ['exceptions' => false]);
    if ($response->getStatusCode() == 200) {
        $service->urlcrawlerrorssamples->markAsFixed($siteUrl, $url->pageUrl, $errorType, $environment);
        echo $fullUrl . " solved \n";
    } else {
        echo $fullUrl . " error persists \n";
    }
}
