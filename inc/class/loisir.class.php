<?php
    class Loisir {
        // Les attributs de la classe
        // repris à partir du MCD pour construire le Diagramme de Classe
        private int $id;
        private string $icone;
        private string $libelle;
        private string $description;

        // Le constructeur qui permet d'initialiser les attributs à des valeurs non nulles
        public function __construct() {
            $this-> id = 0;
            $this-> icone = "";
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
            $out = "<div class='row'>\n";
            $out .= "    <div class='col-1'>";
            $out .= $this-> icone;
            $out .= "   </div>\n";
            $out .= "    <div class='col-1'>\n";
            $out .= "       <h6>" . $this-> libelle . "</h6><p>" .$this-> description . "</p>\n";
            $out .= "   </div>\n";
            $out .= "</div>\n";
            return $out;
        }

        // Les méthodes identifiées dans le diagramme de classe pour abstraction de la couche d'accès aux données
        // Ces méthodes seront reprises dans la couche DAO
        private function clone(Loisir $loisir): void {
            $this-> id = $loisir-> id;
            $this-> icone = $loisir-> icone;
            $this-> libelle = $loisir-> libelle;
            $this-> description = $loisir-> description;
        }

        public static function loadAll(): array {
            include_once __DIR__ . "/../dal/loisir.dao.php";

            return  LoisirDAO::loadAll();
        }

        public function save(): bool {
            // save() permet non simplement de créer une nouvelle compétence que de mettre à jour une compétence existante
            include_once __DIR__ . "/../dal/loisir.dao.php";

            $this-> clone(LoisirDAO::save($this));

            if ($this-> id > 0)
                return true;
            else return false;
        }

        public function get(): bool {
            include_once __DIR__ . "/../dal/loisir.dao.php";

            $this-> clone(LoisirDAO::get($this-> id));

            if ($this-> id > 0)
                return true;
            else return false;
        }

        public function delete(): Loisir {
            include_once __DIR__ . "/../dal/loisir.dao.php";

            return LoisirDAO::delete($this-> id);
        }
    }