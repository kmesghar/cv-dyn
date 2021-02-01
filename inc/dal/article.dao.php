<?php
    class ArticleDAO {
        
        public static function loadAll(): array {
            include_once __DIR__ . "/database.php";

            $sql = "SELECT * FROM articles ORDER BY layout ASC;";

            try {
                $connexionString = "mysql: host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8";
                $database = new PDO($connexionString, Database::DBUSER, Database::DBPASS);
                $database-> setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $query = $database-> prepare($sql);

                $query-> execute();
                $results = $query-> fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Article");

                return $results;
            } catch (Exception $exc) {
                var_dump($exc);
                return new User();
            }
        }

        public static function findByKeywords(array $keywords): array {
            return array();
        }

        public static function get(int $id): Article {
            return new Article();
        }

        public static function save(Article $article): Article {
            include_once __DIR__ . "/database.php";

            $sql = "";
            if ($article-> getId() > 0) {
                $sql = "UPDATE articles SET layout=:layout, title=:title, abstract=:abstract, header=:header, content=:content, footer=:footer, image=:image, keywords=:keywords WHERE id=:id;";
            } else {
                $sql = "INSERT INTO articles (layout, title, abstract, header, content, footer, image, keywords) VALUES (:layout, :title, :abstract, :header, :content, :footer, :image, :keywords);";
            }

            try {
                $connexionString = "mysql: host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8";
                $database = new PDO($connexionString, Database::DBUSER, Database::DBPASS);
                $database-> setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $order = null;
                if ($article-> getId() == 0) {
                    $query = $database-> prepare("SELECT MAX(layout) as layout FROM articles;");
                    $query-> execute();
                    $order = $query-> fetchAll()[0]["layout"];
                }

                $query = $database-> prepare($sql);
                $data = [
                    'layout' => $article-> getlayout(),
                    'title' => $article-> getTitle(),
                    'abstract' => $article-> getAbstract(),
                    'header' => $article-> getHeader(),
                    'content' => $article-> getContent(),
                    'footer' => $article-> getFooter(),
                    'image' => $article-> getImage(),
                    'keywords' => $article-> getKeywordsString()
                ];

                // Si on est en présence d'un update...
                if ($article-> getId() > 0) {
                    $data["id"] = $article-> getId();
                } else {
                    if ($order) {
                        $data["layout"] = $order + 1;
                    } else {
                        $data["layout"] = 1;
                    }
                }

                if ($query-> execute($data)) {
                    if ($article-> getId() == 0) {
                        $article-> setId($database-> lastInsertId());
                    }
                } else {
                    return new Article();
                }

                return $article;
            } catch (Exception $exc) {
                var_dump($exc);
                return new Article();
            }
        }

        public static function delete(int $id): bool {
            return true;
        }

        public static function up(Article $article): bool {
            return false;
        }

        public function down(Article $article): bool {
            return false;
        }
    }