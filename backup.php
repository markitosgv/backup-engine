<?php

require_once(__DIR__.'/vendor/autoload.php');

if ( ! isset($config))
{
    $config = include(__DIR__.'/config/config.php');
}

$app = new Dimsav\Backup\Application($config);

if ($app->hasErrors())
{
    throw new \Dimsav\Exception\RuntimeException($app->getErrors());
}
else
{
    $app->backup();
}