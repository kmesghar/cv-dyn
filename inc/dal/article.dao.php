<?php
    class ArticleDAO {
        
        public static function loadAll(): array {
            return array();
        }

        public static function findByKeywords(array $keywords): array {
            return array();
        }

        public static function get(int $id): Article {
            return new Article();
        }

        public static function save(Article $article): Article {
            return new Article();
        }

        public static function delete(int $id): bool {
            return true;
        }

        public static function up(Article $article): bool {
            return false;
        }

        public function down(Article $article): bool {
            return false;
        }
    }