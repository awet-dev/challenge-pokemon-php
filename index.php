<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$myMoves = array();

if (isset ($_GET['subject'])) {
    $name_Or_Id = $_GET['subject'];
    $content = file_get_contents("https://pokeapi.co/api/v2/pokemon/$name_Or_Id", true);
    $data = json_decode($content, true); // make the data readable
    $pokSrc =  $data['sprites']['front_shiny'];
    $pokName = $data['name'];
    $pokId =  $data['id'];

     foreach ($data['moves'] as $move) {
        array_push($myMoves, $move['move']['name']);
    }
    echo var_dump($myMoves);

} else {
    $pokId = 'write a name or id';
    $pokSrc = '';
    $pokName = '';
    $pokMove = '';
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
        <input type="text" name="subject" id="subject">
        <input type="submit" value="submit">
    </form>

    <div class="result">
        <img src="<?php echo $pokSrc ?>">
        <p><?php echo $pokId ?></p>
        <p><?php echo $pokName ?></p>
        <!--<ul>
            <li><?php echo $pokMove ?></li>
            <li><?php echo $pokMove ?></li>
            <li><?php echo $pokMove ?></li>
            <li><?php echo $pokMove ?></li>
        </ul>-->
    </div>
</body>
</html>

