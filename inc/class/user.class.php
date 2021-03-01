<?php
    class User {
        private int $id;
        private ?string $nom;
        private ?string $prenom;
        private ?string $email;
        private ?string $telephone;
        private ?string $hash;
        private ?string $poste;
        private ?string $adresse1;
        private ?string $adresse2;
        private ?string $codepostal;
        private ?string $ville;
        private ?string $photo;

        // Attention à cette propriété, comme la date de naissance n'est pas un string,
        // et que l'on fetch des objets depuis la base de données, il faut tricher, PDO retourne les propriétés
        // comme des string et non des instances du type déclaré, il faut donc veiller à ce que la propriété
        // est, exceptionnellement, un nom différent à celui du champ correspondant dans la base, pour forcer
        // PDO à taper dans le setter (le magic) et donc intercepter le string et créer une instance de la bonne
        // classe, ici DateTime, la seule autre alternative est d'utiliser des tableaux associatifs (FETCH_ASSOC)
        // et un "hydratateur"...
        private ?DateTime $dateNaissance;
        private ?bool $afficherdatenaissance;
        private ?bool $afficherage;

        public function __construct($id = 0, $nom = "", $prenom = "", $email = "", $telephone = "", $datenaissance = "", $afficherdatenaissance = false, $afficherage = false, $hash = "", $poste = "", $adresse1 = "", $adresse2 = "", $codepostal = "", $ville = "", $photo = "") {
            $this-> id = $id;
            $this-> nom = $nom;
            $this-> prenom = $prenom;
            $this-> email = $email;
            $this-> telephone = $telephone;
            $this-> dateNaissance = new DateTime($datenaissance);
            $this-> afficherdatenaissance = $afficherdatenaissance;
            $this-> afficherage = $afficherage;
            $this-> hash = $hash;
            $this-> poste = $poste;
            $this-> adresse1 = $adresse1;
            $this-> adresse2 = $adresse2;
            $this-> codepostal = $codepostal;
            $this-> ville = $ville;
            $this-> photo = $photo;
        }

        public function __toString() {
            return ucfirst($this-> prenom) . " " . strtoupper($this-> nom);
        }

        private function clone(User $user): void {
            $this-> id = $user-> getId();
            $this-> nom = $user-> getNom();
            $this-> prenom = $user-> getPrenom();
            $this-> email = $user-> getEmail();
            $this-> telephone = $user-> getTelephone();
            $this-> dateNaissance = $user-> getDateNaissance();
            $this-> afficherdatenaissance = $user-> getAfficherDateNaissance();
            $this-> afficherage = $user-> getAfficherAge();
            $this-> hash = $user-> getHash();
            $this-> poste = $user-> posteRecherche();
            $this-> adresse1 = $user-> getAdresse1();
            $this-> adresse2 = $user-> getAdresse2();
            $this-> codepostal = $user-> getCodepostal();
            $this-> ville = $user-> getVille();
            $this-> photo = $user-> getPhoto();
        }

        public function login($email, $password): bool {
            include_once __DIR__ . "/../dal/user.dao.php";
            //$this-> clone(UserDAO::login($email, $password));
            $this-> email = $email;
            $this-> hash = $password;
            UserDAO::login($this);

            if ($this-> id > 0)
                return true;
            else
                return false;
        }

        public function save(): bool {
            // save() permet sauvegarder un nouvel utilisateur ou de mettre à jour l'utilisateur courant
            include_once __DIR__ . "/../dal/user.dao.php";

            $this-> clone(UserDAO::save($this));

            if ($this-> id > 0)
                return true;
            else
                return false;
        }

        public function get($id): bool {
            // get($id) permet d'extraire de la base de données l'utilisateur dont l'id est spécifié en argument
            include_once __DIR__ . "/../dal/user.dao.php";

            $this-> clone(UserDAO::get($id));

            if ($this-> id > 0)
                return true;
            else
                return false;
        }

        public function delete(): Competence {
            include_once __DIR__ . "/../dal/user.dao.php";

            return UserDAO::delete($this-> id);
        }

        // Les getters et setters "magic"
        public function __get($name) {
            if ($name == "datenaissance") {
                return $this-> dateNaissance;
            } else {
                return $this->$name;
            }
        }
    
        public function __set($name, $value) {
            if ($name == "datenaissance") {
                $this-> dateNaissance = new DateTime($value);
            } else {
                $this->$name = $value;
            }
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

        public function setDateNaissance(string $dateNaissance): void {
            $this-> dateNaissance = new DateTime($dateNaissance);
        }

        public function setAfficherDateNaissance(bool $afficherDateNaissance): void {
            $this-> afficherdatenaissance = $afficherDateNaissance;
        }

        public function setAfficherAge(bool $afficherAge): void {
            $this-> afficherage = $afficherAge;
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
        
        public function getDateNaissance(): DateTime {
            return $this-> datenaissance;
        }

        public function getAfficherDateNaissance(): bool {
            return $this-> afficherdatenaissance;
        }

        public function getAfficherAge(): bool {
            return $this-> afficherage;
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
                $adress .= "<br>" . $this-> adresse2;

            return $adress;
        }
        
        public function getAdresse1(): string {
            return $this-> adresse1;
        }
        
        public function getAdresse2(): string {
            if ($this-> adresse2)
                return $this-> adresse2;
            else
                return "";
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
            else
                return "";
        }
    }