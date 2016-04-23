<?php
require '../bootstrap.php';

use Gui\Application;
use Gui\Components\Button;

$application = new Application();

$application->on('start', function() use ($application) {
    $button = (new Button())
        ->setLeft(40)
        ->setTop(100)
        ->setWidth(200)
        ->setValue('Look, I\'m a button!');

    $button->on('click', function() use ($button) {
        $button->setValue('Look, I\'m a clicked button!');
    });
});

$application->run();