<?php

require ("db-functions.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Hippique</title>
</head>
<body>
    <div id="container">
        <div id="sub1">
            <h1>Les courses</h1>
            <form id ="form" action="traitement.php" method="post">
                <label for="name">Choisisser la course</label>
                <select name="name">
                    <?php
                    $allRiding = findRiding();
                    if ($allRiding != true) {
                        $max = 19;
                        for ($i=0; $i <= $max; $i++) { 
                            $jsondata = file_get_contents('riding/riding_'.$i.'.json');
                            $data = json_decode($jsondata, true);
                            foreach ($data['riding'] as $row) {
                                $ridingName = $row['name'];
                                foreach ($row['result'] as $row2) {
                                    $horseName = $row2['horse'];
                                    $horseNameUcf = ucfirst($horseName);
                                    $pos = $row2['position'];
                                    $timer = $row2['temps'];
                                    insertRiding($ridingName, $horseNameUcf, $pos, $timer);
                                }
                            }
                        }
                    }
                    foreach ($allRiding as $allR) {
                        echo $result ="<option>".$allR['name']."</option>";
                        }
                    ?>
                </select>
                <button type="submit" name="submit">Envoyer</button>
            </form>
        </div>
        <div id="sub2">
            <div class="sub2-div">
                <?php
                $horses = findHorse();
                if ($horses == true) {
                    echo "<h2>Résultat des 5 dernières courses</h2>";
                    $tHead = "<table class='table'>
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th id='second-th' colspan='5'>Positions des 5 dérnières courses</th>
                                        </tr>
                                        <tr>
                                            <th></th>";
                    foreach ($horses as $horse) {
                        $horseLast5Position = findHorseLast5Position($horse['horse']);
                        foreach ($horseLast5Position as $last5) {
                            $tHead .= "<th>".strtoupper($last5['name'])."</th>";
                        }
                        break;
                    }
                    echo $tHead .="</tr></thead>";
                    $result = "<tbody>";
                    foreach ($horses as $horse) {
                        $result .= "<tr><td class='horses'>".$horse['horse']."</td>";
                        $horseLast5Position = findHorseLast5Position($horse['horse']);
                        foreach ($horseLast5Position as $last5) {
                            $result .= "<td>".$last5['position']."</td>";
                            
                        }
                    }
                    echo $result .= "</tr></tbody></table>";
                }
                ?>
            </div>
            <div class="sub2-div">
                <?php
                $horses1st = findFirstLast5Riding();
                if ($horses1st == true) {
                    echo "<h2>Pronostic vainqueur</h2>";
                    echo "<h2>Les 1ers sur les 5 dernières courses</h2>";
                    $result1st = "<table class='table'>
                                    <tbody>";
                    foreach ($horses1st as $horse1st) {
                        $result1st .= "<tr><td class='ridings'>".$horse1st['name']."</td>";
                        $result1st .= "<td class='horses'>".$horse1st['horse']."</td>";
                        $result1st .= "<td>".$horse1st['position']."</td>";
                    }
                    echo $result1st .= "</tr></tbody></table>";
                    echo "<p>Mon pronostic pour le prochain est vainqueur est : Flicka";
                }
                ?>
            </div>
            <div class="sub2-div">
                <?php
                $horsesFirstThree = findFirstThreeHorsesLast5Riding();
                if ($horsesFirstThree == true) {
                    echo "<h2>Pronostic tiercé</h2>";
                    echo "<h2>Les 3 premiers sur les 5 dernières courses</h2>";
                    $result1st = "<table class='table'>
                                    <tbody>";
                    foreach ($horsesFirstThree as $horseFirstThree) {
                        $result1st .= "<tr><td class='ridings'>".$horseFirstThree['name']."</td>";
                        $result1st .= "<td class='horses'>".$horseFirstThree['horse']."</td>";
                        $result1st .= "<td>".$horseFirstThree['position']."</td>";
                    }
                    echo $result1st .= "</tr></tbody></table>";
                    echo "<p>Mon pronostic pour le prochain tiercé est : Flicka, Seabiscuit et Prince Noir";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>