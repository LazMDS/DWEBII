<?php
    require_once __DIR__ . '/../database.php';

    class Category {
        private $conn;
        private $table = 'category';

        public function __construct($db) {
            $this->conn = $db;
        }

        public function addCategory($name, $description, $weight) {
            $query = "INSERT INTO " . $this->table . " (name, description, weight) VALUES (:name, :description, :weight)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':weight', $weight);
            return $stmt->execute();
        }

        public function editCategory($id, $name, $description, $weight) {
            $query = "UPDATE " . $this->table . " SET name = :name, description = :description, weight = :weight WHERE id_Category = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':weight', $weight);
            return $stmt->execute();
        }

        public function deleteCategory($id) {
            $query = "DELETE FROM " . $this->table . " WHERE id_Category = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        }

        public function getLastError() {
            return $this->conn->errorInfo();
        }        

        public function getCategory($id) {
            $query = "SELECT * FROM " . $this->table . " WHERE id_Category = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function getAllCategories() {
            $query = "SELECT * FROM " . $this->table;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>
