<?php  
    class Competence {
        // Les attributs de la classe
        // repris à partir du MCD pour construire le Diagramme de Classe
        private int $id;
        private ?string $icone;
        private int $niveau;
        private string $libelle;
        private ?string $description;

        public const STAR_FULL = "<i class='fas fa-star'></i>";
        public const STAR_HALF = "<i class='fas fa-star-half-alt'></i>";
        public const STAR_EMPTY = "<i class='far fa-star'></i>";

        // Le constructeur qui permet d'initialiser les attributs à des valeurs non nulles
        public function __construct() {
            $this-> id = 0;
            $this-> icone = "";
            $this-> niveau = 1;
            $this-> libelle = "";
            $this-> description = "";
        }

        // Les accesseurs des attributs
        // Les "getters" permettent de "lire" les attributs privés
        // Les "setters" permettent "d'écrire" dans les attributs privés
        public function getId() {
            return $this-> id;
        }

        public function setId($id) {
            $this-> id = $id;
        }

        public function getIcone() {
            return $this-> icone;
        }

        public function setIcone($icone) {
            $this-> icone = $icone;
        }

        public function getNiveau() {
            return $this-> niveau;
        }

        public function setNiveau($niveau) {
            $this-> niveau = $niveau;
        }

        public function getLibelle() {
            return $this-> libelle;
        }

        public function setLibelle($libelle) {
            $this-> libelle = $libelle;
        }

        public function getDescription() {
            return $this-> description;
        }

        public function setDescription($description) {
            $this-> description = $description;
        }

        // Les méthodes plus spécifiques ou les redéfinition des méthodes magiques
        public function isset() {
            if ($this-> id > 0)
                return true;
            else return false;
        }

        public function __toString() {
            $out = "<h6>" . $this-> icone . " " . $this-> libelle . "</h6>\n";
            $out .= "<p>" .$this-> description . "</p>\n";

            $stars = 0;
            for ($i=0; $i < ($this-> niveau / 2); $i++) {
                $out .= self::STAR_FULL . "\n";
                $stars++;
            }

            if ($this-> niveau % 2 == 1) {
                $out = substr_replace($out, self::STAR_HALF, -28, -1);
            }
            
            for ($i= ($this-> niveau - 2); $i < 5; $i++) {
                $out .= self::STAR_EMPTY . "\n";
                $stars++;
            }

            if ($stars == 4) {
                $out .= self::STAR_EMPTY . "\n";
            }

            return $out;
        }

        // Les méthodes identifiées dans le diagramme de classe pour abstraction de la couche d'accès aux données
        // Ces méthodes seront reprises dans la couche DAO
        private function clone(Competence $competence): void {
            $this-> id = $competence-> id;
            $this-> libelle = $competence-> libelle;
            $this-> description = $competence-> description;
        }

        public static function loadAll(): array {
            include_once __DIR__ . "/../dal/competence.dao.php";

            return  CompetenceDAO::loadAll();
        }

        public function save(): bool {
            // save() permet non simplement de créer une nouvelle compétence que de mettre à jour une compétence existante
            include_once __DIR__ . "/../dal/competence.dao.php";

            $this-> clone(CompetenceDAO::save($this));

            if ($this-> id > 0)
                return true;
            else return false;
        }

        public function get(): bool {
            include_once __DIR__ . "/../dal/competence.dao.php";

            $this-> clone(CompetenceDAO::get($this-> id));

            if ($this-> id > 0)
                return true;
            else return false;
        }

        public function delete(): Competence {
            include_once __DIR__ . "/../dal/competence.dao.php";

            return CompetenceDAO::delete($this-> id);
        }
    }