# victory-road
A small app that displays Pokemon data and a "Who's that Pokemon?" quiz

## Installation

- clone the repo
- copy .env.example to .env and edit the database details
- run `composer install`
- run `npm install`
- run `npm run prod`
- run `php artisan migrate --seed`
- run `php artisan key:generate`
- run `php artisan serve`

Go to http://localhost:8000 and try it out. There are two pages - Quiz and Pokedex. The Quiz is a "Who's that Pokemon?" game where you must guess the Pokemon that is blacked out. Pokedex simply lists all the Pokemon and you can view some information about each one if you click on it.
