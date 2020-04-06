<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Bully Card Game</title>
        <link rel="stylesheet" href="assets/css/base.css">
    </head>
    <body>
        <h1>Bully Card Game</h1>
        <?php
            require __DIR__ . '/../autoload.php';

            $game = new Game\Game(true);
            $game->deal(['Bonham', 'Jones', 'Page', 'Plant']);
            $game->play();
        ?>
    </body>
</html>

