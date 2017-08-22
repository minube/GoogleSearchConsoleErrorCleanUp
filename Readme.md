# Google Search Console (Webmaster Tools) Automatic Error Clean Up
PHP Cli library to clean up automatically all solved errors in Google Search Console Crawl Errors.
It makes use of [Official Google PHP API Client](https://github.com/google/google-api-php-client)

## Configuration
Install Composer dependencies

`composer install`
    
Create a Google Service Account following [instructions provided by Google](https://developers.google.com/api-client-library/php/auth/web-app#creatingcred)

Replace `/path/to/service-account.json` with the path to the downloaded file

Authorize the Google Service Account to access your WMT info (add the email as a user with full access to your Search Console)

## Usage
`php -f cli.php http://www.example.com errorType device`

###Error type options
- authPermissions
- flashContent
- manyToOneRedirect
- notFollowed
- notFound
- other
- roboted
- serverError
- soft404 (**use with caution** as it only check 200 HTTP status to mark the problem as solved)

### Device Options
- mobile
- smartphoneOnly
- web
