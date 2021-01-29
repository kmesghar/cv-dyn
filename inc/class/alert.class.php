<?php
    class Alert {
        private bool $isset;

        // Le caractère ? permet de déclarer une propriété 'nullable' utile pour le destructeur custom ici
        private ?string $type;
        private ?string $title;
        private ?string $content;
        private ?string $footer;

        public function __construct() {
            $this-> isset = false;
            $this-> type = "";
            $this-> title = "";
            $this-> content = "";
            $this-> footer = "";
        }

        public function __destruct() {
            $this-> isset = false;
            $this-> type = null;
            $this-> title = null;
            $this-> content = null;
            $this-> footer = null;
        }

        public function __toString() {
            $out = "<div class='alert " . $this-> type . "' py-1>";
            
            if ($this-> title != "") {
                $out .= "   <h5 class='alert-heading'>" . $this-> title . "</h5>";
            }

            $out .= "   <p>" . $this-> content . "</p>";
 
            if ($this-> footer != "") {
                $out .= "   <hr>";
                $out .= "   <p class='mb-0'>" . $this-> footer . "</p>";
            }

            $out .= "</div>";

            return $out;
        }

        public function isset() {
            return $this->isset;
        }

        public function setType($type) {
            $this-> isset = true;
            $this-> type = $type;
        }

        public function setTitle($title) {
            $this-> isset = true;
            $this-> title = $title;
        }

        public function setContent($content) {
            $this-> isset = true;
            $this-> content = $content;
        }

        public function setFooter($footer) {
            $this-> isset = true;
            $this-> footer = $footer;
        }
    }