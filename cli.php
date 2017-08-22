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
    try {
        $response = $Guzzle->get($fullUrl, ['exceptions' => false]);
        if ($response->getStatusCode() == 200) {
            $service->urlcrawlerrorssamples->markAsFixed($siteUrl, $url->pageUrl, $errorType, $environment);
            echo $fullUrl . "\033[32m solved \033[0m\n";
        } else {
            echo $fullUrl . "\033[31m  error persists \033[0m\n";
        }
    } catch (GuzzleHttp\Exception\TooManyRedirectsException $e) {
        echo "TOO MANY REDIRECTS\n";
        echo $fullUrl . "\033[31m error persists \033[0m\n";
    } catch (Google_Service_Exception $e) {
        if ($e->getCode() == 429) {
            echo "\n SLEEP TOO MANY REQUESTS\n";
            sleep(10);
        } else {
            echo "Unknown error " . $e->getMessage() . "\n";
            echo "Trying to fix URL: $fullUrl\n";
        }
    }
}
