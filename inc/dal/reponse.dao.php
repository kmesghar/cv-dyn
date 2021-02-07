<?php
    class ReponseDAO {
        // Cette classe regroupe l'ensemble des requêtes SQL liées à la table 'competences'

        public static function loadAll(int $filterMode): array {
            include_once __DIR__ . "/database.php";

            $sql = "SELECT * FROM reponses;";

            try {
                $connexionString = "mysql: host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8";
                $database = new PDO($connexionString, Database::DBUSER, Database::DBPASS);
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
        public static function loadByContact(int $contact, int $filterMode): array {
            include_once __DIR__ . "/database.php";

            $sql = "SELECT * FROM reponses WHERE contact = :contact;";

            try {
                $connexionString = "mysql: host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8";
                $database = new PDO($connexionString, Database::DBUSER, Database::DBPASS);
                $database-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $query = $database-> prepare($sql);
                $query->bindParam(':contact', $contact, PDO::PARAM_INT);

                //$query-> execute(["contact" => $contact]);
                $query-> execute(["contact" => $contact]);

                // Cette ligne ne 'retourne' pas des objets Competence mais STDClass
                //$results = $query-> fetchAll(PDO::FETCH_OBJ);
                // Problème résolu avec cette écriture qui précise la classe attendue
                $results = $query-> fetchAll(PDO::FETCH_CLASS, "Reponse");

                return results;
            } catch (Exception $exc) {
                return array();
            }
        }

        public static function save(Reponse $reponse): bool {
            include_once __DIR__ . "/database.php";

            $sql = "";
            if ($reponse-> id > 0) {
                $sql = "UPDATE reponses SET contact=:contact, subject=:subject, message=:message WHERE id=:id;";
            } else {
                $sql = "INSERT INTO reponses (contact, subject, message) VALUES (:contact, :subject, :message);";
            }
        }

        public static function get(int $id): Reponse {
            include_once __DIR__ . "/database.php";

            $sql = "SELECT * FROM reponses WHERE id = :id;";
        }

        public static function delete(int $id): bool {
            include_once __DIR__ . "/database.php";
            
            $sql = "UPDATE reponses SET trash = 1 WHERE id = :id;";
        }

        public static function drop(int $id): bool {
            include_once __DIR__ . "/database.php";
            
            $sql = "DELETE FROM reponses WHERE id = :id;";
        }
    }