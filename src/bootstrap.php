<?php

require __DIR__ . '/../vendor/autoload.php';

$settings = App\Settings::getSettings();
$configurator = new App\Configurator($settings);

$app = $configurator->configure();

return $app;
