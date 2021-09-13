#!/usr/bin/env php
<?php
require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use App\Application;


$container = new ContainerBuilder();
$container->setParameter('app_dir', __DIR__);

$loader = new YamlFileLoader($container, new FileLocator());
$loader->load(__DIR__.'/config/services.yml');

$container->compile();


// Start the console application.
exit($container->get(Application::class)->run());
