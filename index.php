<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$myMoves = array(); // put the selected moves here

if (isset($_GET['name'])){
    $pokemon = $_GET['name'];
} else {
    $pokemon = 1;
}

function getData($http) {
    $get = file_get_contents($http, true);
    return json_decode($get, true);
}

$url = "https://pokeapi.co/api/v2/pokemon/$pokemon";
$data = getData($url);
foreach ($data['moves'] as $move) {
    array_push($myMoves, $move['move']['name']);
    if (count($myMoves) === 4) {
        break;
    }
}
$output = implode(" ", $myMoves); // change array to string and separate them with space

function getEvolution($data) {
    $evolution_Url = $data['species']['url'];
    $evolution = getdate($evolution_Url);
    echo var_dump($evolution);
}

getEvolution($data);



?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form method="get">
    <input type="text" name="name" placeholder="Enter Name Or Id">
    <input type="submit" value="Search">
</form>
<strong>Name:</strong> <?php echo $data['name']; ?><br>
<strong>Id:</strong> #<?php echo $data['id']; ?><br>
<strong>moves:</strong> <?php echo $output; ?><br>
<img src="<?php echo $data['sprites']['front_shiny'] ?>" alt="pokman image">
</body>
</html>
