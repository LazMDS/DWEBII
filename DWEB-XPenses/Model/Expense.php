<?php
require_once __DIR__ . '/../database.php';

class Expense {
    private $conn;
    private $table = 'expense';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addExpense($description, $category_id, $amount, $date, $user_id) {
        $query = "INSERT INTO expense (description, category_id, amount, date, user_id) 
                  VALUES (:description, :category_id, :amount, :date, :user_id)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':user_id', $user_id);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function editExpense($id, $description, $category_id, $amount, $date, $user_id) {
        $query = "UPDATE expense 
                  SET description = :description, category_id = :category_id, 
                      amount = :amount, date = :date, user_id = :user_id 
                  WHERE id_Expense = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':user_id', $user_id);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    

    public function deleteExpense($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_Expense = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getLastError() {
        return $this->conn->errorInfo();
    }

    public function getExpense($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_Expense = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllExpenses() {
        $query = "SELECT e.*, c.name AS category_name FROM expense e JOIN category c ON e.category_id = c.id_Category WHERE DATE_FORMAT(e.date, '%Y-%m') = :monthYear";
        $stmt = $this->conn->prepare($query);
        $formattedDate = sprintf('%02d/%04d', $month, $year);
        $stmt->bindParam(':monthYear', $formattedDate);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllExpensesByMonthYear($month, $year) {
        try {
            $query = "SELECT e.*, c.name as category_name 
                      FROM expense e 
                      JOIN category c ON e.category_id = c.id_Category 
                      WHERE DATE_FORMAT(e.date, '%Y-%m') = :date_filter";
    
            $stmt = $this->conn->prepare($query);
            $formattedDate = sprintf('%04d-%02d', $year, $month); // Garante que tenha formato "2025-01"
            $stmt->bindParam(':date_filter', $formattedDate, PDO::PARAM_STR);
            $stmt->execute();
    
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$result) {
                throw new Exception("Nenhuma despesa encontrada para $formattedDate.");
            }
    
            return $result;
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}    
    
?>