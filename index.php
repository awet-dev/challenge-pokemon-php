<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

function getData($api, $id = null) {
    $data = file_get_contents($api.$id, true);
    return json_decode($data, true);
}

function getSpecies($url, $array = []) {
    $evolutionChain = getData($url);
    $evolutionUrl = $evolutionChain['evolution_chain']['url'];
    $evolution = getData($evolutionUrl);
    $evolvesTo = $evolution['chain'];
    // push it to array
    while ($evolvesTo['evolves_to']) {
        array_push($array, $evolvesTo['species']['name']);
        $evolvesTo = $evolvesTo['evolves_to'][0];
    }
    array_push($array, $evolvesTo['species']['name']);
    return $array;
}

function getFourMoves($moves, $array = []) {
    foreach ($moves as $move) {
        array_push($array, $move['move']['name']);
        if (count($array) > 5) {
            break;
        }
    }
    return implode("", $array);
}

$pokemonApi = "https://pokeapi.co/api/v2/pokemon/";
$pokemonImg = [];
$pokemonMoves = "";
if (!empty($_POST['id'])) {
    $pokemonData = getData($pokemonApi, $_POST['id']);
    $speciesName = getSpecies($pokemonData['species']['url']);
    foreach ($speciesName as $item) {
        $speciesData = getData($pokemonApi, $item);
        array_push($pokemonImg, $speciesData['sprites']['front_shiny']);
    }
    $pokemonMoves = getFourMoves($pokemonData['moves']);
} else {
    $pokemonData = getData($pokemonApi, 1);
    $speciesName = getSpecies($pokemonData['species']['url']);
    foreach ($speciesName as $item) {
        $speciesData = getData($pokemonApi, $item);
        array_push($pokemonImg, $speciesData['sprites']['front_shiny']);
    }
    $pokemonMoves = getFourMoves($pokemonData['moves']);
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Document</title>
</head>
<body class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Pokemon Api</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li>
            </ul>
            <form action="" method="post" class="form-inline my-2 my-lg-0">
                <input name="id" class="form-control mr-sm-2" type="text" placeholder="Pokemon" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div class="pokemon">
                    <img class="card-img-top" src="<?php echo $pokemonData['sprites']['front_shiny']?>" alt="Card image cap" style="width: 200px">
                    <h4 class="card-title">
                        <strong>Name: </strong> <?php echo ucfirst($pokemonData['name'])?>
                    </h4>
                    <p class="card-text"><strong>Moves: </strong><?php echo $pokemonMoves?></p>
                    <p class="card-text">
                        <strong>Pokemon Id: </strong><?php echo $pokemonData['id']?>
                    </p>
                </div>
                <div class="d-flex">
                    <?php foreach ($pokemonImg as $img) :?>
                        <img class="card-img-top" src="<?php echo $img?>" alt="Card image cap" style="width: 100px">
                    <?php endforeach;?>
                </div>
            </div>
            <div class="d-flex">
                <form action="" method="post" class="form-inline my-2 my-lg-0 mr-2">
                    <input name="id" type="hidden" value="<?php echo $pokemonData['id'] > 1? $pokemonData['id']-1: 1?>">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Previous One</button>
                </form>
                <form action="" method="post" class="form-inline my-2 my-lg-0">
                    <input name="id" type="hidden" value="<?php echo $pokemonData['id']+1?>">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Next One</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>