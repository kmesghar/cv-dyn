<?php
    class CompetenceDAO {
        // Cette classe regroupe l'ensemble des requêtes SQL liées à la table 'competences'

        public static function loadAll(): array {
            include_once __DIR__ . "/database.php";

            $sql = "SELECT * FROM competences;";

            try {
                $connexionString = "mysql: host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8";
                $database = new PDO($connexionString, Database::DBNAME, Database::DBPASS);
                $database-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $query = $database-> prepare($sql);
                $query-> execute();

                // Cette ligne ne 'retourne' pas des objets Competence mais STDClass
                //$results = $query-> fetchAll(PDO::FETCH_OBJ);
                // Problème résolu avec cette écriture qui précise la classe attendue
                $results = $query-> fetchAll(PDO::FETCH_CLASS, "Competence");

                return results;
            } catch (Exception $exc) {
                return array();
            }
        }

        public static function save(Competence $competence): bool {
            include_once __DIR__ . "/database.php";

            $sql = "";
            if ($competence-> id > 0) {
                $sql = "UPDATE competences SET libelle=:libelle, description=:description WHERE id=:id;";
            } else {
                $sql = "INSERT INTO competences (libelle, description) VALUES (:libelle, :description);";
            }
        }

        public static function get(int $id): Competence {
            include_once __DIR__ . "/database.php";

            $sql = "SELECT * FROM competences WHERE id = :id;";
        }

        public static function delete(int $id): bool {
            include_once __DIR__ . "/database.php";
            
            $sql = "DELETE FROM competences WHERE id = :id;";
        }
    }