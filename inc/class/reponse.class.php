<?php
    /**
     *  Les réponses (Reponse) envoyées aux demande de contact (Message);
     */
    class Reponse {
        public const LOAD_ALL = 0;
        public const LOAD_ONLY_NOT_READ = 1;
        public const LOAD_ONLY_READ = 2;
        public const LOAD_ONLY_TRASH = 3;

        private int $id;
        private int $contact;   // Message auquel est destiné la réponse (clé étrangère)
        private string $subject;
        private string $message;
        private bool $read;
        private bool $trash;

        public function __construct() {
            $this-> id = 0;
            $this-> contact = 0;
            $this-> subject = "";
            $this-> message = "";
            $this-> read = false;
            $this-> trash = false;
        }

        public static function loadAll(int $filterMode): array {

        }

        public function get(int $id): bool {

        }

        public function save(): bool {

        }


        public function delete(): bool {
            // Mettre dans la corbeille (flag corbeille en base de données)

        }

        public function drop(): bool {
            // Supprimer définitivement
        }
    }