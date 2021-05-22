# URL Shortener

## Prerequisites

* Basic LAMP stack environment with latest version of PHP and MySQL/MariaDB
* Composer installed
* Have a database created, a password protect user, and grants for that user to that database

## Installation

```
git clone https://github.com/lleblanc42/url-shortener.git
```

```
composer install
```

```
cp .env.example .env
```

Edit .env file with proper DB credentials and app URL

```
php artisan key:generate
```

```
php artisan migrate
```

Ensure the webroot is set to the public folder within the old webroot

## How To Use

### Create Shortened URL

```
curl -X POST -d "url=https://google.com" http://localhost/api/shorten
```

### Show Top 100 Visited URLs

```
curl http://localhost/api/top
```

### Show Redirect URL From Shortened URL

```
curl http://localhost/{hash}
```

## Challanges

Overall, I did not have any major challenges except for time. If I had a bit more time to work, I would have also completed the second part of the challenge. Other than time, my only other challange was not having docker already setup on my machine, thus moving forward with the use of vagrant/homestead, as I already had that environment prepared.

## Design

I chose to use Laravel as I have experience making API's with it already and know how effective the framework is for such tasks. I also chose to use the composer package Hashids to create my hashes for the shortened urls. It seemed like more of a waste of time to have developed my own methods for giving me the hash. It's usually best to use packages over custom code, as it brings down the amount of development time and amount of code required to maintain. My DB schema is rather simple, containing the columns id, source_url, shortened_url, visited, created_at, and updated_at. Simple is usually better, with room for expansion if needed for additional features. As common for most API's, I chose to use the path api/ for all of the calls to ensure a clean and clear path to those controllers.

## Future Improvements

* Complete second part of challange
* Include token authentication when making API calls
* Properly setting up API middleware
* Better error handling with proper messages and structure
* Add in NSFW flag
* Create a structure for sending payloads
    * Include total counts with api/top method
    * Include status message on all methods
    * Include status code on all methods