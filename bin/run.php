<?php

require __DIR__ . '/../vendor/autoload.php';

$game = new Game\Game();
$game->deal(['Freek', 'Bas', 'Henk', 'Pieter']);
$game->play();
