<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

 // put the selected moves here
$myText = array();
if (isset($_GET['name'])){
    $pokemon = $_GET['name'];
} else {
    $pokemon = 1;
}

function getData($http) {
    $get = file_get_contents($http, true);
    return json_decode($get, true);
}

function changArray($data) {
    $array = array();
    foreach ($data['moves'] as $move) {
        array_push($array, $move['move']['name']);
        if (count($array) === 4) {
            break;
        }
    }
    return implode(" ", $array); // change array to string and separate them with space
}

$url = "https://pokeapi.co/api/v2/pokemon/$pokemon";
$data = getData($url);
$output = changArray($data);

$evolution = getData($data['species']['url']);
/*
$evolutionChain = getData($evolution['evolution_chain']['url']);
while ($evolutionChain['chain']['evolves_to']) {
    $link = $evolutionChain['chain']['evolves_to'][0]['species']['name'];
    $name = $link;
    $link += ['evolves_to'][0]['species']['name'];
    var_dump($evolutionChain);
}
 */
$color = $evolution['color']['name'];
$flavor_text = $evolution['flavor_text_entries'][0]['flavor_text'];
if ($evolution['evolves_from_species'] !== NULL) {
    $evolves_from = getData('https://pokeapi.co/api/v2/pokemon/'.$evolution['evolves_from_species']['name']);
} else {
    $evolves_from['name'] = 'No previous evolution';
    $evolves_from['sprites']['front_shiny'] = '';
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
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div id="pokedex">
    <div id="left">
        <div id="logo"></div>
        <div id="bg_curve1_left"></div>
        <div id="bg_curve2_left"></div>
        <div id="curve1_left">
            <div id="buttonGlass">
                <div id="reflect"></div>
            </div>
            <div id="miniButtonGlass1"></div>
            <div id="miniButtonGlass2"></div>
            <div id="miniButtonGlass3"></div>
        </div>
        <div id="curve2_left">
            <div id="junction">
                <div id="junction1"></div>
                <div id="junction2"></div>
            </div>
        </div>
        <div id="screen">
            <div id="topPicture">
                <div id="buttontopPicture1"></div>
                <div id="buttontopPicture2"></div>
            </div>
            <div id="picture">
                <img src="<?php echo $data['sprites']['front_shiny'] ?> "height="170"/>
            </div>
            <div id="buttonbottomPicture"></div>
            <div id="speakers">
                <div class="sp"></div>
                <div class="sp"></div>
                <div class="sp"></div>
                <div class="sp"></div>
            </div>
        </div>
        <div id="bigbluebutton"></div>
        <div id="barbutton1"></div>
        <div id="barbutton2"></div>
        <div id="cross">
            <div id="leftcross">
                <div id="leftT"></div>
            </div>
            <div id="topcross">
                <div id="upT"></div>
            </div>
            <div id="rightcross">
                <div id="rightT"></div>
            </div>
            <div id="midcross">
                <div id="midCircle"></div>
            </div>
            <div id="botcross">
                <div id="downT"></div>
            </div>
        </div>
    </div>
    <div id="right">
        <div id="stats" style="background-color: <?php echo $color?>">
            <strong>Name:</strong> <?php echo $data['name']; ?><br>
            <strong>Id:</strong> #<?php echo $data['id']; ?><br>
            <strong>moves:</strong> <?php echo $output; ?><br>
            <strong id="center">flavor:</strong> <?php echo $flavor_text; ?><br>
            <strong>Name:</strong> <?php echo $evolves_from['name']; ?><br>
            <img src="<?php echo $evolves_from['sprites']['front_shiny'] ?>" />
        </div>
        <div id="blueButtons2">
            <form method="get" id="input-form">
                <input class="input" type="text" name="name" placeholder="Enter Name Or Id">
                <input class="input" type="submit" value="Search">
            </form>
        </div>
        <div id="bg_curve1_right"></div>
        <div id="bg_curve2_right"></div>
        <div id="curve1_right"></div>
        <div id="curve2_right"></div>
    </div>
</div>
</body>
</html>
