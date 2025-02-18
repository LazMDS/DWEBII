<?php
require_once '../database.php';
require_once '../Model/Expense.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
file_put_contents("log.txt", json_encode($_POST, JSON_PRETTY_PRINT), FILE_APPEND);
header('Content-Type: application/json'); // Garante que o retorno sempre seja JSON


$database = new Database();
$conn = $database->getConnection();
$expense = new Expense($conn);

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = $_POST['description'] ?? '';
    $category_id = $_POST['category_id'] ?? '';
    $amount = $_POST['amount'] ?? '';
    $date = $_POST['date'] ?? ''; 
    $user_id = $_POST['user_id'] ?? '';
    $id = $_GET['id'] ?? '';

    if (!empty($id)) {
        // Atualizar despesa existente
        if ($expense->editExpense($id, $description, $category_id, $amount, $date, $user_id)) {
            echo json_encode(["status" => "success", "message" => "Despesa atualizada com sucesso!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erro ao atualizar despesa!"]);
        }
    } else {
        // Criar nova despesa
        if ($expense->addExpense($description, $category_id, $amount, $date, $user_id)) {
            echo json_encode(["status" => "success", "message" => "Despesa adicionada com sucesso!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erro ao adicionar despesa!"]);
        }
    }
}
elseif ($action == 'delete' && $_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Pega o ID corretamente do corpo da requisição
    $input = file_get_contents("php://input");
    parse_str($input, $data);
    $id = $data['id'] ?? '';

    if (!empty($id) && is_numeric($id)) {
        if ($expense->deleteExpense($id)) {
            echo json_encode(["status" => "success", "message" => "Despesa excluída com sucesso!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erro ao excluir despesa!"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "ID inválido!"]);
    }
}      

elseif ($action == 'get' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'] ?? '';
    $expenseData = $expense->getExpense($id);
    echo json_encode($expenseData);
}

elseif ($action == 'getByMonthYear' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['month']) || !isset($_GET['year'])) {
        echo json_encode(['status' => 'error', 'message' => 'Parâmetros mês e ano são obrigatórios']);
        return;
    }
    $month = (int) $_GET['month'];
    $year = (int) $_GET['year'];

    $expenses = $expense->getAllExpensesByMonthYear($month, $year);
    
    echo json_encode([
        "status" => "success",
        "data" => $expenses
    ]);
}



elseif ($action == 'list') {
    echo json_encode($expense->getAllExpenses());
}
else {
    echo json_encode(["status" => "error", "message" => "Ação não permitida!"]);
}
?>
