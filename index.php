<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$myMoves = array(); // put the selected moves here

if (isset ($_GET['name'])) {
    $name_Or_Id = $_GET['name'];
    $pokData = file_get_contents("https://pokeapi.co/api/v2/pokemon/$name_Or_Id", true);
    $pokData = json_decode($pokData, true); // make the data readable
    // echo var_dump($pokData);
    // retrieve the data
    $pokSrc =  $pokData['sprites']['front_shiny'];
    $pokName = $pokData['name'];
    $pokId =  $pokData['id'];
    foreach ($pokData['moves'] as $move) {
        array_push($myMoves, $move['move']['name']);
    }
    $output = array_slice($myMoves, 0, 4); // get only 4 elements from the array
    $output = implode(" ",$output); // change array to string and separate them with space

    $evolution = file_get_contents("https://pokeapi.co/api/v2/pokemon-species/$name_Or_Id", true);
    $evoData = json_decode($evolution, true);
    if ($evoData['evolves_from_species'] !== NULL) {
        $preEvoName = $evoData['evolves_from_species']['name'];
        $preEvoData = file_get_contents("https://pokeapi.co/api/v2/pokemon/$preEvoName", true);
        $preEvoData = json_decode($preEvoData, true);
        $evoPokSrc =  $preEvoData['sprites']['front_shiny'];
    } else {
        $preEvoName = '';
        $evoPokSrc = '';
    }
} else {
    echo '<h2>Write a name or id of a pokman</h2>';
    $pokId = '';
    $pokSrc = '';
    $pokName = '';
    $pokMove = '';
    $output = '';

    $preEvoName = '';
    $evoPokSrc = '';
}
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
    <form name="form" action="" method="get">
        <input type="text" name='name' id="name">
        <input type="submit" value="Search Pokeman">
    </form>

    <div class="result">
        <img src="<?php echo $pokSrc ?>">
        <p><?php echo $pokId ?></p>
        <p><?php echo $pokName ?></p>
        <p><?php echo $output ?></p>
    </div>
    <div class="result">
        <img src="<?php echo $evoPokSrc ?>">
        <p><?php echo $preEvoName ?></p>
    </div>

</body>
</html>

