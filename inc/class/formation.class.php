<?php
    class Formation {
        // Les attributs de la classe
        // repris à partir du MCD pour construire le Diagramme de Classe
        private int $id;
        private string $libelle;
        private string $description;
        private DateTime $date;

        // Le constructeur qui permet d'initialiser les attributs à des valeurs non nulles
        public function __construct() {
            $this-> id = 0;
            $this-> libelle = "";
            $this-> description = "";
            $this-> date = new DateTime();
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

        public function getDate() {
            return $this-> date;
        }

        public function setDate($date) {
            $this-> date = $date;
        }

        // Les méthodes plus spécifiques ou les redéfinition des méthodes magiques
        public function isset() {
            if ($this-> id >0)
                return true;
            else return false;
        }

        public function __toString() {
            return "<h6>" . $this-> libelle . "</h6><p>" .$this-> description . "</p>";
        }

        // Les méthodes identifiées dans le diagramme de classe pour abstraction de la couche d'accès aux données
        // Ces méthodes seront reprises dans la couche DAO
        private function clone(Formation $formation): void {
            $this-> id = $formation-> id;
            $this-> libelle = $formation-> libelle;
            $this-> description = $formation-> description;
            $this-> date = $formation-> date;
        }

        public static function getAll(): array {
            include_once __DIR__ . "/../dal/formation.dao.php";

            return  FormationDAO::getAll();
        }

        public function save(): bool {
            // save() permet non simplement de créer une nouvelle compétence que de mettre à jour une compétence existante
            include_once __DIR__ . "/../dal/formation.dao.php";

            $this-> clone(FormationDAO::save($this));

            if ($this-> id > 0)
                return true;
            else return false;
        }

        public function get(): bool {
            include_once __DIR__ . "/../dal/formation.dao.php";

            $this-> clone(FormationDAO::get($this-> id));

            if ($this-> id > 0)
                return true;
            else return false;
        }

        public function delete(): Competence {
            include_once __DIR__ . "/../dal/formation.dao.php";

            return FormationDAO::delete($this-> id);
        }
    }