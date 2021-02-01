<?php
    class Article {
        // Les articles sont mis en une dans la page d'accueil, et accessibles indiviuellement dans une page dédiée (article.php)
        private int $id;
        private int $layoutorder;   // Ordre d'affichage
        private string  $title;     // Titre (obligatoire)
        private ?string $abstract;  // Résumé, si absent, affichage des x premiers caractères du contenu
        private ?string $header;    // En-tête si présent
        private string  $content;   // Contenu (obligatoire)
        private ?string $footer;    // Pied de page si présent
        private ?string $image;     // Image si présente
        private ?array $keywordsArray;   // Tableau de mot-clés (strings)

        // setter magic
        public function __set($name, $value) {
            if ($name == "keywords") {
                $this-> keywordsArray = explode("|", $value);
            } else {
                $this-> $name = $value;
            }
        }

        // setter magic
        public function __get($name) {
            if ($name == "keywords") {
                return $this-> keywordsArray;
            } else {
                return $this-> $name;
            }
        }

        // public function __construct() {
        //     $this-> id  = 0;
        //     $this-> layout = 0;
        //     $this-> title = "";
        //     $this-> abstract = "";
        //     $this-> header = "";
        //     $this-> content = "";
        //     $this-> footer = "";
        //     $this-> image = "";
        //     $this-> keywords = array ();
        // }

        public function __construct($id = 0, $layout = 0, $title = "", $abstract = "", $header = "", $content = "", $footer = "", $image = "", $keywords = "") {
            $this-> id = $id;
            $this-> layout = $layout;
            $this-> title = $title;
            $this-> abstract = $abstract;
            $this-> header = $header;
            $this-> content = $content;
            $this-> footer = $footer;
            $this-> image = $image;
            $this-> keywordsArray = explode("|", $keywords);
        }

        public function __toString(): void {
            $out = "<div class='row'>";
            $out = "    <div class='col-4'>";
            if ($this-> image != "")
                $out .= "       <img src='" . $this-> image . "' alt='" . $this-> title . "' class='img-thumbnail rounded'>";

            $out .= "   </div>";
            $out = "    <div class='col-8'>";
            if ($this-> header != "")
                $out .= "       <h4>" . $this-> title . "</h4>";

            if ($this-> header != "") {
                $out .= "       <p>" . $this-> header . "</p>";
                $out .= "       <hr>";
            }

            if ($this-> content != "") {
                $out .= "       <p>" . $this-> content . "</p>";
            }

            if ($this-> footer != "") {
                $out .= "       <hr>";
                $out .= "       <p>" . $this-> footer . "</p>";
            }
            
            $out .= "   </div>";
            $out .= "</div>";
        }

        /* SETTERS */
        public function setId(int $id): void {
            $this-> id = $id;
        }

        public function setLayout(int $order): void {
            $this-> layout = $order;
        }

        public function setTitle(string $title): void {
            $this-> title = $title;
        }

        public function setAbstract(string $abstract): void {
            $this-> abstract = $abstract;
        }

        public function setHeader(string $header): void {
            $this-> header = $header;
        }

        public function setContent(string $content): void {
            $this-> content = $content;
        }

        public function setFooter(string $footer): void {
            $this-> footer = $footer;
        }

        public function setImage(string $image): void {
            $this-> image = $image;
        }

        public function setKeywords(string $keywords): void {
            $this-> keywordsArray = explode("|", $keywords);
        }

        public function setKeywordsArray(array $keywords): void {
            $this-> keywordsArray = $keywords;
        }
        /* FIN SETTERS */
        
        /* GETTERS */
        public function getId(): int {
            return $this-> id;
        }

        public function getLayout(): int {
            return $this-> layout;
        }

        public function getTitle(): string {
            return $this-> title;
        }

        public function getAbstract(): string {
            return $this-> abstract;
        }

        public function getHeader(): string {
            return $this-> header;
        }

        public function getContent(): string {
            return $this-> content;
        }

        public function getFooter(): string {
            return $this-> footer;
        }

        public function getImage(): string {
            return $this-> image;
        }

        public function getKeywords(): array {
            return $this-> keywordsArray;
        }

        public function getKeywordsString(): string {
            $out = "";
            foreach ($this-> keywords as $keyword) {
                $out .= "$keyword|";
            }

            substr_replace($out ,"",-1);

            return $out;
        }
        /* FIN GETTERS */

        public function preview(): void {
            $out = "<div class='row'>";
            $out = "    <div class='col-4'>";
            if ($this-> image != "")
                $out .= "       <img src='" . $this-> image . "' alt='" . $this-> title . "' class='img-thumbnail rounded'>";

            $out .= "   </div>";
            $out = "    <div class='col-8'>";
            if ($this-> header != "")
                $out .= "       <h5>" . $this-> title . "</h5>";

            if ($this-> header != "") {
                $out .= "       <p>" . $this-> abstract . "</p>";
            }
            
            $out .= "   </div>";
            $out .= "</div>";
        }

        public static function loadAll(): array {
            include_once __DIR__ . "/../dal/article.dao.php";

            return ArticleDAO::loadAll();
        }

        public static function findByKeywords(array $keywords): array {
            include_once __DIR__ . "/../dal/article.dao.php";

            return ArticleDAO::findByKeywords($keywords);
        }

        public static function get(int $id): Article {
            include_once __DIR__ . "/../dal/article.dao.php";

            return ArticleDAO::get($id);
        }

        public function save(): bool {
            include_once __DIR__ . "/../dal/article.dao.php";

            if (ArticleDAO::save($this)-> getId() > 0) {
                return true;
            } else return false;
        }

        public function delete(): bool {
            include_once __DIR__ . "/../dal/article.dao.php";

            return ArticleDAO::delete($this-> id);
        }

        public function up(): bool {
            return false;
        }

        public function down(): bool {
            return false;
        }
    }