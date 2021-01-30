<?php
    class LoisirDAO {
        // Cette classe regroupe l'ensemble des requêtes SQL liées à la table 'loisirs'

        public static function loadAll(): array {
            include_once __DIR__ . "/database.php";

            $sql = "SELECT * FROM loisirs;";

            try {
                $connexionString = "mysql: host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8";
                $database = new PDO($connexionString, Database::DBNAME, Database::DBPASS);
               $database-> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

                $query = $database-> prepare($sql);
                $query-> execute();

                // Cette ligne ne 'retourne' pas des objets Competence mais STDClass
                // $results = $query-> fetchAll(PDO::FETCH_OBJ);
                // Problème résolu avec cette écriture qui précise la classe attendue
                $results = $query-> fetchAll(PDO::FETCH_CLASS, "Loisir");

                return results;
            } catch (Exception $exc) {
                return array();
            }
        }

        public static function save(Loisir $loisir): bool {
            include_once __DIR__ . "/database.php";

            $sql = "";
            if ($competence-> id > 0) {
                $sql = "UPDATE loisirs SET libelle=:libelle, description=:description WHERE id=:id;";
            } else {
                $sql = "INSERT INTO loisirs (libelle, description) VALUES (:libelle, :description);";
            }
        }

        public static function get(int $id): Loisir {
            include_once __DIR__ . "/database.php";

            $sql = "SELECT * FROM loisirs WHERE id = :id;";
        }

        public static function delete(int $id): bool {
            include_once __DIR__ . "/database.php";
            
            $sql = "DELETE FROM loisirs WHERE id = :id;";
        }
    }