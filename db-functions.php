<?php

    function connexion(){
        try{
            return new PDO(
                "mysql:host=127.0.0.1:3306;dbname=hippique",
                "root",
                "",
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                    ]
                );
            }
            catch(PDOException $error) {
                echo "<mark>",$error,"</mark>";
            }
            return $dbh;
        }
        
        function insertRiding($ridingName, $horseName, $pos, $timer) {
            $dbh = connexion();
            $stmt = $dbh->prepare ("INSERT INTO riding (name, horse, position, timer)
                                        VALUES (:name, :horse, :pos, :timer)
                                ");
            $stmt->bindParam(":name", $ridingName, PDO::PARAM_STR);
            $stmt->bindParam(":horse", $horseName, PDO::PARAM_STR);
            $stmt->bindParam(":pos", $pos, PDO::PARAM_INT);
            $stmt->bindParam(":timer", $timer, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        function findAll() {
        $dbh = connexion();
        $stmt = $dbh->query ("SELECT *
                            FROM riding
                            ");  
        return $stmt->fetchAll();
    }
    
    function findRiding() {
        $dbh = connexion();
        $stmt = $dbh->query ("SELECT DISTINCT name
                            FROM riding 
                            ");  
        return $stmt->fetchAll();
    }


    function findRidingByName($ridingName) {
        $dbh = connexion();
        $stmt = $dbh->query ("SELECT name, horse, position, timer
                            FROM riding
                            WHERE riding.name = '".$ridingName."'
                            ");
        return $stmt->fetchAll();
    }

    
    function findHorse() {
        $dbh = connexion();
        $stmt = $dbh->query ("SELECT DISTINCT horse
                            FROM riding 
                            ");  
        return $stmt->fetchAll();
    }

    function findHorseLast5Position($horseName) {
        $dbh = connexion();
        $stmt = $dbh->query ("SELECT *
                            FROM (SELECT ri.id, ri.horse, ri.position, ri.name
                                    FROM riding ri
                                    WHERE ri.horse = '".$horseName."'
                                    LIMIT 231, 5
                                ) AS sub
                            ORDER BY sub.id DESC
                            ");  
        return $stmt->fetchAll();
    }

    function findFirstLast5Riding() {
        $dbh = connexion();
        $stmt = $dbh->query ("SELECT *
                                FROM (SELECT ri.id, ri.name, ri.horse, ri.position
                                        FROM riding ri
                                        WHERE ri.position = 1
                                        LIMIT 231, 5
                                ) AS sub
                                ORDER BY sub.id DESC 
                            ");  
        return $stmt->fetchAll();
    }

    function findFirstThreeHorsesLast5Riding() {
        $dbh = connexion();
        $stmt = $dbh->query ("SELECT *
                                FROM (SELECT ri.id, ri.name, ri.horse, ri.position
                                        FROM riding ri
                                        WHERE ri.position BETWEEN 1 AND 3
                                        LIMIT 693, 15 
                                ) AS sub
                                ORDER BY sub.id DESC
                            ");  
        return $stmt->fetchAll();
    }
    