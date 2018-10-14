XParody
============
Website: COMING SOON <br>
XParody helps create song parodies.

Requirements
--------
+ PHP  7.1.3
+ MariaDB  10.1.36
+ Laravel  5.7.*

Install and Run
--------

1. Install PHP, MariaDB and Laravel.

1. Create one database.

1. Create `.env` file in the laravel root directory.
    1. Copy `.env.example` and rename it to `.env`.
    1. Set `DB_DATABASE`, `DB_USERNAME` and `DB_PASSWORD` according to database you created.
    1. Set `APP_NAME` as you like (eg. 'XParody').

1. Run the migrations to create database tables.

        php artisan migrate

1. Run server.

Usage
--------
TODO

Dependency
--------
+ tablesorter
  - Copyright (c) 2014 Christian Bach
  - Released under the MIT license
  - https://github.com/christianbach/tablesorter/blob/master/LICENSE
+ Autosize
  - Copyright (c) 2015 Jack Moore
  - Released under the MIT license
  - https://github.com/jackmoore/autosize/blob/master/LICENSE.md
+ clipboard.js
  - Copyright (c) 2018 Zeno Rocha
  - Released under the MIT license
  - https://zenorocha.mit-license.org/
