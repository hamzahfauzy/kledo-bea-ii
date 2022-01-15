# Kledo Backend Assessment II

## Installation

```sh
git clone https://github.com/hamzahfauzy/kledo-bea-ii
cd kledo-bea-ii
composer install
cp .env.example .env
php artisan key:generate
```

Config database such as database name, database username, and database password in .env file

## Then Run

```sh
php artisan migrate
php artisan db:seed
```

## Run Test
```sh
php artisan test
```