## About ToGo List

The repo represents simple CRUD application of places for visiting. It involves google maps and search bar for finding and adding a new place on the map and in the list. It is possible to edit name of the place, mark as visited and delete it.

The tech-stack used in this app is as follows: PHP with Laravel framework, Vue.js and SQLite as main storage of data.
The database is selected SQLite for making setup of the development environment easily. It can be expanded to for example MySQL if the app grows.
The coordinates of the place is just a string but it should be a geo-spatial field in the DB. It can be changed in future
The app uses simple session base authentication but the repo has a branch where the authentication is planed to be a JSON WEB Token.
Future work includes filtering, sorting, searching and pagination of the table of places.

## Setup

For setup you must have 
- PHP version 7 and above
- node.js and npm
- composer
- git version control

To start setup

- clone the repo by running  `git clone https://github.com/narek-king/ToGo-list.git`
- then `cd ToGo-list`
- install all php vendor packages by running including Laravel `composer install`

Then you need to setup database and environment

- SQLite should be installed on your PC — follow this [Tutorialpoint](https://www.tutorialspoint.com/sqlite/sqlite_installation.htm)
- create sqlite file `touch ./database/database.sqlite`
- copy `.env.example` file with renaming it to `.env`
- run   `php artisan key:generate`
- Change the lines in the `.env` file as followes
    
    - `DB_CONNECTION=sqlite`
    - `DB_DATABASE=[absolut path to]ToGo-list/database/database.sqlite`
      
- now create the tables in the db by running `php artisan migrate`
- finally run `php artisan serve` and go to the localhost:8000 url in your browser


## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
