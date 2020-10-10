<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

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
if(isset($_GET['page'])) {
    $starter = $_GET['page'];
    $final = $starter+19;
} else {
    $starter = 1;
    $final = 20;
}
for ($i = $starter; $i <= $final; $i++) {
    $url = "https://pokeapi.co/api/v2/pokemon/$i";
    $data = getData($url);
    array_push($moves, changArray($data));
    array_push($pok_id, $data['id']);
    array_push($img_src, $data['sprites']['front_shiny']);
    array_push($pok_name, $data['name']);
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
        <?php $pagination = '<nav aria-label="Page navigation example" class="col-sm">
            <ul class="pagination">
                <a class="page-link" href="?page=1">2nd</a>
                <a class="page-link" href="?page=21">3rd</a>
                <a class="page-link" href="?page=31">4th</a>
                <a class="page-link" href="?page=41">5th</a>
            </ul>
        </nav>';
        echo $pagination;
        ?>

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
        <div class="row">
            <?php
            // if it is clicked display the detail of that pokemon

            if (isset($_GET['link'])) {
                $index = $_GET['link'];
                $parent_id = $pok_id[$index];
                $parent_name = $pok_name[$index];
                $parent_img_src = $img_src[$index];
                $move = $moves[$index];
                $evolve_from_species = get_evolution("https://pokeapi.co/api/v2/pokemon/$parent_id");
                $color = $evolve_from_species['color'];
                $evolve_img_src = "";
                $name_evolve_species = "";
                $evolve_id = "";
                $evolve_move = "";
                if($evolve_from_species['species'] !== NULL) {
                    $name_evolve_species = $evolve_from_species['species']['name'];
                    $evolve_data = getData("https://pokeapi.co/api/v2/pokemon/$name_evolve_species");
                    $evolve_img_src = $evolve_data['sprites']['front_shiny'];
                    $evolve_id = $evolve_data['id'];
                    $evolve_move = changArray($evolve_data);
                }

                echo "<div class='row'>
                          <div class='card col-sm' style='width: 18rem;'>
                            <img src='$parent_img_src' class='card-img-top' alt=''>
                            <div class='card-body'>
                                <h5 class='card-title'><strong>Name: </strong>$parent_name, <strong>Id: </strong>$parent_id</h5>
                                <p class='card-text'><strong>Moves: </strong>$move</p>
                            </div>
                          </div>
                          <div class='card col-sm' style='width: 18rem;'>
                            <img src='$evolve_img_src' class='card-img-top' alt=''>
                            <div class='card-body'>
                                <h5 class='card-title'><strong>Name: </strong>$name_evolve_species, <strong>Id: </strong>$evolve_id</h5>
                                <p class='card-text'><strong>Moves: </strong>$evolve_move</p>
                            </div>
                          </div>
                      </div>";

            } else {
                unset($id);
            }
    echo "<figure class='figure row row-cols-4'>";
            foreach ($img_src AS $g => $value) {
                echo "<div class='col'>
                            <a href='?link=$g'><img src='$value' class='figure-img img-fluid rounded' alt='Responsive image'/></a>
                            <figcaption class='figure-caption'>$pok_name[$g]</figcaption>
                      </div>";
            }?>
        </figure>
    </div>
    <!--here start the old code-->
<?php echo $pagination?>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>
