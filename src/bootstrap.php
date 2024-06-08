<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use Symfony\Component\Dotenv\Dotenv;
use METRIC\App\Config\AppConfig;

if (str_contains(gethostname(), 'P-146-ubuntu')) {
	$file_path = __DIR__ . '/../.env.local';
} else if (str_contains(gethostname(), 'P-138')) {
	$file_path = __DIR__ . '/../.env.local';
} else if (str_contains(gethostname(), 'demos.metricsalad.com')) {
	$file_path = __DIR__ . '/../.env';
}	else {
	$file_path = __DIR__ . '/../.env';
}

$dotenv = new Dotenv();
$dotenv->load($file_path);

// carga la variables del archivo de configuración en una clase para que sea accesible desde cualquier punto de la aplicación
foreach ($_ENV as $key => $value) {
	AppConfig::getInstance()->setValue($key, $value);
}
