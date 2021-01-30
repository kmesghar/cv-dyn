<?php
    class Article {
        // Les articles sont mis en une dans la page d'accueil, et accessibles indiviuellement dans une page dédiée (article.php)
        private int $id;
        private int $order;         // Ordre d'affichage
        private ?string $abstract;  // Résumé, si absent, affichage des x premiers caractères du contenu
        private ?string $header;    // En-tête si présent
        private string  $title;     // Titre (obligatoire)
        private string  $content;   // Contenu (obligatoire)
        private ?string $footer;    // Pied de page si présent
        private ?string $image;     // Image si présente
        private ?array $keywords;  // Tableau de mot-clés (strings)

        public function __construct() {
            $id = 0;
            $order = 0;
            $abstract = "";
            $header = "";
            $title = "";
            $content = "";
            $footer = "";
            $image = "";
            $keywords = array ();
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
            return false;
        }

        public function delete(): bool {
            return true;
        }

        public function up(): bool {
            return false;
        }

        public function down(): bool {
            return false;
        }
    }