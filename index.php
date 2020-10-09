<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

//$myText = array();
//if (isset($_GET['name'])){
//    $pokemon = $_GET['name'];
//} else {
//    $pokemon = 1;
//}


//$output = changArray($data);


/*
$evolutionChain = getData($evolution['evolution_chain']['url']);
while ($evolutionChain['chain']['evolves_to']) {
    $link = $evolutionChain['chain']['evolves_to'][0]['species']['name'];
    $name = $link;
    $link += ['evolves_to'][0]['species']['name'];
    var_dump($evolutionChain);
}
 */
//$color = $evolution['color']['name'];
//$flavor_text = $evolution['flavor_text_entries'][0]['flavor_text'];
//if ($evolution['evolves_from_species'] !== NULL) {
//    $evolves_from = getData('https://pokeapi.co/api/v2/pokemon/'.$evolution['evolves_from_species']['name']);
//} else {
//    $evolves_from['name'] = 'No previous evolution';
//    $evolves_from['sprites']['front_shiny'] = '';
//}


// display 20 pokemon in grid in one page and so one === so generate grid for each pokemon
// if no input number loop over 20 and display the first 20 pokemon /=== use pagination
// but if listed amount of number loop over the listed iteration and display that many pokemon
//
// display 20 in one page by looping 20 times and generate the first 20 pokemon
// if the second button is clicked start form the last pokemon and loop 20 times and so on

//  ================================= start ======================================== //

// get data form the pokemon api
function getData($http) {
    $get = file_get_contents($http, true);
    return json_decode($get, true);
}

function get_evolution($http) {
    $get = file_get_contents($http, true);
    $data = json_decode($get, true);
    $evolution_url = $data['species']['url'];
    $get = file_get_contents($evolution_url, true);
    $data = json_decode($get, true);
    return array('color' => $data['color']['name'], 'species' => $data['evolves_from_species']);
}

function changArray($data) {
    $moves = array();
    foreach ($data['moves'] as $move) {
        array_push($moves, $move['move']['name']);
        if (count($moves) === 4) {
            break;
        }
    }
    return implode(" ", $moves); // change array to string and separate them with space
}

$img_src = [];
$pok_name = [];
$pok_id = [];
$moves = [];
for ($i = 1; $i <= 20; $i++) {
    $url = "https://pokeapi.co/api/v2/pokemon/$i";
    $data = getData($url);
    array_push($moves, changArray($data));
    array_push($pok_id, $data['id']);
    array_push($img_src, $data['sprites']['front_shiny']);
    array_push($pok_name, $data['name']);
}

// if it is clicked display the detail of that pokemon
if (isset($_GET['link'])) {
    $index = $_GET['link'];
    $id = $pok_id[$index];
    $move = $moves[$index];
    $evolve_from_species = get_evolution("https://pokeapi.co/api/v2/pokemon/$id");
    $color = $evolve_from_species['color'];
    if($evolve_from_species['species'] !== NULL) {
        $name_evolve_species = $evolve_from_species['species']['name'];
        $evolve_data = getData("https://pokeapi.co/api/v2/pokemon/$name_evolve_species");
        $evolve_img_src = $evolve_data['sprites']['front_shiny'];
    }
} else {
    unset($id);
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
<div class="container">

    <!--here start the new code-->

    <div class="row">
        <nav aria-label="Page navigation example" class="col-sm">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>

        <div class="dropdown col-sm">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Dropdown button
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
            </div>
        </div>

        <div class="dropdown col-sm">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Dropdown button
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
            </div>
        </div>
    </div>

    <div class="container text-center">
        <figure class="figure row row-cols-4">
            <?php foreach ($img_src AS $g => $value) {
                echo "<div class='col'>
                            <a href='?link=$g'><img src='$value' class='figure-img img-fluid rounded' alt='Responsive image'/></a>
                            <figcaption class='figure-caption'>$pok_name[$g]</figcaption>
                      </div>";}
            ?>
        </figure>
    </div>
    <!--here start the old code-->

</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>
