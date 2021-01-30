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
                // $results = $query-> fetchAll(PDO::FETCH_OBJ);
                

                if ($query-> rowCount()) {
                    if (password_verify($password, $results[0]-> getHash())) {
                        return $results[0];
                    } else return new User();
                } else {
                    return new User();
                }
            } catch (Exception $exc) {
                // var_dump($exc);
                return new User();
            }
        }

        public static function save(User $user): User {
            include_once __DIR__ . "/database.php";

            $sql = "";
            if ($user-> id > 0) {
                $sql = "UPDATE users SET nom=:nom, prenom=:prenom, email=:email, telephone=:telephone, datenaissance=:datenaissance, afficherdatenaissance=:afficherdatenaissance, afficherage=:afficherage, hash=:hash, poste=:poste, adresse1=:adresse1, adresse2=:adresse2, codepostal=:codepostal, ville=:ville, photo=:photo WHERE id=:id;";
            } else {
                $sql = "INSERT INTO users (nom, prenom, email, telephone, datenaissance, afficherdatenaissance, afficherage, hash, poste, adresse1, adresse2, codepostal, ville, photo) VALUES (:nom, :prenom, :email, :telephone, :datenaissance, , :afficherdatenaissance, :afficherage, :hash, :poste, :adresse1, :adresse2, :codepostal, :ville, :photo);";
            }

            try {
                $connexionString = "mysql: host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8";
                $database = new PDO($connexionString, Database::DBUSER, Database::DBPASS);
                $database-> setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $query = $database-> prepare($sql);
                $data = [
                    'nom' => $user-> getNom(),
                    'prenom' => $user-> getPrenom(),
                    'email' => $user-> getEmail(),
                    'telephone' => $user-> getTelephone(),
                    'datenaissance' => $user-> getDateNaissance()-> format("Y-m-d"),
                    'afficherdatenaissance' => ( $user-> getAfficherDateNaissance() ? '1' : '0' ),
                    'afficherage' => ( $user-> getAfficherAge() ? '1' : '0' ),
                    'hash' => $user-> getHash(),
                    'poste' => $user-> posteRecherche(),
                    'adresse1' => $user-> getAdresse1(),
                    'adresse2' => $user-> getAdresse2(),
                    'codepostal' => $user-> getCodePostal(),
                    'ville' => $user-> getVille(),
                    'photo' => $user-> getPhoto(),
                    'id' => $user-> getId()
                ];

                $query-> execute($data);

                return $user;
            } catch (Exception $exc) {
                var_dump($exc);
                return new User();
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
                // $results = $query-> fetchAll(PDO::FETCH_OBJ);

                if ($query-> rowCount()) {
                    return $results[0];
                } else {
                    return new User();
                }
            } catch (Exception $exc) {
                // var_dump($exc);
                return new User();
            }
        }

        public static function delete(int $id): bool {
            include_once __DIR__ . "/database.php";
            
            $sql = "DELETE FROM users WHERE id = :id;";
        }
    }