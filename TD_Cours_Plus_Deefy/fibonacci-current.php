<?php

require_once __DIR__ . '/vendor/autoload.php';

use IUT\Spotify\Fibonacci;

$fibonacci = new Fibonacci();
$fibonacci->calculateNextValue();
$fibonacci->displayCurrentValue();