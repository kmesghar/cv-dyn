<?php
    class Message {
        public const LOAD_ALL = 0;
        public const LOAD_ONLY_NOT_READ = 1;
        public const LOAD_ONLY_READ = 2;
        public const LOAD_ONLY_TRASH = 3;

        private int $id;
        private string $email;
        private ?string $name;
        private ?string $phone;
        private string $subject;
        private string $message;
        private DateTime $_date;
        private bool $_read;
        private bool $_trash;

        public function __construct() {
            $this-> id = 0;
            $this-> email = "";
            $this-> name = "";
            $this-> phone = "";
            $this-> subject = "";
            $this-> message = "";
            $this-> _date = new DateTime();
            $this-> _read = false;
            $this-> _trash = false;
        }

        private function clone(Message $message): void {
            $this-> id = $message-> getId();
            $this-> email = $message-> getFrom();
            $this-> name = $message-> getName();
            $this-> phone = $message-> getPhone();
            $this-> subject = $message-> getSubject();
            $this-> message = $message-> getMessage();
            $this-> _date = $message-> getDate();
            $this-> _read = $message-> getRead();
            $this-> _trash = $message-> getTrash();
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
            return $this-> _date;
        }

        public function getRead(): bool {
            return $this-> _read;
        }

        public function getDeleted(): bool {
            return $this-> _trash;
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
            $this-> _date = $date;
        }

        public function setRead(bool $read): void {
            $this-> _read = $read;
        }

        public function setDeleted(bool $deleted): void {
            $this-> _trash = $deleted;
        }
    }