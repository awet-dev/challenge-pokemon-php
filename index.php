<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


$content = file_get_contents("https://pokeapi.co/api/v2/pokemon/ditto");
$data = var_dump ( json_decode($content, true)); // make the data readable
echo $data;


?>;
