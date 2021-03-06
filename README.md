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

### API

#### Create Shortened URL

```
curl -X POST -d "url=https://google.com" http://localhost/api/shorten
```

You also have the option to include nsfw=1 in the payload to mark the url as not safe for work.


#### Show Top 100 Visited URLs

```
curl http://localhost/api/top
```

#### Show Redirect URL From Shortened URL

```
curl http://localhost/api/{hash}
```

### Web

Visit the base url for the website in your web browser. In my case, it was http://localhost:8000/. On the homepage, you can enter in urls to get shortened and there's a handy nav in the top to go between the top 100 and back to the homepage.

## Challanges

Overall, I did not have any major challenges except for time. My only real challange was not having docker already setup on my machine, thus moving forward with the use of vagrant/homestead, as I already had that environment prepared.

## Design

I chose to use Laravel as I have experience making API's with it already and know how effective the framework is for such tasks. I also chose to use the composer package Hashids to create my hashes for the shortened urls. The hashes it creates is in base62 and I use 6 characters for the unique hashes. This gives me 62 characters to work with that include numbers, upper and lower case numbers without special characters, making it ideal for the most amount of possible combinations while adhearing to basic URL strucutres. My DB schema is rather simple, containing the columns id, source_url, shortened_url, visited, nsfw, created_at, and updated_at. Simple is usually better, with room for expansion if needed for additional features. As common for most API's, I chose to use the path api/ for all of the calls to ensure a clean and clear path to those controllers.

## Future Improvements

* Include token authentication when making API calls
* Properly setting up API middleware
* Better error handling with proper messages and structure
* Create a structure for sending payloads
    * Include total counts with api/top method
    * Include status message on all methods
    * Include status code on all methods