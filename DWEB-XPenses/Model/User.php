<?php
    require_once __DIR__ . "/../database.php";
    class User {

        private $conn;
        private $table = "user";


        public function __construct($db) {
            $this->conn = $db;
        }

        public function register($name, $email, $password) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO " . $this->table . " (name, email, password) VALUES (:name, :email, :password)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $hashed_password);
            return $stmt->execute();
        }
    
        public function login($email, $password) {
            $query = "SELECT id_User, name, password FROM " . $this->table . " WHERE email = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && password_verify($password, $user['password'])) {
                return $user;
            } else {
                return false;
            }
        }

        public function updateProfilePicture($id, $fileName) {
            $stmt = $this->conn->prepare("UPDATE " . $this->table . " SET profile_picture = ? WHERE id_User = ?");
            return $stmt->execute([$fileName, $id]);
        }        
        
        public function getUserById($id) {
            $stmt = $this->conn->prepare("SELECT id_User, name, email, profile_picture FROM " . $this->table . " WHERE id_User = ?");
            $stmt->execute([$id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && $user['profile_picture']) {
                $user['profile_picture'] = "../uploads/" . htmlspecialchars($user['profile_picture']);
            } else {
                $user['profile_picture'] = "default-profile.png"; // Define uma imagem padrão se não houver
            }

            return $user;
        }

        public function getPass($id) {
            $stmt = $this->conn->prepare("SELECT id_User, password  FROM " . $this->table . " WHERE id_User = ?");
            $stmt->execute([$id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Adiciona um log para verificar se o valor retornado está correto
            error_log("Retorno de getUserById(): " . print_r($user, true));


            return $user;
        }

        public function updatePassword($id, $newPassword) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare("UPDATE " . $this->table . " SET password = ? WHERE id_User = ?");
            return $stmt->execute([$hashedPassword, $id]);
        }

        public function updateUserData($id, $field, $value) {
            $stmt = $this->conn->prepare("UPDATE " . $this->table . " SET $field = ? WHERE id_User = ?");
            return $stmt->execute([$value, $id]);
        }
        
    }
?>