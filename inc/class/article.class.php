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

        public static function loadAll(): array {
            return array();
        }
    }