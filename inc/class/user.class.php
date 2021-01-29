<?php
    class User {
        private int $id;
        private ?string $nom;
        private ?string $prenom;
        private ?string $email;
        private ?string $hash;
        private ?string $poste;
        private ?string $adresse1;
        private ?string $adresse2;
        private ?string $codepostal;
        private ?string $ville;
        private ?string $photo;

        public function __construct() {
            $this-> id = 0;
            $this-> nom = "";
            $this-> prenom = "";
            $this-> email = "";
            $this-> telephone = "";
            $this-> dateNaissance = "";
            $this-> hash = "";
            $this-> poste = "";
            $this-> adresse1 = "";
            $this-> adresse2 = "";
            $this-> codepostal = "";
            $this-> ville = "";
            $this-> photo = "";
        }

        public function __toString() {
            return strtoupper($this-> nom) . " " . ucfirst($this-> prenom);
        }

        private function clone(User $user): void {
            $this-> id = $user-> id;
            $this-> nom = $user-> nom;
            $this-> prenom = $user-> prenom;
            $this-> email = $user-> email;
            $this-> telephone = $user-> telephone;
            $this-> dateNaissance = $user-> dateNaissance;
            $this-> hash = $user-> hash;
            $this-> poste = $user-> poste;
            $this-> adresse1 = $user-> adresse1;
            $this-> adresse2 = $user-> adresse2;
            $this-> codepostal = $user-> codepostal;
            $this-> ville = $user-> ville;
            $this-> photo = $user-> photo;
        }

        public function login($email, $password): bool {
            include_once __DIR__ . "/../dal/user.dao.php";
            //$currentObject = &$this;
            //$currentObject = UserDAO::login($email, $password);
            $this-> clone(UserDAO::login($email, $password));

            if ($this-> id > 0)
                return true;
            else return false;
        }

        public function save(): bool {
            // save() permet sauvegarder un nouvel utilisateur ou de mettre à jour l'utilisateur courant
            include_once __DIR__ . "/../dal/user.dao.php";

            $this-> clone(UserDAO::save($this));

            if ($this-> id > 0)
                return true;
            else return false;
        }

        public function get($id): bool {
            // get($id) permet d'extraire de la base de données l'utilisateur dont l'id est spécifié en argument
            include_once __DIR__ . "/../dal/user.dao.php";

            $this-> clone(UserDAO::get($id));
            // $currentObject = &$this;
            // $currentObject = UserDAO::login($email, $password);

            if ($this-> id > 0)
                return true;
            else return false;
        }

        public function delete(): Competence {
            include_once __DIR__ . "/../dal/user.dao.php";

            return UserDAO::delete($this-> id);
        }

        // Les setters
        
        // public function setVal(?string $val) {
        //     $this->val = $val;
        // }

        public function setId(int $id): void {
            $this-> id = $id;
        }

        public function setNom(string $nom): void {
            $this-> nom = $nom;
        }

        public function setPrenom(string $prenom): void {
            $this-> prenom = $prenom;
        }

        public function setEmail(string $email): void {
            $this-> email = $email;
        }

        public function setTelephone(string $telephone): void {
            $this-> telephone = $telephone;
        }

        public function setDateNaissance(DateTime $dateNaissance): void {
            $this-> dateNaissance = $dateNaissance;
        }

        public function setHash(string $hash): void {
            $this-> hash = $hash;
        }

        public function setPosteRecherche(string $poste): void {
            $this-> poste = $poste;
        }

        public function setAdresse1(string $adresse): void {
            $this-> adresse1 = $adresse;
        }

        public function setAdresse2(string $adresse): void {
            $this-> adresse2 = $adresse;
        }

        public function setCodePostal(string $codePostal) {
            $this-> codepostal = $codePostal;
        }

        public function setVille(string $ville) {
            $this-> ville = $ville;
        }

        public function setPhoto(string $photo) {
            $this-> photo = $photo;
        }

        // Les getters
        public function getId(): int {
            return $this-> id;
        }
        
        public function getNom(): string {
            return $this-> nom;
        }

        public function getPrenom(): string {
            return $this-> prenom;
        }
        
        public function getEmail(): string {
            return $this-> email;
        }
        
        public function getTelephone(): string {
            return $this-> telephone;
        }

        public function getHash(): string {
            return $this-> hash;
        }

        public function posteRecherche(): string {
            return $this-> poste; 
        }
        
        public function getAdresse(): string {
            $adress = $this-> adresse1;

            if ($this-> adresse2 != "")
                $adress .= $this-> adresse2;

            return $adress;
        }
        
        public function getAdresse1(): string {
            return $this-> adresse1;
        }
        
        public function getAdresse2(): string {
            return $this-> adresse2;
        }

        public function getCodePostal(): string {
            return $this-> codepostal;
        }

        public function getVille(): string {
            return $this-> ville;
        }

        public function getPhoto(): string {
            if ($this-> photo)
                return $this-> photo;
            else return "";
        }
    }