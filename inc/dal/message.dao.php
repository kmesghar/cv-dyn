<?php
    class MessageDAO {
        // Cette classe regroupe l'ensemble des requêtes SQL liées à la table 'messages'

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

        public static function count(int $filterMode): int {
            include_once __DIR__ . "/database.php";

            $sql = "";
            switch ($filterMode) {
                case Message::LOAD_ALL:
                    $sql = "SELECT COUNT(*) AS results FROM messages WHERE _archive=0 AND _trash=0;";
                    break;
                case Message::LOAD_ONLY_NOT_READ:
                    $sql = "SELECT COUNT(*) AS results FROM messages WHERE _read=0 AND _archive=0 AND _trash=0;";
                    break;
                case Message::LOAD_ONLY_READ:
                    $sql = "SELECT COUNT(*) AS results FROM messages WHERE _read=1  AND _archive=0 AND _trash=0;";
                    break;
                case Message::LOAD_ONLY_ARCHIVED:
                    $sql = "SELECT COUNT(*) AS results FROM messages WHERE _archive=1 AND _trash=0;";
                    break;
                case Message::LOAD_ONLY_TRASHED:
                    $sql = "SELECT COUNT(*) AS results FROM messages WHERE _trash=1;";
                    break;
                default:
                    break;
            }

            try {
                $connexionString = "mysql: host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8";
                $database = new PDO($connexionString, Database::DBUSER, Database::DBPASS);
                $database-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $query = $database-> prepare($sql);
                $results = $query->execute();
    
                if ($query->rowCount() > 0) {
                    $results = $query -> fetchall(PDO::FETCH_OBJ);
    
                    return $results[0]->results;
                } else {
                    return 0;
                }
            } catch (Exception $exc) {
                //var_dump($exc);
                return array();
            }
        }

        public static function loadAll(int $filterMode, int $first, int $perPage): array {
            include_once __DIR__ . "/database.php";

            $sql = "";
            switch ($filterMode) {
                case Message::LOAD_ALL:
                    $sql = "SELECT * FROM messages WHERE _archive=0 AND _trash=0 LIMIT $first, $perPage;";
                    break;
                case Message::LOAD_ONLY_NOT_READ:
                    $sql = "SELECT * FROM messages WHERE _read=0 AND _archive=0 AND _trash=0 LIMIT $first, $perPage;";
                    break;
                case Message::LOAD_ONLY_READ:
                    $sql = "SELECT * FROM messages WHERE _read=1  AND _archive=0 AND _trash=0 LIMIT $first, $perPage;";
                    break;
                case Message::LOAD_ONLY_ARCHIVED:
                    $sql = "SELECT * FROM messages WHERE _archive=1 AND _trash=0 LIMIT $first, $perPage;";
                    break;
                case Message::LOAD_ONLY_TRASHED:
                    $sql = "SELECT * FROM messages WHERE _trash=1 LIMIT $first, $perPage;";
                    break;
                default:
                    break;
            }

            try {
                $connexionString = "mysql: host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8";
                $database = new PDO($connexionString, Database::DBUSER, Database::DBPASS);
                $database-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $query = $database-> prepare($sql);
                $query-> execute();

                //$results = $query-> fetchAll(PDO::FETCH_CLASS, "Message");
                $results = $query-> fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Message");

                return $results;
            } catch (Exception $exc) {
                //var_dump($exc);
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

        public static function setFlagRead(int $id): bool {
            include_once __DIR__ . "/database.php";

            // Marquer comme lu (flag read en base de données)
            $sql = "UPDATE messages SET _read=1 WHERE id=:id";

            try {
                $connexionString = "mysql: host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8";
                $database = new PDO($connexionString, Database::DBUSER, Database::DBPASS);
                $database-> setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $query = $database-> prepare($sql);

                $query->bindParam(':id', $id, PDO::PARAM_INT);

                if ($query-> execute()) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $exc) {
                var_dump($exc);
                return false;
            }
        }

        public static function unsetFlagRead(int $id): bool {
            include_once __DIR__ . "/database.php";

            // Marquer comme non lu (flag read en base de données)
            $sql = "UPDATE messages SET _read=0 WHERE id=:id";

            try {
                $connexionString = "mysql: host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8";
                $database = new PDO($connexionString, Database::DBUSER, Database::DBPASS);
                $database-> setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $query = $database-> prepare($sql);

                $query->bindParam(':id', $id, PDO::PARAM_INT);

                if ($query-> execute()) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $exc) {
                var_dump($exc);
                return false;
            }
        }

        public static function setFlagArchive(int $id): bool {
            include_once __DIR__ . "/database.php";

            // Marquer comme archivé (flag archive en base de données)
            $sql = "UPDATE messages SET _archive=1 WHERE id=:id";

            try {
                $connexionString = "mysql: host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8";
                $database = new PDO($connexionString, Database::DBUSER, Database::DBPASS);
                $database-> setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $query = $database-> prepare($sql);

                $query->bindParam(':id', $id, PDO::PARAM_INT);

                if ($query-> execute()) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $exc) {
                var_dump($exc);
                return false;
            }
        }

        public static function unsetFlagArchive(int $id): bool {
            include_once __DIR__ . "/database.php";

            // Marquer comme non archivé (flag archive en base de données)
            $sql = "UPDATE messages SET _archive=0 WHERE id=:id";

            try {
                $connexionString = "mysql: host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8";
                $database = new PDO($connexionString, Database::DBUSER, Database::DBPASS);
                $database-> setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $query = $database-> prepare($sql);

                $query->bindParam(':id', $id, PDO::PARAM_INT);

                if ($query-> execute()) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $exc) {
                var_dump($exc);
                return false;
            }
        }

        public static function delete(int $id): bool {
            include_once __DIR__ . "/database.php";

            // Marquer supprimé (flag trash en base de données = corbeille)
            
            $sql = "UPDATE messages SET _trash = 1 WHERE id = :id;";

            try {
                $connexionString = "mysql: host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8";
                $database = new PDO($connexionString, Database::DBUSER, Database::DBPASS);
                $database-> setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $query = $database-> prepare($sql);

                $query->bindParam(':id', $id, PDO::PARAM_INT);

                if ($query-> execute()) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $exc) {
                var_dump($exc);
                return false;
            }
        }

        public static function restore(int $id): bool {
            include_once __DIR__ . "/database.php";

            // Restaurer depuis la corbeille (flag trash en base de données)
            
            $sql = "UPDATE messages SET _trash = 0 WHERE id = :id;";

            try {
                $connexionString = "mysql: host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8";
                $database = new PDO($connexionString, Database::DBUSER, Database::DBPASS);
                $database-> setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $query = $database-> prepare($sql);

                $query->bindParam(':id', $id, PDO::PARAM_INT);

                if ($query-> execute()) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $exc) {
                var_dump($exc);
                return false;
            }
        }

        public static function drop(int $id): bool {
            include_once __DIR__ . "/database.php";
            
            $sql = "DELETE FROM messages WHERE id = :id;";
        }
    }