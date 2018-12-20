#!/usr/bin/env php
<?php
require_once __DIR__ . '/vendor/autoload.php';
use Console\ValidatorCommand;
use Symfony\Component\Console\Application;

$app = new Application('Phone numbers validator', 'v1.0.0');
$app-> add(new ValidatorCommand());
$app -> run();