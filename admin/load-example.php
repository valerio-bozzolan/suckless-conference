<?php
// this is just an example
$database = '';
$username = '';
$password = '';
$location = 'localhost';
$charset  = 'utf8mb4';
$prefix   = 'ldto_';

// de-comment to see more shitty stuff
// define( 'DEBUG', true );

// this directory
define( 'ABSPATH', __DIR__ );

// public pathname without trailing slash
define( 'ROOT', '' );

// load the suckless-php framework
require '/path/to/suckless-php/load.php';

// load conference stuff
require '/path/to/suckless-conference/load.php';
