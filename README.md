# Bully card game

Lets virtual players play against each other in a simplified version of the bully card game.

## Run game

The game is automatically played and is not interactive.


### Setup

To set up the game execute the following line in your terminal from the project's directory.

```
composer install
```

### CLI

You can run the game by executing the following line in your terminal from the project's directory.

```
php bin/run.php
```

### Web

Alternatively you can run the game by using PHP's built-in server. Execute  the following line in your terminal from the project's directory.

```
php -S localhost:8000 -t web
```

Then navigate to *http://localhost:8000/* in your browser.

## Run tests

Execute the following line in your terminal from the project's directory.

```
./vendor/bin/phpunit tests
```