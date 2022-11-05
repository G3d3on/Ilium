<?php

    require ("db-functions.php");
    session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Courses</title>
</head>
<body>
    <div id="riding-container">
        <h2>Résultat de la course: <?php echo strtoupper($_SESSION['riding']['0']['name']); ?></h2>
        <table id="table-riding">
            <thead>
                <tr>
                    <th>Nom de la course</th>
                    <th>Nom du cheval</th>
                    <th>Position du cheval</th>
                    <th>Temps du cheval</th>
                </tr>
            </thead>
            <?php
            $riding = $_SESSION['riding'];
                $result = "<tbody>";
                foreach ($riding as $rid) {
                    $result .= "<tr>";
                    $result .= "<td>".$rid['name']."</td>";
                    $result .= "<td>".$rid['horse']."</td>";
                    $result .= "<td>".$rid['position']."</td>";
                    $result .= "<td>".$rid['timer']."</td>";
                    $result .= "</tr>";
                }
                echo $result .= "</tbody>";
            ?>
        </table>
    </div>
</body>
</html>