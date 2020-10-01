<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$myMoves = array(); // put the selected moves here

if (isset($_GET['name'])) {
    $name_Or_Id = $_GET['name'];
    if ($pokData = file_get_contents("https://pokeapi.co/api/v2/pokemon/$name_Or_Id", true)) {
        $pokData = file_get_contents("https://pokeapi.co/api/v2/pokemon/$name_Or_Id", true);
        $pokData = json_decode($pokData, true); // make the data readable
        // retrieve the data
        $pokSrc = $pokData['sprites']['front_shiny'];
        $pokName = $pokData['name'];
        $pokId = $pokData['id'];
        foreach ($pokData['moves'] as $move) {
            array_push($myMoves, $move['move']['name']);
            if (count($myMoves) === 4) {
                break;
            }
        }
        $output = implode(" ", $myMoves); // change array to string and separate them with space

        $evolution = file_get_contents("https://pokeapi.co/api/v2/pokemon-species/$name_Or_Id", true);
        $evoData = json_decode($evolution, true);
        if ($evoData['evolves_from_species'] !== NULL) {
            $preEvoName = $evoData['evolves_from_species']['name'];
            $preEvoData = file_get_contents("https://pokeapi.co/api/v2/pokemon/$preEvoName", true);
            $preEvoData = json_decode($preEvoData, true);
            $evoPokSrc = $preEvoData['sprites']['front_shiny'];
        } else {
            $preEvoName = 'No Pre-Evolution';
            $evoPokSrc = '';
        }
    } else {
        die("Error: The file does not exist.");
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
    <title>Pokédex</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form id="input-form" name="form" action="" method="get">
        <input type="text" name='name' id="name" class="input">
        <input type="submit" value="Search Pokeman" class="input">
    </form>
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
                    <img src="<?php echo $pokSrc ?>" height="170" />
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
            <div id="stats">
                <strong>Id:</strong> <?php echo $pokId ?><br/>
                <strong>Name:</strong> <?php echo $pokName ?><br/>
                <strong>Moves:</strong> <?php echo $output ?><br/>
                <strong>Per-evolution:</strong> <?php echo $preEvoName ?> <br/>
                <img src="<?php echo $evoPokSrc ?>"/>
            </div>
            <div id="blueButtons1">
                <div class="blueButton"></div>
                <div class="blueButton"></div>
                <div class="blueButton"></div>
                <div class="blueButton"></div>
                <div class="blueButton"></div>
            </div>
            <div id="blueButtons2">
                <div class="blueButton"></div>
                <div class="blueButton"></div>
                <div class="blueButton"></div>
                <div class="blueButton"></div>
                <div class="blueButton"></div>
            </div>
            <div id="miniButtonGlass4"></div>
            <div id="miniButtonGlass5"></div>
            <div id="barbutton3"></div>
            <div id="barbutton4"></div>
            <div id="yellowBox1"></div>
            <div id="yellowBox2"></div>
            <div id="bg_curve1_right"></div>
            <div id="bg_curve2_right"></div>
            <div id="curve1_right"></div>
            <div id="curve2_right"></div>
        </div>
    </div>
</body>
</html>

