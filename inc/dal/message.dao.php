<?php
    class MessageDAO {
        // Cette classe regroupe l'ensemble des requêtes SQL liées à la table 'competences'

        public static function getNotReadCount(): int {
            include_once __DIR__ . "/database.php";
            
            $sql = "SELECT COUNT(id) as count FROM messages WHERE _read = 0";

            try {
                $connexionString = "mysql: host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8";
                $database = new PDO($connexionString, Database::DBUSER, Database::DBPASS);
                $database-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $query = $database-> prepare($sql);
                $query-> execute();

                $results = $query-> fetchAll(PDO::FETCH_OBJ);

                return $results[0]-> count;
            } catch (Exception $exc) {
                var_dump($exc);
                return 0;
            }
        }

        public static function loadAll(int $filterMode): array {
            include_once __DIR__ . "/database.php";

            $sql = "SELECT * FROM messages;";

            try {
                $connexionString = "mysql: host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8";
                $database = new PDO($connexionString, Database::DBUSER, Database::DBPASS);
                $database-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $query = $database-> prepare($sql);
                $query-> execute();

                // Cette ligne ne 'retourne' pas des objets Competence mais STDClass
                //$results = $query-> fetchAll(PDO::FETCH_OBJ);
                // Problème résolu avec cette écriture qui précise la classe attendue
                $results = $query-> fetchAll(PDO::FETCH_CLASS, "Message");

                return results;
            } catch (Exception $exc) {
                return array();
            }
        }

        public static function save(Message $message): Message {
            include_once __DIR__ . "/database.php";

            $sql = "";
            if ($message-> getId() > 0) {
                $sql = "UPDATE messages SET email=:email, name=:name, phone=:phone, subject=:subject, message=:message WHERE id=:id;";
            } else {
                $sql = "INSERT INTO messages (email, name, phone, subject, message) VALUES (:email, :name, :phone, :subject, :message);";
            }

            $datas = [
                "email" => $message-> getFrom(),
                "name" => $message-> getName(),
                "phone" => $message-> getPhone(),
                "subject" => $message-> getSubject(),
                "message" => $message-> getMessage()
            ];

            try {
                $connexionString = "mysql: host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8";
                $database = new PDO($connexionString, Database::DBUSER, Database::DBPASS);
                $database-> setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $query = $database-> prepare($sql);

                $query->bindParam(':email', $datas["email"], PDO::PARAM_STR);
                $query->bindParam(':name', $datas["name"], PDO::PARAM_STR);
                $query->bindParam(':phone', $datas["phone"], PDO::PARAM_STR);
                $query->bindParam(':subject', $datas["subject"], PDO::PARAM_STR);
                $query->bindParam(':message', $datas["message"], PDO::PARAM_STR);

                // Si on est en présence d'un update...
                if ($message-> getId() > 0) {
                    $query->bindParam(':id', $message-> getId(), PDO::PARAM_INT);
                }

                if ($query-> execute()) {
                    if ($message-> getId() == 0) {
                        $message-> setId($database-> lastInsertId());
                    }

                    return $message;
                } else {
                    return new Message();
                }
            } catch (Exception $exc) {
                var_dump($exc);
                return new Message();
            }
        }

        public static function get(int $id): Message {
            include_once __DIR__ . "/database.php";

            $sql = "SELECT * FROM messages WHERE id = :id;";
        }

        public static function delete(int $id): bool {
            include_once __DIR__ . "/database.php";
            
            $sql = "UPDATE messages SET trash = 1 WHERE id = :id;";
        }

        public static function drop(int $id): bool {
            include_once __DIR__ . "/database.php";
            
            $sql = "DELETE FROM messages WHERE id = :id;";
        }
    }