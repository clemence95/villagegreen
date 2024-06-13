<?php

use Doctrine\ORM\Tools\Console\Command\ConvertMappingCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Application;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;

require 'vendor/autoload.php';

$kernel = new \App\Kernel('dev', true);
$kernel->boot();
$entityManager = $kernel->getContainer()->get(EntityManagerInterface::class);

$cli = new Application('Doctrine Command Line Interface');
$cli->setCatchExceptions(true);
$cli->setHelperSet(new \Symfony\Component\Console\Helper\HelperSet([
    'em' => new EntityManagerHelper($entityManager)
]));
$cli->add(new ConvertMappingCommand());

$output = new ConsoleOutput();
$input = new ArrayInput([
    'command' => 'orm:convert-mapping',
    '--namespace' => 'App\\Entity\\',
    '--force' => true,
    'to-type' => 'annotation',
    'dest-path' => 'src/Entity'
]);

$cli->run($input, $output);











