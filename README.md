#URL Shortener

##Prerequisites

* Basic LAMP stack environment with latest version of PHP and MySQL/MariaDB
* Composer installed
* Have a database created, a password protect user, and grants for that user to that database

##Installation

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

##Challanges

##Design

##Future Improvements