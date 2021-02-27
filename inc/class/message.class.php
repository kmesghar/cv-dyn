<?php
    /**
     *  Les demandes de contact des visiteurs (Message)
     */
    class Message {
        public const LOAD_ALL = 0;
        public const LOAD_ONLY_NOT_READ = 1;
        public const LOAD_ONLY_READ = 2;
        public const LOAD_ONLY_ARCHIVED = 3;
        public const LOAD_ONLY_TRASHED = 4;

        private int $id;
        private string $email;
        private ?string $name;
        private ?string $phone;
        private string $subject;
        private string $message;
        private DateTime $date;
        private bool $read;
        private bool $archive;
        private bool $trash;

        public function __construct($message="", $date="", $id=0, $email="", $name="", $phone="", $subject="", $read=false, $archive=false, $trash=false) {
            $this-> id = $id;
            $this-> email = $email;
            $this-> name = $name;
            $this-> phone = $phone;
            $this-> subject = $subject;
            $this-> message = $message;
            $this-> date = new DateTime($date);
            $this-> read = $read;
            $this-> archive = $archive;
            $this-> trash = $trash;
        }

        private function clone(Message $message): void {
            $this-> id = $message-> getId();
            $this-> email = $message-> getFrom();
            $this-> name = $message-> getName();
            $this-> phone = $message-> getPhone();
            $this-> subject = $message-> getSubject();
            $this-> message = $message-> getMessage();
            $this-> date = $message-> getDate();
            $this-> read = $message-> getRead();
            $this-> archive = $archive-> getArchived();
            $this-> trash = $message-> getTrash();
        }

        public static function getNotReadCount(): int {
            include_once __DIR__ . "/../dal/message.dao.php";

            return MessageDAO::getNotReadCount();
        }

        public static function loadAll(int $filterMode): array {
            include_once __DIR__ . "/../dal/message.dao.php";

            return MessageDAO::loadAll($filterMode);
        }

        public function get(int $id): bool {
            include_once __DIR__ . "/../dal/message.dao.php";

            clone(MessageDAO::get($id));

            if ($this-> id > 0)
                return true;
            else
                return false;
        }

        public function save(): bool {
            include_once __DIR__ . "/../dal/message.dao.php";

            if ((MessageDAO::save($this))-> getId() > 0) {
                return true;
            } else return false;
        }


        public function delete(): bool {
            // Mettre dans la corbeille (flag corbeille en base de données)

        }

        public function drop(): bool {
            // Supprimer définitivement
        }

        /**
         *  Un setter 'auto' magic pour PDO
         */
        public function __set($property, $value) {
            if ($property == "_date") {
                $this-> date = new DateTime($value);
            } else if ($property == "_read") {
                $this-> read = $value;
            } else if ($property == "_archive") {
                $this-> archive = $value;
            } else if ($property == "_trash") {
                $this-> trash = $value;
            } else {
                $this->$property = $value;
            }
        }

        /* LES HABITUELS GETTERS */
        public function getId(): int {
            return $this-> id;
        }

        public function getFrom(): string {
            return $this-> email;
        }
        public function getName(): string {
            return $this-> name;
        }

        public function getPhone(): string {
            return $this-> phone;
        }

        public function getSubject(): string {
            return $this-> subject;
        }

        public function getMessage(): string {
            return $this-> message;
        }

        public function getDate(): DateTime {
            return $this-> date;
        }

        public function getRead(): bool {
            return $this-> read;
        }

        public function getArchived(): bool {
            return $this-> archive;
        }

        public function getDeleted(): bool {
            return $this-> trash;
        }

        /* ET LES TOUT AUSSI HABITUELS SETTERS */
        public function setId(int $id): void {
            $this-> id = $id;
        }

        public function setFrom(string $from): void {
            $this-> email = $from;
        }

        public function setName(string $name): void {
            $this-> name = $name;
        }

        public function setPhone(string $phone): void {
            $this-> phone = $phone;
        }

        public function setSubject(string $subject): void {
            $this-> subject = $subject;
        }

        public function setMessage(string $message): void {
            $this-> message = $message;
        }

        public function setDate(DateTime $date): void {
            $this-> date = $date;
        }

        public function setRead(bool $read): void {
            $this-> read = $read;
        }

        public function setArchived(bool $read): void {
            $this-> archive = $archive;
        }

        public function setDeleted(bool $deleted): void {
            $this-> trash = $deleted;
        }
    }