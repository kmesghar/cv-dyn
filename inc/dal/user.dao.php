<?php
    class UserDAO {
        // Cette classe regroupe l'ensemble des requêtes SQL liées à la table 'utilisateurs'

        public static function login($email, $password): User {
            include_once __DIR__ . "/database.php";

            $sql = "SELECT * FROM users WHERE email=:email;";

            try {
                $connexionString = "mysql: host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8";
                $database = new PDO($connexionString, Database::DBUSER, Database::DBPASS);
                $database-> setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $query = $database-> prepare($sql);
                $query-> bindParam(':email', $email, PDO::PARAM_STR);
                $query-> execute();

                $results = $query-> fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "User");
                //$results = $query-> fetchAll(PDO::FETCH_OBJ);

                if ($query-> rowCount()) {
                    if (password_verify($password, $results[0]-> getHash())) {
                        return $results[0];
                    } else return new User();
                } else {
                    return new User();
                }
            } catch (Exception $exc) {
                //var_dump($exc);
                return new User();
            }
        }

        public static function save(User $user): bool {
            include_once __DIR__ . "/database.php";

            $sql = "";
            if ($competence-> id > 0) {
                $sql = "UPDATE users SET nom=:nom, prenom=:prenom WHERE id=:id;";
            } else {
                $sql = "INSERT INTO users (nom, prenom) VALUES (:nom, :prenom);";
            }
        }

        public static function get(int $id): User {
            include_once __DIR__ . "/database.php";

            $sql = "SELECT * FROM users WHERE id = :id;";

            try {
                $connexionString = "mysql: host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8";
                $database = new PDO($connexionString, Database::DBUSER, Database::DBPASS);
                $database-> setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $query = $database-> prepare($sql);
                $query-> bindParam(':id', $id, PDO::PARAM_INT);
                $query-> execute();

                $results = $query-> fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "User");
                //$results = $query-> fetchAll(PDO::FETCH_OBJ);

                if ($query-> rowCount()) {
                    return $results[0];
                } else {
                    return new User();
                }
            } catch (Exception $exc) {
                //var_dump($exc);
                return new User();
            }
        }

        public static function delete(int $id): bool {
            include_once __DIR__ . "/database.php";
            
            $sql = "DELETE FROM users WHERE id = :id;";
        }
    }